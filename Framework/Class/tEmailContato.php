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
 * @subpackage Mail
 * @version 1.0 - 2006-08-31 17:00:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */
 
class EmailContatoException extends Exception{}

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
 * Classe base para envio de e-mail's com formatação padrão de contato
 * @package Framework
 * @subpackage Mail
 * @version 1.0 - 2006-08-31 17:00:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */
 
class EmailContato extends Email
{

   /** 
    * Attributes:
    */

   /**
	* @var string $strArquivo
	* @access private
	*/
	private $strArquivo;
   
   /**
	* @var string $strPagina
	* @access private
	*/
	private $strPagina;
   
   /**
	* @var string $strMensagemHtml
	* @access private
	*/
	private $strMensagemHtml;
	
   /**
	* @var string $strMensagemTexto
	* @access private
	*/
	private $strMensagemTexto;
   
   /**
	* @var string $strTituloPagina
	* @access private
	*/
	private $strTituloPagina;
   
   /**
	* @var string $strLogotipo
	* @access private
	*/
	private $strLogotipo;

   /**
	* @var string $strAssunto
	* @access private
	*/
	private $strAssunto;
   
   /**
	* @var string $arInformacoes
	* @access private
	*/
	private $strInformacoes;
   
   /**
	* @var string $strTextoChamada
	* @access private
	*/
	private $strTextoChamada;

   /**
	* @var string $strTextoRodape
	* @access private
	*/
	private $strTextoRodape;
	
   /**
	* @var string $strLarguraColunaLabel
	* @access private
	*/
	private $strLarguraColunaLabel;
	
//---------------------------------------------------------------------------------------------	

   /** 
    * Properties:
    */

   /**
	* Método para setar o valor do atributo $strArquivo
	* Sempre informe o caminho completo para o arquivo.
	* @param string $arquivo : Caminho para o arquivo com a formatção da mensagem
	* @return void		 
	* @access public
	*/
		public function SetArquivo($arquivo)
		{
			 $this->strArquivo = (string) $arquivo;				
		}

   /**
	* Método para retornar o valor do atributo $strArquivo
	* @return string $strArquivo
	* @access public
	*/
		public function GetArquivo()
		{
			 return $this->strArquivo;
		} 

   /**
	* Método para setar o valor do atributo $strPagina
	* @param string $pagina : Pagina gerada com o conteúdo do arquivo html informado.
	* @return void		 
	* @access public
	*/
		public function SetPagina($pagina)
		{
			 $this->strPagina = (string) $pagina;				
		}

   /**
	* Método para retornar o valor do atributo $strPagina
	* @return string $strPagina
	* @access public
	*/
		public function GetPagina()
		{
			 return $this->strPagina;
		}

   /**
	* Método para setar o valor do atributo $strMensagemHtml
	* @param string $mensagemHtml : Corpo da mensagem html
	* @return void		 
	* @access public
	*/
		public function SetMensagemHtml($mensagemHtml)
		{
			 $this->strMensagemHtml = (string) $mensagemHtml;				
		}

   /**
	* Método para retornar o valor do atributo $strMensagemHtml
	* @return string $strMensagemHtml
	* @access public
	*/
		public function GetMensagemHtml()
		{
			 return $this->strMensagemHtml;
		} 
	
   /**
	* Método para setar o valor do atributo $strMensagemTexto
	* @param string $mensagemTexto : Mensagem alternativa em formato txt para usuários que não aceitam html.
	* @return void		 
	* @access public
	*/
		public function SetMensagemTexto($mensagemTexto)
		{

			 $this->strMensagemTexto = (string) $mensagemTexto;				
		}

   /**
	* Método para retornar o valor do atributo $strMensagemTexto
	* @return string $strMensagemTexto
	* @access public
	*/
		public function GetMensagemTexto()
		{
			 return $this->strMensagemTexto;
		}
	
   /**
	* Método para setar o valor do atributo $strAssunto
	* @param string $assunto : Assunto da mensagem
	* @return void		 
	* @access public
	*/
		public function SetAssunto($assunto)
		{
			 $this->strAssunto = (string) $assunto;				
		}

   /**
	* Método para retornar o valor do atributo $strAssunto
	* @return string $strAssunto
	* @access public
	*/
		public function GetAssunto()
		{
			 return $this->strAssunto;
		}	

   /**
	* Método para setar o valor do atributo $strTituloPagina
	* @param string $tituloPagina : Título da Página Html
	* @return void		 
	* @access public
	*/
		public function SetTituloPagina($tituloPagina)
		{
			 $this->strTituloPagina = (string) $tituloPagina;				
		}

   /**
	* Método para retornar o valor do atributo $strTituloPagina
	* @return string $strTituloPagina
	* @access public
	*/
		public function GetTituloPagina()
		{
			 return $this->strTituloPagina;
		}
		
