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
 * Classe responsável pelo gerenciamento de erros 
 * @package Framework
 * @subpackage Files
 * @version 1.0 - 2006-11-22 10:32:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */
 
class FileImageUploadException extends Exception{}

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
 * Classe de upload de arquivos de imagem via HTTP
 * @package Framework
 * @subpackage Files
 * @version 1.0 - 2006-11-22 10:32:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class FileImageUpload extends FileUpload
{
   /** 
    * Attributes:
    */

   /**
    * Dimensão Default
    * @var 	$objRequestFile
	* @access 	private
	*/		
	private $intDefaultDimension;	
	
   /**
    * Gerar Thumbnail
    * @var 	$blnGenerateThumbnail
	* @access 	private
	*/		
	private $blnGenerateThumbnail;
	
   /**
    * Dimensão do Thumbnail
    * @var 	$intThumbnailDimension;	
	* @access 	private
	*/		
	private $intThumbnailDimension;	

   /**
    * Arquivo de imagem da marca d'água
    * @var 	$strImageWaterMark
	* @access 	private
	*/		
	private $strImageWaterMark;
	
   /**
    * Exibe um texto como marca d'água
    * @var 	$blnDisplayImageWaterMark
	* @access 	private
	*/		
	private $strTextWaterMark;	
	
//---------------------------------------------------------------------------------------   

   /** 
    * Properties:
    */

   /**
	* Método para setar o valor do atributo $intDefaultDimension
	* @return void		 
	* @access public
	*/
		public function SetDefaultDimension($intDefaultDimension)
		{
			 $this->intDefaultDimension = $intDefaultDimension;
		}

   /**
	* Método para retornar o valor do atributo $intDefaultDimension
	* @return string $intDefaultDimension
	* @access public
	*/
		public function GetDefaultDimension()
		{
			 return $this->intDefaultDimension;
		}

   /**
	* Método para setar o valor do atributo $blnGenerateThumbnail
	* @return void		 
	* @access public
	*/
		public function SetGenerateThumbnail($blnGenerateThumbnail)
		{
			 $this->blnGenerateThumbnail = $blnGenerateThumbnail;
		}

   /**
	* Método para retornar o valor do atributo $blnGenerateThumbnail
	* @return string $blnGenerateThumbnail
	* @access public
	*/
		public function GetGenerateThumbnail()
		{
			 return $this->blnGenerateThumbnail;
		}

   /**
	* Método para setar o valor do atributo $intThumbnailDimension
	* @return void		 
	* @access public
	*/
		public function SetThumbnailDimension($intThumbnailDimension)
		{
			 $this->intThumbnailDimension = $intThumbnailDimension;
		}

   /**
	* Método para retornar o valor do atributo $intThumbnailDimension
	* @return string $intThumbnailDimension
	* @access public
	*/
		public function GetThumbnailDimension()
		{
			 return $this->intThumbnailDimension;
		}

   /**
	* Método para setar o valor do atributo $strImageWaterMark
	* @return void		 
	* @access public
	*/
		public function SetImageWaterMark($strImageWaterMark)
		{
			 $this->strImageWaterMark = $strImageWaterMark;
		}

   /**
	* Método para retornar o valor do atributo $strImageWaterMark
	* @return string $strImageWaterMark
	* @access public
	*/
		public function GetImageWaterMark()
		{
			 return $this->strImageWaterMark;
		}

   /**
	* Método para setar o valor do atributo $strTextWaterMark
	* @return void		 
	* @access public
	*/
		public function SetTextWaterMark($strTextWaterMark)
		{
			 $this->strTextWaterMark = $strTextWaterMark;
		}

   /**
	* Método para retornar o valor do atributo $strTextWaterMark
	* @return string $strTextWaterMark
	* @access public
	*/
		public function GetTextWaterMark()
		{
			 return $this->strTextWaterMark;
		}

//---------------------------------------------------------------------------------------   
   
   /** 
    * Methods:
    */
   
   /**
	* Método construtor da classe
	* @return void
	* @access public
	*/
	    public function __construct()
	    {	
		    parent::__construct();
			
			$this->SetDefaultDimension(450);
			$this->SetGenerateThumbnail(false);
			$this->SetThumbnailDimension("");
			$this->SetImageWaterMark("");
			$this->SetTextWaterMark("");			
	    }

   /**
	* Método destrutor da classe
	* @return void
	* @access public
	*/
	    public function __destruct()
	    {	
		    unset($this);
	    }

	/**
	 * Converte a imagem gif para jpg 
	 * Devido a classe Image não suportar imagens gif, 
	 * é necessário a conversão da imagem para jpg,
	 * para realizar seu redimensionamento e a adição de marcas d'água
	 * @return boolean true se a imagem foi convertida e false caso contrário
	 * @access private
	 */
		public function ConvertToJpg()
		{
		    if(parent::FileType() == 'gif')
			{
			    parent::Upload();
				
				new ImageConverter(parent::GetName(), "jpg");
				
				$objFile = new File(parent::GetName());
				
				parent::GetRequestFile()->tmp_name = $objFile->Path(). "/" .$objFile->Name(false) . ".jpg";
				parent::GetRequestFile()->type = "image/jpg";
				parent::SetName($objFile->Path(). "/" .$objFile->Name(false) . ".jpg");
				
				$objFile->Delete();
				
				return true;
			}
			else
			{
			    return false;
			}
		}

	/**
	 * Adiciona marca d'água com imagem
	 * @param object $objImage
	 * @return object $objImage
	 * @access private
	 */
		private function AddImageWaterMark(Image $objImage)
		{
		    $objImage->img_watermark          = $this->GetImageWaterMark();
			$objImage->img_watermark_Valing   = 'BOTTOM';
			$objImage->img_watermark_Haling   = 'RIGHT';
			
			return $objImage;
		}

	/**
	 * Adiciona marca d'água com texto
	 * @param object $objImage
	 * @return object $objImage
	 * @access private
	 */
		private function AddTextWaterMark(Image $objImage)
		{
		    $objImage->txt_watermark          = $this->GetTextWaterMark();
			$objImage->txt_watermark_color    = 'CCCCCC';
			$objImage->txt_watermark_font     = 2;
			$objImage->txt_watermark_Valign   = 'TOP';
			$objImage->txt_watermark_Halign   = 'LEFT';
			$objImage->txt_watermark_Hmargin  = 10;
			$objImage->txt_watermark_Vmargin  = 10;
			
			return $objImage;
		}

	/**
	 * Salva a imagem no servidor
	 * @return boolean true se o comando foi executado com sucesso, caso contrário false
	 * @access private
	 */
		public function SaveImage()
		{
		    $objImage = new Image(parent::GetRequestFile()->tmp_name);
			
			$objImage->SizeAuto($this->GetDefaultDimension());
			
			// Configurando a qualidade da imagem:
			$objImage->quality                  = 75;
			$objImage->output_format            = 'PNG';
			$objImage->jpeg_progressive         = 0;
			$objImage->allow_enlarge            = true;
			$objImage->CalculateQFactor(10000);
			$objImage->bicubic_resample         = false;
			
			// Adionando marca d'água com imagem:
			$objImage = $this->AddImageWaterMark($objImage);
			
            // Adionando marca d'água com texto:
			$objImage = $this->AddTextWaterMark($objImage);
			
			// Salvando a imagem:
			$objImage->Process();
			$blnSaved = $objImage->Save(parent::FileUniqueName());
			
			if(!empty($objImage->error_msg))
			{
			    throw new FileImageUploadException("Erro ao redimensionar a imagem: " . $objImage->error_msg);
			}
			
			return $blnSaved;
		}

	/**
	 * Gera uma imagem miniatura da imagem salva
	 * @return boolean true se o comando foi executado com sucesso, caso contrário false
	 * @access private
	 */
		public function SaveThumbnail()
		{	
	        $intThumbnailDimension = $this->GetThumbnailDimension();
			
			// Dimensões do thumbnail setado, gerando thumb da imagem original
			if(is_int($intThumbnailDimension))
			{
			    $objImage = new Image(parent::GetRequestFile()->tmp_name);	                 

				$objImage->SizeAuto($intThumbnailDimension);
				
				$objImage->quality                  = 80;
				$objImage->output_format            = 'PNG';
				$objImage->jpeg_progressive         = 0;
				$objImage->allow_enlarge            = true;
				$objImage->CalculateQFactor(10000);
				$objImage->bicubic_resample         = false;
				
				// Gerando o nome da miniatura:
				$strThumbName = parent::GetDirectory() . "thumb_" . end(explode('_', parent::GetName()));
				
				$objImage->Process();
				$blnSaved = $objImage->Save($strThumbName);
				
				if(!empty($objImage->error_msg))
				{
					throw new FileImageUploadException("Erro ao gerar a miniatura da imagem: " . $objImage->error_msg);
				}
				
				return $blnSaved;
			}
			else
			{
			    // não é necessário gerar o thumb
				return true;
			}
		}		
	
	/**
	 * Realiza o upload da imagem, sobrecarrega o operador da classe base FileUpload
	 * @return boolean true se o comando foi executado com sucesso, caso contrário false
	 * @access private
	 */
		public function Upload()
		{	
		    parent::FileValidate();
			
			// Convertendo o arquivo de gif para jpg, se necessário:
			$blnConverted = $this->ConvertToJpg();
			
			// Salvando a imagem tratada:
			$blnImageSaved = $this->SaveImage();
			
			// Gerando a miniatura da imagem:
			$blnThumbSaved = $this->SaveThumbnail();
			
			// Se a imagem foi convertida, apague a jpg criada:
			if($blnConverted)
			{
				$objFile = new File(parent::GetRequestFile()->tmp_name);
				$objFile->Delete();
			}
			
			if($blnImageSaved && $blnThumbSaved)
			{
			    return true;
			}
			else
			{
			    return false;
			}
		}
}
