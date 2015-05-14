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
 * @version 1.0 - 2009-04-29 10:00:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class HTMLTableException extends Exception{}

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
 * Classe de geração de tabelas em formato html
 * @package Framework
 * @subpackage HTML
 * @version 1.0 - 2009-04-29 10:00:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class HTMLTable
{
    /** 
     * Attributes:
     */   

    /**
     * Título (caption) da tabela
     * @var object
     * @access private
     */
         private $objCaption;

    /**
     * Atributos da tag table
     * @var Collection
     * @access private
     */
         private $objAttributes;

    /**
     * Header da tabela thead
     * @var object
     * @access private
     */
         private $objHead;

    /**
     * Body da tabela tbody
     * @var object
     * @access private
     */
         private $objBody;

    /**
     * Foot da tabela tfoot
     * @var object
     * @access private
     */
         private $objFoot;


//------------------------------------------------------------------------------	
	
   /** 
    * Properties:
    */

   /**
    * Método para setar o valor do atributo $objCaption
    * @return void		 
    * @access public
    */
	public function SetCaption($objCaption)
	{
	    $this->objCaption = $objCaption;
	}
    
    /**
     * Método para retornar o valor do atributo $strCaption
     * @return string $objCaption
     * @access public
     */
	public function GetCaption()
	{
	    return $this->objCaption;
	}

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
    * Método para setar o valor do atributo $objHead
    * @return void		 
    * @access public
    */
	public function SetHead($objHead)
	{
	    $this->objHead = $objHead;
	}
    
    /**
     * Método para retornar o valor do atributo $objHead
     * @return string $objHead
     * @access public
     */
	public function GetHead()
	{
	    return $this->objHead;
	}
	
   /**
    * Método para setar o valor do atributo $objBody
    * @return void		 
    * @access public
    */
	public function SetBody($objBody)
	{
	    $this->objBody = $objBody;
	}
    
    /**
     * Método para retornar o valor do atributo $objBody
     * @return string $objBody
     * @access public
     */
	public function GetBody()
	{
	    return $this->objBody;
	}
	
   /**
    * Método para setar o valor do atributo $strMessage
    * @return void		 
    * @access public
    */
	public function SetFoot($objFoot)
	{
	    $this->objFoot = $objFoot;
	}
    
    /**
     * Método para retornar o valor do atributo $objFoot
     * @return string $objFoot
     * @access public
     */
	public function GetFoot()
	{
	    return $this->objFoot;
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
			$this->SetCaption(new HTMLTableCaption());
			$this->SetAttributes($this->TableAttributes());
			$this->SetHead(new HTMLTableHead());
			$this->SetBody(new HTMLTableBody());
			$this->SetFoot(new HTMLTableFoot());
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
     * Retorna um array com os atributos da tag table
     * @return array
     * @access public
     */
	public function TableAttributes()
	{
		$arAttributes = array('id'          => '',
							  'class'       => '',
							  'border'      => '1',
							  'summary'     => '',
							  'cellpadding' => '',
							  'cellspacing' => '',
							  'style'       => '',
							  'width'       => '',
							  'dir'         => '',
							  'frame'       => '',
							  'lang'        => '',
							  'title'       => '');
		
		return new Collection($arAttributes);
	}

    /**
     * Renderiza da tabela
     * @return string
     * @access public
     */
	public function Render()
	{
		$strHTML = '<table ';
		
		foreach($this->objAttributes as $strAttribute => $mxdValue)
		{
			if($mxdValue != '')
			{
				$strHTML .= $strAttribute.'="'.$mxdValue.'" ';
			}	
		}
		
		$strHTML.= '>'.chr(10);

		$strHTML.= $this->GetCaption()->Render();
		$strHTML.= $this->objHead->Render();
		$strHTML.= $this->objBody->Render();
		$strHTML.= $this->objFoot->Render();
		
		$strHTML.= '</table>'.chr(10);
		
		return $strHTML;
	}
}