   /**
	* Método para setar o valor do atributo $strLogotipo
	* @param string $logotipo : Logotipo do cabeçalho da mensagem
	* @return void		 
	* @access public
	*/
		public function SetLogotipo($logotipo)
		{
			 $this->strLogotipo = (string) $logotipo;				
		}

   /**
	* Método para retornar o valor do atributo $strLogotipo
	* @return string $strLogotipo
	* @access public
	*/
		public function GetLogotipo()
		{
			 return $this->strLogotipo;
		}

   /**
	* Método para setar o valor do atributo $arInformacoes
	* @param string $arInformacoes : Array contendo como chave as labels da mensagem e como valor o conteúdo da mensagem
	* @return void		 
	* @access public
	*/
		public function SetInformacoes($arInformacoes)
		{
			 $this->arInformacoes = $arInformacoes;				
		}

   /**
	* Método para retornar o valor do atributo $arInformacoes
	* @return string $arInformacoes
	* @access public
	*/
		public function GetInformacoes()
		{
			 return $this->arInformacoes;
		}

   /**
	* Método para setar o valor do atributo $strTextoChamada
	* @param string $textoChamada : Texto de chamada da mensagem.
	* @return void		 
	* @access public
	*/
		public function SetTextoChamada($textoChamada)
		{
			 $this->strTextoChamada = (string) $textoChamada;				
		}

   /**
	* Método para retornar o valor do atributo $strTextoChamada
	* @return string $strTextoChamada
	* @access public
	*/
		public function GetTextoChamada()
		{
			 return $this->strTextoChamada;
		}		

   /**
	* Método para setar o valor do atributo $strTextoRodape
	* @param string $textoChamada : Texto do rodape da mensagem.
	* @return void		 
	* @access public
	*/
		public function SetTextoRodape($textoRodape)
		{
			 $this->strTextoRodape = (string) $textoRodape;				
		}

   /**
	* Método para retornar o valor do atributo $strTextoRodape
	* @return string $strTextoRodape
	* @access public
	*/
		public function GetTextoRodape()
		{
			 return $this->strTextoRodape;
		}

   /**
	* Método para setar o valor do atributo $strLarguraColunaLabel (O valor padrão é 30%)
	* @param string $textoChamada : Largura da coluna de labels na tabela de informações.
	* @return void		 
	* @access public
	*/
		public function SetLarguraColunaLabel($larguraColunaLabel)
		{
			 $this->strLarguraColunaLabel = (string) $larguraColunaLabel;				
		}

   /**
	* Método para retornar o valor do atributo $strLarguraColunaLabel
	* @return string $strLarguraColunaLabel
	* @access public
	*/
		public function GetLarguraColunaLabel()
		{
			 return $this->strLarguraColunaLabel;
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
		     $this->IsSMTP();
			 $this->IsHTML(true);
			 $this->WordWrap  = 50;
			 
			 $this->SMTPAuth  = SystemConfig::SMTP_AUTHENTICATION;
			 $this->Host      = SystemConfig::SMTP_PORT;
			 $this->Username  = SystemConfig::SMTP_USER;
			 $this->Password  = SystemConfig::SMTP_PASSWORD;

			 $this->From  	  = SystemConfig::SYSTEM_EMAIL;
			 $this->Priority  = 3;
			  
			 $this->SetArquivo(SystemConfig::PATH . "/Web/Utils/EmailTemplates/default.htm");
			 $this->SetLogotipo(SystemConfig::SYSTEM_URL . SystemConfig::SYSTEM_LOGO);
			 $this->SetTituloPagina(SystemConfig::COMPANY_NAME);
			 $this->SetPagina("");
			 $this->SetMensagemHtml("");
			 $this->SetMensagemTexto("");
			 $this->SetAssunto("");
			 $this->SetInformacoes("");
			 $this->SetTextoChamada("");
			 $this->SetLarguraColunaLabel("30%");
			 
			 // Configurando o rodapé do e-mail:
			 $strRodape = "<strong>".SystemConfig::COMPANY_NAME . "</strong><br />";
			 $strRodape.= SystemConfig::COMPANY_ADDRESS    . "<br />";
			 $strRodape.= "Central de Atendimento: " . SystemConfig::COMPANY_PHONE      . "<br />";
			 $strRodape.= "Visite nosso site: <a href=\"http://" . SystemConfig::COMPANY_SITE . "\">";
			 $strRodape.= SystemConfig::COMPANY_SITE       . "</a>";
			 
			 $this->SetTextoRodape($strRodape);
		}

