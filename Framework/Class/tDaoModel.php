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
 * @subpackage Ado
 * @version 1.0 - 2009-11-17 11:55:17
 * @author Diego Botelho Martins <diego@rgweb.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class DaoModelException extends Exception{}

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
 * Classe responsável pelo acesso a dados armazenados em meio persistente
 * Classe mãe das classes de acesso a dados de objetos de negócio.
 * Ex.: class DaoPessoa extends DaoEsus
 *
 * @package Framework
 * @subpackage Ado
 * @version 1.0 - 2009-11-17 11:55:17
 * @author Diego Botelho Martins <diego@rgweb.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

abstract class DaoModel
{
    /**
     * Attributes:
     */

   /**
	* Conexão com o servidor de banco de dados
	* @var AdoConnection
	* @access private
	*/		
	private $objAdoConnection;	
	
//------------------------------------------------------------------------------

    /**
     * Properties:
     */

    /**
     * Retorna o valor da constante _TABLE obrigatóriamente 
     * presente nas classes que herdam de DaoModel
     * @return string Tabela gerenciada por esta classe
     */
         public abstract function GetTable();
         
//------------------------------------------------------------------------------         
         
    /** 
     * Propriedade de acesso do atributo $objAdoConnection
     * @return  AdoConnection
	 * @access public
     */
        public function GetAdoConnection()
        {
            return $this->objAdoConnection;
        }

//------------------------------------------------------------------------------        
        
    /**
     * Propriedade modificadora do atributo $objAdoConnection
     * @param AdoConnection $objConnection 
	 * @access public
     */
        public function SetAdoConnection($objConnection)
        {
            $this->objAdoConnection = $objConnection;
        }         

//------------------------------------------------------------------------------

    /**
     * Methods:
     */

    /**
     * Método construtor da classe
     * @param string $strHost
     * @param string $strUser
     * @param string $strPassword
     * @param string $strDataBase
     * @param string $intPort
     * @return void
     * @access public
     * @see DaoModel::__construct()
     */
         public function __construct()
         {
             try
             {
             	 //echo get_class($this).'<br>';
             	 //Utils::StartExecution();
				 $this->SetAdoConnection($this->Conectar());
				 //echo 'Conectar: ' . Utils::EndExecution() . '<br>';
             }
             catch(Exception $e)
             {
                 throw $e;
             }		         
         }

//------------------------------------------------------------------------------

    /**
     * Método destrutor da classe
     * @return void
     * @access public
     */
         public function __destruct()
         {
             unset($this);
         }

//------------------------------------------------------------------------------         
         
    /**
     * Define o comportamento deste quando utilizado como um string
     * @return string nome desta classe
     */         
         public function __toString()
         {
         	return __CLASS__;
         }         
         
//------------------------------------------------------------------------------

    /**
     * Retorna um objeto de conexão com o banco de dados
     * Deve ser implementado nas classes filhas para obter
     * a conexão de acordo com as necessidades de cada objeto
     * 
     * @return AdoConnection
     * @access protected
     * @throws Exception Dispara uma exceção caso ocorra algum erro
     */
         protected abstract function Conectar();
         
//------------------------------------------------------------------------------

    /**
     * Cadastra um novo registro
     * @param object $objModel Objeto de negócio
     * 
     * @param array $arAttributes (Opcional) Atributos da operação, 1º 
     * elemento do array deve ser 'save' ou 'ignore'
     * 
     * @param string $strCondition (Opcional) Condição para inserção, 
	 * muito utilizado para tratamento de concorrência. 
	 * Saiba mais nas referências abaixo:
	 * http://dev.mysql.com/doc/refman/4.1/pt/select.html
	 * http://en.wikipedia.org/wiki/DUAL_table
	 * 
	 * @param String $strType
	 * Valores possíveis:
	 * AdoStatementInsert::INSERT  -> Cadastra um novo registro. Dispara erro se for duplicado. 
	 * AdoStatementInsert::IGNORE  -> Só cadastra se o registro não existir na tabela.
	 * AdoStatementInsert::REPLACE -> Cadastra um novo registro. Atualiza se for duplicado.
     * 
     * @return mixed Se o comando for executado com sucesso retorna o id 
     * do registro, caso contrário false
     * @access public
     * @throws Exception Dispara uma exceção caso ocorra algum erro
     * @see AdoStatementInsert::Execute()
     */
         public function Cadastrar(Model $objModel, 
         						   $arAttributes = NULL, 
         						   $strCondition = NULL,
         						   $strType 	 = AdoStatementInsert::INSERT)
         {
             try
             {
             	 $objInsert = new AdoStatementInsert();
             	 
             	 // Repassa o objeto de conexão
             	 $objInsert->SetAdoConnection($this->GetAdoConnection());
             	

             	 
				 return $objInsert->Execute($objModel, 
					 					    $this->GetTable(), 
					 					    $arAttributes,
					 					    $strCondition,
					 					    $strType);
             }
             catch(Exception $e)
             {
                 throw $e;
             }
         }

//------------------------------------------------------------------------------

