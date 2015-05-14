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
 * @version 1.0 - 2006-11-30 10:00:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class CodeGenBusinessException extends Exception{}

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
 * Gera classes de negócios automaticamente
 *
 * @package Framework
 * @subpackage CodeGen
 * @version 1.0 - 2006-11-30 10:00:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class CodeGenBusiness extends CodeGenClass
{
   
   /** 
    * Attributes:
    */
   
//---------------------------------------------------------------------------------------   

   /** 
    * Properties:
    */

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
	    }

   /**
	* Método destrutor da classe
	* @return void
	* @access public
	*/
	    public function __destruct()
	    {	
		    parent::__destruct();
			unset($this);
	    }
	
   /**
	* Escreve o código da classe
	* @return string código da classe
	* @access private
	*/	
		private function BeginClass()
		{
			$strClass = "<?php" . parent::NewLine(2);
			
			// Arquivos necessários
			//$strClass.= parent::GenerateRequires();
			
			// Classe Exception
			$strClass.= parent::GenerateHeader("Classe responsável pelo gerenciamento de erros");
			$strClass.= "class " . parent::GetName() . "Exception extends Exception{}" . parent::NewLine(2);
			
			// Classe
			$strClass.= parent::GenerateHeader("Classe responsável pela implementação da lógica de negócio");
			$strClass.= "class " . parent::GetName() . parent::NewLine();
			$strClass.= "{";
			$strClass.= parent::NewLine();
			$strClass.= $this->GenerateAttributes();
			$strClass.= $this->GenerateProperties();
			$strClass.= $this->GenerateMethods();
			
			return $strClass;				
		}

       /**
	* Escreve os atributos da classe
	* @return string Atributos da classe
	* @access private
	*/		
		private function GenerateAttributes()
		{
			$strAttributes = parent::LineBlock("Attributes");
			
			foreach(parent::GetAttributes() as $arAttribute)
			{
				$strName = $arAttribute["name"];
				$strType = $arAttribute["type"];
				
				if(parent::IsCrypted($arAttribute["name"]))
				{
				    $strSize = parent::GetDecryptedSize($arAttribute["size"]);
				}
				else
				{
				    $strSize = $arAttribute["size"];
				}
				
				// Nesse caso o tipo é boolean:
				if($strType == "int" && $strSize == 1)
				{
				    $strDescription = "boolean";    
				}
				else
				{
				    $strDescription = $strType;
				}
				
				$strAttributes.= parent::Indent()  . "/**"                     . parent::NewLine();
				$strAttributes.= parent::Indent()  . " *"                      . parent::NewLine();
				$strAttributes.= parent::Indent()  . " * @var $strDescription" . parent::NewLine();
				$strAttributes.= parent::Indent()  . " * @size $strSize"       . parent::NewLine();				
				$strAttributes.= parent::Indent()  . " * @access private"      . parent::NewLine();
				$strAttributes.= parent::Indent()  . " */"                     . parent::NewLine();
				$strAttributes.= parent::Indent(2) . " private \$$strName;"    . parent::NewLine(2);
            }			
			
			$strAttributes.= $this->GenerateObjects();
			
			$strAttributes.= parent::NewLine();
			
			return $strAttributes;
		}

   /**
	* Gera os objetos que representam os relacionamentos da classe com outras classes
	* @return string Atributos da classe
	* @access private
	*/		
		private function GenerateObjects()
		{
		    $strObjects = "";
			
			$arMatches = array();

			if(is_array(parent::GetRelationships()))
			{
				foreach(parent::GetRelationships() as $arRelationship)
				{
					if(in_array($arRelationship["class"], $arMatches))
					{
						$strDesc = "**** Verificar o nome correto deste objeto ****";
						$strClassName = $arRelationship["class"] . $arRelationship["fk"];
					}
					else
					{
						$strClassName = $arRelationship["class"];
					}
					
					$strName = "obj" . $strClassName;
					
					$strObjects.= parent::Indent()  . "/**"                                . parent::NewLine();
					$strObjects.= parent::Indent()  . " * $strDesc"                        . parent::NewLine();
					$strObjects.= parent::Indent()  . " * @var ". $arRelationship["class"] . parent::NewLine();
					$strObjects.= parent::Indent()  . " * @access private"                 . parent::NewLine();
					$strObjects.= parent::Indent()  . " */"                                . parent::NewLine();
					$strObjects.= parent::Indent(2) . " private \$$strName;"               . parent::NewLine(2);
					
					array_push($arMatches, $arRelationship["class"]);
				}
			}
			return $strObjects;
		}

   /**
	* Escreve as propriedades da classe
	* @return string Propriedades da classe
	* @access private
	*/		
		private function GenerateProperties()
		{
			$strProperties = parent::LineBlock("Properties");
			
			$strProperties.= parent::Indent()  . "/**"                                                                     . parent::NewLine();
			$strProperties.= parent::Indent()  . " * Método de acesso dinâmico as propriedades da classe"                  . parent::NewLine();
			$strProperties.= parent::Indent()  . " * @param string \$strMethod método de acesso ao atributo"               . parent::NewLine();
			$strProperties.= parent::Indent()  . " * @param array \$arArguments Valor a ser setado no atributo"             . parent::NewLine();
			$strProperties.= parent::Indent()  . " * @return mixed"                                                        . parent::NewLine();
			$strProperties.= parent::Indent()  . " * @access public "                                                      . parent::NewLine();
			$strProperties.= parent::Indent()  . " */"                                                                     . parent::NewLine();
			$strProperties.= parent::Indent(2) . " public function __call(\$strMethod, \$arArguments)"                     . parent::NewLine();
			$strProperties.= parent::Indent(2) . " {"                                                                      . parent::NewLine();
			$strProperties.= parent::Indent(3) . " list(\$strPrefix, \$strProperty) = Utils::buildAttribute(\$strMethod);" . parent::NewLine(2);
			$strProperties.= parent::Indent(3) . " if(empty(\$strPrefix) || empty(\$strProperty)) return;"                 . parent::NewLine(2);
			$strProperties.= parent::Indent(3) . " if(\$strPrefix == 'Get' && array_key_exists(\$strProperty, get_object_vars(\$this)))". parent::NewLine();
			$strProperties.= parent::Indent(3) . " {"                                                                      . parent::NewLine();
			$strProperties.= parent::Indent(4) . " return \$this->\$strProperty;"                                           . parent::NewLine();
			$strProperties.= parent::Indent(3) . " }"                                                                      . parent::NewLine();
			$strProperties.= parent::Indent(3) . " elseif(\$strPrefix == 'Set' && array_key_exists(\$strProperty, get_object_vars(\$this)))" . parent::NewLine();
			$strProperties.= parent::Indent(3) . " {"                                                                      . parent::NewLine();
			$strProperties.= parent::Indent(4) . " \$this->\$strProperty = \$arArguments[0];"                              . parent::NewLine();
			$strProperties.= parent::Indent(3) . " }"                                                                      . parent::NewLine();
			$strProperties.= parent::Indent(2) . " }"                                                                      . parent::NewLine(2);
			
			return $strProperties;
		}
		
   /**
	* Escreve as propriedades da classe
	* @return string Propriedades da classe
	* @access private
	*/		
		private function GenerateMethods()
		{
			$strMethods = parent::LineBlock("Methods");
			
			$strMethods.= $this->GenerateConstruct();
			$strMethods.= $this->GenerateDestruct();
			$strMethods.= $this->GenerateValidar();
			$strMethods.= $this->GenerateCadastrar();
			$strMethods.= $this->GenerateAlterar();
			$strMethods.= $this->GenerateExcluir();
			$strMethods.= $this->GenerateCarregar();
			$strMethods.= $this->GenerateListar();
			
			return $strMethods;	
		}
		
   /**
	* Escreve o construtor da classe
	* @return string Construtor da classe
	* @access private
	*/		
		private function GenerateConstruct()
		{
			$strConstruct = parent::Indent()  . "/**"                            . parent::NewLine();
			$strConstruct.= parent::Indent()  . " * Método construtor da classe" . parent::NewLine();
			$strConstruct.= parent::Indent()  . " * @return void"                . parent::NewLine();	
			$strConstruct.= parent::Indent()  . " * @access public"              . parent::NewLine();	
			$strConstruct.= parent::Indent()  . " */"                            . parent::NewLine();
			$strConstruct.= parent::Indent(2) . " public function __construct()" . parent::NewLine();
			$strConstruct.= parent::Indent(2) . " {"                             . parent::NewLine();
			
			foreach(parent::GetAttributes() as $arAttribute)
			{
				if($arAttribute["type"] == 'int' && in_array('not_null', $arAttribute['flags']) && (in_array('primary_key', $arAttribute['flags']) || in_array('unique_key', $arAttribute['flags']) || in_array('multiple_key', $arAttribute['flags'])))
				{
				    $mxdValue = 0;
				}
				else
				{
				    $mxdValue = "''";
				}
				
				$strConstruct.= parent::Indent(3);
				$strConstruct.= " \$this->Set" . ucfirst($arAttribute["name"]);
				$strConstruct.= "(".$mxdValue.");" . parent::NewLine();
			}
			
			if(is_array(parent::GetRelationships()))
			{
				$arMatches = array();
				
				foreach(parent::GetRelationships() as $arRelationship)
				{
					if(in_array($arRelationship["class"], $arMatches))
					{
						$strClassName = $arRelationship["class"] . $arRelationship["fk"];
					}
					else
					{
						$strClassName = $arRelationship["class"];
					}
					
					$strConstruct.= parent::Indent(3);
					$strConstruct.= " \$this->Set" . $strClassName;
					$strConstruct.= "(new ".$arRelationship["class"].");" . parent::NewLine();
					
					array_push($arMatches, $arRelationship["class"]);
				}			
			}
			
			$strConstruct.= parent::Indent(2) . " }"  . parent::NewLine(2);
			
            $strConstruct.= parent::LineBlock(false, false);
            
			return $strConstruct;
		}

   /**
	* Escreve o destrutor da classe
	* @return string Destrutor da classe
	* @access private
	*/		
		private function GenerateDestruct()
		{
			$strDestruct = parent::Indent()  . "/**"                           . parent::NewLine();
			$strDestruct.= parent::Indent()  . " * Método destrutor da classe" . parent::NewLine();
			$strDestruct.= parent::Indent()  . " * @return void"               . parent::NewLine();	
			$strDestruct.= parent::Indent()  . " * @access public"             . parent::NewLine();	
			$strDestruct.= parent::Indent()  . " */"                           . parent::NewLine();
			$strDestruct.= parent::Indent(2) . " public function __destruct()" . parent::NewLine();
			$strDestruct.= parent::Indent(2) . " {"                            . parent::NewLine();
			$strDestruct.= parent::Indent(3) . " unset(\$this);"               . parent::NewLine();
			$strDestruct.= parent::Indent(2) . " }"                            . parent::NewLine(2);
			
            $strDestruct.= parent::LineBlock(false, false);
            
			return $strDestruct;
		}

   /**
	* Escreve o método Validar
	* @return string método validar
	* @access private
	*/		
		private function GenerateValidar()
		{
			$strValidar = parent::Indent()  . "/**"                                                                   . parent::NewLine();
			$strValidar.= parent::Indent()  . " * Valida o valor de cada atributo da classe"                          . parent::NewLine();
            $strValidar.= parent::Indent()  . " * @param array \$arAttributes (Opcional) Atributos a serem validados" . parent::NewLine();
			$strValidar.= parent::Indent()  . " * @return void "                                                      . parent::NewLine();
			$strValidar.= parent::Indent()  . " * @access public"                                                     . parent::NewLine();
			$strValidar.= parent::Indent()  . " * @throws ".parent::GetName()."Exception Dispara uma exceção caso ocorra algum erro" . parent::NewLine();
			$strValidar.= parent::Indent()  . " * @see Validatation::Validate()"                                      . parent::NewLine();				
			$strValidar.= parent::Indent()  . " */"                                                                   . parent::NewLine();
			$strValidar.= parent::Indent(2) . " public function Validar(\$arAttributes = NULL)"                       . parent::NewLine();
			$strValidar.= parent::Indent(2) . " {"                                                                    . parent::NewLine();
			$strValidar.= parent::Indent(3) . " try"                                                                  . parent::NewLine();
			$strValidar.= parent::Indent(3) . " {"                                                                    . parent::NewLine();
			$strValidar.= parent::Indent(3) . parent::Indent() . " \$objValidation = new Validation();"               . parent::NewLine(2);

            foreach(parent::GetAttributes() as $arAttribute)
			{
				$strName = $arAttribute["name"];
				$strType = $arAttribute["type"];
				$strSize = $arAttribute["size"];
                
				if(parent::IsCrypted($arAttribute["name"]))
				{
				    $strSize = parent::GetDecryptedSize($arAttribute["size"]);
				}
				else
				{
				    $strSize = $arAttribute["size"];
				}
				
				// Nesse caso o tipo é boolean:				
				if($strType == "int" && $strSize == 1)
				{
				    $strType = "boolean";    
				}
				
				if(in_array('not_null', $arAttribute['flags']) && !in_array('primary_key', $arAttribute['flags']))
				{
				    $blnNull = 'false';
				}
				else
				{
				    $blnNull = 'true'; 
				}   
				
			    $strValidar.= parent::Indent(3) . parent::Indent();
				$strValidar.= " \$objValidation->AddAttribute('$strName', \$this->Get" . ucfirst($strName) . "(), ";
				$strValidar.= "'$strType', $strSize, $blnNull);";
				$strValidar.= parent::NewLine();
			}
			
			$strValidar.= parent::NewLine();
			
			$strValidar.= parent::Indent(3) . parent::Indent() . " \$objValidation->Validate(\$arAttributes);"    . parent::NewLine();
			
			$strValidar.= parent::Indent(3) . " }"                                                                . parent::NewLine();
			$strValidar.= parent::Indent(3) . " catch(Exception \$e)"                                             . parent::NewLine();
			$strValidar.= parent::Indent(3) . " {"                                                                . parent::NewLine();
			$strValidar.= parent::Indent(4) . " throw new " . parent::GetName() . "Exception(\$e->getMessage());" . parent::NewLine();
			$strValidar.= parent::Indent(3) . " }"                                                                . parent::NewLine();
			$strValidar.= parent::Indent(2) . " }"                                                                . parent::NewLine(2);
			
            $strValidar.= parent::LineBlock(false, false);
            
			return $strValidar;
		}

   /**
	* Escreve o método Cadastrar
	* @return string método cadastrar
	* @access private
	*/		
		private function GenerateCadastrar()
		{
			$strCadastrar = parent::Indent()  . "/**"                                                                       . parent::NewLine();
			$strCadastrar.= parent::Indent()  . " * Cadastra um novo registro"                                              . parent::NewLine();
			$strCadastrar.= parent::Indent()  . " * @param array \$arAttributes (Opcional) Atributos da operação, ";
			$strCadastrar.= "1º elemento do array deve ser 'save' ou 'ignore'"                                              . parent::NewLine();			
			$strCadastrar.= parent::Indent()  . " * @return mixed Se o comando "; 
			$strCadastrar.= "for executado com sucesso retorna o id do registro, ";                                
			$strCadastrar.= "caso contrário false"                                                                          . parent::NewLine();
			$strCadastrar.= parent::Indent()  . " * @access public"                                                         . parent::NewLine();	
            $strCadastrar.= parent::Indent()  . " * @throws Exception Dispara uma exceção caso ocorra algum erro"           . parent::NewLine();	
			$strCadastrar.= parent::Indent()  . " * @see Dao".parent::GetName()."::Cadastrar()"                             . parent::NewLine();	
			$strCadastrar.= parent::Indent()  . " */"                                                                       . parent::NewLine();
			$strCadastrar.= parent::Indent(2) . " public function Cadastrar(\$arAttributes = NULL)"                         . parent::NewLine();
			$strCadastrar.= parent::Indent(2) . " {"                                                                        . parent::NewLine();
			$strCadastrar.= parent::Indent(3) . " try"                                                                      . parent::NewLine();
			$strCadastrar.= parent::Indent(3) . " {"                                                                        . parent::NewLine();
			$strCadastrar.= parent::Indent(4) . " \$this->Validar(\$arAttributes);"                                         . parent::NewLine(2);
			$strCadastrar.= parent::Indent(4) . " \$objDao".parent::GetName()." = new Dao".parent::GetName().";"            . parent::NewLine(2);
			$strCadastrar.= parent::Indent(4) . " return \$objDao".parent::GetName()."->Cadastrar(\$this, \$arAttributes);" . parent::NewLine();
			$strCadastrar.= parent::Indent(3) . " }"                                                                        . parent::NewLine();
			$strCadastrar.= parent::Indent(3) . " catch(Exception \$e)"                                                     . parent::NewLine();
			$strCadastrar.= parent::Indent(3) . " {"                                                                        . parent::NewLine();
			$strCadastrar.= parent::Indent(3) . parent::Indent() . " throw \$e;"                                            . parent::NewLine();
			$strCadastrar.= parent::Indent(3) . " }"                                                                        . parent::NewLine();
			$strCadastrar.= parent::Indent(2) . " }"                                                                        . parent::NewLine(2);
			
            $strCadastrar.= parent::LineBlock(false, false);
            
			return $strCadastrar;
		}

   /**
	* Escreve o método alterar
	* @return string método alterar
	* @access private
	*/		
		private function GenerateAlterar()
		{
			$strAlterar = parent::Indent()  . "/**"                                                                     . parent::NewLine();
			$strAlterar.= parent::Indent()  . " * Altera o registro informado"                                          . parent::NewLine();
            $strAlterar.= parent::Indent()  . " * @param array \$arAttributes (Opcional) Atributos da operação, ";
			$strAlterar.= "1º elemento do array deve ser 'save' ou 'ignore'"                                            . parent::NewLine();
			$strAlterar.= parent::Indent()  . " * @param string \$strUserCondition (Opcional) Condição da operação"     . parent::NewLine();
			$strAlterar.= parent::Indent()  . " * @return boolean true se o comando for executado com sucesso, "; 
			$strAlterar.= "caso contrário false"                                                                        . parent::NewLine();	
			$strAlterar.= parent::Indent()  . " * @access public"                                                       . parent::NewLine();	
            $strAlterar.= parent::Indent()  . " * @throws Exception Dispara uma exceção caso ocorra algum erro"         . parent::NewLine();				
            $strAlterar.= parent::Indent()  . " * @see Dao".parent::GetName()."::Alterar()"                             . parent::NewLine();	
			$strAlterar.= parent::Indent()  . " */"                                                                     . parent::NewLine();
			$strAlterar.= parent::Indent(2) . " public function Alterar(\$arAttributes = NULL, ";
			$strAlterar.= "\$strUserCondition = NULL)"                                                                  . parent::NewLine();
			$strAlterar.= parent::Indent(2) . " {"                                                                      . parent::NewLine();
			$strAlterar.= parent::Indent(3) . " try"                                                                    . parent::NewLine();
			$strAlterar.= parent::Indent(3) . " {"                                                                      . parent::NewLine();
			$strAlterar.= parent::Indent(4) . " \$this->Validar(\$arAttributes);"                                       . parent::NewLine(2);
			$strAlterar.= parent::Indent(4) . " \$objDao".parent::GetName()." = new Dao".parent::GetName().";"          . parent::NewLine(2);
			$strAlterar.= parent::Indent(4) . " return \$objDao".parent::GetName()."->Alterar(\$this, ";
			$strAlterar.= "\$arAttributes, \$strUserCondition);"                                                        . parent::NewLine();
			$strAlterar.= parent::Indent(3) . " }"                                                                      . parent::NewLine();
			$strAlterar.= parent::Indent(3) . " catch(Exception \$e)"                                                   . parent::NewLine();
			$strAlterar.= parent::Indent(3) . " {"                                                                      . parent::NewLine();
			$strAlterar.= parent::Indent(4) . " throw \$e;"                                                             . parent::NewLine();
			$strAlterar.= parent::Indent(3) . " }"                                                                      . parent::NewLine();
			$strAlterar.= parent::Indent(2) . " }"                                                                      . parent::NewLine(2);
			
            $strAlterar.= parent::LineBlock(false, false);
            
			return $strAlterar;
		}

   /**
	* Escreve o método excluir
	* @return string método excluir
	* @access private
	*/		
		private function GenerateExcluir()
		{
			$strExcluir = parent::Indent()  . "/**"                                                                         . parent::NewLine();
			$strExcluir.= parent::Indent()  . " * Exclui o registro informado"                                              . parent::NewLine();
			$strExcluir.= parent::Indent()  . " * @param string \$strUserCondition (Opcional) Condição da operação"         . parent::NewLine();
			$strExcluir.= parent::Indent()  . " * @return boolean true se o comando for executado com sucesso, "; 
			$strExcluir.= "caso contrário false"                                                                            . parent::NewLine();	
			$strExcluir.= parent::Indent()  . " * @access public"                                                           . parent::NewLine();	
            $strExcluir.= parent::Indent()  . " * @throws Exception Dispara uma exceção caso ocorra algum erro"             . parent::NewLine();				
			$strExcluir.= parent::Indent()  . " * @see Dao".parent::GetName()."::Excluir()"                                 . parent::NewLine();	
			$strExcluir.= parent::Indent()  . " */"                                                                         . parent::NewLine();
			$strExcluir.= parent::Indent(2) . " public function Excluir(\$strUserCondition = NULL)"                         . parent::NewLine();
			$strExcluir.= parent::Indent(2) . " {"                                                                          . parent::NewLine();
			$strExcluir.= parent::Indent(3) . " try"                                                                        . parent::NewLine();
			$strExcluir.= parent::Indent(3) . " {"                                                                          . parent::NewLine();
			$strExcluir.= parent::Indent(4) . " \$objDao".parent::GetName()." = new Dao".parent::GetName().";"              . parent::NewLine(2);
			$strExcluir.= parent::Indent(4) . " return \$objDao".parent::GetName()."->Excluir(\$this, \$strUserCondition);" . parent::NewLine();
			$strExcluir.= parent::Indent(3) . " }"                                                                          . parent::NewLine();
			$strExcluir.= parent::Indent(3) . " catch(Exception \$e)"                                                       . parent::NewLine();
			$strExcluir.= parent::Indent(3) . " {"                                                                          . parent::NewLine();
			$strExcluir.= parent::Indent(4) . " throw \$e;"                                                                 . parent::NewLine();
			$strExcluir.= parent::Indent(3) . " }"                                                                          . parent::NewLine();
			$strExcluir.= parent::Indent(2) . " }"                                                                          . parent::NewLine(2);
			
            $strExcluir.= parent::LineBlock(false, false);
            
			return $strExcluir;
		}

   /**
	* Escreve o método carregar
	* @return string método carregar
	* @access private
	*/		
		private function GenerateCarregar()
		{
			$strCarregar = parent::Indent()  . "/**"																    . parent::NewLine();
			$strCarregar.= parent::Indent()  . " * Inicializa o objeto com o registro armazenado em meio persistente "  . parent::NewLine();
			$strCarregar.= parent::Indent()  . " * @param array \$arAttributes (Opcional) Atributos a serem carregados" . parent::NewLine();
			$strCarregar.= parent::Indent()  . " * @return object " . parent::GetName()                                 . parent::NewLine();
			$strCarregar.= parent::Indent()  . " * @access public"												        . parent::NewLine();	
            $strCarregar.= parent::Indent()  . " * @throws Exception Dispara uma exceção caso ocorra algum erro"        . parent::NewLine();				
            $strCarregar.= parent::Indent()  . " * @see Dao".parent::GetName()."::Carregar()"                           . parent::NewLine();				
			$strCarregar.= parent::Indent()  . " */"																    . parent::NewLine();
			$strCarregar.= parent::Indent(2) . " public function Carregar(\$arAttributes = NULL)"					    . parent::NewLine();
			$strCarregar.= parent::Indent(2) . " {"																	    . parent::NewLine();
			$strCarregar.= parent::Indent(3) . " try"																    . parent::NewLine();
			$strCarregar.= parent::Indent(3) . " {"																	    . parent::NewLine();
			$strCarregar.= parent::Indent(4) . " \$objDao".parent::GetName()." = new Dao".parent::GetName().";"	        . parent::NewLine();
			$strCarregar.= parent::Indent(4) . " \$objDao".parent::GetName()."->Carregar(\$this, \$arAttributes);"     . parent::NewLine(2);
			
			if(is_array(parent::GetRelationships()))
			{
				$arMatches = array();
				
				foreach(parent::GetRelationships() as $arRelationship)
				{
					if(in_array($arRelationship["class"], $arMatches))
					{
						$strClassName = $arRelationship["class"] . $arRelationship["fk"];
					}
					else
					{
						$strClassName = $arRelationship["class"];
					}
						  
					$strCarregar.= parent::Indent(4) . " \$this->Get".$strClassName."()->Set".ucfirst($arRelationship["pk"])."(\$this->Get".ucfirst($arRelationship["fk"])."());" . parent::NewLine();
					$strCarregar.= parent::Indent(4) . " \$this->Get".$strClassName."()->Carregar();" . parent::NewLine(2);
					
					array_push($arMatches, $arRelationship["class"]);
				}
			}
						
			$strCarregar.= parent::Indent(3) . " }"					   . parent::NewLine();
			$strCarregar.= parent::Indent(3) . " catch(Exception \$e)" . parent::NewLine();
			$strCarregar.= parent::Indent(3) . " {"					   . parent::NewLine();
			$strCarregar.= parent::Indent(4) . " throw \$e;"		   . parent::NewLine();
			$strCarregar.= parent::Indent(3) . " }"        			   . parent::NewLine();
			$strCarregar.= parent::Indent(2) . " }"                    . parent::NewLine(2);
			
            $strCarregar.= parent::LineBlock(false, false);
            
			return $strCarregar;
		}

   /**
	* Escreve o método listar
	* @return string método listar
	* @access private
	*/		
		private function GenerateListar()
		{
			$strListar = parent::Indent()  . "/**". parent::NewLine();
			$strListar.= parent::Indent()  . " * Retorna uma lista de objetos desta classe onde cada objeto representa um registro. "    . parent::NewLine();
			$strListar.= parent::Indent()  . " * @param array \$arAttributes (Opcional) Atributos a serem carregados na listagem"        . parent::NewLine();
			$strListar.= parent::Indent()  . " * @param array \$arOrderBy (Opcional) Ordernação da listagem array(array('campo1', 'campo2'), 'ASC')" . parent::NewLine();
			$strListar.= parent::Indent()  . " * @return array Array de objetos " . parent::GetName()                                    . parent::NewLine();
			$strListar.= parent::Indent()  . " * @access public"															  		     . parent::NewLine();	
            $strListar.= parent::Indent()  . " * @throws Exception Dispara uma exceção caso ocorra algum erro"                           . parent::NewLine();	
            $strListar.= parent::Indent()  . " * @see Dao".parent::GetName()."::Listar()"                                                . parent::NewLine();				
			$strListar.= parent::Indent()  . " * @see Collection"                                                                        . parent::NewLine();				
			$strListar.= parent::Indent()  . " */"																			  		     . parent::NewLine();
			$strListar.= parent::Indent(2) . " public function Listar(\$arAttributes = NULL, \$arOrderBy = NULL)"	      		         . parent::NewLine();
			$strListar.= parent::Indent(2) . " {"																			  		     . parent::NewLine();
			$strListar.= parent::Indent(3) . " try"																		  		         . parent::NewLine();
			$strListar.= parent::Indent(3) . " {"																			  	 	     . parent::NewLine();
			$strListar.= parent::Indent(4) . " \$objDao".parent::GetName()." = new Dao".parent::GetName().";"					 	     . parent::NewLine(2);
			$strListar.= parent::Indent(4) . " return new Collection(\$objDao".parent::GetName()."->Listar(__CLASS__, \$arAttributes, \$arOrderBy));" . parent::NewLine();
			$strListar.= parent::Indent(3) . " }"																			  		     . parent::NewLine();
			$strListar.= parent::Indent(3) . " catch(Exception \$e)"														  		     . parent::NewLine();
			$strListar.= parent::Indent(3) . " {"																			  		     . parent::NewLine();
			$strListar.= parent::Indent(4) . " throw \$e;"												  		                         . parent::NewLine();
			$strListar.= parent::Indent(3) . " }"																			  		     . parent::NewLine();
			$strListar.= parent::Indent(2) . " }"												   							  		     . parent::NewLine();
			$strListar.= parent::NewLine();
            
            $strListar.= parent::LineBlock(false, false);
            
			return $strListar;
		}

   /**
	* Salva o código gerado em um arquivo com o mesmo nome da classe
	* @param string $strDir diretório onde será gerado o arquivo da classe
	* @param string $strClassCode código gerado
	* @access private
	*/		
		private function Save($strDir, $strClassCode)
		{
			$strDir .= str_replace(" ", "", parent::getSubPackage()) . "/";
			
			$objFolder = new Folder();
			$objFolder->Create($strDir);
			
			// Criando o diretório Class onde ficarão as classes:
			$strLibDir = $strDir . "Model/";	
			$objFolder->Create($strLibDir);

			// Criando o diretório Class onde ficarão as classes:
			$strCtrlDir = $strDir . "Controller/";	
			$objFolder->Create($strCtrlDir);
			
			// Criando o diretório de arquivos de interface:
			$strTemplatesDir = $strDir . "View/";
			$objFolder->Create($strTemplatesDir);

			// Criando o diretório de arquivos de biblioteca de interfaces:
			$strTemplatesDir = $strDir . "View/Class/";
			$objFolder->Create($strTemplatesDir);

			// Criando o diretório de arquivos de css:
			$strTemplatesDir = $strDir . "View/Styles/";
			$objFolder->Create($strTemplatesDir);
			
			// Criando o diretório de classes de acesso a dados
			$strUtilsDir = $strDir . "Dao/";
			$objFolder->Create($strUtilsDir);
			
			// Criando o nome da classe
			$strFileName = $strLibDir . "t" . parent::GetName() . ".php";
			
			$objFile = new File($strFileName, 'w+');
			$objFile->Open();

			$blnFileSaved = $objFile->Write($strClassCode);
                        
            //$strStatusColor = $blnFileSaved ? 'green' : 'red';
            
            $strOutput = date('Y-m-d H:i:s') . ' - ' . $strFileName . "\n";
           
            echo $strOutput;
            
            return $blnFileSaved;
                     
		}

       /**
	* Gera a classe
	* @param string $strDir diretório onde será gerado o arquivo da classe
	* @return string código completo da classe
	* @access public
	*/		
		public function Generate($strDir)
		{
			// Conectando ao servidor de banco de dados:
			$objDBServer = AdoFactory::Server();
			
			// Verificando se a tabela informada existe:
			$arDataBaseTables = $objDBServer->GetTables();
			
			if(!in_array(parent::GetTable(), $arDataBaseTables[$objDBServer->GetDataBase()]))
			{
				$strMessage = "O código da classe " . parent::GetName() . " não pode ser gerado ";
				$strMessage.= "pois sua tabela " . parent::getTable() . " não existe em " . $objDBServer->getDataBase();
				
				throw new CodeGenBusinessException($strMessage);
			}
			
			// Construindo os relacionamentos da tabela
			parent::BuildRelationships();
			
			// Obtendo os campos da tabela:
			$rscFields = $objDBServer->ListFields(parent::getTable());
			
			// Setando os atributos da classe com os campos obtidos:
			$this->SetAttributes($objDBServer->FieldsInfo($rscFields));
			
			$strClassCode = $this->BeginClass();
			$strClassCode.= parent::EndClass();
			
			// Salvando o arquivo
			return $this->Save($strDir, $strClassCode);
		}
}
?>