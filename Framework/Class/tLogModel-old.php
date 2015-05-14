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
 * Classe responsável pelo gerenciamento de erros
 *
 * @package Logic
 * @subpackage Arquivos
 * @version 1.0 - 2011-10-14 08:56:44
 * @author Paulo de Tarço <paulo@rgweb.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright  2010 RG Sistemas - Todos os diretos reservados.
 */

class LogModelOldException extends Exception{}

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
 * Classe responsável pela implementação da lógica de negócio
 *
 * @package Logic
 * @subpackage Arquivos
 * @version 1.0 - 2011-10-14 08:56:44
 * @author Paulo de Tarço <paulo@rgweb.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright  2010 RG Sistemas - Todos os diretos reservados.
 */

abstract class LogModelOld extends Model
{
    /**
     * Attributes:
     */

    /**
     * Objeto que mapeia o relacionamento
     * 
     * @var TipoLog
     * @access protected
     */
        protected $objTipoLog;         

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
         	 parent::__construct();
         	 
             $this->SetTipoLog(new TipoLog);  
         }

//------------------------------------------------------------------------------

    /**
     * Registra o log de operação do objeto funcionário
     * @param Model $objModel Objeto a ser registrado no log
     * @param String $strOperacao Operação a ser registrada no log
     * @return mixed Se o comando for executado com sucesso retorna o id do registro, caso contrário false
     * @access public
     * @throws Exception Dispara uma exceção caso ocorra algum erro
     */
         public abstract function Registrar(Model $objModel, $strOperacao);         

//------------------------------------------------------------------------------
         
}