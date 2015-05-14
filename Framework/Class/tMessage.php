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
 * @subpackage Messages
 * @version 1.0 - 2006-10-16 16:17:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class FrameworkMessageException extends Exception{}

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
 * Classe de gerenciamento de mensagens de usuário
 * @package Framework
 * @subpackage Messages
 * @version 1.0 - 2006-10-16 16:17:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class Message
{
   /** 
    * Attributes:
    */   
   
   /**
	* @var string $objException
	* @access private
	*/
	    private $objException;
	
   /**
    * Caractere de nova linha
    * @var   $strNewLine
	* @access private
	*/		
	    private $strNewLine;

//---------------------------------------------------------------------------------------------	
	
   /** 
    * Properties:
    */

   /**
	* Método para setar o valor do atributo $strAction
	* @param string $strAction Objeto do tipo Exception
	* @return void		 
	* @access public
	*/
		public function SetException($objException)
		{
			 $this->objException = $objException;
		}

   /**
	* Método para retornar o valor do atributo $objException
	* @return string $objException
	* @access public
	*/
		public function GetException()
		{
			 return $this->objException;
		}

   /**
	* Método para setar o valor do atributo $strNewLine
	* @return void		 
	* @access public
	*/
		public function SetNewLine($strNewLine)
		{
			 $this->strNewLine = $strNewLine;
		}

   /**
	* Método para retornar o valor do atributo $strNewLine
	* @return string $strNewLine
	* @access public
	*/
		public function GetNewLine()
		{
			 return $this->strNewLine;
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
		    $this->SetException('');
			$this->SetNewLine("\n");
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
	* Insere quebra de linha
	* @param int $intNumNewLine número de quebras de linhas a serem inseridas
	* @return string Quebras de linha
	* @access protected
	*/
	    protected function NewLine($intNumNewLine = 1)
		{
		    $strNewLine = '';
			
			for($i = 0; $i < $intNumNewLine; $i++)
			{
			    $strNewLine .= $this->GetNewLine();
			}
			
			return $strNewLine;
		}

   /**
	* Retorna a string contendo a mensagem
    * @param boolean $blnDebugTrace (Opcional) Exibe ou não o traçado da exceção
	* @return string Mensagem
	* @access public
	*/
	    public function FormatExceptionMessage($blnDebugTrace = true)
	    {
	    	if(!($this->GetException() instanceof Exception))
			{
			    throw new FrameworkMessageException('Nenhuma excessão informada');    
			}
			
			// Se habilitado, exibe todos os arquivos percorridos até a origem do erro
			if($blnDebugTrace)
			{
			    $strDebugTrace = get_class($this->GetException()) .': ';
			    $strDebugTrace.= str_replace('<br>', '\n', $this->GetException()->GetMessage());
				
			    $strDebug = '';
			    
			    foreach(array_reverse($this->GetException()->GetTrace()) as $arError)
			    {
			    	if(!empty($arError['file']))
					{
					    $strDebug .= '> ' . basename($arError['file']).' ';
						$strDebug .= '('.$arError['line'].') => ';
						
						if(!empty($arError['class']))
						{
						    $strDebug .= $arError['class'] .$arError['type'];
						}
						
						$strDebug .= $arError['function'];
						$strDebug .= '(';
						
						$blnHaveParams = false;
						
						// Formata os parâmetros do método:
						if(is_array($arError['args']))
						{
							foreach($arError['args'] as $strParam)
							{
								if(!empty($strParam)) 
								{
									if(is_object($strParam))
									{
										$strParam = get_class($strParam);
									}
									elseif(is_array($strParam))
									{
										$arrValues = array_values($strParam);

										// Se algum dos valores dentro do argumento for um array
										// ou um objeto, converte para uma string								
										for($intI = 0; $intI < count($arrValues); $intI++)
										{
											if(is_array($arrValues[$intI]))
											{
												$arrValues[$intI] = 'Array';
											}
											elseif(is_object($arrValues[$intI]))
											{
												// Exibe o nome da classe do objeto
												$arrValues[$intI] = get_class($arrValues[$intI]);
											}
										}
										
										$strValues = implode(', ', array_values($arrValues));
										$strParam  = "array(".$strValues.")";
									}
								
									$strDebug .= $strParam.", ";
									$blnHaveParams = true;
								}
							}
						}						
						
						// Remove a virgula do último parâmetro:
						if($blnHaveParams)
						{
						    $strDebug = Utils::CutLastChar($strDebug, 2);
						}
						
						
						$strDebug .= ')';
			            
						$strDebug.= $this->NewLine();
					}	
			    }
				
			    $strDebugTrace.= $this->NewLine(2);
				$strDebugTrace.= 'Debug Trace:';
				$strDebugTrace.= $this->NewLine(2);
				$strDebugTrace.= $strDebug;
			}
			else
			{
				$strDebugTrace = NULL;
			}
			
			// Formatando a mensagem:
			$strMessage = $this->GetException()->GetMessage();
			$strMessage = str_replace("&lt;br&gt;","\n", $strMessage);
			
			return array($strMessage, $strDebugTrace);
		}
		
   /**
	* Formata a mensagem do banco de dados
    * @param int $intCode código da mensagem
	* @param string $strMessage Mensagem a ser formatada
	* @return string Mensagem formatada
	* @access public
	*/
	    public function FormatDataBaseMessage($intCode, $strMessage)
	    {
			switch($intCode)
			{
			    case '1062': 
				{
				    $strError = str_replace('Duplicate entry', 'Valor existente', $strMessage);
					$strError = str_replace(' for key', '', $strError); 
					//$strError = Utils::CutLastChar($strError, 1); 
					break;
				}
				case '1265': 
				{
				    $strError = str_replace('Data truncated for column ', 'Valor inválido para o campo ', $strMessage);
					$strError = str_replace(' at row ', '', $strError); 
					$strError = Utils::CutLastChar($strError, 1); 
					break;
				}
				case '1216': 
				case '1217': 
				case '1451': 
				{
				    $strError = 'Não foi possível excluir. '; 
					$strError.= 'Este registro está vinculado com outros registros no sistema.';
					break;
				}
				case '1452': 
				{
				    $strError = 'Não foi possível cadastrar/atualizar. '; 
					$strError.= "Chave estrangeira inválida. \n $strMessage ";
					break;
				}
				default: $strError = $strMessage;  
			}
			
			return $strError;
		}

   /**
	* Exibe a mensagem na tela
	* @param string $strType (Opcional) Tipo de exibição "alert" ou "html"
	* @param string $strUrl (Opcional) URL de redirecionamento em caso de exibição do tipo "alert"
    * @return string Mensagem
	* @access public
	*/
	    public function Display($strType = "alert", $strUrl = NULL)
	    {
	        switch($strType)
			{
			    case "alert":
				{
				    $this->SetNewLine("\\n");
					
					list($strMessage, $strDebugTrace) = $this->FormatExceptionMessage(SystemConfig::MSG_DEBUG_TRACE);
					
					$strAlertMessage = empty($strDebugTrace) ? Utils::UnHTMLEntities($strMessage) : $strDebugTrace;
					
					echo "<script>alert(\"".$strAlertMessage."\");</script>";
					
					if(!is_null($strUrl))
					{
					    echo "<meta http-equiv='refresh' content='0;URL=". $strUrl ."'>";
					}
					
					break;
				}
				case "html":
				{
				   	echo "<pre>";
					print_r($this->FormatExceptionMessage(SystemConfig::MSG_DEBUG_TRACE));
					echo "</pre>";
					break;
				}
			}
		}		
}
