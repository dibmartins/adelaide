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
 * Classe de gerenciamento de diretórios do sistema
 *
 * Esta classe utiliza as classes ArrayAccess e IteratorAggregate do pacote SPL do PHP
 * @package Framework
 * @subpackage Files
 * @version 1.0 - 2006-09-21 17:15:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.php.net/manual/pt_BR/ref.dir.php
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class Folder extends Collection
{
   /** 
    * Attributes:
    */   
   
   /**
	* @var string $strFolder
	* @access private
	*/
	private $strFolder;
	
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
	* Método para setar o valor do atributo $strFolder
	* @param string $dir Nome do diretório a ser gerenciado
	* @return void		 
	* @access public
	*/
		public function SetFolder($dir)
		{
			 $this->strFolder = (string) $dir;
		}

   /**
	* Método para retornar o valor do atributo $strFolder
	* @return string $strFolder
	* @access public
	*/
		public function GetFolder()
		{
			 return $this->strFolder;
		}

   /**
	* Método para setar o valor do atributo $rscHandle
	* @param string $handle Handle de conexão com o diretório
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
	* @param string $strFolder caminho para o diretório a ser gerenciado
	* @return void
	* @access public
	*/
		public function __construct($strFolder = '')
		{
			 parent::__construct();
			 
			 $this->SetFolder($strFolder);
			 $this->SetHandle(NULL);
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
	* Verifica se existe um recurso associado ao diretório
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
				    throw new Exception("O diretório '".$this->GetFolder()."' não está aberto");
				}
				else
				{
				   return false;
				}
			}
		}

   /**
	* Verifica se o diretório já foi scaneado
	* @return boolean true se já foi scaneado, caso contrário false
	* @access public
	*/
	    public function Scaned($blnThrowException = true)
	    {	
		    if(count(parent::GetCollection()) > 0)
			{
			    return true;
			}
			else
			{
			    if($blnThrowException)
				{
				    throw new Exception("O diretório '".$this->GetFolder()."' não foi lido");
				}
				else
				{
				   return false;
				}
			}
		}

   /**
	* Abre um diretório
	* Seta em Folder::rscHandle o recurso de abertura do diretório
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* Uma excessão será gerada caso o diretório não seja informado 
	* @access public
	*/
		public function Open()
		{
			if(is_dir($this->GetFolder()))
			{
				$this->SetHandle(@opendir($this->GetFolder()));
				
				if($this->Opened())
				{
					return true;
				}
				else
				{
					throw new Exception("não foi possível abrir o diretório");
				}
			}
			else
			{
				throw new Exception("diretório \"".$this->GetFolder()."\" não encontrado");
			}
		}
		
   /**
	* Muda de diretório
	* Seta em Folder::strFolder o novo diretório
	* @param string $strFolder Nome do novo diretório
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
		public function Change($strFolder)
		{
		    $this->Close();
			
			$this->SetFolder($strFolder);
			
			$this->Open();
		    parent::SetCollection(NULL);
				
			if(chdir($strFolder))
			{
				return true;
			}
			else
			{
				throw new Exception("não foi possível mudar para o diretório especificado");
			}
		}

   /**
	* Volta (rewind) o handle de diretório
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
		public function Rewind()
		{
		    if($this->Opened())
			{
			    @rewinddir($this->GetHandle());
				return true;
			}
		}

   /**
	* Deleta o diretório
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
		public function Delete()
		{
		    if($this->Opened(false))
			{
			    $this->Rewind();
				$this->Scan();
			}
			else
			{
			    $this->Open();
				$this->Scan();
			}
			
			$this->Close();
			
			if(count(parent::GetCollection()) == 0)
			{
			    return rmdir($this->GetFolder());
			}
			else
			{
			    throw new Exception("O diretório \"".$this->GetFolder()."\" não pode ser removido porque ele não está vazio");
			}	
		}

   /**
	* Retorna o espaço disponível no diretório
	* @param string $strFolder Nome do diretório
	* @return float Espaço em disco
	* @access public
	*/
		public function FreeEspace($strFolder)
		{
		    return @disk_free_space($strFolder);
		}

   /**
	* Cria um novo diretório
	* @param string $strFolder Nome do diretório a ser criado
	* @param string $intMode Permissões de acesso
	* O parâmetro $intMode consiste em três números em octal especificando as restrições de acesso para o proprietário, 
	* grupo de usuário do proprietário e finalmente qualquer outro, nessa ordem. Cada número pode ser calculado 
	* pela adição das Permissões necessárias para o alvo. O número 1 significa direito de execução, 
	* 2 significa direito de escrita, 4 significa direito de leitura. Some esses números para ter os direitos desejados. 
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
		public function Create($strFolder, $intMode = 0777)
		{
		    return @mkdir($strFolder, $intMode);
		}

   /**
	* Fecha o recurso do diretório aberto
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function Close()
	    {	
		    if($this->Opened())
			{
				if(@closedir($this->GetHandle()))
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
	* Apaga todos os arquivos do diretório atual
	* Obs.: diretórios não são removidos
	* @return void
	* @access public
	*/
	    public function Clear()
	    {	
		    if($this->Opened() && $this->Scaned())
			{
				foreach(parent::GetCollection() as $strFile)
				{
					$objFile = new File($this->GetFolder() . "/" . $strFile);
					
					if($objFile->IsFile())
					{
						$objFile->Delete();
					}   
				}
			}			
		}
		
   /**
	* Lista todo o conteúdo do diretório
	* Seta em parent::arCollection o conteúdo do diretório
	* @param $intSorting Ordenação da listagem : 0 para ascendente, 1 para descendente
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function Scan($intSorting = 0)
	    {	
		    if($this->Opened())
			{	
				while(($strFilename = @readdir($this->GetHandle())) !== false) 
				{
                     $arFiles[] = $strFilename;					 
                }
				
				// Retirando o . e .. do conteúdo do diretório
				if($this->GetFolder != "/")
				{
				    unset($arFiles[0]);
					unset($arFiles[1]);
					
					sort($arFiles);
				}
				
				switch($intSorting)
				{
					case 0 : 
					{
						// Ordenando de forma ascendente:
						@sort($arFiles);
						
						parent::SetCollection($arFiles); 
						break;
					}
					case 1 :
					{
						// Ordenando de forma descendente:
						@rsort($arFiles);
						
						parent::SetCollection($arFiles); 
						break;
					}
					
					default : throw new Exception("Forma de ordenação inválida");						
				}
				
				if(parent::GetCollection() !== false)
				{
					return true;
				}
				else 
				{
					throw new Exception("não foi possível ler o arquivo");	
					return false;
				}				
			}				
		}
}
