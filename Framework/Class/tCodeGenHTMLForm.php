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
 * @version 1.0 - 2006-11-30 09:35:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class CodeGenHTMLFormException extends Exception{}

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
 * Gera os campos do form para cada campo de uma tabela do banco de dados
 *
 * @package Framework
 * @subpackage CodeGen
 * @version 1.0 - 2006-12-11 09:35:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class CodeGenHTMLForm
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
    * @var 	$strFile
    * @access 	private
    */		
	private $strFile;
   
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
	* Método para setar o valor do atributo $strFile
	* @param $strValue  Valor a ser salvo no atributo $strFile
	* @return void		 
	* @access public
	*/
		public function SetFile($strValue)
		{
			 $this->strFile = $strValue;
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
				
				$strForm = "";
				
				$i = 0;
				
				// Gerando o índice:
				foreach($arTables[$objDBServer->GetDataBase()] as $strTable)
				{
				    $strForm.= "<a href=\"#".$strTable."\">".$strTable."</a><br />\n";
				}
				
				$strForm.= "<br /><br />\n";
				
				// Gerando os campos para cada tabela listada:
				foreach($arTables[$objDBServer->GetDataBase()] as $strTable)
				{
					$this->SetTable($strTable);
					$arFields = $this->Generate();
					
					$strForm.= "\n<a name=\"".$strTable."\" id=\"".$strTable."\">\n";
					
					$strForm.= "<!-- Campos da tabela " . $strTable . " -->\n\n";
					
					$strForm.= "<fieldset>\n\n";
                                        $strForm.= "    <legend>".$strTable."</legend>\n\n";
					
					foreach($arFields as $strField)
					{
						$strForm .= $strField . "\n";
					}
					
					$strForm.= "</fieldset>\n\n";
					$strForm.= "</a>\n";
					
					$i++;
				}
				
				$objFile = new File($this->GetFile(), 'w+');
				$objFile->Open();
				
				$objFile->Write($strForm);
				
				echo $i . " forms gerados com sucesso!";
				
				header("Location: " . $this->GetFile());
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
				
				foreach($objDBServer->FieldsInfo($rscFields) as $arField)
				{
					// Verificando se o campo é obrigatório:
					$strRequired = in_array("not_null", $arField["flags"]) ? "" : " alt=\"no_required\" ";
					
					// Label para o campo
					$strLabel   = ucwords(trim(substr(str_replace('_',' ', $arField["name"]), 4)));
					$strLabelFK = ucwords(trim(substr(str_replace('_',' ', $arField["name"]), 6)));
					
					// Chave Primária: Campo Hidden
					if(in_array("primary_key", $arField["flags"]))
					{
						$strField.= "    <input type=\"hidden\" name=\"" .$arField["name"] . "\" id=\"" . $arField["name"] . "\" value=\"{\$value_".$arField["name"]."}\"" . $strRequired . " />\n";
						
						array_push($arFields, $strField); 
					}
					
					// Foreign Key: Campo Select 
					elseif(in_array("multiple_key", $arField["flags"]))
					{
						$strField = "    <label for=\"".$arField["name"]."\">".$strLabelFK.":</label>\n";
						$strField.= "    <select name=\"" . $arField["name"] . "\" id=\"" . $arField["name"] . "\"" . $strRequired . " >";
						$strField.= "{html_options options=\$options_" . $arField["name"]." selected=\$selected_" . $arField["name"] . "}</select><br />\n";
					   
						array_push($arFields, $strField); 
					}
					
					// Boolean: Campo Checkbox
					elseif($arField["type"] == "int" && $arField["size"] == 1)
					{
						$strField = "    <label for=\"".$arField["name"]."\">".$strLabel.":</label>\n";
						$strField.= "    <select name=\"" . $arField["name"] . "\" id=\"" . $arField["name"] . "\"" . $strRequired . " >";
						$strField.= "{html_options options=\$options_" . $arField["name"]." selected=\$selected_" . $arField["name"] . "}</select><br />\n";
						
						array_push($arFields, $strField);
					}
					
					// Blob: Campo Textarea
					elseif($arField["type"] == "blob")
					{
						$strField = "    <label for=\"".$arField["name"]."\">".$strLabel.":</label>\n";
						$strField.= "    <textarea name=\"" . $arField["name"] . "\" id=\"" . $arField["name"] . "\" cols=\"104\" rows=\"4\"" . $strRequired . "/>{\$value_".$arField["name"]."}</textarea><br />\n";
						
						array_push($arFields, $strField);
					}
					
					// Date: Campo text com seletor de data
					elseif($arField["type"] == "date")
					{
						$strField = "    <label for=\"".$arField["name"]."\">".$strLabel.":</label>\n";
						$strField.= "    <input type=\"text\" name=\"" . $arField["name"] . "\" id=\"" . $arField["name"] . "\" value=\"{\$value_".$arField["name"]."}\" readonly=\"readonly\" class=\"calendar default\""  . $strRequired . " /><br />\n";
						
						array_push($arFields, $strField);
					}
					
					// número Inteiro: Campo text
					elseif($arField["type"] == "int")
					{
					    $strType = $this->IsCrypted($arField["name"]) ? "password" : "text";
						
						$strField = "    <label for=\"".$arField["name"]."\">".$strLabel.":</label>\n";
						$strField.= "    <input type=\"".$strType."\" name=\"" . $arField["name"] . "\" id=\"" . $arField["name"] . "\" maxlength=\"" . $arField["size"] . "\" value=\"{\$value_".$arField["name"]."}\" " . $strRequired . " onkeypress=\"return Mask(this,'num',event);\" /><br />\n";
						
						array_push($arFields, $strField);
					}
					
					// número Float: Campo text
					elseif($arField["type"] == "real")
					{
						$strType = $this->IsCrypted($arField["name"]) ? "password" : "text";
						
						$strField = "    <label for=\"".$arField["name"]."\">".$strLabel.":</label>\n";
						$strField.= "    <input type=\"".$strType."\" name=\"" . $arField["name"] . "\" id=\"" . $arField["name"] . "\" maxlength=\"" . $arField["size"] . "\" value=\"{\$value_".$arField["name"]."}\" " . $strRequired . " onkeydown=\"Decimal(this,event);\" onkeypress=\"return Mask(this,'num',event);\" /><br />\n";
						
						array_push($arFields, $strField);
					}
					
					// Texto: Campo text
					elseif($arField["type"] == "string")
					{
						$strType = $this->IsCrypted($arField["name"]) ? "password" : "text";
						
						$intSize = $arField["size"] > 50 ? 50 : $arField["size"];
						
						$strField = "    <label for=\"".$arField["name"]."\">".$strLabel.":</label>\n";
						$strField.= "    <input type=\"".$strType."\" name=\"" . $arField["name"] . "\" id=\"" . $arField["name"] . "\" value=\"{\$value_".$arField["name"]."}\" maxlength=\"" . $arField["size"] . "\" " . $strRequired . " /><br />\n";
						
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