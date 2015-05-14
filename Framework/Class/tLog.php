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
 * @subpackage Log
 * @version 1.0 - 2009-04-23 10:21:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class LogException extends Exception{}

/**
 * Classe de geração de logs do sistema
 * @package Framework 
 * @subpackage Log
 * @version 1.0 - 2009-04-23 10:21:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class Log
{
    /** 
     * Attributes:
     */   

    /**
     * Mensagem a ser gravada no log
     * @var string
     * @access private
     */
         private $strMessage;
   
    /**
     * Arquivo onde será gravado o log
     * @var string
     * @access private
     */
         private $strFile;
	 
    /**
     * Prioridade do registro de 1 (baixo) a 3 (alto)
     * @var int
     * @access private
     */
         private $intPriority;
		 

//---------------------------------------------------------------------------------------------	
	
   /** 
    * Properties:
    */

   /**
    * Método para setar o valor do atributo $strMessage
    * @return void		 
    * @access public
    */
	public function SetMessage($strMessage)
	{
	    $this->strMessage = $strMessage;
	}
    
    /**
     * Método para retornar o valor do atributo $strMessage
     * @return string $strMessage
     * @access public
     */
	public function GetMessage()
	{
	    return $this->strMessage;
	}

   /**
    * Método para setar o valor do atributo $strFile
    * @return void		 
    * @access public
    */
	public function SetFile($strFile)
	{
	    $this->strFile = $strFile;
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
    * Método para setar o valor do atributo $intPriority
    * @return void		 
    * @access public
    */
	public function SetPriority($intPriority)
	{
	    if($intPriority < 1 && $intPriority > 3)
		{
			throw new LogException('A prioridade do log deve ser um inteiro entre 1 e 3.');			
		}
		
		$this->intPriority = $intPriority;
	}
    
    /**
     * Método para retornar o valor do atributo $intPriority
     * @return string $intPriority
     * @access public
     */
	public function GetPriority()
	{
	    return $this->intPriority;
	}

//---------------------------------------------------------------------------------------------	
		
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
	    try
		{
			$strFile = SystemConfig::PATH;
			$strFile.= SystemConfig::LOG_SYSTEM_DIR;
            $strFile.= $this->CreateLogFileName();
			
			$this->SetMessage('');
			$this->SetFile($strFile);
			$this->SetPriority(SystemConfig::LOG_DEFAULT_PRIORITY);
		}
		catch(Exception $e)
		{
			throw $e;
		}
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
     * Retorna um nome para o arquivo de log
     * Exemplo 20090423.xml nome do arquivo de log gerado no dia 23/04/2009
     * @return string
     * @access private
     */
	private function CreateLogFileName()
	{
		try
		{
			list($strDate, $strTime) = explode(' ', Date::Now());
			
			return str_replace('-', '', $strDate) . '.xml';
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}

    /**
     * Formata o registro a ser salvo no log
     * @return object SimpleXMLElement
     * @access private
     */
	private function UpdateLog()
	{
		try
		{
			$objXML = new XML();
			
			$objXmlLog = $objXML->LoadFile($this->GetFile());
           
			if(!$objXmlLog instanceof SimpleXMLElement)
			{
				$objXmlLog = new SimpleXMLElement('<?xml version = "1.0" encoding = "iso-8859-1"?><system></system>');
                
                //throw new LogException('Erro ao ler o arquivo de log ('.$this->GetFile().'). XML inválido!');
			}

            // Obtém as informações do navegador e so do usuário
            extract(Browser::Detect());
            
			$objLog = $objXmlLog->AddChild('log');
			$objLog->addAttribute('id'   , Utils::UniqueId());
			
            // Esse trecho é necessário para incluir um elemento cdata
            // que pode conter caracteres especiais. é o caso do elemento message
            $objMessageNode = $objLog->AddChild('message');
            $objNode     = dom_import_simplexml($objMessageNode);
            $objOwnerDoc = $objNode->ownerDocument;
            $objNode->appendChild($objOwnerDoc->createCDATASection(htmlentities($this->strMessage))); 
            
            $objLog->AddChild('file'     , $_SERVER['SCRIPT_NAME']);
            $objLog->AddChild('priority' , $this->intPriority);
            $objLog->AddChild('datetime' , Date::Now());
            $objLog->AddChild('ip'       , Utils::UserIP());
			$objLog->AddChild('browser' , $strBrowser.' '.$strVersion);
            $objLog->AddChild('os'       , $strPlatform);
           
			return $objXmlLog;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
    /**
     * Cria/Atualiza o arquivo de log
     * @return boolean
     * @access private
     */
	public function Save($blnReturn = false)
	{
		try
		{
        	$strLog = $this->UpdateLog()->asXML();

			if($blnReturn) return $strLog;        	
        	
            $objFile = new File($this->GetFile(), 'w+');
			$objFile->Open();
            $objFile->Write($strLog);
			$objFile->Close();
		}
		catch(Exception $e)
		{
			throw $e;
		}
	} 	
}