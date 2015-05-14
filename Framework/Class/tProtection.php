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
 * @subpackage Protection
 * @version 1.0 - 2006-12-14 13:36:58
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class ProtectionException extends Exception{}

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
 * Classe responsável para tratar a sessão do sistema. Cria, destroi e valida as sessões.
 * @package Framework
 * @subpackage Protection
 * @version 1.0 - 2006-12-14 13:36:58
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */
 
class Protection
{
    /**
     * Attributes:
     */

    /**
     *
     * @var object $objRecord 
     * @access private
     */
         private $objRecord;

    /**
     *
     * @var string $strSessionId 
     * @access private
     */
         private $strSessionId;

//---------------------------------------------------------------------------------------

    /**
     * Properties:
     */

    /**
     * Seta o valor do atributo $objRecord
     * @param object $objRecord Valor a ser salvo no atributo $objRecord
     * @return void
     */
         public function SetSession($objRecord)
         {
             $this->objRecord = $objRecord;
         }

    /**
     * Retornando o valor do atributo $objRecord
     * @return object
     */
         public function GetSession()
         {
             return $this->objRecord;
         }

    /**
     * Seta o valor do atributo $strSessionId
     * @param string $strSessionId Valor a ser salvo no atributo $strSessionId
     * @return string
     */
         public function SetSessionId($strSessionId)
         {
             $this->strSessionId = $strSessionId;
         }

    /**
     * Retornando o valor do atributo $strSessionId
     * @return string
     */
         public function GetSessionId()
         {
             return $this->strSessionId;
         }


//---------------------------------------------------------------------------------------

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
             $this->SetSession("");
			 $this->SetSessionId("");
			 
			 session_cache_expire(30);
			 session_start();
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
     * Salva as variáveis do $objRecord na sessão.
     * @return void
     * @access public
     */
         public function SaveSession()
         {
		     $_SESSION['VAR_1']  = $this->GetSession()->var1;
		     $_SESSION['VAR_2']  = $this->GetSession()->var2;
		     $_SESSION['VAR_3']  = $this->GetSession()->var3;
			 
			 $_SESSION["SESSAO_ID"] = Utils::UniqueId();
			 
			 $this->SetSessionId($_SESSION["SESSAO_ID"]);		 				 				 
		 }

    /**
     * Encerra a sessão atual e redireciona para a página principal do sistema (tela de login).
     * @return void
     * @access public
     */
         public function DestroySession()
         {
			 // Destruindo a seção
			 session_destroy();

             //$strPath = ($_SERVER['HTTPS'] == "off") ? "http://" : "http://";
			 //$strPath.= $_SERVER['HTTP_HOST'] . "/" . next(explode("/", $_SERVER["PHP_SELF"])) . "/caminho/para/login.php";
			 //$strPath = "http://caminho/para/login.php";
			 //header("Location: ".$strPath);
		 }		

    /**
     * Encerra a sessão atual do cliente e redireciona para a página de login.
     * @return void
     * @access public
     */
         public function DestroyClientSession()
         {
			 // Destruindo a sessão
			 session_destroy();
			 $_SESSION = array();

			 //header("Location: login.php?idLoc=" . $strIdLocatario);
		 }

    /**
     * Valida se a sessão atual existe e se é do usuário logado, 
	 * caso negativo, encerra a sessão e redireciona para a página de login.
     * @return void
     * @access public
     */
         public function ValidateSession()
         {
             // Verifica se existe os dados da sessão de login 
             if(!isset($_SESSION["SESSAO_ID"]))
             { 
                 // usuário não logado! Redireciona para a página de login 
                 $this->DestroySession();
                 exit;
             }		
		 }
		 
    /**
     * Valida se a sessão atual do cliente existe, em caso negativo, 
	 * encerra a sessão e redireciona para a página de login.
     * @return void
     * @access public
     */
         public function ValidateClientSession()
         {
             // Verifica se existe os dados da sessão de login 
             if(!isset($_SESSION["SESSAO_CLIENTE_ID"]))
             { 
                 // Usuário não logado! Redireciona para a página de login 
                 $this->DestroyClientSession();
                 exit;
             }		
		 }		 		 
}
