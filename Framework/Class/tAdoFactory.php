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
 * @subpackage Ado
 * @version 1.0 - 2006-08-13 17:00:00 
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */
 
class AdoFactoryException extends Exception{}

/**
 * Classe de acesso a instâncias de conexões com banco de dados.
 * @package Framework
 * @subpackage Ado
 * @version 1.0 - 2006-08-13 17:00:00 
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.oodesign.com.br/patterns/FactoryMethod.html
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class AdoFactory
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
	* padrão Factory : Retorna uma conexão com o SGBD especificado.
	* @param string $strServer SGBD a ser instanciado
	* @return object
	* @access public
	* @see AdoMysql::Singleton()
	*/
		public static function Server($strServer   = '', 
									  $strHost     = '', 
									  $strUser     = '', 
									  $strPassword = '', 
									  $intPort     = SystemConfig::ADO_PORT, 
									  $strDataBase = '')
		{
		    try
			{
				switch($strServer)
				{
				    case 'Mysql': 
				    {
				    	return AdoMysql::Singleton($strHost, $strUser, $strPassword, $intPort, $strDataBase); break;
				    }
					/*
					case 'PostgreSQL' : return AdoPostgreSQL :: Singleton(); break;
					case 'SQLServer'  : return AdoSQLServer  :: Singleton(); break;
					case 'Oracle'     : return AdoOracle     :: Singleton(); break;
					case 'ODBC'       : return AdoODBC       :: Singleton(); break;
					*/
					default : throw new AdoFactoryException("Servidor " . $strServer . " não suportado");
				}
			} 
			catch(Exception $e)
			{
				throw $e;
			}
		}
}
