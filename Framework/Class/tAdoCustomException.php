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
 * Classe utilizada para identificar excessões customizadas do banco.
 * O Mysql não possui a funcionalidade de disparar erros customizados
 * Então criamos uma tabela erros_customizados com os possíveis erros
 * do sistema que devem ser disparados pelo banco. Quando um erro tiver
 * que ser disparado, basta executar um comando INSERT no erro desejado
 * nessa tabela que o mysql vai disparar o erro de duplicidade (1062)
 * Que é capturado em AdoMysql::ErrorHandler e como é um erro dessa tabela
 * a excessão abaixo é disparada
 * 
 * Ex.: INSERT INTO erros_customizados VALUES(1, 'duplicidade de horario');
 *
 * @package Framework
 * @subpackage Ado
 * @version 1.0 - 2009-10-30 10:51:17
 * @author Diego Botelho Martins <diego@rgweb.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */
class AdoCustomException extends DisplayException
{
	// Construtor sobrecarregado para formatação do erro
	public function __construct($message = null, $code = 0)
	{
		// Obtém o trecho "1-duplicidade de horario"
		$arrError = explode("'", $message);
		
		// Separa o código (1) da mensagem (duplicidade de horario)
		list($intErrorCode, $strError) = explode("-", $arrError[1]);
        
		// Em 09/01/2012:
		// #DOUGLAS - É necessário atribuir os valores para os atributos da
		// classe, pois sem fazer isso, o método getCode() retorna um valor
		// errado; veja em Consultas.Model.Consulta.Agendar(), ao tentar
		// capturar "catch(AdoCustomException $e)". As duas linhas abaixo
		// resolveram o problema:
		$this->code    = $intErrorCode;
		$this->message = $strError;
				
		parent::__construct($strError, $intErrorCode);
	}
}