    /**
     * Altera o registro informado
     * @param object $objModel Objeto de negócio
     * @param array $arAttributes (Opcional) Atributos da operação, 1º elemento do array deve ser 'save' ou 'ignore'
     * @param string $strUserCondition (Opcional) Condição da operação
     * @return boolean true se o comando for executado com sucesso, caso contrário false
     * @access public
     * @throws Exception Dispara uma exceção caso ocorra algum erro
     * @see AdoStatementUpdate::Execute()
     */
         public function Alterar(Model $objModel, 
         						 $arAttributes     = NULL, 
         						 $strUserCondition = NULL)
         {
             try
             {
				 $objUpdate = new AdoStatementUpdate();
             	
				 // Repassa o objeto de conexão
             	 $objUpdate->SetAdoConnection($this->GetAdoConnection());
				 
             	 return $objUpdate->Execute($objModel, 
             	 							$this->GetTable(), 
             	 							$arAttributes, 
             	 							$strUserCondition);
             }
             catch(Exception $e)
             {
                 throw $e;
             }
         }

//------------------------------------------------------------------------------

    /**
     * Exclui o registro informado
     * @param object $objModel Objeto de negócio
     * @param string $strUserCondition (Opcional) Condição da exclusão
     * @return boolean true se o comando for executado com sucesso, caso contrário false
     * @access public
     * @throws Exception Dispara uma exceção caso ocorra algum erro
     * @see AdoStatementDelete::Execute()
     */
         public function Excluir(Model $objModel, $strUserCondition = NULL)
         {
             try
             {
             	 $objDelete = new AdoStatementDelete();
             	
             	 // Repassa o objeto de conexão
             	 $objDelete->SetAdoConnection($this->GetAdoConnection());
             	 
                 return $objDelete->Execute($objModel, 
		                 					$this->GetTable(), 
		                 					$strUserCondition);
             }
             catch(Exception $e)
             {
                 throw $e;
             }
         }

//------------------------------------------------------------------------------

    /**
     * Inicializa o objeto com o registro armazenado em meio persistente 
     * @param object $objModel Referência ao Objeto de negócio
     * @param array $arAttributes (Opcional) Atributos a serem carregados
     * @param boolean $blnFilter Se true irá verificar se os campos informados existem
     * na tabela mapeada pela classe de $objModel, carregando somente os que
     * existirem, se false retornará erro se o campo não existir na tabela
     * 
     * @return void
     * @access public
     * @throws Exception Dispara uma exceção caso ocorra algum erro
     * @see AdoStatementLoad::Execute()
     */
         public function Carregar(Model &$objModel, 
         						  $arAttributes = NULL, 
         						  $strCondition = NULL, 
         						  $blnFilter    = false)
         {
             try
             {
             	 $objLoad = new AdoStatementLoad();
             	
             	 // Repassa o objeto de conexão
             	 $objLoad->SetAdoConnection($this->GetAdoConnection());             	 
             	 
                 $objLoad->Execute($objModel         , 
                 			       $this->GetTable() , 
                 			       $arAttributes     , 
                 			       $strCondition     , 
                 			       $blnFilter);
             }
             catch(Exception $e)
             {
                 throw $e;
             }
         }

//------------------------------------------------------------------------------

    /**
     * Retorna uma lista de objetos desta classe onde cada objeto representa um registro. 
     * @param string $strClassName Nome da classe a ser colecionada
     * @param array $arAttributes (Opcional) Atributos a serem carregados na listagem
     * @param array $arOrderBy (Opcional) Ordernação da listagem array(array('campo1', 'campo2'), 'ASC')
     * @return void
     * @access public
     * @throws Exception Dispara uma exceção caso ocorra algum erro
     * @see AdoStatementCollection::Execute()
     */
         public function Listar($strClassName, 
         						$arAttributes = NULL, 
         						$arOrderBy    = NULL)
         {
             try
             {
             	 $objList = new AdoStatementCollection();
             	
             	 // Repassa o objeto de conexão
             	 $objList->SetAdoConnection($this->GetAdoConnection());
             	 
                 return $objList->Execute($strClassName, 
                 						  $this->GetTable(), 
                 						  $arAttributes, 
                 						  $arOrderBy);
             }
             catch(Exception $e)
             {
                 throw $e;
             }
         }

//------------------------------------------------------------------------------

