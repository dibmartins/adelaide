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
 * @version 1.0 - 2006-08-30 17:00:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class AdoSQLBuilderException extends Exception{}

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
 * Classe responsável por montar strings de comando SQL SELECT
 * @package Framework
 * @subpackage Ado
 * @version 1.0 - 2006-08-30 17:00:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */
class AdoSQLBuilder
{

   /**
    * Attributes:
    */

   /**
    * @var array $arFields
    * @access private
    */
    private $arFields;

   /**
    * @var array $arFrom
    * @access private
    */
    private $arFrom;

   /**
    * @var array $arInnerJoin
    * @access private
    */
    private $arInnerJoins;

   /**
    * @var array $arLeftJoin
    * @access private
    */
    private $arLeftJoins;

   /**
    * @var array $arInnerJoin
    * @access private
    */
    private $arRightJoins;

   /**
    * @var array $arGroupBy
    * @access private
    */
    private $arGroupBy;

   /**
    * @var array $arWhere
    * @access private
    */
    private $arWhere;

   /**
    * @var array $arLimit
    * @access private
    */
    private $arLimit;

   /**
    * @var array $arOrderBy
    * @access private
    */
    private $arOrderBy;

    //---------------------------------------------------------------------------------------------

   /**
    * Properties:
    */

   /**
    * Método para setar os campos da consulta
    * @param array $arFields : Array com os campos da consulta.
    * @return void
    * @access public
    */
    public function Fields(array $arFields)
    {
        if(is_array($arFields))
        {
            foreach($arFields as $campo)
            {
                $this->arFields[] = $campo;
            }
        }
    }

   /**
    * Método para retornar o valor do atributo $arFields
    * @return array
    * @access public
    */
    public function GetFields()
    {
        return $this->arFields;
    }

   /**
    * Método para setar a tabela que será consultada no cláusula SQL FROM
    * @param array $arFrom : Array com o nome da tabela e seu apelido (opcional).
    * @return void
    * @access public
    */
    public function From($arFrom)
    {
        $this->arFrom = $arFrom;
    }

   /**
    * Método para retornar o valor do atributo $arFrom
    * @return array
    * @access public
    */
    public function GetFrom()
    {
        return $this->arFrom;
    }

   /**
    * Método para setar as cláusulas INNER JOIN da consulta
    * @param array $arInnerJoin : Array com os  inner joins da consulta
    * cada inner join é um array composto pelo nome da tabela, seu apelido e a Condição de junção.
    * @return void
    * @access public
    */
    public function InnerJoin(array $arInnerJoin)
    {
        $this->arInnerJoins[] = $arInnerJoin;
    }

   /**
    * Método para retornar o valor do atributo $arInnerJoins
    * @return array
    * @access public
    */
    public function GetInnerJoins()
    {
        return $this->arInnerJoins;
    }

   /**
    * Método para setar as cláusulas LEFT JOIN da consulta
    * @param array $arLeftJoin : Array com os  left joins da consulta
    * cada left join é um array composto pelo nome da tabela, seu apelido e a Condição de junção.
    * @return void
    * @access public
    */
    public function LeftJoin(array $arLeftJoin)
    {
        $this->arLeftJoins[] = $arLeftJoin;
    }

   /**
    * Método para retornar o valor do atributo $arLeftJoins
    * @return array
    * @access public
    */
    public function GetLeftJoins()
    {
        return $this->arLeftJoins;
    }

   /**
    * Método para setar as cláusulas RIGHT JOIN da consulta
    * @param array $arRightJoin : Array com os  right joins da consulta
    * cada right join é um array composto pelo nome da tabela, seu apelido e a Condição de junção.
    * @return void
    * @access public
    */
    public function RightJoin(array $arRightJoin)
    {
        $this->arRightJoins[] = $arRightJoin;
    }

   /**
    * Método para retornar o valor do atributo $arRightJoins
    * @return array
    * @access public
    */
    public function GetRightJoins()
    {
        return $this->arRightJoins;
    }

   /**
    * Método para setar a tabela que será consultada no cláusula SQL WHERE
    * @param array $arWhere : Array com as condições da cláusula.
    * @return void
    * @access public
    */
    public function Where(array $arWhere)
    {
        $this->arWhere = $arWhere;
    }

   /**
    * Método para retornar o valor do atributo $arWhere
    * @return array
    * @access public
    */
    public function GetWhere()
    {
        return $this->arWhere;
    }

   /**
    * Método para setar a tabela que será consultada no cláusula SQL LIMIT
    * @param array $arLimit : Array com as condições da cláusula.
    * @return void
    * @access public
    */
    public function Limit(array $arLimit)
    {
        $this->arLimit = $arLimit;
    }

