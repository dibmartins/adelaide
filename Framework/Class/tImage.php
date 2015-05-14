<?php
/**
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
 * Classe de gerenciamento de imagens, gera thumbnails, redimensiona, aplica marca d'água 
 * O processamento da imagem pode ser exibido no browser, salvo em arquivo ou retornado em uma variável.
 * @package Framework
 * @subpackage Images
 * @version 1.0 - 2006-11-08 17:49:00
 * @author Emilio Rodriguez <emiliort@gmail.com>
 * @author Diego Botelho Martins <dibmartins@gmail.com>
 * 
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 *
 * Requer:
 * GD Library
 *
 * Thumbnail: normal thumbnail generation
 * Watermark: Text or image in PNG format. Suport multiples positions.
 * Auto-fitting: adjust the dimensions so that the resized image aspect is not distorted
 * Scaling: enlarge and shrink the image
 * Format: both JPEG and PNG are supported, but the watermark image can only be in PNG format as it needs to be transparent
 * Autodetect the GD library version supported by PHP
 * Calculate quality factor for a specific file size in JPEG format.
 * Suport bicubic resample algorithm
 * Tested: PHP 4 valid
 */

class Image 
{
   /** 
    * Attributes:
    */

    /**
     * @access public
     * @var integer Quality factor for JPEG output format, default 80
     */
    public $quality = 80;
    
	/**
     * @access public
     * @var string output format, default JPG, valid values 'JPG' | 'PNG'
     */
    public $output_format = 'JPG';
    
	/**
     * @access public
     * @var integer set JPEG output format to progressive JPEG : 0 = no , 1 = yes
     */
    public $jpeg_progressive = 0;
    
	/**
     * @access public
     * @var boolean allow to enlarge the thumbnail.
     */
    public $allow_enlarge = false;

    /**
     * @access public
     * @var string [OPTIONAL] set watermark source file, only PNG format [RECOMENDED ONLY WITH GD 2 ]
     */
    public $img_watermark = '';
    
	/**
     * @access public
     * @var string [OPTIONAL] set watermark vertical position, TOP | CENTER | BOTTOM
     */
    public $img_watermark_Valing = 'TOP';
    
	/**
     * @access public
     * @var string [OPTIONAL] set watermark horizonatal position, LEFT | CENTER | RIGHT
     */
    public $img_watermark_Haling = 'LEFT';

    /**
     * @access public
     * @var string [OPTIONAL] set watermark text [RECOMENDED ONLY WITH GD 2 ]
     */
    public $txt_watermark = '';
    
	/**
     * @access public
     * @var string [OPTIONAL] set watermark text color , RGB Hexadecimal[RECOMENDED ONLY WITH GD 2 ]
     */
    public $txt_watermark_color = '000000';
    
	/**
     * @access public
     * @var integer [OPTIONAL] set watermark text font: 1,2,3,4,5
     */
    public $txt_watermark_font = 1;
    
	/**
     * @access public
     * @var string  [OPTIONAL] set watermark text vertical position, TOP | CENTER | BOTTOM
     */
    public $txt_watermark_Valign = 'TOP';
    
	/**
     * @access public
     * @var string [OPTIONAL] set watermark text horizonatal position, LEFT | CENTER | RIGHT
     */
    public $txt_watermark_Halign = 'LEFT';
    
	/**
     * @access public
     * @var integer [OPTIONAL] set watermark text horizonatal margin in pixels
     */
    public $txt_watermark_Hmargin = 10;
    
	/**
     * @access public
     * @var integer [OPTIONAL] set watermark text vertical margin in pixels
     */
    public $txt_watermark_Vmargin = 10;
    
	/**
     * @access public
     * @var boolean [OPTIONAL] set resample algorithm to bicubic
     */
    public $bicubic_resample = false;

    /**
     * @access public
     * @var string [OPTIONAL] set maximun memory usage, default 8 MB ('8M'). (use '16M' for big images)
     */
    public $memory_limit = '32M';

    /**
     * @access public
     * @var string [OPTIONAL] set maximun execution time, default 30 seconds ('30'). (use '60' for big images)
     */
    public $max_execution_time = '30';

    /**
     * @access public
     * @var string  errors mensage
     */
    public $error_msg = '';

    /**
     * @access private
     * @var mixed images
     */
    public $img;

//---------------------------------------------------------------------------------------   