   /**
	* Carrega o conteúdo do arquivo html para a memória
	* @return void
	* @access private
	*/
		private function LoadPagina()
		{
		     try
			 {
				 $objFile = new File($this->GetArquivo());
				 
				 if($objFile->exists())
				 {			 
					 // Ativando o buffer de saída:
				     // Mais detalhes em: http://www.php.net/manual/pt_BR/function.ob-start.php
				     ob_start(); 
					 
					 require($this->GetArquivo());
					 
					 // Mais detalhes em: http://www.php.net/manual/pt_BR/function.ob-get-contents.php
				     $this->SetPagina(ob_get_contents());
				 
					 // Limpando o buffer de saída
					 // Mais detalhes em: http://www.php.net/manual/pt_BR/function.ob-end-clean.php
					 ob_end_clean(); 
				 }
			 }
			 catch(Exception $e)
			 {
			     throw $e;
			 }
		}

   /**
	* Formata as informações passadas em uma tabela para exibição
	* @return string
	* @access private
	*/
		private function FormatarInformacoes()
		{
		     if(is_array($this->GetInformacoes()))
			 {
				 $strInformacoes = "<table border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";
			 
			     // Auxiliar para alternar as cores das linhas:
				 $blnAux = true;
				 
				 foreach($this->GetInformacoes() as $strLabel => $strConteudo)
				 {
					 // Alternando as cores das linhas
					 if($blnAux) 
					 { 
						 $strEstiloLinha = "stlCor1"; 
						 $blnAux = false; 
					 } 
					 else 
					 { 
						 $strEstiloLinha = "stlCor2"; 
						 $blnAux = true; 
					 }
					 
					 $strInformacoes.= "<tr>\n";
					 $strInformacoes.= "<td class=\"".$strEstiloLinha."\" width=\"".$this->GetLarguraColunaLabel()."\">";
					 $strInformacoes.= "<strong>".$strLabel.":</strong></td>\n";
					 $strInformacoes.= "<td class=\"".$strEstiloLinha."\">".$strConteudo."</td>\n";
					 $strInformacoes.= "</tr>\n";				 
				 }
				 
				 $strInformacoes.= "</table>";
				 
				 return $strInformacoes;
			 }
			 else
			 {
			     throw new EmailContatoException("As informações não foram setadas corretamente.");
			 }			 
		}
   
   /**
	* Formata a mensagem com os dados informados
	* @return void
	* @access private
	*/
		private function Formatar()
		{
		     // Substituindo os delimitadores:
			 $strMensagem = str_replace("_tituloPagina_", $this->GetTituloPagina(), $this->GetPagina());
			 $strMensagem = str_replace("_logotipo_", $this->GetLogotipo(), $strMensagem);
			 $strMensagem = str_replace("_assunto_", ":: ".$this->GetAssunto(), $strMensagem);
			 $strMensagem = str_replace("_textoChamada_", $this->GetTextoChamada(), $strMensagem);
			 $strMensagem = str_replace("_textoRodape_", $this->GetTextoRodape(), $strMensagem);
			 $strMensagem = str_replace("_url_", SystemConfig::SYSTEM_URL, $strMensagem);

			 // Se $this->arInformacoes foi preechido, então construa a tabela de exibição:
			 if(is_array($this->GetInformacoes()) and sizeof($this->GetInformacoes()) > 0)
			 {
			     $strMensagem = str_replace("_informacoes_",$this->FormatarInformacoes(),$strMensagem);
			 }
			 
			 // Senão coloque os dados setados em $this->strMensagemHtml:
			 elseif($this->GetMensagemHtml())
			 {
			     $strMensagem = str_replace("_informacoes_",$this->GetMensagemHtml(),$strMensagem);
			 }
			 
			 // Nenhum conteúdo informado
			 else
			 {
			     return false;
			 }
			 
			 return $strMensagem;
		}
		
   /**
	* Configura o e-mail para envio
	* @return boolean
	* @access public
	*/
		public function Configurar()
		{
             // Carregando o conteúdo do papel de carta:
			 $this->LoadPagina();
			 
			 // Setando o assunto do e-mail:
			 $this->Subject = $this->GetAssunto();
			 
			 // Setando a página html
			 $this->Body = $this->Formatar();
			 			 			 
			 // Se um conteúdo alternativo em txt foi informado:
			 $this->AltBody = $this->GetMensagemTexto();
			 			 
			 // Se nem a mensagem html nem a mensagem txt foram informadas: 
			 if(empty($this->Body) and empty($this->AltBody))
			 {
			     throw new EmailContatoException("Mensagem de e-mail sem conteúdo");
			 } 
        }
   
   /**
	* Envia a mensagem de e-mail
	* @return boolean
	* @access public
	*/
		public function Enviar()
		{
		    try
			{
			    $this->Configurar();
				 
				if($this->Send())
				{
				    return true;
				}
				else
				{
				    throw new EmailContatoException("Falha ao enviar a mensagem (".$this->ErrorInfo.")");			 
				}
			}
			catch(Exception $e)
			{
			    throw $e;
			}
		}
}
