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
 *
 * @package Framework
 * @subpackage CodeGen
 * @version 1.0 - 2006-11-30 10:30:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class CodeGenClassException extends Exception{}

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
 * Classe geradora de classes do pacote de negócios
 *
 * @package Framework
 * @subpackage CodeGen
 * @version 1.0 - 2006-11-30 10:30:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class CodeGenClass
{
   
   /** 
    * Attributes:
    */

   /**
    * Nome da classe a ser gerada
    * @var 	$strName
    * @access 	private
    */		
	private $strName;
	
   /**
    * Nome da tabela que a classe irá representar
    * @var 	$strTable
    * @access 	private
    */		
	private $strTable;
	
   /**
    * Atributos da classe
    * @var 	$arAttributes
	* @access 	private
	*/		
	private $arAttributes;
	
   /**
    * Nome do pacote
    * @var 	$strPackage
	* @access 	private
	*/		
	private $strPackage;
	
   /**
    * Nome do pacote
    * @var 	$strSubPackage
	* @access 	private
	*/		
	private $strSubPackage;	
	
   /**
    * Autor da classe
    * @var 	$strAuthor
	* @access 	private
	*/		
	private $strAuthor;

   /**
    * Versão da classe
    * @var 	$strVersion
    * @access 	private
    */		
	private $strVersion;

   /**
    * códigos a serem incluídos na classe
    * @var 	$arRequires
	* @access 	private
	*/		
	private $arRequires;
	
   /**
    * Identação da classe
    * @var 	$strIndent
	* @access 	private
	*/		
	private $strIndent;
	
   /**
    * Caractere de nova linha
    * @var 	$strNewLine
	* @access 	private
	*/		
	private $strNewLine;

   /**
    * Modelo XML do DBDesigner
    * @var 	$strModel
	* @access 	private
	*/		
	private $strModel;

   /**
    * Classes e suas respectivas tabelas
    * @var 	$arClasses
	* @access 	private
	*/		
	private $arClasses;

   /**
    * Relacionamentos da tabela setada em $strTable
    * @var 	$arRelationships
	* @access 	private
	*/		
	private $arRelationships;
   
//---------------------------------------------------------------------------------------   

   /** 
    * Properties:
    */

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
	* Método para setar o valor do atributo $strTable
	* @return void		 
	* @access public
	*/
		public function SetTable($strTable)
		{
			 $this->strTable = $strTable;
		}

   /**
	* Método para retornar o valor do atributo $strTable
	* @return string $strTable
	* @access public
	*/
		public function GetTable()
		{
			 return $this->strTable;
		}

   /**
	* Método para setar o valor do atributo $arAttributes
	* @return void		 
	* @access public
	*/
		protected function SetAttributes($arAttributes)
		{
			 $this->arAttributes = $arAttributes;
		}

   /**
	* Método para retornar o valor do atributo $arAttributes
	* @return string $arAttributes
	* @access public
	*/
		public function GetAttributes()
		{
			 return $this->arAttributes;
		}

   /**
	* Método para setar o valor do atributo $strPackage
	* @return void		 
	* @access public
	*/
		public function SetPackage($strPackage)
		{
			 $this->strPackage = $strPackage;
		}

   /**
	* Método para retornar o valor do atributo $strPackage
	* @return string $strPackage
	* @access public
	*/
		public function GetPackage()
		{
			 return $this->strPackage;
		}

   /**
	* Método para setar o valor do atributo $strSubPackage
	* @return void		 
	* @access public
	*/
		public function SetSubPackage($strSubPackage)
		{
			 $this->strSubPackage = $strSubPackage;
		}

   /**
	* Método para retornar o valor do atributo $strSubPackage
	* @return string $strSubPackage
	* @access public
	*/
		public function GetSubPackage()
		{
			 return $this->strSubPackage;
		}

   /**
	* Método para setar o valor do atributo $strAuthor
	* @return void		 
	* @access public
	*/
		public function SetAuthor($strAuthor)
		{
			 $this->strAuthor = $strAuthor;
		}

   /**
	* Método para retornar o valor do atributo $strAuthor
	* @return string $strAuthor
	* @access public
	*/
		public function GetAuthor()
		{
			 return $this->strAuthor;

		}

   /**
	* Método para setar o valor do atributo $strVersion
	* @return void		 
	* @access public
	*/
		public function SetVersion($strVersion)
		{
			 $this->strVersion = $strVersion;
		}

   /**
	* Método para retornar o valor do atributo $strVersion
	* @return string $strVersion
	* @access public
	*/
		public function GetVersion()
		{
			 return $this->strVersion;

		}

   /**
	* Método para setar o valor do atributo $arRequires
	* @return void		 
	* @access public
	*/
		public function SetRequires($arRequires)
		{
			 $this->arRequires = $arRequires;
		}

   /**
	* Método para retornar o valor do atributo $arRequires
	* @return string $arRequires
	* @access public
	*/
		public function GetRequires()
		{
			 return $this->arRequires;
		}

   /**
	* Método para setar o valor do atributo $strIndent
	* @return void		 
	* @access public
	*/
		public function SetIndent($strIndent)
		{
			 $this->strIndent = $strIndent;
		}

   /**
	* Método para retornar o valor do atributo $strIndent
	* @return string $strIndent
	* @access public
	*/
		public function GetIndent()
		{
			 return $this->strIndent;
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

   /**
	* Método para setar o valor do atributo $strModel
	* @return void		 
	* @access public
	*/
		public function SetModel($strModel)
		{
			 $this->strModel = $strModel;
		}

   /**
	* Método para retornar o valor do atributo $strModel
	* @return string $strModel
	* @access public
	*/
		public function GetModel()
		{
			 return $this->strModel;
		}

   /**
	* Método para setar o valor do atributo $arClasses
	* @return void		 
	* @access public
	*/
		public function SetClasses($arClasses)
		{
			 $this->arClasses = $arClasses;
		}

   /**
	* Método para retornar o valor do atributo $arClasses
	* @return string $arClasses
	* @access public
	*/
		public function GetClasses()
		{
			 return $this->arClasses;
		}

   /**
	* Método para setar o valor do atributo $arRelationships
	* @return void		 
	* @access public
	*/
		public function SetRelationships($arRelationships)
		{
			 $this->arRelationships = $arRelationships;
		}

       /**
	* Método para retornar o valor do atributo $arRelationships
	* @return string $arRelationships
	* @access public
	*/
		public function GetRelationships()
		{
			 return $this->arRelationships;
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
			$this->SetName('');
			$this->SetTable('');
			$this->SetAuthor("Diego Botelho Martins <diego@rgweb.com.br>");
			$this->SetPackage("Framework");
			$this->SetSubPackage('');
			$this->SetRequires(array("'../../../Framework/Class/System.php'"));
			$this->SetIndent("    ");
			$this->SetNewLine("\n");
			$this->SetModel("E:\/Sites/SISTEMAS ZINABRE/DOCUMENTOS/der_ecommerce_2006.xml");
			
			$objXML       = new XML();
			$objXMLTables = $objXML->loadFile($this->GetModel());
			$this->SetClasses($this->GetModelClasses($objXMLTables));
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
	* Obtém os relacionamentos da tabela informa setando em this->arRelationships;
        * @return void
	* @access public
	*/
	    public function BuildRelationships()
	    {
			// Obtendo todos os relacionamentos da tabela:
			$objDBServer = AdoFactory::Server();
			$arRelationships = $objDBServer->GetRelationships($this->GetTable());
            
			for($i = 0; $i < count($arRelationships); $i++)
			{
			    $arClasses = $this->GetClasses();
                            
                            if(!is_array($arClasses)) return false;
                            
                            foreach($arClasses as $arClass)
                            {
                               if($arClass["table"] == $arRelationships[$i]["table"])
                               {
                                   $arRelationships[$i]["class"] = $arClass["name"];
                               }
                            }
			}
			
			$this->SetRelationships($arRelationships);
		}

       /**
	* Retorna as regiões do modelo DBDesigner, que serão os subPackages do sistema
	* @param object $objXMLTables Objeto XML carregado com o arquivo do modelo
	* @return array $arRegions Array com as regiões do sistema, o array é indexado pelo id da região no XML
	* @access public
	*/
	    public function GetModelRegions($objXMLTables)
	    {
                        if(!is_object($objXMLTables))
                        {
                           return false;                           
                        }
                        
                        // Obtendo as regiões do modelo do dbDesign
			foreach($objXMLTables->METADATA->REGIONS->REGION as $objSimpleXML)
			{
				foreach($objSimpleXML->attributes() as $strKey => $strValue)
				{
					if($strKey == "ID")             $strIndex  = (string) $strValue;
					elseif($strKey == "RegionName") $strRegion = (string) ucfirst($strValue);
					else continue;		
				}
				
				$arRegions[$strIndex] = $strRegion;	
			}
			
			return $arRegions;
		}
		
       /**
	* Retorna as regiões do modelo DBDesigner, que serão os subPackages do sistema
	* @param object $objXMLTables Objeto XML carregado com o arquivo do modelo
	* @return array $arClasses Array com as classes do sistema
	* @access public
	*/
	    public function GetModelClasses($objXMLTables)
	    {
                        if(!is_object($objXMLTables))
                        {
                           return false;                           
                        }
                        
                        $arRegions = $this->GetModelRegions($objXMLTables);
			
			$i = 0;
			
			// Obtendo as tabelas, seu nome de classe e o subPackage ao qual pertence:
			foreach($objXMLTables->METADATA->TABLES->TABLE as $objSimpleXML)
			{
				foreach($objSimpleXML->attributes() as $strKey => $strValue)
				{
					if($strKey == "Tablename")    
					{
						$strTable  = (string) $strValue;
					}	
					elseif($strKey == "Comments") 
					{
						list($intIdRegion, $strClassName) = explode("#", $strValue);
						
						if(empty($intIdRegion) || empty($strClassName))
						{
						    throw new SubPackagesGeneratorException("O comentário com o nome da classe não foi informado na tabela " . $strTable);
						}
						
						// Obtendo o nome do subPacote:
						foreach($arRegions as $strKey => $strRegion)
						{
							if($strKey == $intIdRegion)
							{				
								$strSubPackage = $strRegion;
							}	
						}
					}	

					else continue;
				}
				
				$arClasses[$i]["name"]       = $strClassName;
				$arClasses[$i]["subpackage"] = $strSubPackage;
				$arClasses[$i]["table"]      = $strTable;
				
				$i++;
			}
			
			return $arClasses;
		}


   /**
	* Insere indentação
	* @param int $intNumIndent número de indentações a serem inseridas
	* @return string Indentações 
	* @access protected
	*/
	    protected function Indent($intNumIndent = 1)
		{
		    $strIndent = '';
			
			for($i = 0; $i < $intNumIndent; $i++)
			{
			    $strIndent.= $this->GetIndent();
			}
			
			return $strIndent;
		}

   /**
	* Insere quebra de linha
	* @param int $intNumNewLine número de quebras de linhas a serem inseridas
	* @return string Quebras de linha
	* @access protected
	*/
	    protected function NewLine($intNumNewLine = 1)
		{
		    $strNewLine = '';
			
			for($i = 0; $i < $intNumNewLine; $i++)
			{
			    $strNewLine .= $this->GetNewLine();
			}
			
			return $strNewLine;
		}

       /**
	* Gera o comentário da classe
	* @param string $strDescription Descrição da classe
	* @return string Header da classe
	* @access protected
	*/
	    protected function GenerateHeader($strDescription)
		{
			$strHeader = "/**"                                                                                             . $this->NewLine(); 
			$strHeader.= " * " . $strDescription                                                                           . $this->NewLine(); 
			$strHeader.= " *"                                                                                              . $this->NewLine();
			$strHeader.= " * @package "    . $this->GetPackage()                                                           . $this->NewLine();  
			$strHeader.= " * @subpackage " . $this->GetSubPackage()                                                        . $this->NewLine();  
			$strHeader.= " * @version "    . $this->GetVersion() . " - " . date("Y-m-d H:i:s") . ''                        . $this->NewLine(); 
			$strHeader.= " * @author "     . $this->GetAuthor()                                                            . $this->NewLine();  
			$strHeader.= " * @link http://www.diegobotelho.com.br"                                                                . $this->NewLine();  
			$strHeader.= " * @copyright  " . date("Y") . " RG Sistemas - Todos os diretos reservados." . $this->NewLine();
			$strHeader.= " */" . $this->NewLine(2);
			
			return $strHeader;
		}
		
   /**
	* Gera as diretivas de inclusão de arquivos
	* @return string Includes da classe
	* @access protected
	*/
		protected function GenerateRequires()
		{
			$strRequire = '';
			
			foreach($this->GetRequires() as $strRequire)
			{
				$strRequire = "require_once(" . $strRequire . ");" . $this->NewLine();
			}
			
			$strRequire.= $this->NewLine();
			
			return $strRequire;
		}
	
       /**
	* Encerra a classe
	* @return string código final da classe
	* @access protected
	*/
		protected function EndClass()
		{
			$strClass = "}";
			
			return $strClass;
		}

   /**
	* Escreve uma linha divisora de blocos da classe
	* @param string $strBlock Bloco da classe
	* @return string Linha divisora de blocos da classe
	* @access protected
	*/		
		protected function LineBlock($strBlock, $blnComment = true)
		{
			$strLineBlock = '';
                        
            if($strBlock != "Attributes")
			{
			    $strLineBlock.= "//------------------------------------------------------------------------------";
			    $strLineBlock.= $this->NewLine(2);
			}
			
			if($blnComment)
            {
               $strLineBlock.= $this->Indent() . "/**"                   . $this->NewLine();
               $strLineBlock.= $this->Indent() . " * " . $strBlock . ":" . $this->NewLine();
               $strLineBlock.= $this->Indent() . " */"                   . $this->NewLine(2);
            }
            
			return $strLineBlock;
		}
	/**
	* Retorna o tamanho máximo de uma string original a partir do seu tamanho máximo criptografado
	* @param int $intCryptedSize Tamanho máximo criptografado
	* @return string Linha divisora de blocos da classe
	* @access protected
	*/	
		protected function GetDecryptedSize($intCryptedSize)
		{
		    $arDecryptedValues = array( 4 => 1,
						8 => 2,
						8 => 3,
						12 => 4,
						16 => 5,
						16 => 6,
						20 => 7,
						24 => 8,
						24 => 9,
						28 => 10,
						32 => 11,
						32 => 12,
						36 => 13,
						40 => 14,
						40 => 15,
						44 => 16,
						48 => 17,
						48 => 18,
						52 => 19,
						56 => 20,
						56 => 21,
						60 => 22,
						64 => 23,
						64 => 24,
						68 => 25,
						72 => 26,
						72 => 27,
						76 => 28,
						80 => 29,
						80 => 30,
						84 => 31,
						88 => 32,
						88 => 33,
						92 => 34,
						96 => 35,
						96 => 36,
						100 => 37,
						104 => 38,
						104 => 39,
						108 => 40,
						112 => 41,
						112 => 42,
						116 => 43,
						120 => 44,
						120 => 45,
						124 => 46,
						128 => 47,
						128 => 48,
						132 => 49,
						136 => 50,
						136 => 51,
						140 => 52,
						144 => 53,
						144 => 54,
						148 => 55,
						152 => 56,
						152 => 57,
						156 => 58,
						160 => 59,
						160 => 60,
						164 => 61,
						168 => 62,
						168 => 63,
						172 => 64,
						176 => 65,
						176 => 66,
						180 => 67,
						184 => 68,
						184 => 69,
						188 => 70,
						192 => 71,
						192 => 72,
						196 => 73,
						200 => 74,
						200 => 75,
						204 => 76,
						208 => 77,
						208 => 78,
						212 => 79,
						216 => 80,
						216 => 81,
						220 => 82,
						224 => 83,
						224 => 84,
						228 => 85,
						232 => 86,
						232 => 87,
						236 => 88,
						240 => 89,
						240 => 90,
						244 => 91,
						248 => 92,
						248 => 93,
						252 => 94,
						256 => 95,
						256 => 96,
						260 => 97,
						264 => 98,
						264 => 99,
						268 => 100,
						272 => 101,
						272 => 102,
						276 => 103,
						280 => 104,
						280 => 105,
						284 => 106,
						288 => 107,
						288 => 108,
						292 => 109,
						296 => 110,
						296 => 111,
						300 => 112,
						304 => 113,
						304 => 114,
						308 => 115,
						312 => 116,
						312 => 117,
						316 => 118,
						320 => 119,
						320 => 120,
						324 => 121,
						328 => 122,
						328 => 123,
						332 => 124,
						336 => 125,
						336 => 126,
						340 => 127,
						344 => 128,
						344 => 129,
						348 => 130,
						352 => 131,
						352 => 132,
						356 => 133,
						360 => 134,
						360 => 135,
						364 => 136,
						368 => 137,
						368 => 138,
						372 => 139,
						376 => 140,
						376 => 141,
						380 => 142,
						384 => 143,
						384 => 144,
						388 => 145,
						392 => 146,
						392 => 147,
						396 => 148,
						400 => 149,
						400 => 150,
						404 => 151,
						408 => 152,
						408 => 153,
						412 => 154,
						416 => 155,
						416 => 156,
						420 => 157,
						424 => 158,
						424 => 159,
						428 => 160,
						432 => 161,
						432 => 162,
						436 => 163,
						440 => 164,
						440 => 165,
						444 => 166,
						448 => 167,
						448 => 168,
						452 => 169,
						456 => 170,
						456 => 171,
						460 => 172,
						464 => 173,
						464 => 174,
						468 => 175,
						472 => 176,
						472 => 177,
						476 => 178,
						480 => 179,
						480 => 180,
						484 => 181,
						488 => 182,
						488 => 183,
						492 => 184,
						496 => 185,
						496 => 186,
						500 => 187,
						504 => 188,
						504 => 189,
						508 => 190,
						512 => 191,
						512 => 192,
						516 => 193,
						520 => 194,
						520 => 195,
						524 => 196,
						528 => 197,
						528 => 198,
						532 => 199,
						536 => 200,
						536 => 201,
						540 => 202,
						544 => 203,
						544 => 204,
						548 => 205,
						552 => 206,
						552 => 207,
						556 => 208,
						560 => 209,
						560 => 210,
						564 => 211,
						568 => 212,
						568 => 213,
						572 => 214,
						576 => 215,
						576 => 216,
						580 => 217,
						584 => 218,
						584 => 219,
						588 => 220,
						592 => 221,
						592 => 222,
						596 => 223,
						600 => 224,
						600 => 225,
						604 => 226,
						608 => 227,
						608 => 228,
						612 => 229,
						616 => 230,
						616 => 231,
						620 => 232,
						624 => 233,
						624 => 234,
						628 => 235,
						632 => 236,
						632 => 237,
						636 => 238,
						640 => 239,
						640 => 240,
						644 => 241,
						648 => 242,
						648 => 243,
						652 => 244,
						656 => 245,
						656 => 246,
						660 => 247,
						664 => 248,
						664 => 249,
						668 => 250,
						672 => 251,
						672 => 252,
						676 => 253,
						680 => 254,
						680 => 255,
						);
            
			return $arDecryptedValues[$intCryptedSize];
		}
		
       /**
	* Testa se o atributo é criptografado
	* verificando se o nome do atributo possui a palavra "crypt" depois do prefixo. 
	* Exemplo: $lus_crypt_senha
	* @param string $strFieldName Nome do campo a ser verificado
	* @return boolean true se o campo possui valores criptografados, caso contrário false
	* @access public
	*/
		public function IsCrypted($strAttributeName)
		{
		    $arAttributeName = explode("_", $strAttributeName);
		    return $arAttributeName[1] == "crypt" ? true : false;
		}		
}
?>