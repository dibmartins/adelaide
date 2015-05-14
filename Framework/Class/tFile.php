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
 * @version 1.0 - 2006-09-21 17:15:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class FileException extends Exception{}

/**
 * Classe de gerenciamento de arquivos do sistema
 * @package Framework
 * @subpackage Files
 * @version 1.0 - 2006-09-21 17:15:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.php.net/manual/pt_BR/ref.filesystem.php
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class File extends Collection
{
   /** 
    * Attributes:
    */   
   
   /**
	* @var string $strFile
	* @access private
	*/
	private $strFile;
	
   /**
	* @var string $strMode
	* @access private
	*/
	private $strMode;	
	
   /**
	* @var string $rscHandle
	* @access private
	*/
	private $rscHandle;

//---------------------------------------------------------------------------------------------	
	
   /** 
    * Properties:
    */   
   
   /**
	* Método para setar o valor do atributo $strFile
	* @param string $file Nome do arquivo ou diretorio a ser gerenciado
	* @return void		 
	* @access public
	*/
		public function SetFile($file)
		{
			 $this->strFile = (string) $file;
		}

   /**
	* Método para retornar o valor do atributo $strFile
	* @return string $strFile
	* @access public
	*/
		public function GetFile()
		{
			 return $this->strFile;
		}

   /**
	* Método para setar o valor do atributo $strMode
	* @param string $mode Modo de abertura do arquivo
	* @return void		 
	* @access public
	*/
		public function SetMode($mode)
		{
			 $this->strMode = (string) $mode;
		}

   /**
	* Método para retornar o valor do atributo $strMode
	* @return string $strMode
	* @access public
	*/
		public function GetMode()
		{
			 return $this->strMode;
		}
		
   /**
	* Método para setar o valor do atributo $rscHandle
	* @param string $handle Handle de conexão com o arquivo
	* @return void		 
	* @access public
	*/
		public function SetHandle($handle)
		{
			 $this->rscHandle = $handle;
		}

   /**
	* Método para retornar o valor do atributo $rscHandle
	* @return string $rscHandle
	* @access public
	*/
		public function GetHandle()
		{
			 return $this->rscHandle;
		}

