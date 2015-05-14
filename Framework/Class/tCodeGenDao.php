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
 * @version 1.0 - 2006-11-30 09:30:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class CodeGenDaoException extends Exception{}

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
 * Gera classes de acesso a dados automaticamente
 *
 * @package Framework
 * @subpackage CodeGen
 * @version 1.0 - 2006-12-04 09:30:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class CodeGenDao extends CodeGenClass
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
			$strClass.= "class Dao" . parent::GetName() . "Exception extends Exception{}" . parent::NewLine(2);
			
			$strClass.= parent::GenerateHeader("Classe responsável pelo acesso a dados armazenados em meio persistente");
			$strClass.= "class Dao" . parent::GetName() . " extends DaoModel "  . parent::NewLine();
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
			
			$strAttributes.= parent::Indent() . "/**"                                                    . parent::NewLine();
			$strAttributes.= parent::Indent() . " * Tabela do banco de dados gerenciada por esta classe" . parent::NewLine();
			$strAttributes.= parent::Indent() . " * @var string"                                         . parent::NewLine();
			$strAttributes.= parent::Indent() . " * @access private"                                     . parent::NewLine();
			$strAttributes.= parent::Indent() . " */"                                                    . parent::NewLine();
			$strAttributes.= parent::Indent() . "const _TABLE = '".parent::getTable()."';"             . parent::NewLine();
            
			$strAttributes.= parent::NewLine();
			
			return $strAttributes;
		}

   /**
	* Escreve as propriedades da classe
	* @return string Propriedades da classe
	* @access private
	*/		
		private function GenerateProperties()
		{
			$strProperties = parent::LineBlock("Properties");
			
			$strProperties.= parent::Indent()  . "/**"                                         . parent::NewLine();
			$strProperties.= parent::Indent()  . " * Retorna o valor da constante _TABLE"      . parent::NewLine();
			$strProperties.= parent::Indent()  . " * @return string Tabela gerenciada por esta classe" . parent::NewLine();
			$strProperties.= parent::Indent()  . " */"                                         . parent::NewLine();
			$strProperties.= parent::Indent(2) . " public function GetTable()"                 . parent::NewLine();
			$strProperties.= parent::Indent(2) . " {"                                          . parent::NewLine();
			$strProperties.= parent::Indent(3) . " return self::_TABLE;"                       . parent::NewLine();
			$strProperties.= parent::Indent(2) . " }"                                          . parent::NewLine(2);
			
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
			$strConstruct = parent::Indent()  . "/**"                                        . parent::NewLine();
			$strConstruct.= parent::Indent()  . " * Método construtor da classe"             . parent::NewLine();
			$strConstruct.= parent::Indent()  . " * @return void"                            . parent::NewLine();	
			$strConstruct.= parent::Indent()  . " * @access public"                          . parent::NewLine();	
			$strConstruct.= parent::Indent()  . " * @see DaoModel::__construct()" . parent::NewLine();	
			$strConstruct.= parent::Indent()  . " */"                                        . parent::NewLine();
			$strConstruct.= parent::Indent(2) . " public function __construct()"             . parent::NewLine();
			$strConstruct.= parent::Indent(2) . " {"                                         . parent::NewLine();
			$strConstruct.= parent::Indent(3) . " parent::__construct();"                    . parent::NewLine();
			$strConstruct.= parent::Indent(2) . " }" . parent::NewLine(2);
			
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
			$strDestruct = parent::Indent()  . "/**"                            . parent::NewLine();
			$strDestruct.= parent::Indent()  . " * Método destrutor da classe"  . parent::NewLine();
			$strDestruct.= parent::Indent()  . " * @return void"                . parent::NewLine();	
			$strDestruct.= parent::Indent()  . " * @access public"              . parent::NewLine();	
			$strDestruct.= parent::Indent()  . " */"                            . parent::NewLine();
			$strDestruct.= parent::Indent(2) . " public function __destruct()"  . parent::NewLine();
			$strDestruct.= parent::Indent(2) . " {"                             . parent::NewLine();
			$strDestruct.= parent::Indent(3) . " unset(\$this);"                . parent::NewLine();
			$strDestruct.= parent::Indent(2) . " }"                             . parent::NewLine(2);
			
            $strDestruct.= parent::LineBlock(false, false);
            
			return $strDestruct;
		}

   /**
	* Escreve o método cadastrar
	* @return string método cadastrar
	* @access private
	*/		
		private function GenerateCadastrar()
		{
			$strCadastrar = parent::Indent()  . "/**"                                                                          . parent::NewLine();
			$strCadastrar.= parent::Indent()  . " * Cadastra um novo registro"                                                 . parent::NewLine();
			$strCadastrar.= parent::Indent()  . " * @param object \$obj".parent::GetName()." Objeto ".parent::GetName().""     . parent::NewLine();
			$strCadastrar.= parent::Indent()  . " * @param array \$arAttributes (Opcional) Atributos da operação, ";
			$strCadastrar.= "1º elemento do array deve ser 'save' ou 'ignore'"                                                 . parent::NewLine();
			$strCadastrar.= parent::Indent()  . " * @return mixed Se o comando "; 
			$strCadastrar.= "for executado com sucesso retorna o id do registro, ";
			$strCadastrar.= "caso contrário false"                                                                             . parent::NewLine();	
			$strCadastrar.= parent::Indent()  . " * @access public"                                                            . parent::NewLine();	
            $strCadastrar.= parent::Indent()  . " * @throws Exception Dispara uma exceção caso ocorra algum erro"              . parent::NewLine();	
			$strCadastrar.= parent::Indent()  . " * @see AdoStatementInsert::Execute()"                                        . parent::NewLine();
			$strCadastrar.= parent::Indent()  . " */"                                                                          . parent::NewLine();
			$strCadastrar.= parent::Indent(2) . " public function Cadastrar(".parent::GetName()." \$obj".parent::GetName();
			$strCadastrar.= ", \$arAttributes = NULL)"                                                                         . parent::NewLine();
			$strCadastrar.= parent::Indent(2) . " {"                                                                           . parent::NewLine();
			$strCadastrar.= parent::Indent(3) . " try"                                                                         . parent::NewLine();
			$strCadastrar.= parent::Indent(3) . " {"                                                                           . parent::NewLine();
			$strCadastrar.= parent::Indent(4) . " return parent::Insert(\$obj".parent::GetName().", self::_TABLE, ";
			$strCadastrar.= "\$arAttributes);"                                                                                 . parent::NewLine();
			$strCadastrar.= parent::Indent(3) . " }"                                                                           . parent::NewLine();
			$strCadastrar.= parent::Indent(3) . " catch(Exception \$e)"                                                        . parent::NewLine();
			$strCadastrar.= parent::Indent(3) . " {"                                                                           . parent::NewLine();
			$strCadastrar.= parent::Indent(3) . parent::Indent() . " throw \$e;"                                               . parent::NewLine();
			$strCadastrar.= parent::Indent(3) . " }"                                                                           . parent::NewLine();
			$strCadastrar.= parent::Indent(2) . " }"                                                                           . parent::NewLine(2);
			
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
			$strAlterar = parent::Indent() . "/**"                                                                         . parent::NewLine();
			$strAlterar.= parent::Indent() . " * Altera o registro informado"                                              . parent::NewLine();
			$strAlterar.= parent::Indent() . " * @param object \$obj".parent::GetName()." Objeto ".parent::GetName().""    . parent::NewLine();			
			$strAlterar.= parent::Indent() . " * @param array \$arAttributes (Opcional) Atributos da operação, ";
			$strAlterar.= "1º elemento do array deve ser 'save' ou 'ignore'"                                               . parent::NewLine();
	        $strAlterar.= parent::Indent() . " * @param string \$strUserCondition (Opcional) Condição da operação"         . parent::NewLine();
			$strAlterar.= parent::Indent() . " * @return boolean true se o comando for executado com sucesso, "; 
			$strAlterar.= "caso contrário false"                                                                           . parent::NewLine();	
			$strAlterar.= parent::Indent() . " * @access public"                                                           . parent::NewLine();	
            $strAlterar.= parent::Indent()  . " * @throws Exception Dispara uma exceção caso ocorra algum erro"            . parent::NewLine();				
			$strAlterar.= parent::Indent()  . " * @see AdoStatementUpdate::Execute()"                                      . parent::NewLine();
			$strAlterar.= parent::Indent() . " */"                                                                         . parent::NewLine();
			$strAlterar.= parent::Indent(2) . " public function Alterar(".parent::GetName()." \$obj".parent::GetName();
			$strAlterar.= ", \$arAttributes = NULL, \$strUserCondition = NULL)"                                            . parent::NewLine();
			$strAlterar.= parent::Indent(2) . " {"                                                                         . parent::NewLine();
			$strAlterar.= parent::Indent(3) . " try"                                                                       . parent::NewLine();
			$strAlterar.= parent::Indent(3) . " {"                                                                         . parent::NewLine();
			$strAlterar.= parent::Indent(4) . " return parent::Update(\$obj".parent::GetName().", self::_TABLE, ";
			$strAlterar.= "\$arAttributes, \$strUserCondition);"                                                           . parent::NewLine();
			$strAlterar.= parent::Indent(3) . " }"                                                                         . parent::NewLine();
			$strAlterar.= parent::Indent(3) . " catch(Exception \$e)"                                                      . parent::NewLine();
			$strAlterar.= parent::Indent(3) . " {"                                                                         . parent::NewLine();
			$strAlterar.= parent::Indent(4) . " throw \$e;"                                                                . parent::NewLine();
			$strAlterar.= parent::Indent(3) . " }"                                                                         . parent::NewLine();
			$strAlterar.= parent::Indent(2) . " }"                                                                         . parent::NewLine(2);
			
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
			$strExcluir.= parent::Indent()  . " * @param object \$obj".parent::GetName()." Objeto ".parent::GetName().""    . parent::NewLine();						
            $strExcluir.= parent::Indent()  . " * @param string \$strUserCondition (Opcional) Condição da exclusão"         . parent::NewLine();
			$strExcluir.= parent::Indent()  . " * @return boolean true se o comando for executado com sucesso, "; 
			$strExcluir.= "caso contrário false"                                                                            . parent::NewLine();	
			$strExcluir.= parent::Indent()  . " * @access public"                                                           . parent::NewLine();	
	        $strExcluir.= parent::Indent()  . " * @throws Exception Dispara uma exceção caso ocorra algum erro"             . parent::NewLine();				
            $strExcluir.= parent::Indent()  . " * @see AdoStatementDelete::Execute()"                                       . parent::NewLine();
			$strExcluir.= parent::Indent()  . " */"                                                                         . parent::NewLine();
			$strExcluir.= parent::Indent(2) . " public function Excluir(";
			$strExcluir.= parent::GetName() . " \$obj".parent::GetName().", \$strUserCondition = NULL)"                     . parent::NewLine();
			$strExcluir.= parent::Indent(2) . " {"                                                                          . parent::NewLine();
			$strExcluir.= parent::Indent(3) . " try"                                                                        . parent::NewLine();
			$strExcluir.= parent::Indent(3) . " {"                                                                          . parent::NewLine();
			$strExcluir.= parent::Indent(4) . " return parent::Delete(\$obj".parent::GetName().", self::_TABLE, ";
			$strExcluir.= "\$strUserCondition);"                                                                            . parent::NewLine();
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
			$strCarregar = parent::Indent()  . "/**"																	                . parent::NewLine();
			$strCarregar.= parent::Indent()  . " * Inicializa o objeto com o registro armazenado em meio persistente "                  . parent::NewLine();
            $strCarregar.= parent::Indent()  . " * @param object \$obj".parent::GetName()." Referência ao objeto ".parent::GetName()."" . parent::NewLine();						
			$strCarregar.= parent::Indent()  . " * @param array \$arAttributes (Opcional) Atributos a serem carregados"                 . parent::NewLine();
			$strCarregar.= parent::Indent()  . " * @return void"			                                                            . parent::NewLine();
			$strCarregar.= parent::Indent()  . " * @access public"												                        . parent::NewLine();	
            $strCarregar.= parent::Indent()  . " * @throws Exception Dispara uma exceção caso ocorra algum erro"                        . parent::NewLine();				
			$strCarregar.= parent::Indent()  . " * @see AdoStatementLoad::Execute()"                                                    . parent::NewLine();
			$strCarregar.= parent::Indent()  . " */"																	                . parent::NewLine();
			$strCarregar.= parent::Indent(2) . " public function Carregar(".parent::GetName()." &\$obj".parent::GetName();
			$strCarregar.= ", \$arAttributes = NULL)"		                                                                            . parent::NewLine();
			$strCarregar.= parent::Indent(2) . " {"																	                    . parent::NewLine();
			$strCarregar.= parent::Indent(3) . " try"																                    . parent::NewLine();
			$strCarregar.= parent::Indent(3) . " {"																	                    . parent::NewLine();
			$strCarregar.= parent::Indent(4) . " parent::Load(\$obj".parent::GetName().", self::_TABLE, \$arAttributes);"              . parent::NewLine();
			$strCarregar.= parent::Indent(3) . " }"																	                    . parent::NewLine();
			$strCarregar.= parent::Indent(3) . " catch(Exception \$e)"												                    . parent::NewLine();
			$strCarregar.= parent::Indent(3) . " {"																                        . parent::NewLine();
			$strCarregar.= parent::Indent(4) . " throw \$e;"										                                    . parent::NewLine();
			$strCarregar.= parent::Indent(3) . " }"        															                    . parent::NewLine();
			$strCarregar.= parent::Indent(2) . " }"                                                                                     . parent::NewLine(2);
			
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
			$strListar = parent::Indent()  . "/**"                                                                                    . parent::NewLine();
			$strListar.= parent::Indent()  . " * Retorna uma lista de objetos desta classe onde cada objeto representa um registro. " . parent::NewLine();
            $strListar.= parent::Indent()  . " * @param string \$strClassName Nome da classe a ser colecionada"                       . parent::NewLine();						
			$strListar.= parent::Indent()  . " * @param array \$arAttributes (Opcional) Atributos a serem carregados na listagem"     . parent::NewLine();
			$strListar.= parent::Indent()  . " * @param array \$arOrderBy (Opcional) Ordernação da listagem array(array('campo1', 'campo2'), 'ASC')" . parent::NewLine();
			$strListar.= parent::Indent()  . " * @return void"							                                              . parent::NewLine();
			$strListar.= parent::Indent()  . " * @access public"															  		  . parent::NewLine();	
			$strListar.= parent::Indent()  . " * @throws Exception Dispara uma exceção caso ocorra algum erro"                        . parent::NewLine();	
			$strListar.= parent::Indent()  . " * @see Collection"                                              . parent::NewLine();
			$strListar.= parent::Indent()  . " */"																			  		  . parent::NewLine();
			$strListar.= parent::Indent(2) . " public function Listar(\$strClassName, \$arAttributes = NULL, \$arOrderBy = NULL)"     . parent::NewLine();
			$strListar.= parent::Indent(2) . " {"																			  		  . parent::NewLine();
			$strListar.= parent::Indent(3) . " try"																		  		      . parent::NewLine();
			$strListar.= parent::Indent(3) . " {"																			  	 	  . parent::NewLine();
			$strListar.= parent::Indent(4) . " return parent::Collection(\$strClassName, self::_TABLE, \$arAttributes, \$arOrderBy);" . parent::NewLine();
			$strListar.= parent::Indent(3) . " }"																			  		  . parent::NewLine();
			$strListar.= parent::Indent(3) . " catch(Exception \$e)"														  		  . parent::NewLine();
			$strListar.= parent::Indent(3) . " {"																			  		  . parent::NewLine();
			$strListar.= parent::Indent(4) . " throw \$e;"												  		                      . parent::NewLine();
			$strListar.= parent::Indent(3) . " }"																			  		  . parent::NewLine();
			$strListar.= parent::Indent(2) . " }"												   							  		  . parent::NewLine();
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
			
			$strDir .= "Dao/";
			
			$objFolder->Create($strDir);
			
			// Criando o nome da classe
			$strFileName = $strDir . "tDao" . parent::GetName() . ".php";
			
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
			$strClassCode = $this->BeginClass();
			$strClassCode.= parent::EndClass();
			
			// Salvando o arquivo
			return $this->Save($strDir, $strClassCode);
		}
}
?>