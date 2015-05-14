<?php
require_once 'tSimpleImage.php';
require_once 'tImageFileUploadMsg.php';

class ImageFileUploadError extends Exception {}

class ImageFileUpload
{
	private $_intMaxFileSize;
	private $_arrValidFileExtensions;
	private $_folderBase;

//------------------------------------------------------------------------------

	/**
	 * Construtor.
	 * 
	 * @param int $intMaxFileSize Quantidade em bytes máxima permitida para o
	 *  tamanho do arquivo.
	 * @param Array $arrValidFileExtensions Extensões permitidas de imagem.
	 * @param String $backendFolderBase Pasta em que serão armazenadas as
	 *  imagens; essa pasta deverá ter permissão de leitura/escrita.
	 */
	public function __construct($intMaxFileSize,
								$arrValidFileExtensions,
								$backendFolderBase)
	{
		try
		{
			if( !is_numeric($intMaxFileSize) )
			{
				throw new InvalidArgumentException('$intMaxFileSize precisa ser '
					. 'um valor inteiro com o número de bytes máximo permitido.');
			}
			if( !is_array($arrValidFileExtensions) )
			{
				throw new InvalidArgumentException('$arrValidFileExtensions '
					. 'precisa ser um array com as extensões dos arquivos '
					. 'permitodos para upload.');
			}
			if( !is_string($backendFolderBase) )
			{
				throw new InvalidArgumentException('$backendFolderBase precisa '
					. 'ser uma string com o caminho da pasta base no servidor '
					. 'com permissão adequada, onde será salvo o arquivo.');
			}
			
			$this->_intMaxFileSize = $intMaxFileSize;
			$this->_arrValidFileExtensions = $arrValidFileExtensions;
			$this->_folderBase = $backendFolderBase;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
//------------------------------------------------------------------------------
	
	/**
	 * Executa o upload da foto para a pasta preconfigurada.
	 * 
	 * @param resource $resFile Arquivo a ser enviado.
	 * @param integer $intCropToNewHeight Nova altura da imagem.
	 * @param integer $intCropToNewWidth Nova largura da imagem.
	 * 
	 * @throws ImageFileUploadError quando o arquivo enviado usa uma
	 *  extensão diferente das permitidas e quando o tamanho máximo do
	 *  arquivo foi ultrapassado.
	 */
	public function UploadImageFile($resFile,
			                        $intCropToNewHeight = null,
			                        $intCropToNewWidth = null)
	{
		try
		{
			if( $intCropToNewHeight !== null && !is_numeric($intCropToNewHeight) )
			{
				throw new InvalidArgumentException('$intCropToNewHeight precisa ser numérico.');
			}
			
			if( $intCropToNewWidth !== null && !is_numeric($intCropToNewWidth) )
			{
				throw new InvalidArgumentException('$intCropToNewWidth precisa ser numérico.');
			}
			
			if( $resFile['size'] < $this->_intMaxFileSize )
			{
				$image = new SimpleImage();
		
				$strUniqueDirName = $this->CreateFolderName();
				
				$strUploadDir = $this->_folderBase
				              . $strUniqueDirName;
		
				if( $this->MakeFolder($strUploadDir, 0777) )
				{
					$strFileExtension = strtolower(pathinfo($resFile['name'], PATHINFO_EXTENSION));
		
					// Para gravaçao de mesmo tamanho em banco, foi necessário
					// converter jpeg para jpg:
					if( strtolower($strFileExtension) == 'jpeg' )
					{
						$strFileExtension = 'jpg';
					}
					
					$strUniqueFileName = $this->CreateUniqueFileName();
					
					$strCompleteUploadFileName = $strUploadDir
					                           . $strUniqueFileName
					                           . '.'
					                           . $strFileExtension;
		
					if( in_array($strFileExtension, $this->_arrValidFileExtensions) )
					{
						$image->Load($resFile['tmp_name']);
						
						if( $intCropToNewHeight !== null && $intCropToNewWidth !== null )
						{
							$image->CropToSize($intCropToNewHeight, $intCropToNewWidth);
						}
						
						// Salva a imagem no local indicado, do tipo Jpeg, com qualidade 10 e permissão 777.
						$image->Save($strCompleteUploadFileName, IMAGETYPE_JPEG, 20, 0777);
						
						return $strUniqueDirName
						     . $strUniqueFileName
						     . '.'
						     . $strFileExtension;
					}
					else
					{
						throw new ImageFileUploadError(ImageFileUploadMsg::WRONG_FILE_TYPE);
					}
				}
				else
				{
					throw new ImageFileUploadError(ImageFileUploadMsg::INVALID_PERMISSION);
				}
			}
			else
			{
				throw new ImageFileUploadError(ImageFileUploadMsg::FILE_EXCEEDS_MAX_SIZE);
			}
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
//------------------------------------------------------------------------------
	
	/**
	 * Cria um nome de arquivo único, que usa a data e hora atuais e também
	 * um inteiro aleatório entre 1000 e 9999, como segue:
	 * pic_ + ano + mês + dia + hora + min + seg + microsegundo + aleatório
	 * 
	 *  @return string Nome único do arquivo.
	 */
	private function CreateUniqueFileName()
	{
		try
		{
			$strPrefix    = 'pic_';
			$strYearMonthDayHourMinutesSeconds = date('Y-m-d_H-i-s_');
		
			$arrMicrotime = explode( ' ', microtime() );
			$strMicroseconds = (String)$arrMicrotime[1];
		
			$strRandValue = '_' . (String)mt_rand(1000, 9999);
		
			$strFileName = $strPrefix
			. $strYearMonthDayHourMinutesSeconds
			. $strMicroseconds
			. $strRandValue;
		
			return $strFileName;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
//------------------------------------------------------------------------------
	
	/**
	 * Cria um nome de pasta que usa o ano e o mês atuais como segue:
	 * pics_ + ano + mês.
	 */
	private function CreateFolderName()
	{
		try
		{
			$strPrefix    = 'pics_';
			$strYearMonth = date('Y-m');
		
			$strFolderName = $strPrefix . $strYearMonth . '/';
		
			return $strFolderName;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
//------------------------------------------------------------------------------
		
	/**
	 * Cria uma pasta dentro da pasta base informada; se a pasta a ser criada
	 * já existe, não gera um erro, usa a mesma.
	 * 
	 * @param string $strPath Nome da pasta
	 * @return boolean Se conseguiu criar a pasta ou se a mesma já existe
	 *  e possui permissão de escrita.
	 */
	private function MakeFolder($strPath, $intMode)
	{
		try
		{
			if( !is_string($strPath) )
			{
				throw new InvalidArgumentException('$strPath precisa ser uma ' 
						. 'string com o caminho completo da pasta a ser criada');	
			}
			
			$blnSuccess = false;
		
			if( file_exists($strPath) && is_writable($strPath) )
			{
				$blnSuccess = true;
			}
			else
			{
				$blnSuccess = mkdir($strPath, $intMode);
			}
		
			return $blnSuccess;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
//------------------------------------------------------------------------------
	
}