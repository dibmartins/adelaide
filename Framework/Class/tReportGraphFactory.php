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
 * @subpackage Reports
 * @version 1.0 - 2006-08-13 17:00:00 
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class ReportGraphFactoryException extends Exception{}

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
 * Classe de acesso a instâncias de gráficos pra relatórios.
 * @package Framework
 * @subpackage Reports
 * @version 1.0 - 2006-08-13 17:00:00 
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.oodesign.com.br/patterns/FactoryMethod.html
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */
 
class ReportGraphFactory
{
   /** 
    * Attributes:
    */

//-----------------------------------------------------------------------------------------   

   /** 
    * Properties:
    */

//-----------------------------------------------------------------------------------------  
	
   /** 
    * Methods:
    */
   
   /**
	* Construtor privado 
	* Para não permitir o instanciamento desta classe
	* 
	*/
		private function __construct(){}

   /**
	* padrão Factory : Retorna uma instância do gráfico especificado.
	* @param string $strGraphType : Tipo de gráfico a ser instanciado
	* @return object
	* @access public
	*/
		public static function Graph($strGraphType)
		{
		    try
			{
				switch($strGraphType)
				{
				    case 'Pie'    : return new ReportPieGraph();    break;
					case 'Bars'   : return new ReportBarsGraph();   break;
					case 'Points' : return new ReportPointsGraph(); break;
					case 'Straps' : return new ReportStrapsGraph(); break;
					case NULL     : return NULL; break;
					default       : throw new ReportGraphFactoryException("Gráfico ".$strGraphType." não suportado");
				}
			} 
			catch(Exception $e)
			{
				throw $e;
			}
		}
}