   /**
    * Método para retornar o valor do atributo $arLimit
    * @return array
    * @access public
    */
    public function GetLimit()
    {
        return $this->arLimit;
    }

   /**
    * Método para setar a tabela que será consultada no cláusula SQL GROUP BY
    * @param array $arGroupBy : Array com o nome dos campos da cláusula.
    * @return void
    * @access public
    */
    public function GroupBy(array $arGroupBy)
    {
        $this->arGroupBy = $arGroupBy;
    }

   /**
    * Método para retornar o valor do atributo $arGroupBy
    * @return array
    * @access public
    */
    public function GetGroupBy()
    {
        return $this->arGroupBy;
    }

   /**
    * Método para setar a tabela que será consultada no cláusula SQL ORDER BY
    * @param array $arOrderBy : Array com os campos da cláusula, e a ordem de exibição.
    * @return void
    * @access public
    */
    public function OrderBy(array $arOrderBy)
    {
        $this->arOrderBy = $arOrderBy;
    }

   /**
    * Método para retornar o valor do atributo $arOrderBy
    * @return array
    * @access public
    */
    public function GetOrderBy()
    {
        return $this->arOrderBy;
    }

   /**
    * Método construtor da classe
    * @return void
    * @access public
    */
    public function __construct(){}

    //---------------------------------------------------------------------------------------------

   /**
    * Methods:
    */

   /**
    * Constrói o comando SELECT.
    * @return string
    * @access public
    */
    public function BuildSelect()
    {
        if(is_array($this->GetFields()) and sizeof($this->GetFields()) > 0)
        {
            $sqlCommand = "SELECT ";

            foreach($this->GetFields() as $fieldSelect)
            {
                $sqlCommand.= $fieldSelect.", ";
            }

            // Retirando a virgula do último campo.
            $sqlCommand = substr($sqlCommand, 0, (strlen($sqlCommand)-2));

            // Quebrando a linha:
            $sqlCommand.= "\n";

            return $sqlCommand;
        }
        else
        {
            throw new AdoSQLBuilderException("Nenhum campo foi especificado na cláusula SELECT");
        }
    }

   /**
    * Constrói o comando FROM.
    * @return string
    * @access public
    */
    public function BuildFrom()
    {
        if(is_array($this->GetFrom()) and sizeof($this->GetFrom()) > 0)
        {
            $arFrom = $this->GetFrom();

            $sqlCommand = "FROM ".$arFrom[0];

            if(!empty($arFrom[1]))
            {
                $sqlCommand.= " AS ".$arFrom[1];
            }

            // Quebrando a linha:
            $sqlCommand.= "\n";

            return $sqlCommand;
        }
        else
        {
            throw new AdoSQLBuilderException("A tabela de consulta não foi especificada<br>");
        }
    }

   /**
    * Constrói o comando INNER JOIN.
    * @return string
    * @access public
    */
    public function BuildInnerJoin()
    {
        $sqlCommand = "";

        if(is_array($this->GetInnerJoins()) and sizeof($this->GetInnerJoins()) > 0)
        {
            foreach($this->GetInnerJoins() as $innerJoin)
            {
                if(!empty($innerJoin[0]) and !empty($innerJoin[2]))
                {
                    $strAlias = !is_null($innerJoin[1]) ? " AS " . $innerJoin[1] : "";

                    $sqlCommand.= "INNER JOIN ".$innerJoin[0] . $strAlias . " ON ".$innerJoin[2];

                    // Quebrando a linha:
                    $sqlCommand.= "\n";
                }
                else
                {
                    throw new AdoSQLBuilderException("Inner Join com a tabela '".$innerJoin[0]."' não foi setado corretamente");
                }
            }
        }

        return $sqlCommand;
    }

   /**
    * Constrói o comando LEFT JOIN.
    * @return string
    * @access public
    */
    public function BuildLeftJoin()
    {
        $sqlCommand = "";

        if(is_array($this->GetLeftJoins()) and sizeof($this->GetLeftJoins()) > 0)
        {
            foreach($this->GetLeftJoins() as $leftJoin)
            {
                if(!empty($leftJoin[0]) and !empty($leftJoin[1]) and !empty($leftJoin[2]))
                {
                    $sqlCommand.= "LEFT JOIN ".$leftJoin[0]." AS ".$leftJoin[1]." ON ".$leftJoin[2];

                    // Quebrando a linha:
                    $sqlCommand.= "\n";
                }
                else
                {
                    throw new AdoSQLBuilderException("Left Join com a tabela '".$leftJoin[0]."' não foi setado corretamente");
                }
            }
        }

        return $sqlCommand;
    }

