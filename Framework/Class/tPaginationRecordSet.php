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
 * @subpackage Pagination
 * @version 1.0 - 2009-04-22 09:21:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class PaginationRecordSetException extends Exception{}

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
 * Classe de geração de paginação a partir de uma consulta ao banco de dados
 * @package Framework
 * @subpackage Pagination
 * @version 1.0 - 2009-04-22 09:21:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class PaginationRecordSet extends Pagination
{
    /** 
     * Attributes:
     */   

    /**
     * RecordSet com os registros da paginação
     * @var object AdoRecordSet
     * @access private
     */
         private $objPageRecordSet;

    /**
     * Consulta SQL para gerar a paginação
     * @var string
     * @access private
     */
         private $strQuery;
  
//---------------------------------------------------------------------------------------------	
	
   /** 
    * Properties:
    */

   /**
    * Método para setar o valor do atributo $objPageRecordSet
    * @return void		 
    * @access public
    */
	public function SetPageRecordSet($objPageRecordSet)
	{
	    $this->objPageRecordSet = $objPageRecordSet;
	}
    
    /**
     * Método para retornar o valor do atributo $objPageRecordSet
     * @return string $objPageRecordSet
     * @access public
     */
	public function GetPageRecordSet()
	{
	    return $this->objPageRecordSet;
	} 

   /**
    * Método para setar o valor do atributo $strQuery
    * @return void		 
    * @access public
    */
	public function SetQuery($strQuery)
	{
	    $this->strQuery = $strQuery;
	}
    
    /**
     * Método para retornar o valor do atributo $strQuery
     * @return string $strQuery
     * @access public
     */
	public function GetQuery()
	{
	    return $this->strQuery;
	} 

//---------------------------------------------------------------------------------------------	
		
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
	}

   /**
    * Método destrutor da classe
    * @return void
    * @access public
    */
	public function __destruct()
	{	
	    parent::__destruct();
	    unset($this);
	}

   /**
    * Retorna a paginação de registros de uma consulta ao banco de dados
    * @return string Paginação em formato html
    * @access public
    */
	public function Generate()
	{
	    try
	    {
		$objDBServer = AdoFactory::Server();
		
		// Obtém o número de registros que serão retornados...
		$strCountQuery = str_ireplace(' FROM ', ', COUNT(*) AS totalRows FROM ', $this->strQuery);
		
		$objAdoRecordSet = $objDBServer->Query($strCountQuery);
		
		$intTotalRows = $objAdoRecordSet->First()->totalRows;
		
		if($intTotalRows > 0)
		{
		    parent::SetTotalRows($intTotalRows);
		    
		    // Obtém a paginação
		    $strPagination = parent::Generate();
		    
		    // Realiza a consulta para dada página
		    $strPageQuery = $this->strQuery;
		    
		    if(parent::GetEntriesPerPage() != $intTotalRows)
		    {
			$strPageQuery.= ' LIMIT ' . parent::GetOffset() . ', ' . parent::GetEntriesPerPage();
		    }
		    else
		    {
			$strPageQuery.= ' LIMIT ' .  parent::GetEntriesPerPage();			
		    }
		    
		    $objAdoRecordSet = $objDBServer->Query($strPageQuery);
		    
		    $this->SetPageRecordSet($objAdoRecordSet);
		    
		    return $strPagination;
		}
		else
		{
		    throw new PaginationRecordSetException('Nenhum resultado encontrado.');		    
		}
	    }
	    catch(Exception $e)
	    {
		throw $e;
	    }
	}
}