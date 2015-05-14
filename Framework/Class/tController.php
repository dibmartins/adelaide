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
 * @subpackage MVC
 * @version 1.0 - 2007-07-03 12:00:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class ControllerException extends Exception{}

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
 * Classe responsável pelo controle das requisições
 * @package Framework
 * @subpackage MVC
 * @version 1.0 - 2007-07-03 12:00:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class Controller
{
   /**
    * Attributes:
    */

   /**
    * Objeto com as requisições POST e GET
	* @var object $objRequest
	* @access private
	*/
	    private $objRequest;

   /**
    * Constante utilizada quando uma ação ocorre com sucesso
	* @var boolean OK
	* @access private
	*/
	    const OK   = true;

   /**
    * Constante utilizada quando uma ação falhe
	* @var boolean FAIL
	* @access private
	*/
	    const FAIL = false;
	    	    
//------------------------------------------------------------------------------	
	
   /** 
    * Properties:
    */   

   /**
	* Método para setar o valor do atributo $objRequest
	* @param object $objRequest Objeto carregado com a requisição HTTP
	* @return void		 
	* @access protected
	*/
		protected function SetRequest(Request $objRequest)
		{
			 $this->objRequest = $objRequest;
		}

   /**
	* Método para retornar o valor do atributo $objRequest
	* @return Valor do atributo $objRequest
	* @access protected
	*/
		protected function GetRequest()
		{
			 return $this->objRequest;
		}

//------------------------------------------------------------------------------

    /**
     * Properties:
     */

    /**
     * Método de acesso dinâmico as propriedades da classe
     * @param string $strMethod Método de acesso ao atributo
     * @param array $arArguments Valor a ser setado no atributo
     * @return mixed
     * @access protected 
     */
         public function __call($strMethod, $arArguments)
         {
             list($strPrefix, $strProperty) = Utils::buildAttribute($strMethod);

             if(empty($strPrefix) || empty($strProperty)) return;

             if($strPrefix == 'Get' && array_key_exists($strProperty, get_object_vars($this)))
             {
             	 return $this->$strProperty;
             }             elseif($strPrefix == 'Set' && array_key_exists($strProperty, get_object_vars($this)))
             {
                 $this->$strProperty = $arArguments[0];
             }
             else throw new Exception('Metodo inexistente: ' . get_class($this) . '::' . $strMethod . '()');
        
         }		

//------------------------------------------------------------------------------         
         
   /** 
    * Methods:
    */
	
   /**
	* Método construtor da classe
	* @return void
	* @access protected
	*/
		protected function __construct()
		{
   			// Criando o objeto de gerenciamento de requisições HTTP:
			// $this->SetRequest(new Request); Não está sendo usado no SigsWeb
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
	* Método para controlar as ações requisitadas
	* @param array $arAjaxRequest Dados da requisição feita via Ajax
	* @return void
	* @access protected
	*/
		protected function Process($arAjaxRequest = NULL)
		{
		    try
		    {	
                // Criando o objeto de gerenciamento de requisições HTTP:
			    $this->SetRequest(new Request($arAjaxRequest));

				// Ação requisitada:
				$strAction = $this->GetRequest()->GetAction();

				// Chama o método requisitado na classe filha:
				if(method_exists($this, $strAction))
				{
				    return $this->$strAction();
				}
				else
				{
				    throw new ControllerException("Requisição inválida");
			    }				
		     }
		     catch(Exception $e)
		     {
			    throw $e;
		     }
		}

//------------------------------------------------------------------------------		
		
   /**
	* Método para atribuir o array vindo da view (Flex) ao objeto de negócios
	* @param array $arrView Array com os campos preenchidos na interface
	* @param object $objModel Objeto da camada de negócios a ser preenchido
	* @return void
	* @access protected
	*/
		protected function Assign(array $arrView, $objModel)
		{
		    try
		    {	
                // Verifica se os parametros informados estáo corretos 
		    	if(!is_object($objModel) || !is_array($arrView))
                {
                	throw new ControllerException("Parâmetros inválidos");
                }

                // Obtém os atributos do objeto de negócio via reflexão
                $objReflection = new ReflectionClass($objModel);
                
                $arrAttributes = $objReflection->getProperties(); 
				
                // Percorre o array e relaciona cada campo com a propriedade do objeto de negócios
		    	foreach($arrView as $strField => $mxdValue)
                {
	                // Retira o prefixo do campo da interface ex.: cmb_pes_nome => pes_nome
                	//$strField = substr($strField, 4);
                
                	foreach($arrAttributes as $objReflection)
	                {
	                	if($strField == $objReflection->name)
	                	{
	                		$strAttribute = str_replace('obj', '', $objReflection->name);
	                	
	                		$strSet = 'Set' . ucfirst($strAttribute);
	                		
	                		$objModel->$strSet($mxdValue);
	                		
	                		break;
	                	}
	                }
                }
		     }
		     catch(Exception $e)
		     {
			    throw $e;
		     }
		}		

//------------------------------------------------------------------------------		
		
   /**
	* Formata a mensagem de retorno para a interface interpretar
	* se ocorreu um erro ou não 
	* @param boolean $blnStatus Status da operação 1=sucesso | 0=falha
	* @param mixed $mxdMessage Mensagem a ser exibida, pode ser um array em caso de excessão
	* @return array 
	* @access protected
	*/
		protected function Message($blnStatus, $mxdMessage, Exception $objException = NULL)
		{
	 		 // Formata a mensagem para condificação do flex
		     if(is_string($mxdMessage)) $mxdMessage = utf8_decode($mxdMessage);
		
		     $strExceptionMessage = '';
		     
		     $arrDetails = array();
		     
		     // Se $blnStatus é false é porque ocorreu um erro grave 
		     // que deve parar a execução da lógica, nesse caso temos que formatar
		     // a mensagem e o trace da exessão para exibir na tela de erro do servidor
			 if(!$blnStatus)
			 {
			     // Formata a excessão para exibição
			     if($objException instanceof Exception)
			     {
			      	 $objMessage = new Message();
             	 	 $objMessage->SetException($objException);
             	 	 
             	 	 // Obtém o trace formatado
             	 	 $strExceptionMessage = array_map('utf8_decode', $objMessage->FormatExceptionMessage());
			     }
			 }
			 // Ocorreu um erro de lógica, ao qual a mensagem da excessão deve ser exibida na tela
			 else
			 {
			 	 // Se existe uma excessão para ser exibida, formata ela para para condificação do flex
				 if($objException instanceof Exception)
				 {
				 	 // Formata a mensagem a ser exibida
				 	 $strExceptionMessage = utf8_decode($objException->getMessage());
				 	 
				 	 //Quando o $objException é do tipo DisplayException
				 	 //ele possui um atributo $arrDetails que contém um 
				 	 //array de detalhes(customizado).
				 	 //Sendo assim esse atributo será inserido no array
				 	 //retornado pelo método como o quarto elemento.
					 if($objException instanceof DisplayException)
					 {
					 	 //Formata a mensagem a ser exibida.
					 	 $arrDetails = $objException->GetDetails();
					 }
				 }
			 }
			 
			 // Retorna para o flex um array com o seguinte formato
			 // [0] => true|false = Indica se ocorreu ou não um erro crítico
			 // [1] => Uma mensagem genérica do que ocorreu
			 // [2] => Um trace formatado da excessão, caso a posição 0 seja false
			 // [3] => Detalhes da excessão 
			 // [4] => Identificação do serviço que foi executado
			 return array($blnStatus, 
			 			  $mxdMessage, 
			 			  $strExceptionMessage, 
			 			  $arrDetails, 
			 			  $this->MethodCaller());
		}

//------------------------------------------------------------------------------		
		
   /**
	* Retorna o nome do método que executou o serviço 
	* @return array 
	* @access protected
	*/		
		protected function MethodCaller() 
		{
			$arrTrace = debug_backtrace();
			
		    $strLine   = $arrTrace[2]['line'];
		    $strClass  = $arrTrace[2]['class'];
		    $strMethod = empty($arrTrace[2]['function']) ? 'global' : $arrTrace[2]['function'];
		    
		    $arrMethod = array('class'  => $strClass, 
		    				   'method' => $strMethod,
		    				   'line'   => $strLine);
		    
		    return $arrMethod;
		}		
		
//------------------------------------------------------------------------------		
		
   /**
	* Formata a coleção para ser exibida em um combobox
	* @param Collection Object
	* @param string Nome do campo de valor
	* @param string Nome do campo de label
	* @param string Separador de itens da label
	* @param mixed $mxdSelected Valor a ser definido como selecionado
	* @return array 
	* @access protected
	*/
		protected function ComboBoxDataProvider(Collection $objCollection, 
												$strDataField, 
												$mxdLabelField, 
												$strSeparator = ' - ',
												$mxdSelected = NULL)
		{
        	try
        	{
	        	$arDataProvider = array();
	        	
	        	foreach($objCollection as $objModel)
	            {
	            	$strLabel = '';
	            
	            	// Se a label a ser exibida é um array com vários campos
	            	// Concatena esses campos com o separador informado
		            if(is_array($mxdLabelField))
		        	{
		        		foreach($mxdLabelField as $strLabelField)
		        		{
		        			$strLabel.= $objModel->$strLabelField . $strSeparator;
		        		}
		        		
		        		// Remove o separador do final da concatenação
		        		// Exemplo: Nome - login - => Nome - login
		        		$strLabel = Utils::CutLastChar($strLabel, strlen($strSeparator));
		        	}
		        	// Senão for a label é a própria string informada
	            	elseif( is_string($mxdLabelField))
	            	{
	            		$strLabel = $objModel->$mxdLabelField;
	            	}
	            	
	            	// Aqui atribuimos aos campos data e label os valores
	            	// dos campos que foram informados como tal
	            	$arrItem = array('data'     => $objModel->$strDataField, 
                          			 'label'    => $strLabel);
	            	
	            	if($objModel->$strDataField == $mxdSelected) 
	            	{
	            		$arrItem['selected'] = true;
	            	}

	            	// ATENÇÃO!
	            	// Não está sendo usado mais e trava as combos na web
	            	// quando muitos registros são listados
	            	// Identificador do dataprovider da combo
	            	// Isso serve para diferenciar um dataprovider
	            	// entre as combos do datagrid. Mas pode ter várias
	            	// aplicações.
	            	// $arrItem['cmb_uid'] = Utils::UniqueId();
	            	
	            	// Se além dos campos data e label houverem outros campos
	            	// extras eles também são adicionados ao item da combo
	            	// porém com seus nomes originais
	            	$arrItem = array_merge($arrItem, get_object_vars($objModel));

	            	// Removemos os atributos repetidos
	            	// ou seja aqueles que já foram inseridos como data e label
	            	unset($arrItem[$strDataField]);
	            	unset($arrItem[$strLabel]);
	            	
	            	// Exemplo de como ficará $arrItem
	            	/*Array
					(
					    [data] => 77...............Campo mpd_id setado como data
					    [label] => ARTROLIVE.......Campo mpd_nome setado como label
					    [mpd_codigo] => 51.........Campo extra retornado na consulta
					    [mtu_novo_nome] => CAIXA...Campo extra retornado na consulta
					)*/
	            	
	            	array_push($arDataProvider, $arrItem);
	            }

				return $arDataProvider;
        	}
        	catch(Exception $e)
        	{
        		throw $e;
        	}
		}

//------------------------------------------------------------------------------		
		
   /**
	* Formata a coleção para ser exibido em um datagrid
	* @param Collection Object
	* @return array 
	* @access protected
	*/
		protected function DataGridDataProvider(Collection $objCollection)
		{
		    try
        	{
				return $objCollection->GetCollection();
        	}
			catch(Exception $e)
        	{
        		throw $e;
        	}
		}

//------------------------------------------------------------------------------

//------------------------------------------------------------------------------
// Métodos remotos:
// Os métodos a seguir podem ser invocados via AMFPHP
//------------------------------------------------------------------------------	   
	   
   /**
	* Retorna a data e hora atual no formato dd/mm/aaaa 00:00:00
	* @return string Data e hora atual no formato dd/mm/aaaa 00:00:00
	* @access remote
	*/
		public function Now()
		{
		    try
        	{
				$objDate = new Date; 
				
				return Date::Format($objDate->Now(), 2);
        	}
			catch(Exception $e)
        	{
        		throw $e;
        	}
		}

//------------------------------------------------------------------------------		
		
}