   /** 
    * Properties:
    */

//---------------------------------------------------------------------------------------   
   
   /** 
    * Methods:
    */

    /**
     * Open source image
     * @access public
     * @param string filename of the source image file
     * @return boolean
     */
	function __construct($imgfile) 	
	{
    	$img_info =  @getimagesize( $imgfile );
    
	    // Detect image format
        switch( $img_info[2] )
		{
	    		
				case 1:  //GIF
	    			     $this->img["format"]="GIF";
	    			     $this->img["src"] = ImageCreateFromGIF ($imgfile);
        		         break;
				
				case 2:  //JPEG
	    			     $this->img["format"]="JPEG";
	    			     $this->img["src"] = ImageCreateFromJPEG ($imgfile);
        		         break;
	    
				case 3:  //PNG
						 $this->img["format"]="PNG";
						 $this->img["src"] = ImageCreateFromPNG ($imgfile);
						 $this->img["des"] =  $this->img["src"];
						 break;
	    
				default: $this->error_msg="Not Supported File";
	 				     return false;
	    }
		
		$this->img["x"]       = $img_info[0];       // original dimensions
		$this->img["y"]       = $img_info[1];
        $this->img["x_thumb"] = $this->img["x"];    // thumbnail dimensions
        $this->img["y_thumb"] = $this->img["y"];
        $this->img["des"]     = $this->img["src"];  // thumbnail = original
		
		return true;
	}

    /**
     * Set height for thumbnail
     * @access public
     * @param integer height
     * @return boolean
     */
	function SizeHeight($size = 100) 
	{
		// Height
		$this->img["y_thumb"]=$size;
		if($this->allow_enlarge==true) 
		{
			$this->img["y_thumb"]=$size;
		} 
		else 
		{
			if($size < ($this->img["y"])) 
			{
				$this->img["y_thumb"]=$size;
			} 
			else 
			{
				$this->img["y_thumb"]=$this->img["y"];
			}
		}
		if($this->img["y"]>0) 
		{
			$this->img["x_thumb"] = ($this->img["y_thumb"]/$this->img["y"])*$this->img["x"];
		} 
		else 
		{
			$this->error_msg="Invalid size : Y";
			return false;
		}
	}

    /**
     * Set width for thumbnail
     * @access public
     * @param integer width
     * @return boolean
     */
	function SizeWidth($size=100)  
	{
		// Width
		if($this->allow_enlarge==true) 
		{
			$this->img["x_thumb"]=$size;
		} 
		else 
		{
			if($size < ($this->img["x"])) 
			{
				$this->img["x_thumb"]=$size;
			} 
			else 
			{
				$this->img["x_thumb"]=$this->img["x"];
			}
		}
		if($this->img["x"]>0) 
		{
			$this->img["y_thumb"] = ($this->img["x_thumb"]/$this->img["x"])*$this->img["y"];
		} 
		else 
		{
			$this->error_msg="Invalid size : x";
			return false;
		}
    }

    /**
     * Set the biggest width or height for thumbnail
     * @access public
     * @param integer width or height
     * @return boolean
     */
	function SizeAuto($size=100)   
	{
		// Size
		if($this->img["x"]>=$this->img["y"]) 
		{
    		$this->SizeWidth($size);
		} 
		else 
		{
    		$this->SizeHeight($size);
 		}
	}


    /**
     * Set the biggest width and height for thumbnail
     * @access public
     * @param integer width
     * @param integer height
     * @return boolean
     */
	function Size($size_x,$size_y)   
	{
		// Size
		if((($this->img["x"])/$size_x) >= (($this->img["y"])/$size_y)) 
		{
    		$this->SizeWidth($size_x);
		} 
		else 
		{
    		$this->SizeHeight($size_y);
 		}
	}


    /**
     * Show your thumbnail, output image and headers
     * @access public
     * @return void
     */
	function Show() 
	{
		//show thumb
		header("Content-Type: image/".$this->img["format"]);
    
	    if($this->output_format=="PNG") 
		{ 
		    //PNG
    	    imagePNG($this->img["des"]);
    	} 
		else
		{
            imageinterlace( $this->img["des"], $this->jpeg_progressive);
         	imageJPEG($this->img["des"],"", $this->quality);
        }
	}