   /**
    * Constrói o comando RIGHT JOIN.
    * @return string
    * @access public
    */
    public function BuildRightJoin()
    {
        $sqlCommand = "";

        if(is_array($this->GetRightJoins()) and sizeof($this->GetRightJoins()) > 0)
        {
            foreach($this->GetRightJoins() as $rightJoin)
            {
                if(!empty($rightJoin[0]) and !empty($rightJoin[1]) and !empty($rightJoin[2]))
                {
                    $sqlCommand.= "RIGHT JOIN ".$rightJoin[0]." AS ".$rightJoin[1]." ON ".$rightJoin[2];

                    // Quebrando a linha:
                    $sqlCommand.= "\n";
                }
                else
                {
                    throw new AdoSQLBuilderException("Right Join com a tabela '".$rightJoin[0]."' não foi setado corretamente");
                }
            }
        }

        return $sqlCommand;
    }

   /**
    * Constrói o comando WHERE.
    * @return string
    * @access public
    */
    public function BuildWhere()
    {
        $sqlCommand = '';
        
        if(is_array($this->GetWhere()) and sizeof($this->GetWhere()) > 0)
        {
            $sqlCommand = "WHERE ";

            foreach($this->GetWhere() as $condicaoWhere)
            {
                $sqlCommand.= $condicaoWhere;
            }

            // Quebrando a linha:
            $sqlCommand.= "\n";
        }

        return $sqlCommand;
    }

   /**
    * Constrói o comando LIMIT.
    * @return string
    * @access public
    */
    public function BuildLimit()
    {
        $sqlCommand = '';        
        
        if(is_array($this->GetLimit()) and sizeof($this->GetWhere()) > 0)
        {
            $arLimit = $this->GetLimit();

            $sqlCommand = "LIMIT " . $arLimit[0];

            if(!empty($arLimit[1]))
            {
                $sqlCommand = ", " . $arLimit[1];
            }

            // Quebrando a linha:
            $sqlCommand.= "\n";
        }

        return $sqlCommand;
    }

   /**
    * Constrói o comando GROUP BY.
    * @return string
    * @access public
    */
    public function BuildGroupBy()
    {
        $sqlCommand = "";

        if(is_array($this->GetGroupBy()) and sizeof($this->GetGroupBy()) > 0)
        {
            $sqlCommand.= "GROUP BY ";

            foreach($this->GetGroupBy() as $fieldGroupBy)
            {
                $sqlCommand.= $fieldGroupBy.", ";
            }

            // Retirando a virgula do último campo.
            $sqlCommand = substr($sqlCommand, 0, (strlen($sqlCommand)-2));

            // Quebrando a linha:
            $sqlCommand.= "\n";
        }

        return $sqlCommand;
    }

   /**
    * Constrói o comando ORDER BY.
    * @return string
    * @access public
    */
    public function BuildOrderBy()
    {
        $sqlCommand = "";

        if(is_array($this->GetOrderBy()) and sizeof($this->GetOrderBy()) > 0)
        {
            $arOrderBy = $this->GetOrderBy();

            $sqlCommand.= "ORDER BY ";

            $arFieldsOrderBy = $arOrderBy[0];

            foreach($arFieldsOrderBy as $fieldOrderBy)
            {
                $sqlCommand.= $fieldOrderBy.", ";
            }

            // Retirando a virgula do último campo.
            $sqlCommand = substr($sqlCommand, 0, (strlen($sqlCommand)-2));

            // ASC ou DESC
            if(!empty($arOrderBy[1]) && ($arOrderBy[1] == 'ASC' || $arOrderBy[1] == 'DESC'))
            {
                $sqlCommand.= " ".$arOrderBy[1];
            }
            else
            {
                $sqlCommand.= " ASC ";
            }

            // Quebrando a linha:
            $sqlCommand.= "\n";
        }

        return $sqlCommand;
    }

   /**
    * Inicializa os atributos da classe
    * @return string
    * @access public
    */
    public function Clear()
    {
        $this->Fields("");
        $this->From("");
        $this->InnerJoin("");
        $this->LeftJoin("");
        $this->RightJoin("");
        $this->Where("");
        $this->Limit("");
        $this->GroupBy("");
        $this->OrderBy("");
    }

   /**
    * Constrói um comando SQL.
    * @return string
    * @access public
    */
    public function Select()
    {
        try
        {
            $strSql = $this->BuildSelect();
            $strSql.= $this->BuildFrom();
            $strSql.= $this->BuildInnerJoin();
            $strSql.= $this->BuildLeftJoin();
            $strSql.= $this->BuildRightJoin();
            $strSql.= $this->BuildWhere();
            $strSql.= $this->BuildLimit();
            $strSql.= $this->BuildGroupBy();
            $strSql.= $this->BuildOrderBy();

            return $strSql;
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }
}