    /**
     * Valida os filtros a serem usados nas consultas
     * As inserções e remoções no banco já validam automaticamente
     * aspas simples e ataques de SQLInjection, porém nas buscas
     * é necessário chamar este método para validar os filtros
     * informados.
     *  
     * @param mixed filtros a serem validados
     * @return array
     * @access public
     * @throws Exception Dispara uma exceção caso ocorra algum erro
     */         
         public function ValidarFiltros($mxdFiltros, $strConventerEspacoEmBrancoPara = '%')
         {
	         try
	         {
	         	 // Caso seja um array, valida todos os seus elementos
	         	 if(is_array($mxdFiltros))
	         	 {
		         	 foreach($mxdFiltros as $strChave => $mxdValor)
	         		 {
	         		 	$mxdFiltros[$strChave] = Utils::CheckSQLInjection($mxdValor);
	         		 	
	         		 	// Converte espaços em branco para...
	         		 	$mxdFiltros[$strChave] = preg_replace('@\s+@', 
	         		 										  $strConventerEspacoEmBrancoPara, 
	         		 										  $mxdFiltros[$strChave]);
	         		 }
	         	 }
	         	 else
	         	 {
	         	 	 $mxdFiltros = Utils::CheckSQLInjection($mxdFiltros);
	         	 	 
	         	 	 // Converte espaços em branco para %
					 $mxdFiltros = preg_replace('@\s+@', 
					 							$strConventerEspacoEmBrancoPara, 
					 							$mxdFiltros);
	         	 }	 	         
	         
		         return $mxdFiltros;
	         }
	         catch(Exception $e)
	         {
	         	 throw $e;	          
	         }
         }

//------------------------------------------------------------------------------

    /**
     * Retorna a string de conexão com as credenciais do cliente 
     * que estão na sessão do usuário
     *  
     * @return string
     * @access public
     * @throws Exception Dispara uma exceção caso ocorra algum erro
     */         
         public function ConnectionString()
         {
	         try
	         {
		         // Obtém as credenciais do cliente 
		         // que estão na sessão do usuário
	         	 $objSessaoUsuario = new SessaoUsuario;
	
		       	 $strServer   = $objSessaoUsuario->dba_host;
		       	 $intPort	  = SystemConfig::ADO_PORT;
		       	 $strDataBase = $objSessaoUsuario->dba_base;
		       	 $strUid      = $objSessaoUsuario->dba_login;
		       	 $strPwd 	  = $objSessaoUsuario->dba_senha;         
	         
				 $strStringConexao = "Server=$strServer;"
				      			   . "Port=$intPort;"
				      			   . "Database=$strDataBase;"
				     			   . "Uid=$strUid;"
				      			   . "Pwd=$strPwd;";

				 return $strStringConexao;				      			   
	         }
	         catch(Exception $e)
	         {
	         	 throw $e;	          
	         }
         }

//------------------------------------------------------------------------------

    /**
     * Apaga todo o conteúdo da tabela
     * 
     * ATENÇÃO! Muito cuidado ao utilizar 
     * este método pois o processo não pode ser desfeito
     * 
     * @see Faturamento::Scdn::Importar  
     * @return boolean true se o comando for executado com sucesso
     * @access public
     * @throws Exception Dispara uma exceção caso ocorra algum erro
     */         
         public function Truncar()
         {
	         try
	         {
	         	 $strSQL = 'TRUNCATE TABLE ' . $this->GetTable();
	         
             	 return $this->GetAdoConnection()->Execute($strSQL);		         
	         }
	         catch(Exception $e)
	         {
	         	 throw $e;	          
	         }
         }

//------------------------------------------------------------------------------