    /**
     * Return the result thumbnail
     * @access public
     * @return mixed
     */
	function Dump() 
	{
		//dump thumb
		return $this->img["des"];
	}

    /**
     * Save your thumbnail to file
     * @access public
     * @param string output file name
     * @return boolean
     */
	function Save($save="")	
	{
		// Save thumb
	    if(empty($save)) 
		{
            $this->error_msg = 'Not Save File';
            return false;
        }
        if($this->output_format == "PNG") 
		{ 
		    //PNG
    	    imagePNG($this->img["des"],"$save");
    	} 
		else 
		{
           imageinterlace($this->img["des"], $this->jpeg_progressive);
           imageJPEG($this->img["des"],"$save",$this->quality);
        }
        
		return true;
	}

    /**
     * Generate image
     * @access public
     * @return boolean
     */
    function Process() 
	{
        ini_set('memory_limit',$this->memory_limit);
        ini_set('max_execution_time',$this->max_execution_time);

        $X_des =$this->img["x_thumb"];
        $Y_des =$this->img["y_thumb"];

   		$gd_version=$this->GdVersion();
        if($gd_version>=2) 
		{
        	$this->img["des"] = ImageCreateTrueColor($X_des,$Y_des);

			if($this->txt_watermark!='' ) 
			{
				sscanf($this->txt_watermark_color, "%2x%2x%2x", $red, $green, $blue);
				$txt_color=imageColorAllocate($this->img["des"] ,$red, $green, $blue);
			}

			if(!$this->bicubic_resample) 
			{
				imagecopyresampled ($this->img["des"], $this->img["src"], 0, 0, 0, 0, $X_des, $Y_des, $this->img["x"], $this->img["y"]);
			} 
			else 
			{
				$this->ImageCopyResampleBicubic($this->img["des"], $this->img["src"], 0, 0, 0, 0, $X_des, $Y_des, $this->img["x"], $this->img["y"]);
			}

			if($this->img_watermark!='' && file_exists($this->img_watermark)) 
			{
				$this->img["watermark"]   = ImageCreateFromPNG ($this->img_watermark);
				$this->img["x_watermark"] = imagesx($this->img["watermark"]);
				$this->img["y_watermark"] = imagesy($this->img["watermark"]);
				imagecopyresampled ($this->img["des"], $this->img["watermark"], $this->CalcPositionH (), $this->CalcPositionV (), 0, 0, $this->img["x_watermark"], $this->img["y_watermark"],$this->img["x_watermark"], $this->img["y_watermark"]);
			}

			if($this->txt_watermark!='' ) 
			{
				imagestring ( $this->img["des"], $this->txt_watermark_font, $this->CalcTextPositionH() , $this->CalcTextPositionV(), $this->txt_watermark,$txt_color);
			}
        } 
		else 
		{
			$this->img["des"] = ImageCreate($X_des,$Y_des);
			
			if($this->txt_watermark!='') 
			{
				sscanf($this->txt_watermark_color, "%2x%2x%2x", $red, $green, $blue);
				$txt_color=imageColorAllocate($this->img["des"] ,$red, $green, $blue);
			}
			
			// pre copy image, allocating color of water mark, GD < 2 can't resample colors
			if($this->img_watermark!='' && file_exists($this->img_watermark)) 
			{
				$this->img["watermark"]=ImageCreateFromPNG ($this->img_watermark);
				$this->img["x_watermark"] =imagesx($this->img["watermark"]);
				$this->img["y_watermark"] =imagesy($this->img["watermark"]);
				imagecopy ($this->img["des"], $this->img["watermark"], $this->CalcPositionH (), $this->CalcPositionV (), 0, 0, $this->img["x_watermark"], $this->img["y_watermark"]);
			}
			
			imagecopyresized ($this->img["des"], $this->img["src"], 0, 0, 0, 0, $X_des, $Y_des, $this->img["x"], $this->img["y"]);
			@imagecopy ($this->img["des"], $this->img["watermark"], $this->CalcPositionH (), $this->CalcPositionV (), 0, 0, $this->img["x_watermark"], $this->img["y_watermark"]);
			
			if($this->txt_watermark!='')
			{
				imagestring( $this->img["des"], $this->txt_watermark_font, $this->CalcTextPositionH() , $this->CalcTextPositionV(), $this->txt_watermark, $txt_color); // $this->txt_watermark_color);
			}
        }
        
		$this->img["src"]=$this->img["des"];
        $this->img["x"]= $this->img["x_thumb"];  
        $this->img["y"]= $this->img["y_thumb"];
    }

