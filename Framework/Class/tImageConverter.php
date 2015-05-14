<?php
/*
 * Adelaide Framework  
 * Copyright (C) 2006,2013 Diego Botelho Martins
 *
 * Este programa é um software livre; você pode redistribui-lo e/ou 
 * modifica-lo dentro dos termos da Licença Pública Geral GNU como 
 * publicada pela Fundação do Software Livre (FSF); na versão 3 da 
 * Licença, ou (a seu critério) qualquer versão.
 * 
 * Este programa é distribuido na esperança que possa ser util, 
 * mas SEM NENHUMA GARANTIA; sem uma garantia implicita de ADEQUAÇÂO 
 * a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a
 * Licença Pública Geral GNU para maiores detalhes.
 * 
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU
 * junto com este programa, se não, veja <http://www.gnu.org/licenses/>
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>
 * 
 * Converte uma imagem para outro tipo
 * Formatos suportados: gif, jpg, png, swf, wbmp
 * @package Framework
 * @subpackage Images
 * @version 1.0 - 2006-11-08 16:40:00
 * @author Huda M Elmatsani <justhuda.netscape.net>
 * @author Diego Botelho Martins <dibmartins@gmail.com>
 * @link http://www.phpclasses.org/browse/package/2073.html
 * @link http://www.diegobotelho.com.br
 * @copyright Huda M Elmatsani <justhuda.netscape.net>
 *
 * Requer:
 * GD Library
 * Ming Library
 *
 * Limitação:
 * O formato SWF não pode ser convertido para outro formato.
 */
 
class ImageConverter 
{
	private $imtype;
	private $im;
	private $imname;
	private $imconvertedtype;
	private $output;

	public function __construct() 
	{
		// Parse arguments
		$numargs 		= func_num_args();
		$imagefile  	= func_get_arg(0);
		$convertedtype 	= func_get_arg(1);
		$output 		= 0;
		
		if($numargs > 2) 
		{
		    $this->output = func_get_arg(2);
		}	

		// Ask the type of original file
		$fileinfo  		= pathinfo($imagefile);
		$imtype 		= $fileinfo["extension"];
		$this->imname 	= $fileinfo["dirname"] . "/" . basename($fileinfo["basename"],".".$imtype);
		$this->imtype	= $imtype;

		// Create the image variable of original file
		switch ($imtype) 
		{
			case "gif"  : $this->im = imageCreateFromGIF($imagefile);  break;
			case "jpg"  : $this->im = imageCreateFromJPEG($imagefile); break;
			case "png"  : $this->im = imageCreateFromPNG($imagefile);  break;
			case "wbmp" : $this->im = imageCreateFromWBMP($imagefile); break;			
		}

		// Convert to intended type
		$this->ConvertImage($convertedtype);
	}

	public function ConvertImage($type) 
	{
		// Check the converted image type availability,
		// if it is not available, it will be casted to jpeg
		$validtype = $this->validateType($type);

		if($this->output) 
		{
			// Show the image
			switch($validtype)
			{
				case 'jpeg' :
				case 'jpg' 	: header("Content-type: image/jpeg");
							  if($this->imtype == 'gif' or $this->imtype == 'png') 
							  {
							      $image = $this->ReplaceTransparentWhite($this->im);
								  imageJPEG($image);
							  } 
							  else imageJPEG($this->im);
							  break;
				
				case 'gif' :  header("Content-type: image/gif");
					          imageGIF($this->im);
				 	          break;
				
				case 'png'  : header("Content-type: image/png");
					          imagePNG($this->im);
					          break;
				
				case 'wbmp' : header("Content-type: image/vnd.wap.wbmp");
					          imageWBMP($this->im);
					          break;
				
				case 'swf'  : header("Content-type: application/x-shockwave-flash");
							  $this->imageSWF($this->im);
							  break;
			}
		} 
		else 
		{
			// Save the image
			switch($validtype)
			{
				case 'jpeg' :
				case 'jpg' 	: if($this->imtype == 'gif' or $this->imtype == 'png') 
							  {
							      // Replace transparent with white
								  $image = $this->ReplaceTransparentWhite($this->im);
								  imageJPEG($image,$this->imname.".jpg");
							  } 
							  else imageJPEG($this->im,$this->imname.".jpg");
							  break;

				case 'gif'  : imageGIF($this->im,$this->imname.".gif");
					          break;

				case 'png'  : imagePNG($this->im,$this->imname.".png");
					          break;

				case 'wbmp' : imageWBMP($this->im,$this->imname.".wbmp");
					          break;

				case 'swf'  : $this->imageSWF($this->im,$this->imname.".swf");
					          break;
			}

		}
	}

	// Convert image to SWF
	public function ImageSWF() 
	{
		// Parse arguments
		$numargs = func_num_args();
		$image   = func_get_arg(0);
		$swfname = "";
		if($numargs > 1) $swfname = func_get_arg(1);

		// Image must be in jpeg and
		// convert jpeg to SWFBitmap
		// can be done by buffering it
		ob_start();
		
		imagejpeg($image);
		$buffimg = ob_get_contents();
		
		ob_end_clean();

		$img = new SWFBitmap($buffimg);

		$w = $img->GetWidth();
		$h = $img->GetHeight();

		$movie = new SWFMovie();
		$movie->SetDimension($w, $h);
		$movie->add($img);

		if($swfname)
		{
			$movie->Save($swfname);
		}
		else
		{
			$movie->output;
		}
	}

	// Convert SWF to image
	public function ImageCreateFromSWF($swffile) 
	{
	    die("Conversor SWF não habilitado nessa biblioteca.");
	}

	public function validateType($type) 
	{
		// Check image type availability
		$is_available = FALSE;

		switch($type)
		{
			case 'jpeg' :
			case 'jpg' 	: if(function_exists("imagejpeg"))
				          $is_available = TRUE;
				          break;
			
			case 'gif' :  if(function_exists("imagegif"))
				          $is_available = TRUE;
				          break;

			case 'png' :  if(function_exists("imagepng"))
				          $is_available = TRUE;
			 	          break;

			case 'wbmp' : if(function_exists("imagewbmp"))
				          $is_available = TRUE;
				          break;

			case 'swf' :  if(class_exists("swfmovie"))
				          $is_available = TRUE;
				          break;
		}
		
		if(!$is_available && function_exists("imagejpeg"))
		{
			// If not available, cast image type to jpeg
			return "jpeg";
		}
		elseif(!$is_available && !function_exists("imagejpeg"))
		{
		    die("No image support in this PHP server");
		}
		else 
		{
		    return $type;
		}	
	}

	public function ReplaceTransparentWhite($im)
	{
		$src_w           = ImageSX($im);
		$src_h           = ImageSY($im);
		$backgroundimage = imagecreatetruecolor($src_w, $src_h);
		$white           =  ImageColorAllocate ($backgroundimage, 255, 255, 255);
		
		ImageFill($backgroundimage,0,0,$white);
		ImageAlphaBlending($backgroundimage, TRUE);
		
		imagecopy($backgroundimage, $im, 0,0,0,0, $src_w, $src_h);
		
		return $backgroundimage;
	}
}