//---------------------------------------------------------------------------------------------	
		
   /** 
    * Methods:
    */
	
   /**
	* Método construtor da classe
	* O modo padrão de abertura é somente leitura ('r')
	* Valores possíveis para $strMode
	* 'r'  Abre somente leitura; coloca o ponteiro no começo do arquivo.  
    * 'r+' Abre para leitura e escrita; coloca o ponteiro do arquivo no começo do arquivo.  
    * 'w'  Abre para escrita somente; coloca o ponteiro do arquivo no começo do arquivo e limpa seu conteúdo. Se o arquivo não existe, tenta criá-lo.  
    * 'w+' Abre o arquivo para leitura e escrita; coloca o ponteiro do arquivo no começo e limpa seu conteúdo. Se o arquivo não existe, tenta criá-lo.  
    * 'a'  Abre para escrita somente; coloca o ponteiro do arquivo no final. Se o arquivo não existe, tenta criá-lo.  
    * 'a+' Abre o arquivo para leitura e escrita; coloca o ponteiro do arquivo no final. Se o arquivo não existe, tenta criá-lo.  
    * 'x'  Cria e abre o arquivo para escrita somente; coloca o ponteiro no início do arquivo. Se o arquivo já existe, a chamada a fOpen() irá falhar, retornando FALSE e gerando um erro nível E_WARNING. Se o arquivo não existe, tenta criá-lo. Isto é o equivalente a informar as flags O_EXCL|O_CREAT numa chamada a open(2). Esta opção é suportada no PHP 4.3.2 e posteriores, e somente funciona em arquivos locais.  
    * 'x+' Cria e abre um arquivo para escrita e leitura; coloca o ponteiro do arquivo no início. Se o arquivo já existe, a chamada a fOpen() irá falhar, retornando FALSE e gerando um erro nível E_WARNING. Se o arquivo não existe, tenta criá-lo. Isto é o equivalente a informar as flags O_EXCL|O_CREAT numa chamada a open(2). Esta opção é suportada no PHP 4.3.2 e posteriores, e somente funciona em arquivos locais.  
	* @param string $strFile caminho para o arquivo a ser aberto
	* @param string $strMode Modo de abertura do arquivo
	* @return void
	* @access public
	*/
		public function __construct($strFile = '', $strMode = 'r')
		{
			 parent::__construct();
			 
			 $this->SetFile($strFile);
			 $this->SetMode($strMode);
			 $this->SetHandle(NULL);
			 
			 // Linpando o cache de arquivos
			 $this->ClearFileCache();
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
	* Método mágico que define como esta classe irá se comportar quando for convertida para uma string.
	* Este método é muito útil quando utilizamos $objFile->Read('string'); 
	* Para exibir o conteúdo lido como string basta imprimir o objeto: echo $objFile;
	* @return void
	* @access public
	*/        
		public function __toString() 
		{
           return file_get_contents($this->GetFile());
        }

   /**
	* Verifica se o arquivo existe
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function Exists()
	    {
		    if(file_exists($this->GetFile()))
			{
			    return true;
			}
			else
			{
			    throw new FileException("Arquivo ou diretório '".$this->GetFile()."' não foi encontrado");
			}
		}

   /**
	* Verifica se o arquivo possui Permissões de leitura 
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function Readable()
	    {
		    if(@is_readable($this->GetFile()))
			{
			    return true;
			}
			else
			{
			    throw new FileException("O arquivo '".$this->GetFile()."' não tem permissão de leitura");
			}
		}

   /**
	* Verifica se o arquivo possui Permissões de escrita
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function Writable($strFile = NULL)
	    {
	    	if($strFile == NULL)
	    	{
	    		$strFile = $this->GetFile();
	    	}
	    
		    if(@is_writable($strFile))
			{
			    return true;
			}
			else
			{
			    throw new FilePermitionDeniedException("O arquivo ou diretório '$strFile' não tem permissão de escrita");
			}
		}

   /**
	* Verifica se existe um recurso associado ao arquivo
	* @return boolean true se existir um recurso, caso contrário false
	* @access public
	*/
	    public function Opened($blnThrowException = true)
	    {	
		    if(is_resource($this->GetHandle()))
			{
			    return true;
			}
			else
			{
			    if($blnThrowException)
				{
				    throw new FileException("O arquivo '".$this->GetFile()."' não está aberto");
				}
			}
		}
		
   /**
	* Trava um arquivo
	* @return boolean Retorna as Permissões do arquivo, ou false em caso de erro.
	* @access public
	*/
	    public function Lock()
	    {
		    if($this->Opened())
			{
			    return @flock($this->GetHandle(), LOCK_EX);
			}	
		}
		
   /**
	* Destrava um arquivo bloqueado
	* @return boolean Retorna as Permissões do arquivo, ou false em caso de erro.
	* @access public
	*/
	    public function Unlock()
	    {
		    if($this->Opened())
			{
			    return @flock($this->GetHandle(), LOCK_UN);
			}	
		}		

   /**
	* Tenta mudar as Permissões do arquivo para o dado modo.
	* O parâmetro $intMode consiste em três números em octal especificando as
	* restrições de acesso para o proprietário, grupo de usuário do proprietário
	* e finalmente qualquer outro, nessa ordem. Cada número pode ser calculado 
	* pela adição das Permissões necessárias para o alvo. O número 1 significa
	* direito de execução, 2 significa direito de escrita, 4 significa direito
	* de leitura. Some esses números para ter os direitos desejados. 
	* @param string $intMode Permissão para o arquivo 
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function Chmod($intMode)
	    {
		    return @chmod($this->GetFile(), $intMode);
		}
	
   /**
	* Retorna as Permissões do arquivo
	* @return boolean Retorna as Permissões do arquivo, ou false em caso de erro.
	* @access public
	*/
	    public function Permissions()
	    {
		    return @fileperms($this->GetFile());
		}		

   /**
	* Dado as Permissões em uma string no formato '-rw-r--r--' retorna seu valor
	* equivalente em inteiro
	* Exemplos: 'drwxr-xr-x' retorna 755 'lrwxrwxrwx' retorna 777
	* @return boolean Retorna as Permissões do arquivo, ou false em caso de erro.
	* @access public
	*/
        public function ChmodToNum($strPems) 
		{
		    $strRealMode = "";
		    
			$arLegal    = array("","w","r","x","-");
		    
			$arAttarray = preg_split("//", $strPems);
		    
			for($i = 0; $i < count($arAttarray); $i++)
			{
			   if($key = array_search($arAttarray[$i], $arLegal))
			   {
				   $strRealMode .= $arLegal[$key];
			   }
		    }
		    
			$strPems  = str_pad($strRealMode, 9, '-');
		    
			$arTrans  = array('-'=>'0', 'r'=>'4', 'w'=>'2', 'x'=>'1');
		    
			$strPems  = strtr($strPems, $arTrans);
		    
			$intPerms = '';
		    
			$intPerms .= $strPems[0] + $strPems[1] + $strPems[2];
		    $intPerms .= $strPems[3] + $strPems[4] + $strPems[5];
		    $intPerms .= $strPems[6] + $strPems[7] + $strPems[8];
		    
			return $intPerms;
		} 

   /**
	* Retorna o conteúdo de uma linha do arquivo
	* @param int $intLength Tamanho da linha a ser retornado
	* @return string Conteúdo da linha
	* @access public
	*/
	    public function GetLineContent($intLength = 4096)
	    {
		    return @fgets($this->GetHandle(), $intLine);
		}

   /**
	* Retorna o tamanho em bytes do arquivo
	* Para arquivos entre 2GB e 4GB utilize sprintf("%u", File::Size());
	* @return int tamanho do arquivo
	* @access public
	*/
	    public function Size()
	    {
		    return @filesize($this->GetFile());
		}

   /**
	* Retorna o número de linhas do arquivo
	* Atenção este método faz com que o ponteiro aponte para o início do arquivo
	* @return int número de linhas do arquivo
	* @access public
	*/
	    public function Lines()
	    {	
		    $this->Restart();
			$this->Read();
			$this->Restart();
			
            return count(parent::GetCollection());
		}

   /**
	* Aponta para o início do arquivo
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function Restart()
	    {	
		    if($this->Opened())
			{
				return @rewind($this->GetHandle());				
			}
		}

   /**
	* Testa pelo begin-of-file (bof) em um ponteiro de arquivo
	* @return boolean true se o File::rscHandle estiver apontando para o início do arquivo, caso contrário false
	* @access public
	*/
	    public function Bof()
	    {	
		    if($this->Opened())
			{
				if(@ftell($this->GetHandle()) == 0)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}

   /**
	* Testa pelo end-of-file (eof) em um ponteiro de arquivo
	* @return boolean true se o File::rscHandle estiver apontando para o fim do arquivo, caso contrário false
	* @access public
	*/
	    public function Eof()
	    {	
		    if($this->Opened())
			{
				if(@feof($this->GetHandle()))
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}

   /**
	* Retorna o path do arquivo
	* @return string Path do arquivo
	* @access public
	*/
	    public function Path()
	    {
		    
			return @dirname($this->GetFile());
		}

   /**
	* Retorna o nome do arquivo retirando seu path
	* Se $blnExtension for true, o arquivo é retornado com sua extensão, caso contrário a extensão também é removida
	* @return string Nome do arquivo
	* @access public
	*/
	    public function Name($blnExtension = true)
	    {
		    if($blnExtension)
			{
			    return @basename($this->GetFile());
			}
			else
			{
			    return @basename($this->GetFile(), "." . $this->Extension());
			}	
		}
		
   /**
	* Renomeia o arquivo atual para $strNewName
	* Atenção! Chame File::Close() antes desta função. um arquivo para ser renomeado não pode estar aberto.
	* @param string $strNewName Novo nome para o arquivo: File::rename("new_file.txt"); 
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function Rename($strNewName)
	    {
		    if(!$this->Opened(false))
			{
				if(@rename($this->GetFile(), $strNewName))
				{
					$this->SetFile($strNewName);
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
			    throw new FileException("O arquivo que deseja renomear está aberto, por favor feche-o primeiro");
			}	
		}

   /**
	* Gera uma string única para utilizar como nome de arquivo
	* @return string String aleatória
	* @access public
	*/
	    public function UniqueName()
	    {
		    return substr(md5(uniqid(time())), 0, 10);
		}

   /**
	* Copia o arquivo atual para $strNewName
	* @param string $strNewName Destino da cópia do arquivo: File::rename("../tmp_file.txt"); 
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function Copy($strNewName)
	    {
		    return Copy($this->GetFile(), $strNewName);
		}

   /**
	* Copia o arquivo atual para $strTargetDir
	* @param string $strTargetDir diretório para onde o arquivo deve ser enviado;
	* @param int $intPerms Permissão do arquivo no diretório destino 
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function Upload($strTargetDir, $intPerms = 0644)
	    {
		    if($this->IsUploaded())
			{
			    if(move_uploaded_file($this->GetFile(), $strTargetDir))
				{
				    chmod($strTargetDir, 0777);
					
					return true;
				}
				else
				{
					throw new FileException("Erro desconhecido ao enviar o arquivo");
				}
			}
			else
			{
			    throw new FileException("Nenhum arquivo foi selecionado ou o arquivo não foi submetido via upload");
			}	
		}

   /**
	* Retorna a extensão do arquivo
	* @return string Extensão do arquivo
	* @access public
	*/
	    public function Extension()
	    {
		    if($this->IsFile())
			{
			    return substr($this->GetFile(), strlen($this->GetFile()) - 3, 3);
			}
		}

   /**
	* Verifica se o arquivo informado é um diretório ou não
	* @return boolean true se for um diretório, caso contrário false
	* @access public
	*/
	    public function IsDir()
	    {
		    return @is_dir($this->GetFile());
		}

   /**
	* Verifica se o arquivo informado é um arquivo ou não
	* @return boolean true se for um arquivo, caso contrário false
	* @access public
	*/
	    public function IsFile()
	    {
		    return @is_file($this->GetFile());
		}

   /**
    * Verifica se o arquivo foi submetido via HTTP
 	* @return boolean true se o arquivo foi submetido via HTTP, caso contrário false
	* @access public
	*/
	    public function IsUploaded()
	    {	
		    return @is_uploaded_file($this->GetFile());
		}

   /**
	* Retorna o tipo do arquivo
	* Retorna o tipo do arquivo (file type). Valores possiveis são fifo, char, dir, block, link, file e unknown (desconhecido).
	* @return boolean tipo do arquivo se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function Type()
	    {	
		    return @filetype($this->GetFile());
		}		

   /**
	* Retorna a data e o horário da última vez que o arquivo foi acessado.
	* @return boolean data e hora do último acesso se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function LastAccess()
	    {	
		    return @date("Y-m-d,H:i:s.", fileatime($this->GetFile()));
		}

   /**
	* Limpa as informações em cache de arquivos
	* @return void
	* @access public
	*/
	    public function ClearFileCache()
	    {	
		    @clearstatcache();
		}

   /**
	* Abre um arquivo
	* Seta em File::rscHandle o recurso de abertura do arquivo
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* Uma excessão será gerada caso o arquivo não seja informado 
	* @access public
	*/
		public function Open()
		{
		    $this->SetHandle(fopen($this->GetFile(), $this->GetMode()));
			
			if($this->Opened())
			{
				return true;
			}
			else
			{
				throw new FileException("Não foi possível abrir o arquivo");
			}
		}

   /**
	* Abre uma conexão via socket com uma url ou domínio Unix
	* Seta em File::rscHandle o recurso de abertura da url
	* @param int $intPort Porta de conexão.
	* @return boolean true se a conexão for estabelecida com sucesso, caso contrário false
	* Uma excessão será gerada caso o arquivo não seja informado 
	* @access public
	*/
		public function OpenSocket($intPort = 80)
		{
			$this->SetHandle(fsockopen($this->GetFile(), $intPort, $intErrorCode, $strErrorMsg, 60));
			
			if($this->Opened())
			{
				return true;
			}
			else
			{
				throw new FileException($strErrorMsg, $intErrorCode);
			}
		}		

   /**
	* Escreve um conteúdo no arquivo
	* @param string $strContent Conteúdo a ser gravado no arquivo	
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function Write($strContent)
	    {
		    if($this->Opened() && $this->Writable())
			{
			   // Escrevendo $strContent para o arquivo aberto.
               if(!@fwrite($this->GetHandle(), $strContent)) 
			   {
				   throw new FileException("Erro ao escrever no arquivo.");
			   }
			   else
			   {
			       // Mudando a data de modificação do arquivo...
				   @touch($this->GetFile());
				   
				   return true;
			   }
			}			
		}

   /**
	* Cria, escreve e fecha o arquivo automaticamente
	* @param string $strFile Caminho onde o arquivo será gravado	
	* @param string $strContent Conteúdo a ser gravado no arquivo	
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function PutContent($strFile, $strContent)
	    {
		    try
		    {
		    	return file_put_contents($strFile, $strContent);
		    }
		    catch(Exception $e)
		    {
		    	throw $e;
		    }					
		}

   /**
	* Há um arquivo para uma string ou para um array
	* A forma padrão é array onde cada elemento do array corresponde a uma linha no arquivo, 
	* Se a forma utilizada for string read retorna a string lida do arquivo
	* inclusive com o caracter de nova linha
	* Seta em parent::arCollection o conteúdo do arquivo
	* dependendo do tipo de leitura informado em $strForma
	* @param string $strForma Forma de retorno do arquivo lido. Valores possíveis: 'string' ou 'array'
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function Read($strForma = 'array')
	    {	
		    switch($strForma)
			{
				case 'array' : 
				{
					parent::SetCollection(@file($this->GetFile())); 
					break;
				}
				case 'string' :
				{
					return @file_get_contents($this->GetFile()); 
					break;
				}
				default : throw new FileException("Forma de leitura inválida");						
			}
			
			if(parent::GetCollection() !== false)
			{
				return true;
			}
			else 
			{
				throw new FileException("Não foi possível ler o arquivo");	
				return false;
			}				
		}
		
   /**
	* Fecha o recurso do arquivo aberto
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function Close()
	    {	
		    if($this->Opened())
			{
				if(@fclose($this->GetHandle()))
				{
					return true;
				}
				else
				{
					return false;
				}
			}			
		}
		
   /**
	* Deleta o arquivo do servidor
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function Delete()
	    {
		    if($this->exists())
			{
			    return unlink($this->GetFile());
			}
			else
			{
			    throw new FileException("Arquivo não encontrado");
			}	
		}
		
   /**
	* Compacta um arquivo no formato zip
	* @param $strZip Nome do arquivo zip a ser criado
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function Zip($strZip)
	    {
			$objZip = new Zip($strZip);
			
			if($objZip->Create($this->GetFile()) == 0)
			{
				throw new FileException($objZip->errorInfo(true));
			}
			else
			{
				return true;
			}
		}
		
   /**
	* Descompacta um arquivo zipado
	* @param $strZip Nome do arquivo zip a ser extraído
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function Extract()
	    {
			$objZip = new Zip($this->GetFile());
			
			if ($objZip->Extract() == 0) 
			{
				throw new FileException($objZip->errorInfo(true));
			}
			else
			{
				return true;
			}
		}

   /**
	* Realiza uma busca por uma palavra no arquivo
	* @param $strWord Palavra a ser pesquisada
	* @return array $arMatches Array com as linhas e colunas do arquivo que contém a palavra
	* @access public
	*/
	    public function Search($strWord)
	    {
			if(!$this->Opened(false))
			{
			    $this->Open();
			}
			
			$this->Read();
			
			$i     = 1;
			$index = 0;
			 
			foreach($this as $strLinha)
			{
			    $intColumn = strpos($strLinha, $strWord);
				
				if($intColumn !== false)
				{
				    $arMatches[$index]['line']   = $i;
					$arMatches[$index]['column'] = $intColumn;
					
					$index++;
				}
				
				$i++;
			}
			
			return $arMatches;
		}						
}
