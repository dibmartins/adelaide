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
 * @subpackage Model
 * @version 1.0 - 2009-11-17 10:15:32
 * @author Diego Botelho Martins <diego@rgweb.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class ModelException extends Exception{}

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
 * Classe de projeto, para representar um atendente em uma consulta
 * Responsável pela implementação da lógica de negócio
 * 
 * Por ser um objeto de projeto que não é mapeado no banco de dados
 * este objeto não possui uma classe Dao própria, utilizando então
 * a classe DaoFuncionario
 * 
 * @package Framework
 * @subpackage Model
 * @version 1.0 - 2009-11-17 10:15:32
 * @author Diego Botelho Martins <diego@rgweb.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class Model
{
    /**
     * Attributes:
     */

    /**
     * Objeto de acesso a dados específico para dada classe de negócio
     * Opcional
     * @var array
     * @access private
     */
         private $arrAttributes;

    /**
     * Objeto de acesso a dados específico para dada classe de negócio
     * Opcional
     * @var DaoModel
     * @access protected
     */
         private $objDao; 

//------------------------------------------------------------------------------

    /**
     * Properties:
     */

   /**
	* Método para setar o valor do atributo $objDao
	* @param DaoModel $objDao
	* @return void		 
	* @access protected
	*/
		protected function SetDao(DaoModel $objDao)
		{
			 $this->objDao = $objDao;
		}

   /**
	* Método para retornar o valor do atributo $objDao
	* @return Valor do atributo $objDao
	* @access protected
	*/
		protected function GetDao()
		{
	    	if(!($this->objDao instanceof DaoModel))
			{
			    throw new ModelException('Nenhum objeto Dao informado para classe ' . get_class($this));    
			}
			else
			{
				return $this->objDao;
			}
		}

//------------------------------------------------------------------------------		
		
	/**
     * Método de acesso dinâmico as propriedades da classe
     * @param string $strMethod Método de acesso ao atributo
     * @param array $arArguments Valor a ser setado no atributo
     * @return mixed
     * @access public 
     */
         public function __call($strMethod, $arArguments)
         {
         	 try
         	 {
	             list($strPrefix, $strProperty) = Utils::buildAttribute($strMethod);
	
	             if(empty($strPrefix) || empty($strProperty)) return;
	
	             $blnPropertyExists = array_key_exists($strProperty, $this->arrAttributes);

	             if($strPrefix == 'Get' && $blnPropertyExists)
	             {
	                 return $this->$strProperty;
	             } 
	             elseif($strPrefix == 'Set' && $blnPropertyExists)
	             {
	             	 $this->$strProperty = $arArguments[0];
	             }
	             else 
	             {
	             	 throw new Exception(utf8_decode(get_class($this) . ' não possui a propriedade ' . $strMethod . '()'));
	             }
         	 }
         	 catch(Exception $e)
         	 {
         	 	 throw $e;
         	 }    
         }

//------------------------------------------------------------------------------

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
         	 $this->arrAttributes = get_object_vars($this);
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
     * Transforma este objeto em um array
     * Os atributos que são objetos objetos também são convertidos para array
     * desde que possuam um método com o mesmo nome que este.   
     * @return array
     * @access public
     */
         public function toArray()
         {
             $arrThis = get_object_vars($this);

             // Verifica se os objetos relacionados também possuem 
             //um método para convertê-los para array             
             foreach($arrThis as $strAttName => $mxdValue)
             {
             	 if(is_object($this->$strAttName) && method_exists($this->$strAttName, 'toArray'))
             	 {
             	 	 $arrThis[$strAttName] = $this->$strAttName->toArray();
             	 }
             }
             
             // Remove os atributos desta classe
             unset($arrThis['arrAttributes']);
             unset($arrThis['objDao']);
             
             return $arrThis;
         }         
         
//------------------------------------------------------------------------------

    /**
     * Transforma este objeto em uma string
     * @return string
     * @access public
     */
         public function toString()
         {
             return Utils::OutputBuffer($this->toArray());
         }         
         
//------------------------------------------------------------------------------

    /**
     * serializa este objeto em uma string xml
     * Os atributos que são objetos objetos também são convertidos para xml
     * desde que possuam um método com o mesmo nome que este.   
     * @return string
     * @access public
     */
         public function toXML($arrThis)
         {
             if(is_array($arrThis))
             {
				 $objXML = new XML();
	
				 $objXML->push(get_class($this));         
	         
             	 foreach($arrThis as $mxdPropertyName => $mxdPropertyValue) 
				 {
				 	 if(is_array($mxdPropertyValue))
				 	 {
						 $objXML->push($mxdPropertyName);         
			         
		             	 foreach($mxdPropertyValue as $mxdPropertyName2 => $mxdPropertyValue2) 
						 {
						 	 $objXML->element($mxdPropertyName2, $mxdPropertyValue2);
						 }				 
						 
						 $objXML->pop();				 	 	 
				 	 }
				 	 else
				 	 {
					 	 $objXML->element($mxdPropertyName, $mxdPropertyValue);
				 	 }	 
				 }				 
				 
				 $objXML->pop();
				
				 $strXml = $objXML->GetXml();

				 return $strXml;
             }
         }         
         
//------------------------------------------------------------------------------

    /**
     * Esse funciona só tem que gerar o xml
     */
         public function ArrayToXML($array_name, $ident = 0)
		{
			if(is_array($array_name))
			{
				foreach ($array_name as $k => $v)
				{
					if (is_array($v))
					{
						for ($i=0; $i < $ident * 10; $i++)
						{ 
							echo "&nbsp;"; 
						}
						
						echo $k . " : " . "<br>";
						
						$this->ArrayToXML($v, $ident + 1);
					}
					else
					{
						for ($i=0; $i < $ident * 10; $i++)
						{ 
							echo "&nbsp;"; 
						}
						
						echo $k . " : " . $v . "<br>";
					}
				}
			}
			else
			{
				echo "Variable = " . $array_name;
			}
		}         
         
//------------------------------------------------------------------------------

}