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
 * Classe utilizada para identificar excessões que devem ser exibidas na tela para o usuário. 
 * Toda excessão deste tipo será tratada como uma excessão de lógica e considerada como serviço
 * executado com sucesso. 
 * 
 * @package Framework
 * @subpackage Ado
 * @version 1.0 - 2009-11-10 10:51:17
 * @author Diego Botelho Martins <diego@rgweb.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */
class DisplayException extends Exception
{
	
	/**
     * Attributes:
     */
	
	/**
     *
     * @var array
     * @access 
     */
         protected $arrDetails;
         //protected $code;
         
     //-------------------------------------------------------------------------
	
    /** 
     * Properties:
     */
         
//------------------------------------------------------------------------------
    /**
	 * Método para setar o valor do atributo $arrDetails
	 * em outros exceptions este atributo está sendo utilizado 
	 * passado apenas uma string.
	 * Por padrão ele está ficando como array mas pode ter
	 * outros tipos setados.
	 * @param array $arrDetails
	 * @return void		 
	 * @access public
	 */
		 public function SetDetails($arrDetails)
		 {
			  $this->arrDetails = $arrDetails;
		 }

    /**
	 * Método para retornar o valor do atributo $arrDetails
	 * @return Valor do atributo $arrDetails
	 * @access public
	 */
		 public function GetDetails()
		 {
			  return $this->arrDetails;
		 }

//------------------------------------------------------------------------------
         
 	/**
     * Método construtor da classe
     * @return void
     * @access public
     */
         public function __construct($strMensagem = '', 
         							 $arrDetails  = array())
         {
         	 parent::__construct($strMensagem);
         	 
         	 $this->SetDetails($arrDetails);
         }    
}
