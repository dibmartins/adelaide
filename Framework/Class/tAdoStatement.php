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
  * Classe com métodos comuns a todas as operações 
  * de banco de dados Insert, Update, Select e Delete
  * 
  * @package Framework
  * @subpackage Ado
  * @version 1.0 - 2011-10-18 09:36:00
  * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
  * @link http://www.diegobotelho.com.br
  * @copyright  2011 RG Sistemas - Todos os direitos reservados
  */

abstract class AdoStatement
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
     * Construtor da classe.
	 * @return void
	 * @access public
     */ 
         public function __construct()
         {
		     try
			 {
    
			 }
			 catch(Exception $e)
			 {
				 throw $e;
			 }
         }

//------------------------------------------------------------------------------         

   /**
	* Retorna o valor de um atributo de um objeto.
	* @param object $objObject objeto com o atributo a ser obtido
	* @param string $strAttributeName Nome do atributo que se deseja obter o valor
	* @return string Valor do atributo
	* @access public
	*/
		public function GetAttributeValue($objObject, $strAttributeName)
		{
			$strMethod = Utils::BuildProperty('Get', $strAttributeName);
			
			if($this->IsCrypted($strAttributeName))
			{
				// Retornando o valor do campo criptografado:
				return "ENCODE('".Utils::CheckSQLInjection($objObject->$strMethod())."','". SystemConfig::ENCRYPT_KEY ."')";
			}
			else
			{
				return $objObject->$strMethod();
			}	
		}
		
//------------------------------------------------------------------------------		

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
		    $arFieldName = explode('_', $strFieldName);
			
		    return $arFieldName[1] == 'crypt' ? true : false;
		}
		
//------------------------------------------------------------------------------		

   /**
	* Retorna um array com os campos de uma tabela e suas informações.
	* 
	* Armazena a consulta na sessão do framework para reaproveitá-la 
	* em consultas futuras e aumentar o desempenho.
	* 
	* @param string $strTable Tabela que se deseja obter os campos
	* @return array Array com os campos da tabela e suas informações
	* @access public
	*/
		public function GetTableFields($strTable)
		{
			// #DIEGO
			// Nota: Usar SessaoFramework ou algo parecido no futuro
			// para desacoplar este método da classe SessaoUsuario
			// que é específica do projeto Esus 
			$objSessao = new SessaoUsuario();

			if(!isset($_SESSION['framework']['ado']['tablefields'][$strTable]))
			{
				// Obtendo a lista de campos da tabela:
				$rscFields = $this->GetAdoConnection()->ListFields($strTable);
					
				$arrFieldsInfo = $this->GetAdoConnection()->FieldsInfo($rscFields);			
				
				$_SESSION['framework']['ado']['tablefields'][$strTable] = $arrFieldsInfo;
			}	

			return $_SESSION['framework']['ado']['tablefields'][$strTable];
		}
		
//------------------------------------------------------------------------------		

    /**
	 * Verifica se um registro existe em $strTable
	 * @param string $strTable Tabela onde será feita a verificação
	 * @param string $strCondition Condição da verificação
	 * @return boolean Se o registro existir retorna true, caso contrário false
	 * @access private
	 */
		 public function FindRecord($strTable, $strCondition)
		 {
		     try
			 {
				 $objSQLBuilder = new AdoSQLBuilder();
				 
				 $objSQLBuilder->Fields(array('*'));
				 $objSQLBuilder->From(array($strTable));
				 $objSQLBuilder->Where(array($strCondition));
				 $objSQLBuilder->Limit(array(1));
				 
				 $objRecordSet = $this->GetAdoConnection()->Query($objSQLBuilder->Select());
				 
				 return ($objRecordSet->GetSize() > 0)? true : false;
			 }
			 catch(Exception $e)
			 {
			     throw $e;
			 }	 
		 }
		 
//------------------------------------------------------------------------------		 

   /**
	* Formata o valor do atributo de acordo com o seu tipo para ser salvo no banco de dados
	* @param array $strType Tipo do atributo
	* @param mixed $mxdValue Valor do atributo
    * @return string Campo formatado
	* @access public
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
	* Constrói o comando INSERT.
	* @param object $objObject objeto com os dados a serem inseridos em $strTable
	* @param string $strTable Tabela onde os dados serão armazenados
	*  
	* @param array $arAttributes (Opcional) Atributos da operação, 
	* 1º elemento do array deve ser 'save' ou 'ignore'
	* 
	* @param string $strCondition (Opcional) Condição para inserção, 
	* muito utilizado para tratamento de concorrência. 
	* Saiba mais nas referências abaixo:
	* http://dev.mysql.com/doc/refman/4.1/pt/select.html
	* http://en.wikipedia.org/wiki/DUAL_table
	*  
	* o segundo deve ser um array com os campos a serem salvos ou ignorados
    * @return boolean true se o comando foi realizado com sucesso, caso contrário false, gerando uma exceção
	* @access public
	*/
		
		// Comentei porque a operação Delete, Load 
		// e Collection tem assinaturas diferentes 
		
		/*public abstract function Execute($objObject, 
										 $strTable, 
										 $arAttributes = NULL,
										 $strCondition = NULL);*/		
		
//------------------------------------------------------------------------------		
		
   /**
	* Inicia uma nova transação no banco de dados
    * @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
		public function StartTransaction()
		{
		    return $this->GetAdoConnection()->Begin();
		}
		
//------------------------------------------------------------------------------		

   /**
	* Conclui uma transação no banco de dados
    * @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
		public function Commit()
		{
		    return $this->GetAdoConnection()->Commit();
		}
		
//------------------------------------------------------------------------------		
		
   /**
	* Cancela uma transação no banco de dados
    * @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
		public function RollBack()
		{
		    return $this->GetAdoConnection()->RollBack();
		}
}
