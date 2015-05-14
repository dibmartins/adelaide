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
 * @version 1.0 - 2010-10-20 11:55:17
 * @author Diego Botelho Martins <diego@rgweb.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2010 RG Sistemas - Todos os diretos reservados.
 */

class DaoSearchResultException extends Exception{}

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
 * Objeto que encapsula o resultado de uma busca para ser retornado
 * ao actionscript. Atributos nomeados seguindo a convenção do actionscript. * 
 *
 * @package Framework
 * @subpackage Ado
 * @version 1.0 - 2010-10-20 11:55:17
 * @author Diego Botelho Martins <diego@rgweb.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2010 RG Sistemas - Todos os diretos reservados.
 */

class DaoSearchResult 
{
    /**
     * Attributes:
     */

    /**
     *
     * @var string
     * @access public
     */
         public $dataProvider;

    /**
     *
     * @var string
     * @access public
     */
         public $sql;

    /**
     *
     * @var string
     * @access public
     */
         public $connectionString;

    /**
     *
     * @var string
     * @access public
     */
         public $total;

//------------------------------------------------------------------------------

    /**
     * Methods:
     */

    /**
     * Método construtor da classe
     * @return void
     * @access public
     * @see DaoModel::__construct()
     */
         public function __construct(){}

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
     * Retorna a sql informada sem a clausula LIMIT
     * 
     * @return void
     * @access public
     */
         public function RemoveLimit($strSQL)
         {
         	 $arrSQL = explode("LIMIT", $strSQL);
             $strSQL = $arrSQL[0];
             
             return $strSQL;
         }

//------------------------------------------------------------------------------

}