    /**
     * Calculate JPEG quality factor for a specific size in bytes
     * @access public
     * @param integer maximun file size in bytes
     */
    function CalculateQFactor($size)  
	{
        //based on: JPEGReducer class version 1,  25 November 2004,  Author: huda m elmatsani, Email :justhuda@netscape.net

        //calculate size of each image. 75%, 50%, and 25% quality
        ob_start(); 
		imagejpeg($this->img["des"],'',75);  
		$buffer = ob_get_contents(); 
		ob_end_clean();
        $size75 = strlen($buffer);
        
		ob_start(); 
		imagejpeg($this->img["des"],'',50);  
		$buffer = ob_get_contents(); 
		ob_end_clean();
        $size50 = strlen($buffer);
        
		ob_start(); 
		imagejpeg($this->img["des"],'',25);  
		$buffer = ob_get_contents(); 
		ob_end_clean();
        $size25 = strlen($buffer);

        //calculate gradient of size reduction by quality
        $mgrad1 = 25 / ($size50 - $size25);
        $mgrad2 = 25 / ($size75 - $size50);
        $mgrad3 = 50 / ($size75 - $size25);
        $mgrad  = ($mgrad1 + $mgrad2 + $mgrad3) / 3;
		
        //result of approx. quality factor for expected size
        $q_factor = round($mgrad * ($size - $size50) + 50);

        if($q_factor < 25) 
		{
            $this->quality=25;
        } 
		elseif($q_factor > 100) 
		{
            $this->quality = 100;
        } 
		else 
		{
            $this->quality=$q_factor;
        }
    }

    /**
     * @access private
     * @return integer
     */
    function CalcTextPositionH() 
	{
        $W_mark = imagefontwidth($this->txt_watermark_font)*strlen($this->txt_watermark);
        $W = $this->img["x_thumb"];
		
        switch ($this->txt_watermark_Halign) 
		{
             case 'CENTER': $x = $W / 2 - $W_mark / 2;
                            break;
             
			 case 'RIGHT' : $x = $W - $W_mark - ($this->txt_watermark_Hmargin);
                            break;
             default:
             
			 case 'LEFT'  : $x = 0 + ($this->txt_watermark_Hmargin);
                            break;
         }
         
		 return $x;
    }

    /**
     * @access private
     * @return integer
     */
    function CalcTextPositionV () 
	{
        $H_mark = imagefontheight ($this->txt_watermark_font);
        $H = $this->img["y_thumb"];
    
	    switch ($this->txt_watermark_Valign) 
		{
             case 'CENTER': $y =  $H / 2 - $H_mark / 2;
                            break;
             
			 case 'BOTTOM': $y = $H - $H_mark - ($this->txt_watermark_Vmargin);
                            break;
             default:
             
			 case 'TOP'   : $y = 0 + ($this->txt_watermark_Vmargin);
                            break;
         }
		 
         return $y;
    }

    /**
     * @access private
     * @return integer
     */
    function CalcPositionH () 
	{
        $W_mark = $this->img["x_watermark"];
        $W = $this->img["x_thumb"];
    
	    switch ($this->img_watermark_Haling) 
		{
             case 'CENTER' : $x = $W/2-$W_mark/2;
                             break;
             case 'RIGHT'  : $x = $W-$W_mark;
                             break;
             default:
             
			 case 'LEFT':    $x = 0;
                             break;
         }
		 
         return $x;
    }

    /**
     * @access private
     * @return integer
     */
    function CalcPositionV() 
	{
        $H_mark = $this->img["y_watermark"];
        $H = $this->img["y_thumb"];
    
	    switch($this->img_watermark_Valing) 
		{
             case 'CENTER': $y = $H / 2 - $H_mark / 2;
                            break;
             
			 case 'BOTTOM': $y = $H-$H_mark;
                            break;
             default:
             
			 case 'TOP':    $y = 0;
                            break;
         }
         
		 return $y;
    }

    /**
     * @access private
     * @return boolean
     */
    function CheckGd2()
	{
	    // TEST the GD version
	    if(extension_loaded('gd2') && function_exists('imagecreatetruecolor')) 
	    {
		    return false;
	    } 
	    else 
	    {
		    return true;
	    }
    }