    /**
     * Usado para tratar duplicidade no caso de registros que 
     * tenham a coluna ativo. Gera uma sql de condição para ser
     * concatenada com o INSERT do cadastro. Essa condição é 
     * montada automaticamente baseando-se nos valores dos atributos
     * de $objModel informados em $arrUniqueIndices.   
     * 
     * @see EscalaAgendamento::AlterarEmLote
     *   
     * @return boolean true se o comando for executado com sucesso
     * @access public
     * @throws Exception Dispara uma exceção caso ocorra algum erro
     */         
         public function GerarIndiceUnico(Model $objModel, 
         								  array $arrUniqueIndices)
         {
	         try
	         {
	         	 $strTabela = $this->GetTable();
	         	
	         	 // Convertemos o objeto em array
	         	 // para percorrer-mos seus atributos
	         	 $arrModel = $objModel->toArray();
	         	 
				 $strSQL = 'NOT EXISTS (SELECT 1 '
				 		 . "FROM $strTabela "
				   		 . 'WHERE 1 ';
				   		 
				 foreach($arrModel as $strCampo => $mxdValor)
				 {
				 	 // Verifico se o atributo atual
				 	 // foi passado no array com os atributos
				 	 // informados como únicos 
				 	 if(in_array($strCampo, $arrUniqueIndices))
				 	 {
						 if($mxdValor === NULL)
				 	 	 {
							 $strSQL .= "AND $strCampo IS NULL ";				 	 		
				 	 	 }
				 	 	 // Caso contrário teremos que encontrar o tipo 
				 	 	 // do campo para formatá-lo adequadamente para 
				 	 	 // adicioná-lo na condição
				 	 	 else
				 	 	 {
				 	 	 	 // Obtemos o tipo do campo para formatação
					 	 	 $strTipo = '';
							
					 	 	 // Obtém as informações de cada coluna 
	         	 			 // da tabela gerenciada por esta Dao
	         	 			 $arrInfoColunas = $this->GetTableFields($strTabela);
					 	 	 
					 	 	 // Encontra o tipo de $strCampo 
					 	 	 // nas informações da tabela
						 	 foreach($arrInfoColunas as $arrInfo)
						 	 {
						 	 	 if($strCampo == $arrInfo['name'])
						 	 	 {
						 	 		 $strTipo = $arrInfo['type'];	
						 	 	 }
						 	 }				 	 	 	
				 	 	 	
				 	 	 	 $mxdValor = $this->FormatToDataBase($strTipo, $mxdValor);
				 	 	 	
				 	 		 $strSQL .= "AND $strCampo = '$mxdValor' ";
				 	 	 }	
				 	 }	 
				 }
				 
				 $strSQL .= ')';
				 
				 return $strSQL;				   		 
	         }
	         catch(Exception $e)
	         {
	         	 throw $e;	          
	         }
         }
         
//------------------------------------------------------------------------------		

   /**
	* Retorna um array com os campos de uma tabela e suas informações.
	* 
	* @param string $strTable Tabela que se deseja obter os campos
	* @return array Array com os campos da tabela e suas informações
	* @access public
	*/
		public function GetTableFields($strTable)
		{
			// Obtendo a lista de campos da tabela:
			$rscFields = $this->GetAdoConnection()->ListFields($strTable);
					
			$arrFieldsInfo = $this->GetAdoConnection()->FieldsInfo($rscFields);			
				
			return $arrFieldsInfo;
		}         
         
//------------------------------------------------------------------------------		 

   /**
	* Formata o valor do atributo de acordo com o seu tipo para ser salvo no banco de dados
	* @param array $strType Tipo do atributo
	* @param mixed $mxdValue Valor do atributo
    * @return string Campo formatado
	* @access protected
	*/
		public function FormatToDataBase($strType, $mxdValue)
		{
		    $objDate = new Date;
		
		    switch($strType)
			{
				case 'date':		return Date::Format($mxdValue, 3);
									break;
				
				case 'timestamp':
				case 'datetime' :	return Date::Format($mxdValue, 1);
									break;

				case 'real':		return Utils::MoneyFormat($mxdValue, 0);
									break;

				default:            return $mxdValue; 					
			}
		}		
		
//------------------------------------------------------------------------------         
         
   /**
	* Inicia uma nova transação no banco de dados
    * @return boolean true se o comando foi 
    * realizado com sucesso, caso contrário false
	* @access public
	*/
		public function StartTransaction()
		{
		    return $this->GetAdoConnection()->Begin();
		}

//------------------------------------------------------------------------------		
		
   /**
	* Conclui uma transação no banco de dados
    * @return boolean true se o comando foi 
    * realizado com sucesso, caso contrário false
	* @access public
	*/
		public function Commit()
		{
		    return $this->GetAdoConnection()->Commit();
		}
		
//------------------------------------------------------------------------------		
		
   /**
	* Cancela uma transação no banco de dados
    * @return boolean true se o comando foi 
    * realizado com sucesso, caso contrário false
	* @access public
	*/
		public function RollBack()
		{
		    return $this->GetAdoConnection()->RollBack();
		}         
         
//------------------------------------------------------------------------------

}