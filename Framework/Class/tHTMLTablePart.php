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
 * @version 1.0 - 2009-04-29 11:57:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class HTMLTablePartException extends Exception{}

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
 * Classe base de geração de tags theader, tfoot, e tbody que compõem tabelas no formato html
 * @package Framework
 * @subpackage HTML
 * @version 1.0 - 2009-04-29 11:57:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class HTMLTablePart
{
    /** 
     * Attributes:
     */   

    /**
     * Atributos da tag
     * @var Collection
     * @access private
     */
         private $objAttributes;

    /**
     * Linhas
     * @var object Collection
     * @access private
     */
         private $objRows;


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
    * Método para setar o valor do atributo $objRows
    * @return void		 
    * @access public
    */
	public function SetRows($objRows)
	{
	    $this->objRows = $objRows;
	}
    
    /**
     * Método para retornar o valor do atributo $objRows
     * @param int $intIndex índice da linha desejada
     * @return string $objRows
     * @access public
     */
	public function GetRows($intIndex = null)
	{
	    if(isset($intIndex))
		{
			return $this->objRows->offsetGet($intIndex);
		}
		else
		{
			return $this->objRows;
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
	    try
		{
			$this->SetAttributes($this->TableAttributes());
			
			//Adiciona a linha padrão
			$objRow = new HTMLTableRow();
			
			$this->SetRows(new Collection(array($objRow)));
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
		$arAttributes = array('id'      => '',
							  'class'   => '',
							  'align'   => '',
							  'char'    => '',
							  'charoff' => '',
							  'valign'  => '',
							  'style'   => '',
							  'dir'     => '',
							  'lang'    => '',
							  'title'   => '');
		
		return new Collection($arAttributes);
	}
    
    /**
     * Adiciona uma nova linha
     * @param array $mxdItens Valores a serem inseridos na linha, pode ser um array ou apenas uma string
     * @return void
     * @access public
     */
	public function AddRow($mxdItens = null)
	{
		$objRow = new HTMLTableRow();
		
		if(is_array($mxdItens))
		{
			foreach($mxdItens as $mxdValue)
			{
				$objRow->AddColumn($mxdValue);			
			}
		}
		elseif(isset($mxdItens))
		{
			$objRow->AddColumn($mxdItens);
		}
		
		if($this->objRows instanceof Collection)
		{
			// Objetos Collection podem assumir comportamentos de array! ;P
			$this->objRows[] = $objRow;
		}
		else
		{
			$this->objRows = new Collection(array($objRow));
		}
	}	
	
	/**
     * Renderiza da tabela
     * @param string $strTag nome da tag a ser renderizada tbody, thead ou tfoot
     * @return string
     * @access public
     */
	protected function Render($strTag = 'thead')
	{
		if(!in_array($strTag, array('tbody', 'thead', 'tfoot')))
		{
			throw new HTMLTablePartException($strTag . 'não é uma tag válida.');	
		}		
		
		$strHTML = '<'.$strTag.' ';
		
		foreach($this->objAttributes as $strAttribute => $mxdValue)
		{
			if($mxdValue != '')
			{
				$strHTML .= $strAttribute.'="'.$mxdValue.'" ';
			}	
		}
		
		$strHTML.= '>'.chr(10);
		
		if($this->objRows instanceof Collection)
		{
			$blnHeaderColumns = $strTag == 'thead' ? true : false;
			
			foreach($this->objRows as $this->objRow)
			{
				$strHTML.= $this->objRow->Render($blnHeaderColumns);
			}
		}
		
		$strHTML.= '</'.$strTag.'>'.chr(10);
		
		return $strHTML;
	}
}