    /**
     * Get which version of GD is installed, if any.
     * @return Version (1 or 2) of the GD extension.
     */
    function GdVersion($user_ver = 0)
    {
       if(!extension_loaded('gd')) 
	   { 
	       return; 
	   }
       
	   static $gd_ver = 0;
       
	   // Just accept the specified setting if it's 1.
       if($user_ver == 1) 
	   { 
	       $gd_ver = 1; return 1; 
	   }
       
	   // Use the static variable if function was called previously.
       if($user_ver !=2 && $gd_ver > 0) 
	   { 
	       return $gd_ver; 
	   }
       
	   // Use the gd_info() function if possible.
       if(function_exists('gd_info')) 
	   {
           $ver_info = gd_info();
           preg_match('/\d/', $ver_info['GD Version'], $match);
           $gd_ver = $match[0];
           return $match[0];
       }
       
	   // If phpinfo() is disabled use a specified / fail-safe choice...
       if(preg_match('/phpinfo/', ini_get('disable_functions'))) 
	   {
           if($user_ver == 2) 
		   {
               $gd_ver = 2;
               return 2;
           } 
		   else 
		   {
               $gd_ver = 1;
               return 1;
           }
       }
	   
       // ...otherwise use phpinfo().
       ob_start();
       phpinfo(8);
       $info = ob_get_contents();
       ob_end_clean();
       
	   $info = stristr($info, 'gd version');
       
	   preg_match('/\d/', $info, $match);
       
	   $gd_ver = $match[0];
       
	   return $match[0];
    } 

    function ImageCopyResampleBicubic($dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) 
	{
      $scaleX  = ($src_w - 1) / $dst_w;
      $scaleY  = ($src_h - 1) / $dst_h;
      $scaleX2 = $scaleX / 2.0;
      $scaleY2 = $scaleY / 2.0;
      $tc      = imageistruecolor($src_img);

      for($y = $src_y; $y < $src_y + $dst_h; $y++) 
	  {
          $sY   = $y * $scaleY;
          $siY  = (int) $sY;
          $siY2 = (int) $sY + $scaleY2;

          for($x = $src_x; $x < $src_x + $dst_w; $x++) 
	      {
		      $sX   = $x * $scaleX;
			  $siX  = (int) $sX;
			  $siX2 = (int) $sX + $scaleX2;

			  if($tc) 
			  {
				  $c1 = imagecolorat($src_img, $siX, $siY2);
				  $c2 = imagecolorat($src_img, $siX, $siY);
				  $c3 = imagecolorat($src_img, $siX2, $siY2);
				  $c4 = imagecolorat($src_img, $siX2, $siY);

			      $r = (($c1 + $c2 + $c3 + $c4) >> 2) & 0xFF0000;
			      $g = ((($c1 & 0xFF00) + ($c2 & 0xFF00) + ($c3 & 0xFF00) + ($c4 & 0xFF00)) >> 2) & 0xFF00;
			      $b = ((($c1 & 0xFF)  + ($c2 & 0xFF)  + ($c3 & 0xFF)  + ($c4 & 0xFF))  >> 2);

                  imagesetpixel($dst_img, $dst_x + $x - $src_x, $dst_y + $y - $src_y, $r+$g+$b);
              }  
			  else 
			  {
			      $c1 = imagecolorsforindex($src_img, imagecolorat($src_img, $siX, $siY2));
			      $c2 = imagecolorsforindex($src_img, imagecolorat($src_img, $siX, $siY));
			      $c3 = imagecolorsforindex($src_img, imagecolorat($src_img, $siX2, $siY2));
			      $c4 = imagecolorsforindex($src_img, imagecolorat($src_img, $siX2, $siY));
	
			      $r = ($c1['red']   + $c2['red']   + $c3['red']   + $c4['red']  ) << 14;
			      $g = ($c1['green'] + $c2['green'] + $c3['green'] + $c4['green']) << 6;
			      $b = ($c1['blue']  + $c2['blue']  + $c3['blue']  + $c4['blue'] ) >> 2;

                  imagesetpixel($dst_img, $dst_x + $x - $src_x, $dst_y + $y - $src_y, $r+$g+$b);
              }
          }    
       }
    }

