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
 * @version 1.0 - 2009-07-08 17:32:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class CodeGenMXMLFormException extends Exception{}

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
 * Gera os campos do form mxml para cada campo de uma tabela do banco de dados
 *
 * @package Framework
 * @subpackage CodeGen
 * @version 1.0 - 2009-07-08 17:32:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class CodeGenMXMLForm
{
   
   /** 
    * Attributes:
    */

   /**
    * Tabela com os campos do form.
    * @var 	$strTable
    * @access 	private
    */		
	private $strTable;
	
   /**
    * Arquivo onde serão salvos os campos do formulário.
    * @var 	$strFolder
    * @access 	private
    */		
	private $strFolder;
   
//---------------------------------------------------------------------------------------   

   /** 
    * Properties:
    */

   /**
	* Método para setar o valor do atributo $strTable
	* @param $strValue  Valor a ser salvo no atributo $strTable
	* @return void		 
	* @access public
	*/
		public function SetTable($strValue)
		{
			 $this->strTable = $strValue;
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
	* Método para setar o valor do atributo $strFolder
	* @param $strValue  Valor a ser salvo no atributo $strFolder
	* @return void		 
	* @access public
	*/
		public function SetFolder($strValue)
		{
			 $this->strFolder = $strValue;
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
		    $this->SetTable("");
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
	* Testa se o campo é criptografado
	* verificando se o nome do campo possui a palavra "crypt" depois do prefixo. 
	* Exemplo: lus_crypt_senha
	* @param string $strFieldName Nome do campo a ser verificado
	* @return boolean true se o campo possui valores criptografados, caso contrário false
	* @access public
	*/
		public function IsCrypted($strFieldName)
		{
		    $arFieldName = explode("_", $strFieldName);
			return $arFieldName[1] == "crypt" ? true : false;
		}

   /**
	* Reporta o erro e lança uma AdoServerException
	* @param tipo $tipParametro Descrição do parâmetro 
	* @return void
	* @access public
	*/
	    public function GenerateAllForms()
	    {
		    try
			{
				$objDBServer = AdoFactory::Server();
				
				// Listando as tabelas do banco de dados:
				$arTables = $objDBServer->GetTables();
				
				$i = 0;
				
				// Gerando os campos para cada tabela listada:
				foreach($arTables[$objDBServer->GetDataBase()] as $strTable)
				{
					$this->SetTable($strTable);
					$arFields = $this->Generate();
					
					$strForm = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n\n";
					$strForm.= "<mx:Module\n"; 
					$strForm.= "	xmlns:mx=\"http://www.adobe.com/2006/mxml\"\n"; 
					$strForm.= "	xmlns:ns=\"com.adobe.flex.extras.controls.*\"\n";
					$strForm.= "	xmlns:mc=\"MeusComponentes.*\"\n";
					$strForm.= "	layout=\"absolute\"\n"; 
					$strForm.= "	width=\"1024\"\n";
					$strForm.= "	height=\"768\"\n";
					$strForm.= "	creationComplete=\"Inicializar('FrmCadastrar')\"\n";
					$strForm.= ">\n\n";
					
					$strForm.= "    <mx:Script source=\"../../Logic/******/View/Class/fncInicializar.as\" />\n\n";					
					
					$strForm.= "    <mx:Form>\n\n";
					
					foreach($arFields as $strField)
					{
						$strForm .= $strField . "\n";
					}
					
					$strForm.= "    </mx:Form>\n\n";
					$strForm.= "</mx:Module>\n";
					
					$i++;
					
				    // Gera o nome do arquivo no formato frmNomeDaTabela.mxml
				    $strFormName = $this->GetFolder().'mdl_frm'.str_replace(' ','', ucwords(str_replace('_',' ', $strTable))).'.mxml';
				  
				    $objFile = new File($strFormName, 'w+');
				    $objFile->Open();
				  
				    $objFile->Write($strForm);
					
					echo $strFormName."\n";
				}
			}
			catch(Exception $e)
			{
				throw $e;
			}
		}

   /**
	* Gera os campos para uma tabela específica
	* @return array Array com os campos do formulário da tabela
	* @access public
	*/
	    public function Generate()
	    {
		    try
			{
			    $objDBServer = AdoFactory::Server();

				// Obtendo a lista de campos da tabela:
				$rscFields = $objDBServer->ListFields($this->GetTable());
				
				$arFields = array();
				
				$strField = '';
				
				foreach($objDBServer->FieldsInfo($rscFields) as $arField)
				{
					// Verificando se o campo é obrigatório:
					$strRequired = in_array("not_null", $arField["flags"]) ? "required" : "";

					// Label para o campo
					$strLabel   = ucwords(trim(substr(str_replace('_',' ', $arField["name"]), 4)));
					$strLabelFK = ucwords(trim(substr(str_replace('_',' ', $arField["name"]), 6)));
					
					//Chave Primária: Campo Hidden
					if(in_array("primary_key", $arField["flags"]))
					{
						// IMPLEMENTAR SE HOUVER NECESSIDADE
						//$strField.= "";
						
						//array_push($arFields, $strField); 
					}

					// Foreign Key: Campo Select 
					elseif(in_array("multiple_key", $arField["flags"]))
					{
						$strField = "        <mx:FormItem \n";
						$strField.= "            label=\"".$strLabelFK."\"\n";
						$strField.= "            id=\"lbl_".$arField["name"]."\"\n";
						$strField.= "        >\n";
						$strField.= "            <mx:ComboBox\n";
						$strField.= "                name=\"cmb_".$arField["name"]."\"\n"; 
						$strField.= "                id=\"".$arField["name"]."\"\n"; 
						$strField.= "                width=\"161\"\n";
						$strField.= "            >\n";
						$strField.= "            </mx:ComboBox>\n";
						$strField.= "        </mx:FormItem>\n";
					   
						array_push($arFields, $strField); 
					}
					
					// Boolean: Campo Radiobox
					elseif($arField["type"] == "int" && $arField["size"] == 1)
					{
						$strField = "        <mx:FormItem \n";
						$strField.= "            label=\"".$strLabel."\"\n";
						$strField.= "            id=\"lbl_".$arField["name"]."\"\n";
						$strField.= "        >\n";
						$strField.= "            <mx:HBox\n";
						$strField.= "                width=\"100%\">\n\n";
						$strField.= "                <mx:RadioButtonGroup \n";
						$strField.= "                    id=\"rbg_".$arField["name"]."\"\n";
						$strField.= "                />\n\n";
						$strField.= "                <mx:RadioButton\n";
						$strField.= "                    name=\"".$arField["name"]."1\"\n";
						$strField.= "                    groupName=\"rbg_".$arField["name"]."\"\n";
						$strField.= "                    id=\"".$arField["name"]."1\"\n";
						$strField.= "                    label=\"Check\"\n";
						$strField.= "                />\n";
						$strField.= "                <mx:RadioButton\n";
						$strField.= "                    name=\"".$arField["name"]."2\"\n";
						$strField.= "                    id=\"".$arField["name"]."2\"\n";
						$strField.= "                    label=\"Check\"\n";
						$strField.= "                />\n";
						$strField.= "            </mx:HBox>\n";
						$strField.= "        </mx:FormItem>\n";
						
						array_push($arFields, $strField);
					}
					
					// Blob: Campo Textarea
					elseif($arField["type"] == "blob")
					{
						$strField = "        <mx:FormItem \n";
						$strField.= "            label=\"".$strLabel."\"\n";
						$strField.= "            id=\"lbl_".$arField["name"]."\"\n";
						$strField.= "        >\n";
						$strField.= "            <mx:TextArea\n";
						$strField.= "                name=\"".$arField["name"]."\"\n";
						$strField.= "                id=\"txa_".$arField["name"]."\"\n";
						$strField.= "                width=\"100\"\n";
						$strField.= "            />\n";
						$strField.= "        </mx:FormItem>\n";

						array_push($arFields, $strField);
					}
					
					// Date: Campo text com seletor de data
					elseif($arField["type"] == "date")
					{
						$strField = "        <mx:FormItem \n";
						$strField.= "            label=\"".$strLabel."\"\n";
						$strField.= "            id=\"lbl_".$arField["name"]."\"\n";
						$strField.= "        >\n";
						$strField.= "            <mc:tMaskedDateFieldRG\n";
						$strField.= "                name=\"".$arField["name"]."\"\n";
						$strField.= "                id=\"mdf_".$arField["name"]."\"\n";
						$strField.= "                enabled=\"true\"\n";
						$strField.= "            />\n";
						$strField.= "        </mx:FormItem>\n";
						
						array_push($arFields, $strField);
					}
					
					// número Inteiro: Campo text
					elseif($arField["type"] == "int")
					{
						$strCrypted = $this->IsCrypted($arField["name"]) ? "displayAsPassword=\"true\"" : "";
						
						$intSize = $arField["size"] > 50 ? 50 : $arField["size"];
						
						// FALTA IMPLEMENTAR MÁSCARA PARA NÚMEROS INTEIROS
						$strField = "        <mx:FormItem \n";
						$strField.= "            label=\"".$strLabel."\"\n";
						$strField.= "            id=\"lbl_".$arField["name"]."\"\n";
						$strField.= "        >\n";
						$strField.= "            <mx:TextInput ".$strCrypted."\n";
						$strField.= "                name=\"".$arField["name"]."\"\n";
						$strField.= "                id=\"tin_".$arField["name"]."\"\n";
						$strField.= "                restrict=\"0-9\"\n";
						$strField.= "                width=\"\"\n";
						$strField.= "                maxChars=\"".$arField['size']."\"\n";
						$strField.= "            />\n";
						$strField.= "        </mx:FormItem>\n";
						
						array_push($arFields, $strField);
					}
					
					// número Float: Campo text
					elseif($arField["type"] == "real")
					{
						$strCrypted = $this->IsCrypted($arField["name"]) ? "displayAsPassword=\"true\"" : "";
						
						$intSize = $arField["size"] > 50 ? 50 : $arField["size"];
						
						// FALTA IMPLEMENTAR MÁSCARA PARA númeroS REAIS
						$strField = "        <mx:FormItem \n";
						$strField.= "            label=\"".$strLabel."\"\n";
						$strField.= "            id=\"lbl_".$arField["name"]."\"\n";
						$strField.= "        >\n";
						$strField.= "            <mx:TextInput ".$strCrypted."\n";
						$strField.= "                name=\"".$arField["name"]."\"\n";
						$strField.= "                id=\"".$arField["name"]."\"\n";
						$strField.= "                width=\"\"\n";
						$strField.= "                maxChars=\"".$arField['size']."\"\n";
						$strField.= "            />\n";
						$strField.= "        </mx:FormItem>\n";
						
						array_push($arFields, $strField);
					}
					
					// Texto: Campo text
					elseif($arField["type"] == "string")
					{
						$strCrypted = $this->IsCrypted($arField["name"]) ? "displayAsPassword=\"true\"" : "";
						
						$intSize = $arField["size"] > 50 ? 50 : $arField["size"];
						
						$strField = "        <mx:FormItem \n";
						$strField.= "            label=\"".$strLabel."\"\n";
						$strField.= "            id=\"lbl_".$arField["name"]."\"\n";
						$strField.= "        >\n";
						$strField.= "            <mc:FormatedNameInput ".$strCrypted."\n";
						$strField.= "                name=\"fni_".$arField["name"]."\"\n";
						$strField.= "                id=\"".$arField["name"]."\"\n";
						$strField.= "                width=\"\"\n";
						$strField.= "                maxChars=\"".$arField['size']."\"\n";
						$strField.= "            />\n";
						$strField.= "        </mx:FormItem>\n";
						
						array_push($arFields, $strField);
					}
				}
				
				// Escapando as tags html para exibição:
				return $arFields;
			}
			catch(Exception $e)
			{
				throw $e;
			}
		}
}
?>