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
 * @subpackage RSS
 * @version 1.0 - 2006-11-27 13:07:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class RSSException extends Exception{}

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
 * Classe responsável pela geração de feeds RSS
 * O RSS gerado foi validado pelo W3C, o link para validação é citado abaixo
 * @package Framework
 * @subpackage RSS
 * @version 1.0 - 2006-11-27 13:07:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://validator.w3.org/feed/
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class RSS extends XML
{
   
   /** 
	* Attributes:
    */

   /**
	* Armazena o arquivo xml a ser lido/gerado.
	* @var string $strXMLFile
	* @access private
	*/
	private $strXMLFile;
		
   /**
	* Armazena o título do arquivo.
	* @var string $strChannelTitle
	* @access private
	*/
	private $strChannelTitle;
		
   /**
	* Armazena o link para o site.
	* @var string $strChannelLink
	* @access private
	*/
	private $strChannelLink;	
		
   /**
	* Armazena a descrição do arquivo.
	* @var string $strChannelDescription
	* @access private
	*/
	private $strChannelDescription;
		
   /**
	* Armazena a linguagem do arquivo.
	* @var string $strChannelLanguage
	* @access private
	*/
	private $strChannelLanguage;
		
   /**
	* Armazena o e-mail do editor do arquivo.
	* @var string $strChannelManagingEditor
	* @access private
	*/
	private $strChannelManagingEditor;
		
   /**
	* Armazena o e-mail do webmaster do sistema.
	* @var string $strChannelWebMaster
	* @access private
	*/
	private $strChannelWebMaster;	
		
   /**
	* Armazena a categoria do arquivo.
	* @var string $strChannelCategory
	* @access private
	*/
	private $strChannelCategory;
		
   /**
	* Armazena o nome do sistema que gerou o arquivo.
	* @var string $strChannelGenerator
	* @access private
	*/
	private $strChannelGenerator;
		
   /**
	* Armazena o copyright do site.
	* @var string $strChannelCopyright
	* @access private
	*/
	private $strChannelCopyright;
		
   /**
	* Armazena o titulo da imagem do arquivo.
	* @var string $strChannelImageTitle;
	* @access private
	*/
	private $strChannelImageTitle;
					
   /**
	* Armazena a url da imagem do arquivo.
	* @var string $strChannelImageUrl;
	* @access private
	*/
	private $strChannelImageUrl;
		
   /**
	* Armazena o link da imagem do arquivo.
	* @var string $strChannelImageLink;
	* @access private
	*/
	private $strChannelImageLink;	
		
   /**
	* Armazena a data de geração do arquivo.
	* @var string $strChannelLastBuildDate;
	* @access private
	*/
	private $strChannelLastBuildDate;
		
   /**
	* Armazena o tempo em minutos que um canal 
	* pode ficar armazenado em cache antes de ser atualizado no código. 
	* @var string $strChannelTTL;
	* @access private
	*/
	private $strChannelTTL;
		
   /**
	* Armazena o título do item
	* @var string $strItemTitle;
	* @access private
	*/
	private $strItemTitle;
		
   /**
	* Armazena o link do item
	* @var string $strItemLink;
	* @access private
	*/
	private $strItemLink;
		
   /**
	* Armazena a descrição do item
	* @var string $strItemDescription
	* @access private
	*/
	private $strItemDescription;	
		
   /**
	* Armazena a data de publicação do item, 
	* a data deve ser do formato datetime ou timestamp : 9999-99-99 00:00:00
	* @var string $strItemPubDate;
	* @access private
	*/
	private $strItemPubDate;
			
   /**
	* Armazena o identificador do item
	* Geralmente é o mesmo valor do link do item 
	* @var string $strItemGuid;
	* @access private
	*/
	private $strItemGuid;
   
//---------------------------------------------------------------------------------------   

   /** 
    * Properties:
    */

   /**
	* Método para setar o valor do atributo $strXMLFile
	* @return void		 
	* @access public
	*/
		public function SetXMLFile($strXMLFile)
		{
			 $this->strXMLFile = $strXMLFile;
		}

   /**
	* Método para retornar o valor do atributo $strXMLFile
	* @return string $strXMLFile
	* @access public
	*/
		public function GetXMLFile()
		{
			 return $this->strXMLFile;
		}

   /**
	* Método para setar o valor do atributo $strChannelTitle
	* @return void		 
	* @access public
	*/
		public function SetChannelTitle($strChannelTitle)
		{
			 $this->strChannelTitle = $strChannelTitle;
		}

   /**
	* Método para retornar o valor do atributo $strChannelTitle
	* @return string $strChannelTitle
	* @access public
	*/
		public function GetChannelTitle()
		{
			 return $this->strChannelTitle;
		}

   /**
	* Método para setar o valor do atributo $strChannelLink
	* @return void		 
	* @access public
	*/
		public function SetChannelLink($strChannelLink)
		{
			 $this->strChannelLink = $strChannelLink;
		}

   /**
	* Método para retornar o valor do atributo $strChannelLink
	* @return string $strChannelLink
	* @access public
	*/
		public function GetChannelLink()
		{
			 return $this->strChannelLink;
		}

   /**
	* Método para setar o valor do atributo $strChannelDescription
	* @return void		 
	* @access public
	*/
		public function SetChannelDescription($strChannelDescription)
		{
			 $this->strChannelDescription = $strChannelDescription;
		}

   /**
	* Método para retornar o valor do atributo $strChannelDescription
	* @return string $strChannelDescription
	* @access public
	*/
		public function GetChannelDescription()
		{
			 return $this->strChannelDescription;
		}

   /**
	* Método para setar o valor do atributo $strChannelLanguage
	* @return void		 
	* @access public
	*/
		public function SetChannelLanguage($strChannelLanguage)
		{
			 $this->strChannelLanguage = $strChannelLanguage;
		}

   /**
	* Método para retornar o valor do atributo $strChannelLanguage
	* @return string $strChannelLanguage
	* @access public
	*/
		public function GetChannelLanguage()
		{
			 return $this->strChannelLanguage;
		}
		
   /**
	* Método para setar o valor do atributo $strChannelManagingEditor
	* @return void		 
	* @access public
	*/
		public function SetChannelManagingEditor($strChannelManagingEditor)
		{
			 $this->strChannelManagingEditor = $strChannelManagingEditor;
		}

   /**
	* Método para retornar o valor do atributo $strChannelManagingEditor
	* @return string $strChannelManagingEditor
	* @access public
	*/
		public function GetChannelManagingEditor()
		{
			 return $this->strChannelManagingEditor;
		}
		
   /**
	* Método para setar o valor do atributo $strChannelWebMaster
	* @return void		 
	* @access public
	*/
		public function SetChannelWebMaster($strChannelWebMaster)
		{
			 $this->strChannelWebMaster = $strChannelWebMaster;
		}

   /**
	* Método para retornar o valor do atributo $strChannelWebMaster
	* @return string $strChannelWebMaster
	* @access public
	*/
		public function GetChannelWebMaster()
		{
			 return $this->strChannelWebMaster;
		}
		
   /**
	* Método para setar o valor do atributo $strChannelCategory
	* @return void		 
	* @access public
	*/
		public function SetChannelCategory($strChannelCategory)
		{
			 $this->strChannelCategory = $strChannelCategory;
		}

   /**
	* Método para retornar o valor do atributo $strChannelCategory
	* @return string $strChannelCategory
	* @access public
	*/
		public function GetChannelCategory()
		{
			 return $this->strChannelCategory;
		}
		
   /**
	* Método para setar o valor do atributo $strChannelGenerator
	* @return void		 
	* @access public
	*/
		public function SetChannelGenerator($strChannelGenerator)
		{
			 $this->strChannelGenerator = $strChannelGenerator;
		}

   /**
	* Método para retornar o valor do atributo $strChannelGenerator
	* @return string $strChannelGenerator
	* @access public
	*/
		public function GetChannelGenerator()
		{
			 return $this->strChannelGenerator;
		}
		
   /**
	* Método para setar o valor do atributo $strChannelCopyright
	* @return void		 
	* @access public
	*/
		public function SetChannelCopyright($strChannelCopyright)
		{
			 $this->strChannelCopyright = $strChannelCopyright;
		}

   /**
	* Método para retornar o valor do atributo $strChannelCopyright
	* @return string $strChannelCopyright
	* @access public
	*/
		public function GetChannelCopyright()
		{
			 return $this->strChannelCopyright;
		}
		
   /**
	* Método para setar o valor do atributo $strChannelImageTitle
	* @return void		 
	* @access public
	*/
		public function SetChannelImageTitle($strChannelImageTitle)
		{
			 $this->strChannelImageTitle = $strChannelImageTitle;
		}

   /**
	* Método para retornar o valor do atributo $strChannelImageTitle
	* @return string $strChannelImageTitle
	* @access public
	*/
		public function GetChannelImageTitle()
		{
			 return $this->strChannelImageTitle;
		}
		
   /**
	* Método para setar o valor do atributo $strChannelImageUrl
	* @return void		 
	* @access public
	*/
		public function SetChannelImageUrl($strChannelImageUrl)
		{
			 $this->strChannelImageUrl = $strChannelImageUrl;
		}

   /**
	* Método para retornar o valor do atributo $strChannelImageUrl
	* @return string $strChannelImageUrl
	* @access public
	*/
		public function GetChannelImageUrl()
		{
			 return $this->strChannelImageUrl;
		}
		
   /**
	* Método para setar o valor do atributo $strChannelImageLink
	* @return void		 
	* @access public
	*/
		public function SetChannelImageLink($strChannelImageLink)
		{
			 $this->strChannelImageLink = $strChannelImageLink;
		}

   /**
	* Método para retornar o valor do atributo $strChannelImageLink
	* @return string $strChannelImageLink
	* @access public
	*/
		public function GetChannelImageLink()
		{
			 return $this->strChannelImageLink;
		}
		
   /**
	* Método para setar o valor do atributo $strChannelLastBuildDate
	* @return void		 
	* @access public
	*/
		public function SetChannelLastBuildDate($strChannelLastBuildDate)
		{
			 $this->strChannelLastBuildDate = $strChannelLastBuildDate;
		}

   /**
	* Método para retornar o valor do atributo $strChannelLastBuildDate
	* @return string $strChannelLastBuildDate
	* @access public
	*/
		public function GetChannelLastBuildDate()
		{
			 return $this->strChannelLastBuildDate;
		}
		
   /**
	* Método para setar o valor do atributo $strChannelTTL
	* @return void		 
	* @access public
	*/
		public function SetChannelTTL($strChannelTTL)
		{
			 $this->strChannelTTL = $strChannelTTL;
		}

   /**
	* Método para retornar o valor do atributo $strChannelTTL
	* @return string $strChannelTTL
	* @access public
	*/
		public function GetChannelTTL()
		{
			 return $this->strChannelTTL;
		}
		
   /**
	* Método para setar o valor do atributo $strItemTitle
	* @return void		 
	* @access public
	*/
		public function SetItemTitle($strItemTitle)
		{
			 $this->strItemTitle = $strItemTitle;
		}

   /**
	* Método para retornar o valor do atributo $strItemTitle
	* @return string $strItemTitle
	* @access public
	*/
		public function GetItemTitle()
		{
			 return $this->strItemTitle;
		}
		
   /**
	* Método para setar o valor do atributo $strItemLink
	* @return void		 
	* @access public
	*/
		public function SetItemLink($strItemLink)
		{
			 $this->strItemLink = $strItemLink;
		}

   /**
	* Método para retornar o valor do atributo $strItemLink
	* @return string $strItemLink
	* @access public
	*/
		public function GetItemLink()
		{
			 return $this->strItemLink;
		}
		
   /**
	* Método para setar o valor do atributo $strItemDescription
	* @return void		 
	* @access public
	*/
		public function SetItemDescription($strItemDescription)
		{
			 $this->strItemDescription = $strItemDescription;
		}

   /**
	* Método para retornar o valor do atributo $strItemDescription
	* @return string $strItemDescription
	* @access public
	*/
		public function GetItemDescription()
		{
			 return $this->strItemDescription;
		}
		
   /**
	* Método para setar o valor do atributo $strItemPubDate
	* @return void		 
	* @access public
	*/
		public function SetItemPubDate($strItemPubDate)
		{
			 $this->strItemPubDate = $strItemPubDate;
		}

   /**
	* Método para retornar o valor do atributo $strItemPubDate
	* @return string $strItemPubDate
	* @access public
	*/
		public function GetItemPubDate()
		{
			 return $this->strItemPubDate;
		}
		
		
   /**
	* Método para setar o valor do atributo $strItemGuid
	* @return void		 
	* @access public
	*/
		public function SetItemGuid($strItemGuid)
		{
			 $this->strItemGuid = $strItemGuid;
		}

   /**
	* Método para retornar o valor do atributo $strItemGuid
	* @return string $strItemGuid
	* @access public
	*/
		public function GetItemGuid()
		{
			 return $this->strItemGuid;
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
			
			$this->SetXMLFile("");
			$this->SetChannelTitle("");
			$this->SetChannelLink("");
			$this->SetChannelDescription("");
			$this->SetChannelLanguage("pt-br");
			$this->SetChannelManagingEditor("");
			$this->SetChannelWebmaster("");
			$this->SetChannelCategory("");
			$this->SetChannelGenerator("");
			$this->SetChannelCopyright("");
			$this->SetChannelImageTitle("");
			$this->SetChannelImageUrl("");
			$this->SetChannelImageLink("");
			$this->SetChannelLastBuildDate(date('r'));
			$this->SetChannelTTL("20");
			$this->SetItemTitle("");
			$this->SetItemLink("");
			$this->SetItemDescription("");
			$this->SetItemPubdate("");
			$this->SetItemGuid("");
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
	* Retorna o caractere de fim de linha de acordo com o sistema operacional em que está o PHP.
	* @return string Caractere de fim de linha
	* @access public
	*/
		private function GetLineBreak()
		{
			  switch(strtoupper(substr(PHP_OS, 0, 3)))
			  {
				   case 'WIN' : return "\r\n"; break;
				   case 'MAC' : return "\r";   break;
				   default    : return "\n";   break;
			  }
		}

  /**
   * Método que grava o código xml passado como parâmetro no arquivo xml especficado em $this->GetXMLFile().
   * return boolean
   * @access public
   */	
	   public function WriteToFile($strRSS)
	   {
	       $objFile = new File($this->GetXMLFile(), 'w');
		   $objFile->Open();
		   $objFile->Write($strRSS);
		   $objFile->Close();		   		
	   }
		
  /**
   * Método que redireciona para o arquivo gerado
   * return void
   * @access public
   */	
	   public function Redirect()
	   {
	       ob_start();
		   header("Location: " . $this->GetXMLFile());
		   ob_flush();
	   }
		
   /**
    * Método que retorna o cabeçalho do arquivo xml.
    * @param void
    * @return string $strHeader
    * @access public
    */	
		private function GetHeader()
		{
	        parent::element('title'          , $this->GetChannelTitle());
			parent::element('link'           , $this->GetChannelLink());
			parent::element('description'    , $this->GetChannelDescription());
			parent::element('language'       , $this->GetChannelLanguage());
			parent::element('managingEditor' , $this->GetChannelManagingEditor());
			parent::element('webMaster'      , $this->GetChannelWebMaster());
			parent::element('category'       , $this->GetChannelCategory());
			parent::element('generator'      , $this->GetChannelGenerator());
			parent::element('copyright'      , $this->GetChannelCopyright());
			
			parent::push('image');
			  parent::element('title'        , $this->GetChannelImageTitle());
			  parent::element('url'          , $this->GetChannelImageUrl());
			  parent::element('link'         , $this->GetChannelImageLink());
			parent::pop();
			
			parent::element('lastBuildDate'  , $this->GetChannelLastBuildDate());
		    parent::element('ttl'            , $this->GetChannelTTL());
		}
		
  /**
   * Método que retorna os itens do arquivo xml.
   * @param object $objRecordSet Conteúdo do RSS
   * @return string $rssContent
   * @access public
   */	
	   private function GetContent(AdoRecordSet $objRecordSet)
	   {
		   foreach($objRecordSet as $objRecord)
		   {
			   $strItemPubDate = $this->GetItemPubDate();
			   $strDescription = $this->GetItemDescription();
			   $strItemGuid    = $this->GetItemGuid();
			   $strItemTitle   = $this->GetItemTitle();
 
			   // Formatando a data para o formato RFC 2822:
			   // Exemplo: Thu, 21 Dec 2000 16:01:07 +0200
			   $strPubDate     = date("r", strtotime($objRecord->$strItemPubDate));
			   
			   // Formatando a descrição do item:
			   $strDescription = str_replace("<br>", $this->GetLineBreak(), trim($objRecord->$strDescription)); 
			   
			   parent::push('item');			 
			   parent::element('title'       , $objRecord->$strItemTitle);
			   parent::element('link'        , $this->GetItemLink() . $objRecord->$strItemGuid);
			   parent::element('description' , "<![CDATA[<p>" . $strDescription . "</p>]]>");
			   parent::element('pubDate'     , $strPubDate);
			   parent::element('guid'        , $this->GetItemLink() . $objRecord->$strItemGuid);
			   parent::pop();
		  }
	  }
	  
  /**
   * Método que gera arquivo xml.
   * @param object $objRecordSet Conteúdo do RSS
   * return string código xml a ser gravado em $this->GetXMLFile()
   * @access public
   */	
	   public function Generate(AdoRecordSet $objRecordSet)
	   {
		   parent::push('rss', array('version' => "2.0"));
		  
		   parent::push('channel');
		     $this->GetHeader();
		     $this->GetContent($objRecordSet);
		   parent::pop();
		  
		   parent::pop();
		  
		   return trim(parent::GetXml());
	   }
}
