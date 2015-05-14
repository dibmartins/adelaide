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
 * @subpackage Collection
 * @version 1.0 - 2006-09-28 17:11:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class CollectionException extends Exception{}

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
 * Manipula um objeto como se fosse um array
 * Esta classe utiliza as classes ArrayObject, ArrayAccess e IteratorAggregate do pacote SPL do PHP
 * @package Framework
 * @subpackage Collection
 * @version 1.0 - 2006-09-28 17:11:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.php.net/manual/pt_BR/ref.spl.php
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */
 
class Collection implements ArrayAccess,IteratorAggregate
{
   /** 
    * Attributes:
    */   
   
   /**
	* @var array $arCollection
	* @access protected
	*/
	protected $arCollection;
	
//---------------------------------------------------------------------------------------------	
	
   /** 
    * Properties:
    */   
   
   /**
	* Método para setar o valor do atributo $arCollection
	* @param $value
	* @return void		 
	* @access public
	*/
		public function SetCollection($strValue)
		{
			 $this->arCollection = $strValue;
		}

   /**
	* Método para retornar o valor do atributo $arCollection
	* @return Valor do atributo $arCollection
	* @access public
	*/
		public function GetCollection()
		{
			 return $this->arCollection;
		}
		
//---------------------------------------------------------------------------------------------	
		
   /** 
    * Methods:
    */
	
   /**
	* Método construtor da classe
	* @return void
	* @access public
	*/
		public function __construct($arCollection = NULL)
		{
			 $this->SetCollection($arCollection);
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
	* Método para obter o valor de um elemento da coleção
	* @param $strElement
	* @return mixed
	* @access public
	*/
		 public function __get($strElement)
		 {
		     if(isset($this->arCollection[$strElement]))
			 {
				 return $this->arCollection[$strElement];
			 } 
		 }

   /**
	* Método para setar o valor de um elemento da coleção
	* @param $strElement
	* @param $mxdValue
	* @return void
	* @access public
	*/	
		 public function __set($strElement, $mxdValue)
		 {
			 if(isset($this->arCollection[$strElement])) 
			 {
			 	 $this->arCollection[$strElement] = $mxdValue;
			 } 
		 }
	
   /**
	* Método para verificar se um elemento existe na coleção
	* @param $strElement
	* @return boolean
	* @access public
	*/
		 public function __isset($strElement)
		 {
		     return isset($this->arCollection[$strElement]);
		 }
	
   /**
	* Método para excluir um elemento da coleção
	* @param $strElement
	* @return void
	* @access public
	*/
		 public function __unset($strElement)
		 {
		     unset($this->arCollection[$strElement]);
		 }

   /**
	* Método para excluir a coleção
	* @return void
	* @access public
	*/
		public function Clear()
		{
			 $this->SetCollection(NULL);
		}
	
   /**
	* Método Iterator 
	* @param $strElement
	* @return boolean
	* @access public
	*/  
	    public function offsetExists($strElement)
	    {         
		    if(isset($this->arCollection[$strElement]))  
			{
			    return true;
			}	
		    else 
			{
			    return false;
			}	
	    }   

   /**
	* Método Iterator 
	* @param $strElement
	* @return mixed
	* @access public
	*/  
	    public function offsetGet($strElement)
	    { 
		    if($this->offsetExists($strElement))  
		    {
			    return $this->arCollection[$strElement];
		    }	   
		    else 
		    {
			    return (false);
		    }	   
	    }
  
   /**
	* Método Iterator 
	* @param $strElement
	* @param $mxdValue	
	* @return void
	* @access public
	*/  
	    public function offsetSet($strElement, $mxdValue)
	    {         
		    if ($strElement)  
			{
			    $this->arCollection[$strElement] = $mxdValue;
		    }
			else  
			{
			    $this->arCollection[] = $mxdValue;
			}	
	    }
  
   /**
	* Método Iterator 
	* @param $strElement
	* @return void
	* @access public
	*/  
	    public function offsetUnset($strElement)
	    {
		    unset($this->arCollection[$strElement]);
	    }
  
   /**
	* Método Iterator 
	* @return array
	* @access public
	*/     
        public function &getIterator()
        {
            if(is_array($this->arCollection) || is_object($this->arCollection))
			{
			    
				$objArrayCollection = new ArrayIterator($this->arCollection);
				
				return $objArrayCollection;
			}
			else
			{
			    throw new CollectionException("A listagem não foi gerada");
			}	
        }
        
   /**
	* Método para inserir os itens de um collection
	* no outro. 
	* @return array
	* @access public
	*/     
        public function Join(Collection $objCollection)
        {
            foreach($objCollection->GetCollection() as $obj)
            {
            	$this->arCollection[] = $obj;		
            }
        }
}
