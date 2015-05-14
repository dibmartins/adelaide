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
 * Especifica quais métodos deverão ser implementados pelas classes que herdarão de ReportGraph, 
 * sem definir como esses métodos serão tratados nessas classes.
 * Uma classe ao herdar de ReportGraph estará assumindo que irá implementar cada um destes métodos, 
 * seus parâmentros de entrada e seus retornos.
 * Se algum método aqui declarado não for implementado nas classes filhas de ReportGraph um erro fatal será gerado.
 * Isso garante o perfeito funcionamento de outras classes deste pacote independente do tipo de gráfico escolhido.
 * @package Framework
 * @subpackage Reports
 * @version 1.0 - 2006-11-16 16:15:00 
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */
 
interface InterfaceReportGraph
{
   /**
	* Método construtor da classe
	* @return void
	* @access public
	*/
	    public function __construct();

   /**
	* Método destrutor da classe
	* @return void
	* @access public
	*/
	    public function __destruct();

   /**
	* Salva o arquivo do gráfico
	* @param $strDir diretório onde o gráfico será salvo
	* @return void
	* @access public
	*/
	    public function Save($strDir);   
}
