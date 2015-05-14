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
 * Classe base para envio de e-mail's informativos
 * @package Framework
 * @subpackage Mail
 * @version 1.0 - 2006-09-01 09:00:00 
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class EmailInformativo extends EmailContato
{

   /** 
    * Attributes:
    */   
   
   /**
	* @var string $arNoticias
	* @access private
	*/
	private $arNoticias;
	
//---------------------------------------------------------------------------------------------	

   /** 
    * Properties:
    */

   /**
	* Método para setar o valor do atributo $arNoticias
	* Você pode chamar esse método dentro de um laço para que sejam inseridas várias notícias e depois enviar o e-mail.
	* @param string $arNoticia Array com as notícias 
	* Ex.: $objEmail->addNoticia(array("titulo"         => "Notícia Teste", 
	*                                  "resumo"         => "Resumo da notícia teste", 
	*                                  "dataPublicacao" => "10/05/2006",
	*                                  "link"           => "www.meusite.com.br/noticia.php?id=5"));
	* @return void		 
	* @access public
	*/
		public function addNoticia($arNoticia)
		{
			 $this->arNoticias[] = $arNoticia;
		}

   /**
	* Método para retornar o valor do atributo $arNoticias
	* @return string $arNoticia
	* @access public
	*/
		public function GetNoticias()
		{
			 return $this->arNoticias;
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
	* Retornas as notícias em uma tabela html para exibição
	* @return string
	* @access private
	*/
		private function FormatarNoticias()
		{
		     $strInformacoes = "";
			 
			 foreach($this->GetNoticias() as $noticia)
			 {
				 $strInformacoes.= "<p>\n";
				 $strInformacoes.= "<a href=\"".$noticia["link"]."\">".$noticia["titulo"]."</a><br>\n";
				 $strInformacoes.= $noticia["resumo"]."<br>\n";
				 $strInformacoes.= "<i>Publicada em: ".$noticia["dataPublicacao"]."</i>\n";
				 $strInformacoes.= "</p>\n\n";
             }			 
			 
			 return $strInformacoes; 			 
		}
   
   /**
	* Envia a mensagem de e-mail. 
	* Este método retorna TRUE em caso de sucesso ou gera uma excessão  caso ocorra algum erro.
	* @return boolean
	* @access public
	*/
		public function Enviar()
		{
		     parent::SetMensagemHtml($this->FormatarNoticias());
			 
			 try
			 {
			     parent::Enviar();
			 }
			 catch(Exception $e)
			 {
			     throw new Exception($e->GetMessage());
			 }			 
		}
}
