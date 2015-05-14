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
 * @version 1.0 - 2006-11-21 08:30:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class FileUploadException extends Exception{}

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
 * Classe de upload de arquivos via HTTP
 * @package Framework
 * @subpackage Files
 * @version 1.0 - 2006-11-21 08:30:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class FileUpload
{
   /** 
    * Attributes:
    */

   /**
    * Arquivo enviado via HTTP
    * @var 	$objRequestFile
	* @access 	private
	*/		
	private $objRequestFile;

   /**
    * Mime Types Suportados
    * @var 	$arMimeTypes
	* @access 	private
	*/		
	private $arMimeTypes;

   /**
    * Mime Types Habilitados
    * @var 	$arEnabledMimeTypes
	* @access 	private
	*/		
	private $arEnabledMimeTypes;

   /**
    * Define o tamanho máximo permitido para envio
    * @var 	$intMaxSize
	* @access 	private
	*/		
	private $intMaxSize;
	
   /**
    * diretório para onde o arquivo será enviado
    * @var 	$strDirectory
	* @access 	private
	*/		
	private $strDirectory;
	
   /**
    * Prefixo a ser inserido no nome do arquivo
    * @var 	$strPrefix
	* @access 	private
	*/		
	private $strPrefix;
	
   /**
    * Armazena o novo nome do arquivo 
    * @var 	$strName
	* @access 	private
	*/		
	private $strName;
	
   /**
    * Caractere de quebra de linha nas mensagens de erro
    * @var 	$strNewLine
	* @access 	private
	*/		
	private $strNewLine;	
	
//---------------------------------------------------------------------------------------   

   /** 
    * Properties:
    */

   /**
	* Método para setar o valor do atributo $objRequestFile
	* @return void		 
	* @access public
	*/
		public function SetRequestFile($objRequestFile)
		{
			 $this->objRequestFile = $objRequestFile;
		}

   /**
	* Método para retornar o valor do atributo $objRequestFile
	* @return string $objRequestFile
	* @access public
	*/
		public function GetRequestFile()
		{
			 return $this->objRequestFile;
		}

   /**
	* Método para setar o valor do atributo $arMimeTypes
	* @return void		 
	* @access public
	*/
		public function SetMimeTypes()
		{
			 $arMimeTypes['gif']  = array("image/gif");
			 $arMimeTypes['bmp']  = array("image/bmp");
		 	 $arMimeTypes['png']  = array("image/png", "image/x-png");
			 $arMimeTypes['tiff'] = array("image/tiff");
			 $arMimeTypes['jpg']  = array("image/jpg", "image/jpeg", "image/pjpeg");
			 $arMimeTypes['swf']  = array("application/x-shockwave-flash");
			 $arMimeTypes['zip']  = array("application/zip", "application/x-zip-compressed");
			 $arMimeTypes['gz']   = array("application/x-gzip");
			 $arMimeTypes['doc']  = array("text/richtext", "application/msword");
			 $arMimeTypes['pdf']  = array("application/pdf");
			 $arMimeTypes['xls']  = array("application/vnd.ms-excel", "application/x-excel");
			 $arMimeTypes['doc']  = array("x-type/x-doc");
			 $arMimeTypes['pps']  = array("application/vnd.ms-powerpoint");
			 
			 $this->arMimeTypes = $arMimeTypes;			 
		}

   /**
	* Método para retornar o valor do atributo $arMimeTypes
	* @return string $arMimeTypes
	* @access public
	*/
		public function GetMimeTypes()
		{
			 return $this->arMimeTypes;
		}

   /**
	* Método para setar o valor do atributo $arEnabledMimeTypes
	* @return void		 
	* @access public
	*/
		public function SetEnabledMimeTypes($arEnabledMimeTypes)
		{
			 $this->arEnabledMimeTypes = $arEnabledMimeTypes;
		}

   /**
	* Método para retornar o valor do atributo $arEnabledMimeTypes
	* @return string $arEnabledMimeTypes
	* @access public
	*/
		public function GetEnabledMimeTypes()
		{
			 return $this->arEnabledMimeTypes;
		}

   /**
	* Método para setar o valor do atributo $intMaxSize
	* @return void		 
	* @access public
	*/
		public function SetMaxSize($intMaxSize)
		{
			 $this->intMaxSize = $intMaxSize;
		}

   /**
	* Método para retornar o valor do atributo $intMaxSize
	* @return string $intMaxSize
	* @access public
	*/
		public function GetMaxSize()
		{
			 return $this->intMaxSize;
		}

   /**
	* Método para setar o valor do atributo $strDirectory
	* @return void		 
	* @access public
	*/
		public function SetDirectory($strDirectory)
		{
			 $this->strDirectory = $strDirectory;
		}

   /**
	* Método para retornar o valor do atributo $strDirectory
	* @return string $strDirectory
	* @access public
	*/
		public function GetDirectory()
		{
			 return $this->strDirectory;
		}

   /**
	* Método para setar o valor do atributo $strPrefix
	* @return void		 
	* @access public
	*/
		public function SetPrefix($strPrefix)
		{
			 $this->strPrefix = $strPrefix;
		}

   /**
	* Método para retornar o valor do atributo $strPrefix
	* @return string $strPrefix
	* @access public
	*/
		public function GetPrefix()
		{
			 return $this->strPrefix;
		}

   /**
	* Método para setar o valor do atributo $strName
	* @return void		 
	* @access public
	*/
		public function SetName($strName)
		{
			 $this->strName = $strName;
		}

   /**
	* Método para retornar o valor do atributo $strName
	* @return string $strName
	* @access public
	*/
		public function GetName()
		{
			 return $this->strName;
		}

   /**
	* Método para setar o valor do atributo $strNewLine
	* @return void		 
	* @access public
	*/
		public function SetNewLine($strNewLine)
		{
			 $this->strNewLine = $strNewLine;
		}

   /**
	* Método para retornar o valor do atributo $strNewLine
	* @return string $strNewLine
	* @access public
	*/
		public function GetNewLine()
		{
			 return $this->strNewLine;
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
		    $this->SetRequestFile(new RequestFile());
			$this->SetMimeTypes();
			$this->SetEnabledMimeTypes("");
			$this->SetMaxSize(1048576); // 1 Mega Byte
			$this->SetDirectory(SystemConfig::PATH . SystemConfig::UPLOAD_PATH);
			$this->SetPrefix("");
			$this->SetName("");
			$this->SetNewLine("<br>"); // <br> ou \\n
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
	 * Retorna o tipo do arquivo enviado
	 * @return string Tipo do arquivo
	 * @access private
	 */
		protected function FileType()
		{	
			foreach($this->GetMimeTypes() as $strKey => $arMimes)
			{
				foreach($arMimes as $strMimeType)
				{
					if($this->GetRequestFile()->type == $strMimeType)
					{
						$strFileType = $strKey;
						break;
					}
				}
			}
			
			if(empty($strFileType))
			{
			    $strFileType = 'desconhecido';
			}
			
			return $strFileType;
		}

	/**
	 * Retorna um nome único para o arquivo enviado
	 * O nome do arquivo é composto pelo diretorio + [prefixo] + data de hoje + nomeDoArquivo.extensão
	 * ../Images/image_2211200624dsf34css.jpg
	 * @return void
	 * @access private
	 */
		protected function FileUniqueName()
		{
		    try
			{
				$objFile = new File();
				
				$strPrefix = $this->GetPrefix();
				if(!empty($strPrefix))
				{
					$strPrefix .= "_";
				}
				
				$uniqueName = $this->GetDirectory();
				$uniqueName.= $strPrefix;
				$uniqueName.= date('dmY');
				$uniqueName.= $objFile->UniqueName();
				$uniqueName.= "." . $this->FileType();
				
				$this->SetName($uniqueName);
				
				return $uniqueName;
			}
			catch(Exception $e)
			{
			    throw new FileUploadException($e->GetMessage());
			}	
		}

   /**
	* Verifica se é um arquivo válido para upload
	* @return boolean true se o arquivo for válido, caso contrário false
	* @access public
	*/
	    protected function FileValidate()
	    {
			try
			{
				if(is_null($this->GetRequestFile()->GetFile()))
				{
					throw new Exception("Nenhum arquivo a ser enviado ao servidor");
				}
				
				if(!is_array($this->GetEnabledMimeTypes()))
				{
					throw new Exception("Os tipos permitidos para envio não foram configurados");
				}
				
				$objFile = new File($this->GetRequestFile()->tmp_name);
				
				// Verificando o tamanho KB da imagem
				if($this->GetRequestFile()->size > $this->GetMaxSize())
				{
					$strError = "O tamanho do arquivo ultrapassou o limite permitido!";
					$strError.= $this->GetNewLine();
					$strError.= "Arquivo enviado: "  . round($this->GetRequestFile()->size / 1024, 2) . " Kb";
					$strError.= $this->GetNewLine();
					$strError.= "Limite permitido: " . round($this->GetMaxSize() / 1024, 2) . " Kb";
					
					throw new FileUploadException($strError);
				}
	
				// Verificando se o tipo de arquivo é válido
				if(!in_array($this->FileType(), $this->GetEnabledMimeTypes()))
				{
					$strError = "O tipo do arquivo enviado (".$this->FileType().") é inválido";
					$strError.= $this->GetNewLine();
					$strError.= "Tipo(s) de arquivo permitido(s): ";
					
					foreach($this->GetEnabledMimeTypes() as $value)
					{
						$strError .= $value . ", ";
					}
					
					// Retirando a última virgula no final da string
					$strError = substr($strError, 0, (strlen($strError) - 2));
					
					throw new FileUploadException($strError);
				}
				
				// Verificando se o diretório especificado existe
				$objDir = new File($this->GetDirectory());				
				$objDir->exists();
				
				unset($objFile);
				unset($objDir);
				
				// Arquivo válido!
				return true;
			}
			catch(Exception $e)
			{
				throw new FileUploadException($e->GetMessage());
			}	
		}
		
   /**
	* Realiza o upload do arquivo
	* @return boolean true se o arquivo for enviado com sucesso, caso contrário gera uma excessão
	* @access public
	*/
	    public function Upload()
		{
		    try
			{ 
				$this->FileValidate();
			 
			    $objFile = new File($this->GetRequestFile()->tmp_name);
			    
				return $objFile->Upload($this->FileUniqueName());			 
			}
			catch(Exception $e)
			{
				throw new FileUploadException($e->GetMessage());
			}
		}		
}
