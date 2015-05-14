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
 * @subpackage HTML
 * @version 1.0 - 2009-04-29 14:37:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class HTMLTableCaptionException extends Exception{}

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
 * Classe de geração de títulos em tabelas no formato html
 * @package Framework
 * @subpackage HTML
 * @version 1.0 - 2009-04-29 14:37:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class HTMLTableCaption
{
    /** 
     * Attributes:
     */   

    /**
     * Atributos da tag table
     * @var Collection
     * @access private
     */
         private $objAttributes;

    /**
     * Texto da coluna
     * @var string
     * @access private
     */
         private $strValue;


//------------------------------------------------------------------------------	
	
   /** 
    * Properties:
    */

   /**
    * Método para setar o valor do atributo $objAttributes
    * @return void		 
    * @access public
    */
	public function SetAttributes($objAttributes)
	{
	    $this->objAttributes = $objAttributes;
	}
    
    /**
     * Método para retornar o valor do atributo $objAttributes
     * @return string $objAttributes
     * @access public
     */
	public function GetAttributes()
	{
	    return $this->objAttributes;
	}
	
   /**
    * Método para setar o valor do atributo $strValue
    * @return void		 
    * @access public
    */
	public function SetValue($strValue)
	{
	    $this->strValue = $strValue;
	}
    
    /**
     * Método para retornar o valor do atributo $strValue
     * @return string $strValue
     * @access public
     */
	public function GetValue()
	{
	    return $this->strValue;
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
	    try
		{
			$this->SetAttributes($this->TableAttributes());
			$this->SetValue('');	
		}
		catch(Exception $e)
		{
			throw $e;
		}
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
     * Retorna um array com os atributos da tag
     * @return array
     * @access public
     */
	public function TableAttributes()
	{
		$arAttributes = array('class' => '',
							  'dir'   => '',
							  'id'    => '',
							  'lang'  => '',
							  'style' => '',
							  'title' => '');
							  
		
		return new Collection($arAttributes);
	}
    
	/**
     * Renderiza a(s) coluna(s) da tabela
     * @param boolean $blnHeaderColumns se true usará th ao invés de td por se tratar de colunas do header da tabela
     * @return string
     * @access public
     */
	public function Render()
	{
		$strHTML = '';
		
		if($this->strValue != '')
		{
			$strHTML.= '<caption ';
			
			foreach($this->objAttributes as $strAttribute => $mxdValue)
			{
				if($mxdValue != '')
				{
					$strHTML .= $strAttribute.'="'.$mxdValue.'" ';
				}	
			}
			
			$strHTML.= '>';
			$strHTML.= $this->strValue;
			$strHTML.= '</caption>'.chr(10);
		}	
		
		return $strHTML;
	}
}