    /**
     * generate a unique filename in a directory like prefix_filename_randon.ext
     * @access public
     * @param string path of the destination dir. Example '/img'
     * @param string name of the file to save. Example 'my_foto.jpg'
     * @param string [optional] prefix of the name Example 'picture'
     * @return string full path of the file to save. Exmaple '/img/picture_my_foto_94949.jpg'
     */
    function UniqueFilename($archive_dir , $filename , $file_prefix='') 
	{
    	// checkemaos if file exists
    	$extension = strtolower(substr(strrchr($filename, "."), 1));
    	$name      = str_replace(".".$extension,'',$filename);

    	// only alfanumerics characters
    	$string_tmp = $name;
    	$name = '';
    	
		while ($string_tmp!='') 
		{
    		$character  = substr ($string_tmp, 0, 1);
    		$string_tmp = substr ($string_tmp, 1);
    	
			if(eregi("[abcdefghijklmnopqrstuvwxyz0-9]", $character)) 
			{
    			$name = $name . $character;
    		} 
			else 
			{
    			$name=$name.'_';
    		}
    	}

    	$destination = $file_prefix."_".$name.".".$extension;

    	while(file_exists($archive_dir."/".$destination)) 
		{
    		// if exist, add a random number to the file name
    		srand((double) microtime() * 1000000); // random number inizializzation
    		$destination = $file_prefix."_".$name."_".rand(0,999999999).".".$extension;
    	}
		
    	return ($destination);
    }

	/**
	 * NOT USED : to do: mezclar imagenes a tamanho original, preservar canal alpha y redimensionar
	 * Merge multiple images and keep transparency
	 * $i is and array of the images to be merged:
	 * $i[1] will be overlayed over $i[0]
	 * $i[2] will be overlayed over that
 	 * @param mixed
	 * @retrun mixed the function returns the resulting image ready for saving
	 */
	function ImageMergeAlpha($i) 
	{
		//create a new image
	    $s = imagecreatetruecolor(imagesx($i[0]),imagesy($i[1]));

	    //merge all images
	    imagealphablending($s, true);
	    $z = $i;
	 
	    while($d = each($z)) 
	    {
	        imagecopy($s,$d[1],0,0,0,0,imagesx($d[1]),imagesy($d[1]));
	    }

	    // restore the transparency
	    imagealphablending($s,false);
	    $w = imagesx($s);
	    $h = imagesy($s);
	 
	    for($x=0;$x<$w;$x++) 
	    {
	        for($y=0;$y<$h;$y++) 
		    {
	            $c = imagecolorat($s,$x,$y);
	            $c = imagecolorsforindex($s,$c);
	            $z = $i;
	            $t = 0;
		     
			    while($d = each($z)) 
			    {
		            $ta = imagecolorat($d[1],$x,$y);
		            $ta = imagecolorsforindex($d[1],$ta);
		            $t += 127 - $ta['alpha'];
		        }
		     
			    $t = ($t > 127) ? 127 : $t;
		        $t = 127-$t;
		        $c = imagecolorallocatealpha($s,$c['red'],$c['green'],$c['blue'],$t);
		        imagesetpixel($s,$x,$y,$c);
	        }
	    }
	 
	    imagesavealpha($s, true);
	 
	    return $s;
	}
	
	public function GetInfo($strFile)
	{
	    $objFile = new File($strFile);
		$intSize = number_format($objFile->Size() / 1024, 2);
		
		list($intWidth, $intHeight, $strType, $strDimensions) = @getimagesize($strFile);
		
		switch($strType)
		{
		    case 1 : $strType = "GIF"; break;
			case 2 : $strType = "JPG"; break;
			case 3 : $strType = "PNG"; break;
			case 4 : $strType = "SWF"; break;
			case 5 : $strType = "PSD"; break;
			case 6 : $strType = "BMP"; break;
			case 7 : $strType = "TIFF(intel byte order)";    break;
			case 8 : $strType = "TIFF(motorola byte order)"; break;
			case 9 : $strType = "JPC"; break;
			case 10: $strType = "JP2"; break;
			case 11: $strType = "JPX"; break;
			case 12: $strType = "JB2"; break;
			case 13: $strType = "SWC"; break;
			case 14: $strType = "IFF"; break;
			case 15: $strType = "WBMP"; break;
			case 16: $strType = "XBM"; break;
		}
		
		return array($intWidth, $intHeight, $strType, $strDimensions, $intSize);
	}
}
