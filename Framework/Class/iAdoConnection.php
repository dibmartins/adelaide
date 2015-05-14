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
 * Especifica quais métodos deverão ser implementados pelas classes que herdarão de AdoConnection, 
 * sem definir como esses métodos serão tratados nessas classes.
 * Uma classe ao herdar de AdoConnection estará assumindo que irá implementar cada um destes métodos, 
 * seus parâmentros de entrada e seus retornos.
 * Se algum método aqui declarado não for implementado nas classes filhas de AdoConnection um erro fatal será gerado.
 * Isso garante o perfeito funcionamento de outras classes deste pacote independente do servidor de banco de dados.
 * @package Framework
 * @subpackage Ado
 * @version 1.0 - 2006-09-12 17:00:00 
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */
 
interface InterfaceAdoConnection
{
   /** 
	* Implementa o padrão Singleton para conectar uma única vez o banco de dados.
	* Se ocorrer um erro uma excessão é gerada.
	* @param string $strHost IP do servidor de banco de dados (Opcional)
	* @param string $strUser usuário de acesso ao servidor (Opcional)
	* @param string $strPassword Senha de acesso ao servidor (Opcional)
	* @param int $intPort Porta de conexão com o servidor (Opcional)
	* @param $strDataBase Base a ser selecionada (Opcional)
	* @return object $instance 
	* @access public
	*/
	    static public function Singleton($strHost = '', $strUser = '', $strPassword = '', $intPort = '', $strDataBase = '');

   /**
	* Verifica se já existe uma conexão estabelecida com servidor de banco de dados
	* @return boolean true se a conexão estiver estabelecida, caso contrário false
	* @access public
	*/	
	    public function Connected();
	
   /**
	* Estabelece conexão com o servidor de banco de dados.
	* Caso os parâmetros de conexão não sejam informados, 
	* esta função serão assumidos os valores de conexão definidos na classe AdoConnection.
	* @param string $strHost IP do servidor de banco de dados (Opcional)
	* @param string $strUser usuário de acesso ao servidor (Opcional)
	* @param string $strPassword Senha de acesso ao servidor (Opcional)
	* @param int $intPort Porta de conexão com o servidor (Opcional)
	* @return boolean true se o comando foi realizado com suxesso, caso contrário false
	* @access public
	*/	
	    public function Connect($strHost = '',
	    						$strUser = '',
	    						$strPassword = '',
	    						$intPort = '');
	
   /**
	* Encerra a conexão com o servidor de banco de dados
	* @return boolean true se o comando foi realizado com suxesso, caso contrário false
	* @access public
	*/	
	    public function CloseConnection();
	
   /**
	* Realiza uma consulta ao banco de dados
	* Seta em RecorSet os registros retornados
	* Seta em Rows o número de registros retornados
	* Se ocorrer um erro uma excessão é gerada.
	* @param string $strSQL Comando SQL
	* @param string $strRecordSetMode (Opcional) Modo de armazenamento do recordSet ('object' ou 'array') 
	* @param boolean $blnFreeResult (Opcional) false para que a consulta fique armazenada na memória do servidor
	* @return boolean true se o comando foi realizado com suxesso, caso contrário false
	* @access public
	*/		    
	    public function Query($strProcedure, 
							  $strRecordSetMode = 'object', 
							  $blnFreeResult    = true, 
							  $blnFormat 	    = true);
							  
   /**
	* Executa uma stored procedure no banco de dados
	* 
	* Funciona somente a partir do PHP 5.3.1
	* 
	* Seta em RecorSet os registros retornados
	* Seta em Rows o número de registros retornados
	* Se ocorrer um erro uma excessão é gerada.
	* @param string $strProcedure Comando SQL
	* @param string $strRecordSetMode (Opcional) Modo de armazenamento do recordSet ('object' ou 'array') 
	* @param boolean $blnFreeResult (Opcional) false para que a consulta fique armazenada na memória do servidor
	* @param boolean $blnFormat (Opcional) false para que a consulta seja retornada sem formatação
	* @return object AdoRecordSet
	* @access public
	*/
		public function Call($strProcedure, 
							 $strRecordSetMode = 'object', 
							 $blnFreeResult    = true, 
							 $blnFormat 	   = true);							  
	
   /**
	* Executa uma consulta ao banco de dados
	* Seta em Rows o número de registros retornados
	* Seta em InsertId o último id inserido no banco
	* Se ocorrer um erro uma excessão é gerada.
	* @param string $strSQL Comando SQL
	* @return boolean true se o comando foi realizado com suxesso, caso contrário false
	* @access public
	*/
	    public function Execute($strSQL);
	    
   /**
	* Limpa o cache de memória do servidor
	* Se ocorrer um erro uma excessão é gerada.
	* @return boolean true se o comando foi realizado com suxesso, caso contrário false
	* @access public
	*/	
	    public function FreeResult();
	
   /**
	* Ativa ou desativa o autocommit no banco de dados
	* @param boolean $blnActivate true para ativar e false para desativar
	* @return boolean true se o comando foi realizado com suxesso, caso contrário false
	* @access public
	*/	
	    public function AutoCommit($blnActivate = true);

   /**
	* Inicia uma transação no banco de dados.
	* @return boolean true se o comando foi realizado com suxesso, caso contrário false
	* @access public
	*/
	    public function Begin();
    
