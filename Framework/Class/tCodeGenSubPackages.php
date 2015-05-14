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
 * @version 1.0 - 2006-12-04 14:18:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright © 2009 RG Sistemas - Todos os diretos reservados.
 */

class CodeGenSubPackagesException extends Exception{}

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
 * Gera os subpacotes do sistema
 * Essa classe utiliza o XML gerado pelo DBDesigner 4
 * Um subpacote corresponde a uma região do modelo DBDesigner 4
 * Cada subpacote é formado pelas classes de negócios e dados que representam as tabelas do modelo.
 * As classes ficam dentro do Diretório Class. 
 * Outros dois Diretórios também são criados, porém vazios: Utils e Templates
 * Utils: para armazenar javascripts e outros códigos restritos daquele subpacote
 * Templates: para armazenar templates Smarty restritos daquele subpacote
 * Cada tabela no DBDesigner deve possuir um comentário no seguinte formato: idRegião#NomeDaClasse onde:
 * + idRegião: código da região da tabela (Região é a área colorida onde a tabela se encontra)
 *             Somente visualizando o código XML é que você poderá encontrar o código da região
 * + NomeDaClasse Nome da classe que irá representar aquela tabela ex.: para a tabela cli_clientes a classe é Cliente
 *
 * Nota: Para o perfeito funcionamento a estrutura das tabelas na base de dados mysql 
 * deve estar identica ao modelo do DBDesigner
 *
 * @package Framework
 * @subpackage CodeGen
 * @version 1.0 - 2006-12-04 14:18:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright © 2009 RG Sistemas - Todos os direitos reservados
 */

class CodeGenSubPackages
{
   
   /** 
    * Attributes:
    */

   /**
    * Arquivo XML gerado pelo DBDesigner.
    * @var 	$strModel
	* @access 	private
	*/		
	private $strModel;
	
   /**
    * Diretório onde os subpacotes serão gerados.
    * @var 	$strOutputDir
	* @access 	private
	*/		
	private $strOutputDir;
	
	
   /**
    * Total de classes geradas
    * @var 	$intGeneratedClasses
	* @access 	private
	*/		
	private $intGeneratedClasses;
	
   /**
    * Versão da compilação
    * @var 	$strVersion
	* @access 	private
	*/		
	private $strVersion;	
   
//---------------------------------------------------------------------------------------   

   /** 
    * Properties:
    */
   
   /**
	* Método para setar o valor do atributo $strModel
	* @param $strValue  Valor a ser salvo no atributo $strModel
	* @return void		 
	* @access public
	*/
		public function SetModel($strValue)
		{
			 $this->strModel = $strValue;
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
	* Método para setar o valor do atributo $strOutputDir
	* @param $strValue  Valor a ser salvo no atributo $strOutputDir
	* @return void		 
	* @access public
	*/
		public function SetOutputDir($strValue)
		{
			 $this->strOutputDir = $strValue;
		}

   /**
	* Método para retornar o valor do atributo $strDir
	* @return string $strDir
	* @access public
	*/
		public function GetOutputDir()
		{
			 return $this->strOutputDir;
		}

   /**
	* Método para setar o valor do atributo $intGeneratedClasses
	* @param $strValue  Valor a ser salvo no atributo $intGeneratedClasses
	* @return void		 
	* @access public
	*/
		public function SetGeneratedClasses($strValue)
		{
			 $this->strGeneratedClasses = $strValue;
		}

   /**
	* Método para retornar o valor do atributo $intGeneratedClasses
	* @return string $intGeneratedClasses
	* @access public
	*/
		public function GetGeneratedClasses()
		{
			 return $this->strGeneratedClasses;
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
		    $this->SetModel("");
			$this->SetOutputDir("");
			$this->SetGeneratedClasses(0);
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
	* Retorna as regiões do modelo DBDesigner, que serão os subPackages do sistema
	* @param object $objXMLTables Objeto XML carregado com o arquivo do modelo
	* @return array $arRegions Array com as regiões do sistema, o array é indexado pelo id da região no XML
	* @access public
	*/
	    public function GetModelRegions($objXMLTables)
	    {
	    	// Obtendo as regiões do modelo do dbDesign
			foreach($objXMLTables->METADATA->REGIONS->REGION as $objSimpleXML)
			{
				foreach($objSimpleXML->attributes() as $strKey => $strValue)
				{
					if($strKey == "ID")             $strIndex  = (string) $strValue;
					elseif($strKey == "RegionName") $strRegion = (string) $strValue;
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
	    	$arRegions = $this->GetModelRegions($objXMLTables);
			
			$i = 0;
			
			$strSubPackage = '';
			
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
						    throw new CodeGenSubPackagesException("O comentário com o nome da classe não foi informado na tabela " . $strTable);
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
	* Gera todos os subpacotes do sistema
	* @return true se o comando for executado com sucesso, caso contrário false e uma excessão é lançada
	* @access public
	*/
	    public function Generate()
	    {
            try
			{
                // Criando um objeto XML
				$objXML = new XML();
				
				// Lendo o conteúdo do arquivo DBDesigner
				$objXMLTables = $objXML->loadFile($this->GetModel());
				
				// Exibindo os diretorios de classes criados:
				
				$i = 0;
				
				echo "<pre>";
				echo "Pacotes:<br>";
				echo '<textarea name="classes" cols="120" rows="7">';
				foreach($this->GetModelClasses($objXMLTables) as $arClass)
				{
					// Gerando as classes de negócios:
					$objBusinessClass = new CodeGenBusiness();
					$objBusinessClass->SetName($arClass["name"]);
					$objBusinessClass->SetPackage("SigsWeb");
					$objBusinessClass->SetSubPackage($arClass["subpackage"]);
					$objBusinessClass->SetVersion($this->GetVersion());
					$objBusinessClass->SetTable($arClass["table"]);
					$objBusinessClass->Generate($this->GetOutputDir());

					// Gerando as classes de acesso a dados:
					$objDaoClass = new CodeGenDao();
					$objDaoClass->SetName($arClass["name"]);
					$objDaoClass->SetPackage("SigsWeb");
					$objDaoClass->SetSubPackage($arClass["subpackage"]);
					$objDaoClass->SetVersion($this->GetVersion());
					$objDaoClass->SetTable($arClass["table"]);
					$objDaoClass->Generate($this->GetOutputDir());

					$i++;
				}
			    echo '</textarea><br><br>';
				
				// Gerando a interface:
				echo "Interfaces:<br>";
				echo '<textarea name="interfaces" cols="120" rows="7">';
				$objForm = new CodeGenMXMLForm();
				$objForm->SetFolder($this->GetOutputDir()."_Gui/");
				$objForm->GenerateAllForms();
				echo '</textarea><br><br>';

				echo "Por favor atualize o arquivo 'Framework/Class/_resources.xml'<br>";
				echo '<textarea name="resources" cols="120" rows="7">';
				foreach($this->GetModelRegions($objXMLTables) as $strRegion)
				{
				    echo '<path>Logic/' .$strRegion . "/Controller</path>\n";
					echo '<path>Logic/' .$strRegion . "/Model</path>\n";
				    echo '<path>Logic/' .$strRegion . "/Dao</path>\n";
				}
				echo '</textarea><br><br>';
				echo "</pre>";

				$this->SetGeneratedClasses($i);
			}
			catch(Exception $e)
			{
				throw $e;
			}
		}
}
?>