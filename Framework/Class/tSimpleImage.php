<?php
class SimpleImageError extends Exception {}

class SimpleImage
{
	private $image;
	private $intImageType;
	
//------------------------------------------------------------------------------

	/**
	 * Carrega a imagem.
	 * 
	 * @param resource $resFile Arquivo.
	 */
	public function Load($resFile)
	{
		try
		{
			$image_info = getimagesize($resFile);
			$this->image_type = $image_info[2];
			
			if( $this->image_type == IMAGETYPE_JPEG )
			{
				$this->image = imagecreatefromjpeg($resFile);
			}
			elseif( $this->image_type == IMAGETYPE_GIF )
			{
				$this->image = imagecreatefromgif($resFile);
			}
			elseif( $this->image_type == IMAGETYPE_PNG )
			{
				$this->image = imagecreatefrompng($resFile);
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
//------------------------------------------------------------------------------
	
	/**
	 * Salva o arquivo informado.
	 * 
	 * @param string $strFileName Caminho completo e nome do arquivo.
	 * @param integer $intImageType Tipo da imagem.
	 * @param integer $intQuality Qualidade que o arquivo será salvo (0-100)
	 * @param integer $octPermissions Permissões para o arquivo. É necessário
	 *  usar um inteiro informado no formato octal (precedido com zero).
	 */
	public function Save($strFileName,
			$intImageType = IMAGETYPE_JPEG,
			$intQuality = 75,
			$octPermissions = 0777)
	{
		try
		{
			if( $intImageType == IMAGETYPE_JPEG )
			{
				imagejpeg($this->image, $strFileName, $intQuality);
			}
			elseif( $intImageType == IMAGETYPE_GIF )
			{
				imagegif($this->image, $strFileName);
			}
			elseif( $intImageType == IMAGETYPE_PNG )
			{
				imagepng($this->image, $strFileName);
			}
			
			if( $octPermissions != null)
			{
				chmod($strFileName, $octPermissions);
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
//------------------------------------------------------------------------------
	
	/**
	 * Usado para gerar uma imagem binariamente. A imagem poderá ser exibida
	 * por exemplo, através de um arquivo html, configurando-se o header html
	 * apropriado: em PHP, use header('Content-Type: image/jpeg') antes de
	 * invocar Output().
	 * 
	 * @param integer $intImageType
	 */
	public function Output($intImageType = IMAGETYPE_JPEG)
	{
		try
		{
			if( $intImageType == IMAGETYPE_JPEG )
			{
				imagejpeg($this->image);
			}
			elseif( $intImageType == IMAGETYPE_GIF )
			{
				imagegif($this->image);
			}
			elseif( $intImageType == IMAGETYPE_PNG )
			{
				imagepng($this->image);
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
//------------------------------------------------------------------------------
	
	/**
	 * Captura a largura da imagem.
	 * 
	 * @return integer Largura da imagem.
	 */
	public function GetWidth()
	{
		return imagesx($this->image);
	}
	
//------------------------------------------------------------------------------
	
	/**
	 * Captura a altura da imagem.
	 *
	 * @return integer Altura da imagem.
	 */
	public function GetHeight()
	{
		return imagesy($this->image);
	}
	
//------------------------------------------------------------------------------
	
	/**
	 * Redimensiona a imagem proporcionalmente, tendo como base a altura
	 * desejada.
	 * 
	 * @param integer $intHeight Nova altura em pixels.
	 */
	public function ResizeToHeight($intHeight)
	{
		try
		{
			$fltRatio = $intHeight / $this->getHeight();
			$intWidth = $this->getWidth() * $fltRatio; $this->Resize($intWidth, $intHeight);
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
//------------------------------------------------------------------------------
	
	/**
	 * Redimensiona a imagem proporcionalmente, tendo como base a largura
	 * desejada.
	 *
	 * @param integer $intWidth Nova largura em pixels.
	 */
	public function ResizeToWidth($intWidth)
	{
		try
		{
			$fltRatio = $intWidth / $this->getWidth();
			$intHeight = $this->getheight() * $fltRatio;
			$this->Resize($intWidth, $intHeight);
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
//------------------------------------------------------------------------------
	
	/**
	 * Redimensiona a imagem percentualmente, tendo como base a escala
	 * desejada.
	 *
	 * @param float $fltScale
	 */
	public function Scale($fltScale)
	{
		try
		{
			$intWidth = $this->getWidth() * $fltScale/100;
			$intHeight = $this->getheight() * $fltScale/100;
			$this->Resize($intWidth, $intHeight);
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
//------------------------------------------------------------------------------
	
	/**
	 * Redimensiona a imagem através da sua nova largura e altura, em pixels.
	 * 
	 * @param integer $intWidth Nova largura.
	 * @param integer $intHeight Nova altura.
	 */
	public function Resize($intWidth, $intHeight)
	{
		try
		{
			if( !is_numeric($intWidth) )
			{
				throw new InvalidArgumentException('$intWidth precisa ser numérico.');
			}
			
			if( !is_numeric($intHeight) )
			{
				throw new InvalidArgumentException('$intHeight precisa ser numérico.');
			}
			
			$resNewImage = imagecreatetruecolor($intWidth, $intHeight);
			
			imagecopyresampled($resNewImage,
					$this->image,
					0, 0, 0, 0,
					$intWidth, $intHeight,
					$this->getWidth(), $this->getHeight());
			
			$this->image = $resNewImage;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
//------------------------------------------------------------------------------
	
	/**
	 * Trata uma imagem recebida em qualquer dimensão, seja retrato ou
	 * paisagem, seja grande ou pequena, redimensionando a mesma e em seguida
	 * recortando de modo centralizado, para que fique no novo tamanho
	 * proposto, em pixels, sem distorcer a imagem. 
	 * 
	 * @param integer $intHeight Nova altura
	 * @param integer $intWidth Nova largura
	 */
	public function CropToSize($intHeight, $intWidth)
	{
		try
		{
			if( !is_numeric($intWidth) )
			{
				throw new InvalidArgumentException('$intWidth precisa ser numérico.');
			}
			
			if( !is_numeric($intHeight) )
			{
				throw new InvalidArgumentException('$intHeight precisa ser numérico.');
			}
			
			$fltNewImageRatio = $this->GetHeight() / $this->GetWidth();
			$fltOldImageRatio = $intHeight / $intWidth;
			
			if( $fltNewImageRatio > $fltOldImageRatio )
			{
				
				$this->ResizeToWidth($intWidth);
			}
			else
			{
				$this->ResizeToHeight($intHeight);
			}
			
			$this->cropFromCenter($intWidth, $intHeight);
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
//------------------------------------------------------------------------------

	/**
	 * Recorta uma imagem do centro, provendo a sua nova dimensão. Caso
	 * a altura não seja passada, a largura irá servir também de altura,
	 * fazendo com que seja criada uma imagem quadrada.
	 *
	 * @param integer $intCropWidth Largura do recorte
	 * @param integer $intCropHeight Altura do recorte
	 */
	public function CropFromCenter($intCropWidth, $intCropHeight = null)
	{
		try
		{
			if( !is_numeric($intCropWidth) )
			{
				throw new InvalidArgumentException('$intCropWidth precisa ser numérico.');
			}
		
			if( $intCropHeight !== null && !is_numeric($intCropHeight) )
			{
				throw new InvalidArgumentException('$intCropHeight precisa ser numérico.');
			}
		
			if( $intCropHeight === null )
			{
				$intCropHeight = $intCropWidth;
			}
		
			$intCropWidth	= ($this->GetWidth() < $intCropWidth) ? $this->GetWidth() : $intCropWidth;
			$intCropHeight = ($this->GetHeight() < $intCropHeight) ? $this->GetHeight() : $intCropHeight;
		
			$cropX = intval(($this->GetWidth() - $intCropWidth) / 2);
			$cropY = intval(($this->GetHeight() - $intCropHeight) / 2);
		
			$this->crop($cropX, $cropY, $intCropWidth, $intCropHeight);
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
//------------------------------------------------------------------------------
	
	/**
	 * Recorta a imagem da posição x, y inicial para a largura e altura
	 * informada.
	 *
	 * @param integer $intStartX Posição X base do corte.
	 * @param integer $intStartY Posição Y base do corte.
	 * @param integer $intCropWidth Largura do corte.
	 * @param integer $intCropHeight Altura do corte.
	 */
	public function Crop($intStartX, $intStartY, $intCropWidth, $intCropHeight)
	{
		try
		{
			if( !is_numeric($intStartX) )
			{
				throw new InvalidArgumentException('$intStartX precisa ser numérico.');
			}
		
			if( !is_numeric($intStartY) )
			{
				throw new InvalidArgumentException('$intStartY precisa ser numérico.');
			}
		
			if( !is_numeric($intCropWidth) )
			{
				throw new InvalidArgumentException('$intCropWidth precisa ser numérico.');
			}
		
			if( !is_numeric($intCropHeight) )
			{
				throw new InvalidArgumentException('$intCropHeight precisa ser numérico.');
			}
		
			$intCropWidth	= ($this->GetWidth() < $intCropWidth) ? $this->GetWidth() : $intCropWidth;
			$intCropHeight = ($this->GetHeight() < $intCropHeight) ? $this->GetHeight() : $intCropHeight;
		
			if( ($intStartX + $intCropWidth) > $this->GetWidth())
			{
				$intStartX = ($this->GetWidth() - $intCropWidth);
			}
		
			if( ($intStartY + $intCropHeight) > $this->GetHeight())
			{
				$intStartY = ($this->GetHeight() - $intCropHeight);
			}
		
			if( $intStartX < 0)
			{
				$intStartX = 0;
			}
		
			if( $intStartY < 0)
			{
				$intStartY = 0;
			}
		
			if( function_exists('imagecreatetruecolor') )
			{
				$newImage = imagecreatetruecolor($intCropWidth, $intCropHeight);
			}
			else
			{
				$newImage = imagecreate($intCropWidth, $intCropHeight);
			}
		
			imagecopyresampled
			(
					$newImage,
					$this->image,
					0,
					0,
					$intStartX,
					$intStartY,
					$intCropWidth,
					$intCropHeight,
					$intCropWidth,
					$intCropHeight
			);
		
			$this->image = $newImage;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
//------------------------------------------------------------------------------
	
}