   /**
	* Finaliza a transação gravando os resultados das inserções/exclusões etc...
	* @return boolean true se o comando foi realizado com suxesso, caso contrário false
	* @access public
	*/	
	    public function Commit();
	
   /**
	* Cancela toda a transação, caso ocorra erro, sem gravar nada no banco de dados
	* @return boolean true se o comando foi realizado com suxesso, caso contrário false
	* @access public
	*/	
	    public function Rollback();
	
   /**
	* Lista as tabelas de um banco.
	* Exemplo para percorrer as tabelas listadas: 
	* $arTabelas = AdoConnection()->GetTables();
	* foreach($arTabelas[GetAdoConnection()->GetDataBase()] as $strTable){...}
	* @return array Um array com as tabelas é retornado. 
	* @access public
	*/		
	    public function GetTables();   
   
   /**
	* Retorna um array contendo as tabelas filhas relacionadas com a tabela mãe ($strTable) 
	* e os índices desses relacionamentos.
	* @param $strTable Tabela mãe que desejamos obter seus relacionamentos
	* @return array tabelas relacionadas com $strTable
	* @access public
	*/
	    public function GetRelationships($strTable);
		
   /**
	* Retorna todas as tabelas mões que utilizam a tabela filha ($strTable).
	* @param $strTable Tabela filha que desejamos obter seus relacionamentos
	* @return array Um array com as tabelas é retornado. 
	* @access public
	*/	
	    public function GetParentTables($strTable);		   
   
   /**
	* Retorna um resource com os campos de uma tabela.
	* @param string $strTable Nome da tabela
	* @return resource Um ponteiro de resultado dos campos é retornado. 
	* @access public
	*/	
	    public function ListFields($strTable);
	
   /**
	* Retorna o número de campos de um resultado.
	* @param resource $rscFields Resultado retornado em $this->GetFields($strTable) (Opcional)
	* Se $rscFields for omitido, então o resultado da última consulta será utilizado.
	* @return int Total de campos do resultado
	* @access public
	*/	
	    public function TotalFields($rscFields = '');
	
   /**
	* Retorna o nome do campo especificado.
	* @param resource $rscFields Resultado retornado em $this->GetFields($strTable) (Opcional)
	* Se $rscFields for omitido, então o resultado da última consulta será utilizado.
	* @param int $intIndex Numero da posição do campo. índice.
	* @return string Nome do campo.
	* @access public
	*/		    
	    public function FieldName($rscFields = '', $intIndex);
	
   /**
	* Retorna o tipo do campo especificado.
	* @param resource $rscFields Resultado retornado em $this->GetFields($strTable) (Opcional)
	* Se $rscFields for omitido, então o resultado da última consulta será utilizado.
	* @param int $intIndex Numero da posição do campo. índice.
	* @return string Tipo do campo.
	* @access public
	*/		    
		public function FieldType($rscFields = '', $intIndex);
	
   /**
	* Retorna o tamanho do campo especificado.
	* @param resource $rscFields Resultado retornado em $this->GetFields($strTable) (Opcional)
	* Se $rscFields for omitido, então o resultado da última consulta será utilizado.
	* @param int $intIndex número da posição do campo. índice.
	* @return string Tipo do campo.
	* @access public
	*/		    
		public function FieldSize($rscFields = '', $intIndex);
	
   /**
	* Retorna um array com as flags do campo especificado.
	* As seguintes flags são retornadas: "not_null", "primary_key", "unique_key"...
	* @param resource $rscFields Resultado retornado em $this->GetFields($strTable) (Opcional)
	* Se $rscFields for omitido, então o resultado da última consulta será utilizado.
	* @param int $intIndex número da posição do campo. índice.
	* @return array Flags do campo.
	* @access public
	*/		    
		public function FieldFlags($rscFields = '', $intIndex);
	
   /**
	* Retorna as informações dos campos utilizados na consulta atual
 	* Para utilizar este método, desabilite a opção de liberar memória 
	* setando o 3o. parâmetro do método query para false
	* @param resource $rscFields Resultado retornado em $this->GetFields($strTable) (Opcional)
	* Se $rscFields for omitido, então o resultado da última consulta será utilizado.
	* @return array Info dos campos
	* @access public
	*/	   
	    public function FieldsInfo($rscFields = '');
	
   /**
	* Retorna a string com as aspas simples e duplas escapadas.
	* @param string $strValue String a ser formatada.
	* @return string String formatada.
	* @access public
	*/	
	    public function Escape($strValue);
	
   /**
	* Retorna a informação da sessão
	* @return string Informação da sessão
	* @access public
	*/
	    public function ServerInfo();

   /**
	* Retorna a informação do host
	* @return string Informação do host
	* @access public
	*/
	    public function HostInfo();  
 
   /**
	* Retorna as informações do status do servidor de banco de dados em um array.
	* Se ocorrer um erro uma excessão é gerada.
	* @param string $rscLinkId Resource de identificação da conexão.
	* @return array Status do servidor
	* @access public
	*/	
	    public function Status();
		
   /**
	* Retorna a versão do servidor
	* @return string Versão do servidor
	* @access public
	*/
	    public function Version();		
	
   /**
	* Gera um arquivo sql com a estrutura e os dados das tabelas da base informada.
	* Se ocorrer um erro uma excessão é gerada.
	* @return boolean
	* @access public
	*/	
	    public function Backup();
}
