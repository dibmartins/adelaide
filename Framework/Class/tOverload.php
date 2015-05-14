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
 * @subpackage Overload
 * @version 1.0 - 2007-07-11 17:37:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright  2009 RG Sistemas - Todos os diretos reservados.
 */

class OverloadException extends Exception{}

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
 * Classe que sobrecarrega o acesso as propriedades da classe que a herda
 * @package Framework
 * @subpackage Overload
 * @version 1.0 - 2007-07-11 17:37:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright  2009 RG Sistemas - Todos os direitos reservados
 */

class Overload
{
   /** 
    * Attributes:
    */   
   
//---------------------------------------------------------------------------------------------	
	
   /** 
    * Properties:
    */

//---------------------------------------------------------------------------------------------	
		
   /** 
    * Methods:
    */

	/**
     * Obtém o valor da propriedade
     * @param mixed $strProperty
     * @return mixed
     * @access protected
     */	
		protected function __get($strProperty)
		{
			$strGetProperty = "Get".ucfirst($strProperty);
			
			if(method_exists($this, $strGetProperty))
			{
				return $this->$strGetProperty();
			}
			else 
			{
			    throw new OverloadException($strProperty . ": Propriedade inexistente");
			}	
		}

	/**
     * Seta o valor informado na propriedade
     * @param mixed $strProperty
     * @return void
     * @access protected
     */	
		protected function __set($strProperty, $mxdValue)
		{
			$strGetProperty = "Set".ucfirst($strProperty);
			
			if(method_exists($this, $strGetProperty))
			{
				$this->$strGetProperty($mxdValue);
			}
			else 
			{
			    throw new OverloadException($strProperty . ": Propriedade inexistente ou somente de leitura");
			}	
		}

	/**
     * Sobrecarrega a função isset
     * @return boolean
     * @access protected
     */	
		protected function __isset($strProperty)
		{
			return isset($this->$strProperty);		
		}

	/**
     * Sobrecarrega a função unset
     * @return void
     * @access protected
     */	
		protected function __unset($strProperty)
		{
			unset($this->$strProperty);
		}

	/**
     * Carrega a propriedade no momento em que ela é solicitada
	 * Lazy Load Pattern
     * @return void
     * @access protected
     */			
		protected function LazyLoad($strProperty, $intForeignKey, $strClass, $intId)
		{
			if(!is_null($intId))
			{
				$this->$strProperty = new $strClass($intId);
			}
			elseif($this->$intForeignKey && is_numeric($this->$intForeignKey))
			{
				$this->$strProperty = new $strClass($this->$intForeignKey);
			}
			elseif(is_null($this->categoria))
			{
				$this->$strProperty = new $strClass();
			}
		}
}
