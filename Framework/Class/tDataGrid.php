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
 * @subpackage DataGrid
 * @version 1.0 - 2009-05-01 10:00:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class DataGridException extends Exception{}

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
 * Classe de geração de grids para exibição de registros
 * @package Framework
 * @subpackage DataGrid
 * @version 1.0 - 2009-05-01 10:00:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class DataGrid
{
    /** 
     * Attributes:
     */   

    /**
     * Consulta SQL
     * @var string
     * @access private
     */
         private $strQuery;

    /**
     * Fonte RecordSet do DataGrid
     * @var object RecordSet
     * @access private
     */
         private $objRSSource;
		 
    /**
     * Paginação de resultados
     * @var string
     * @access private
     */
         private $strPagination;
		 
    /**
     * Habilita/Desabilita a paginação de resultados padrão true
     * @var boolean
     * @access private
     */
         private $blnEnabledPagination;		 

    /**
     * Habilita/Desabilita a exibição campos de acesso aos registros
     * @var boolean
     * @access private
     */
         private $blnEnableAccessFields;

    /**
     * Tipo do campo a ser exibido na primeira coluna (checkbox/radio)
     * @var string
     * @access private
     */
         private $strAccessFieldType;

//------------------------------------------------------------------------------	
	
   /** 
    * Properties:
    */

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

   /**
    * Método para setar o valor do atributo $objRSSource
    * @return void		 
    * @access protected
    */
	protected function SetSource(RecordSet $objRSSource)
	{
	    $this->objRSSource = $objRSSource;
	}
    
    /**
     * Método para retornar o valor do atributo $objRSSource
     * @return string $objRSSource
     * @access public
     */
	public function GetSource()
	{
	    return $this->objRSSource;
	}

   /**
    * Método para setar o valor do atributo $strPagination
    * @return void		 
    * @access protected
    */
	protected function SetPagination($strPagination)
	{
	    $this->strPagination = $strPagination;
	}
    
    /**
     * Método para retornar o valor do atributo $strPagination
     * @return string $strPagination
     * @access public
     */
	public function GetPagination()
	{
	    return $this->strPagination;
	}

   /**
    * Método para setar o valor do atributo $blnEnabledPagination
    * @return void		 
    * @access public
    */
	public function SetEnablePagination($blnEnabledPagination)
	{
	    $this->blnEnabledPagination = $blnEnabledPagination;
	}
    
    /**
     * Método para retornar o valor do atributo $blnEnabledPagination
     * @return string $blnEnabledPagination
     * @access public
     */
	public function GetEnablePagination()
	{
	    return $this->blnEnabledPagination;
	}

   /**
    * Método para setar o valor do atributo $blnEnableAccessFields
    * @return void		 
    * @access public
    */
	public function SetEnableAccessFields($blnEnableAccessFields)
	{
	    $this->blnEnableAccessFields = $blnEnableAccessFields;
	}
    
    /**
     * Método para retornar o valor do atributo $blnEnableAccessFields
     * @return string $blnEnableAccessFields
     * @access public
     */
	public function GetEnableAccessFields()
	{
	    return $this->blnEnableAccessFields;
	}

   /**
    * Método para setar o valor do atributo $strAccessFieldType
    * @return void		 
    * @access public
    */
	public function SetAccessFieldType($strAccessFieldType)
	{
	    if($strAccessFieldType != 'checkbox' && $strAccessFieldType != 'radio')
		{
			throw new DataGridException('AccessFieldType inválido, informe checkbox ou radio');
		}
		$this->strAccessFieldType = $strAccessFieldType;
	}
    
    /**
     * Método para retornar o valor do atributo $strAccessFieldType
     * @return string $strAccessFieldType
     * @access public
     */
	public function GetAccessFieldType()
	{
	    return $this->strAccessFieldType;
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
			$this->SetQuery('');
			$this->SetPagination('');
			$this->SetEnablePagination(true);
			$this->SetEnableAccessFields(true);
			$this->SetAccessFieldType('checkbox');
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}

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
     * Renderiza o datagrid
     * @return string
     * @access private
     */
	private function LoadSource()
	{
		try
		{
			// Se a paginação estiver habilitada:
			if($this->blnEnabledPagination)
			{
				$objPagination = new PaginationRecordSet();
			
				// Define a consulta
				$objPagination->SetQuery($this->strQuery);

				// Seta a paginação gerada:
				$this->strPagination = $objPagination->Generate();
				
				// Seta o recordset gerado:
				$this->objRSSource = $objPagination->GetPageRecordSet();
			}
			else
			{
				// Obtendo a conexão com o servidor:
				$objDBServer = AdoFactory::Server();
			
				// Seta o recordset gerado:
				$this->objRSSource = $objDBServer->Query($this->strQuery, "object", false);
			}
		}	
		catch(Exception $e)
		{
			throw $e;
		}
	}	

//------------------------------------------------------------------------------

    /**
     * Renderiza a paginação do datagrid
     * @return string
     * @access private
     */
	private function RenderPagination()
	{
		try
		{
			$strPagination = '';
			
			if($this->blnEnabledPagination)
			{
				$strPagination.= '<div class="datagrid-pagination">';
				$strPagination.= $this->strPagination;
				$strPagination.= '</div>';
			}
			
			return $strPagination;
		}	
		catch(Exception $e)
		{
			throw $e;
		}
	}	

//------------------------------------------------------------------------------


    /**
     * Renderiza o datagrid
     * @return string
     * @access public
     */
	public function Render()
	{
		try
		{
			// Gera o recordset do datagrid:
			$this->LoadSource();
			
			if($this->objRSSource->GetSize() > 0)
			{
				// Movendo o índice do recordSet para o início:
				$this->objRSSource->Restart();
				
				$objTable = new HTMLTable();
				
				if($this->blnEnableAccessFields)
				{
					$objTable->GetHead()->GetRows(0)->AddColumn('&nbsp;');
				}
				
				// Adiciona as colunas
				$strPKField = null;
				foreach($this->objRSSource->GetFields() as $arField)
				{
					if(in_array("primary_key", $arField['flags'])) { $strPKField = $arField['name']; }
					
					$objTable->GetHead()->GetRows(0)->AddColumn(ucfirst(strtolower($arField['name'])));
				}
				
				if(!isset($strPKField) && $this->blnEnableAccessFields)
				{
					throw new DataGridException('Um campo chave primária deve ser informado.');
				}
				
				// Adiciona as linhas
				$intI = 0;
				foreach($this->objRSSource as $objRecord)
				{
					$objTable->GetBody()->AddRow();
					
					if($this->blnEnableAccessFields)
					{
						$strFieldName = 'DatagridSelectedItem';
						$strFieldName.= $this->strAccessFieldType == 'checkbox' ? '[]' : '';
						
						$strCheckbox = '<input type="'.$this->strAccessFieldType.'" name="'.$strFieldName.'" id="DatagridItem_'.$intI.'" class="datagrid-checkbox" value="'.$objRecord->$strPKField.'" />';
					
						$objTable->GetBody()->GetRows($intI)->AddColumn($strCheckbox);
					}
					
					foreach($this->objRSSource->GetFields() as $arField)
					{
						$objTable->GetBody()->GetRows($intI)->AddColumn($objRecord->$arField['name']);
					}
					
					$intI++; 
				}
				
				$this->objRSSource->Restart();
				
				$strDataGrid = $objTable->Render();
				$strDataGrid.= $this->RenderPagination();
				
				return $strDataGrid;
			}
		}	
		catch(Exception $e)
		{
			throw $e;
		}
	}

//------------------------------------------------------------------------------
}