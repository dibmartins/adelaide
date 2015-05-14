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
 * @version 1.0 - 2006-09-08 11:52:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class AdoRecordSetException extends Exception{}

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
 * Classe de manipulação de recordSets
 * Um objeto RecordSet é criado recebendo o retorno do método Query() 
 * de classes que herdam de AdoConnection, como AdoMysql, eles não podem ser criados separadamente.
 * @package Framework
 * @subpackage Ado
 * @final Atenção! Esta classe não pode ser herdada.
 * @version 1.0 - 2006-09-08 11:52:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 * @see AdoMysql::Query()
 */
final class AdoRecordSet implements ArrayAccess, IteratorAggregate
{
   /** 
    * Attributes:
    */
   
   /**
	* @var array string $arRecordSet
	* @access private
	*/	
	private $arRecordSet;
	
   /**
	* @var int $intPosition
	* @access private
	*/	
	private $intIndex;
	
   /**
	* @var int $intSize
	* @access private
	*/	
	private $intSize;

   /**
	* @var array string $arFields
	* @access private
	*/	
	private $arFields;
	
   /**
	* @var string $strDataBase
	* @access private
	*/	
	private $strDataBase;	

   /**
	* @var string $strSql
	* @access private
	*/	
	private $strSql;
	
   /**
	* @var string $strServerInfo
	* @access private
	*/	
	private $strServerInfo;		
		
   
//---------------------------------------------------------------------------------------   
   
   /** 
    * Properties:
    */
   
   /**
	* Método para setar o valor do atributo $arRecordSet
	* @param array $arRecordSet Array com os campos e valores de cada registro da consulta
	* @param array $blnFormat Se true irá formatar os campos da consulta (Atenção! Essa opção habilitada em grandes consultas compromete seu desempenho)
	* @return void		 
	* @access public
	*/
		public function SetRecordSet($arRecordSet, $blnFormat = true)
		{
            $this->arRecordSet = $blnFormat ? $this->Format($arRecordSet) : $arRecordSet;
            $this->SetSize(count($arRecordSet));			 	 
		}

   /**
	* Método para retornar o valor do atributo $arRecordSet
	* @return string $arRecordSet
	* @access public
	*/
		public function GetRecordSet()
		{
			 return $this->arRecordSet;
		}   
   
   /**
	* Método para setar o valor do atributo $intIndex. 
	* Move o Index do recordSet para a posição informada
	* @param int $intIndex Posição atual do recordSet
	* @return void		 
	* @access public
	*/
		public function SetIndex($intIndex)
		{
			if($this->ValidIndex($intIndex))
			{
			    $this->intIndex = $intIndex;
			}
		}

   /**
	* Método para retornar o valor do atributo $intIndex
	* @return int $intIndex
	* @access private
	*/
		public function GetIndex()
		{
			 return $this->intIndex;
		}   

   /**
	* Método para setar o valor do atributo $intSize
	* @param int $intSize Tamanho do recordSet
	* @return void		 
	* @access private
	*/
		private function SetSize($intSize)
		{
			 $this->intSize = $intSize;
		}

   /**
	* Método para retornar o valor do atributo $intSize
	* @return int $intSize
	* @access public
	*/
		public function GetSize()
		{
			 return $this->intSize;
		}
		
   /**
	* Método para setar o valor do atributo $arFields
	* @param array $arFields Array com as informações de todos os campos da consulta
	* @return void		 
	* @access public
	*/
		public function SetFields($arFields)
		{
			 if(is_array($arFields))
			 {
			     $this->arFields = $arFields;
			 }
			 else
			 {
			     throw new AdoRecordSetException('Campos inválidos');
			 }			
		}

       /**
	* Método para retornar o valor do atributo $arFields
	* @param boolean $blnOnlyFieldName Se true retornará somente o nome dos campos
	* @return string $arFields
	* @access public
	*/
		public function GetFields($blnOnlyFieldName = false)
		{
			if($blnOnlyFieldName)
                        {
                           $arFieldsNames = array();
                           
                           foreach($this->arFields as $arField)
                           {
                              $arFieldsNames[] = $arField['name'];   
                           }
                           
                           return $arFieldsNames;
                        }
                        else
                        {
                           return $this->arFields;
                        }
		}

   /**
	* Método para setar o valor do atributo $strDataBase
	* @param string $strDataBase Banco de dados que foi realizada a consulta
	* @return void		 
	* @access private
	*/
		public function SetDataBase($strDataBase)
		{
			 $this->strDataBase = $strDataBase;
		}

   /**
	* Método para retornar o valor do atributo $strDataBase
	* @return int $strDataBase
	* @access public
	*/
		public function GetDataBase()
		{
			 return $this->strDataBase;
		}

   /**
	* Método para setar o valor do atributo $strSql
	* @param string $strSql Comando Sql
	* @return void		 
	* @access private
	*/
		public function SetSql($strSql)
		{
			 $this->strSql = $strSql;
		}

   /**
	* Método para retornar o valor do atributo $strSql
	* @return int $strSql
	* @access public
	*/
		public function GetSql()
		{
			 return $this->strSql;
		}		
   
   /**
	* Método para setar o valor do atributo $strServerInfo
	* @param string $strServerInfo Informações do servidor
	* @return void		 
	* @access private
	*/
		public function SetServerInfo($strServerInfo)
		{
			 $this->strServerInfo = $strServerInfo;
		}

   /**
	* Método para retornar o valor do atributo $strServerInfo
	* @return int $strServerInfo
	* @access public
	*/
		public function GetServerInfo()
		{
			 return $this->strServerInfo;
		}   
   
//---------------------------------------------------------------------------------------

   /** 
    * Methods:
    */

   /**
	* Método construtor da classe
	* @param string $arRecordSet Array com os campos e valores de cada registro da consulta
	* @return void
	* @access public
	*/
	    public function __construct()
	    {	
			$this->SetSize(count($this->GetRecordSet()));
			$this->SetIndex(0);
			$this->SetServerInfo("");
			$this->SetSql("");			
	    }
		
   //** Métodos necessários da classe Iterator
   
   /**
	* Método Iterator 
	* @return boolean
	* @access public
	*/  
	    public function OffsetExists($offset)
	    {         
		    if(isset($this->arRecordSet[$offset]))  
			{
			    return true;
			}	
		    else 
			{
			    return false;
			}	
	    }   

   /**
	* Método Iterator 
	* @return boolean
	* @access public
	*/  
	    public function OffsetGet($offset)
	    { 
		    if ($this->OffsetExists($offset))
		    {
			    return $this->arRecordSet[$offset];
		    }	   
		    else 
		    {
			    return (false);
		    }	   
	    }
  
   /**
	* Método Iterator 
	* @return void
	* @access public
	*/  
	    public function OffsetSet($offset, $value)
	    {         
		    if ($offset)  
			{
			    $this->arRecordSet[$offset] = $value;
		    }
			else  
			{
			    $this->arRecordSet[] = $value;
			}	
	    }
  
   /**
	* Método Iterator 
	* @return void
	* @access public
	*/  
	    public function OffsetUnset($offset)
	    {
		    unset ($this->arRecordSet[$offset]);
	    }
  
   /**
	* Método Iterator 
	* @return array
	* @access public
	*/     
        public function GetIterator()
        {
            return new ArrayIterator($this->arRecordSet);
        }
   
   //** Fim dos métodos da classe Iterator

   /**
	* Verifica se um dado índice é válido ou não
	* @param int $intIndex índice a ser validado
	* @return boolean true se for um índice válido, caso contrário false
	* @access public
	*/
	    public function ValidIndex($intIndex)
	    {	

            if(is_int($intIndex) && ( ($intIndex >= 0) && ($intIndex <= $this->GetSize()) )  )
			{
			    return true;
			}
			else
			{
			    throw new AdoRecordSetException($intIndex." não é um índice válido");
			}
	    }

   /**
	* Formata os campos do recordset
	* @param array $arRecordSet Array com os campos e valores de cada registro da consulta
	* @return array
	* @access private
	*/
	    private function Format($arRecordSet)
	    {
		     for($i = 0; $i < count($arRecordSet); $i++)
			 {
			     if(is_object($arRecordSet[$i]))
				 {
				     foreach(array_keys(get_object_vars($arRecordSet[$i])) as $strAttribute)
					 {
					     $arFieldInfo = $this->FieldInfo($strAttribute);
						 
						 switch($arFieldInfo["type"])
						 {
						      case 'blob':	$arRecordSet[$i]->$strAttribute = Utils::BlobFormat($arRecordSet[$i]->$strAttribute);
							  break;
											
						      case 'date':	
						      {
						      	 $objDate = new Date(); 
						      	 $arRecordSet[$i]->$strAttribute = Date::Format($arRecordSet[$i]->$strAttribute, 4);
								 break;
						      }
							  case 'timestamp':
						      case 'datetime' :  $objDate = new Date(); $arRecordSet[$i]->$strAttribute = Date::Format($arRecordSet[$i]->$strAttribute, 2);
									break;

						      case 'real':	$arRecordSet[$i]->$strAttribute = Utils::MoneyFormat($arRecordSet[$i]->$strAttribute, 1);
									break;
												
						      default:		$arRecordSet[$i]->$strAttribute = Utils::TextFormat($arRecordSet[$i]->$strAttribute);
									break;					
						 }
					 }
				 }
				 elseif(is_array($arRecordSet[$i]))
				 {
				     foreach(array_keys($arRecordSet[$i]) as $strAttribute)
					 {
					     $arFieldInfo = $this->FieldInfo($strAttribute);
						 
						 switch($arFieldInfo["type"])
						 {
						     case 'blob':		$arRecordSet[$i][$strAttribute] = Utils::BlobFormat($arRecordSet[$i][$strAttribute]);
												break;
											
							 case 'date':		
							 {
							 	 $objDate = new Date;	
							 	 $arRecordSet[$i][$strAttribute] = Date::Format($arRecordSet[$i][$strAttribute], 4);
							 	 break;
							 }

							 case 'datetime':	
							 {
								 $objDate = new Date;	
								 $arRecordSet[$i][$strAttribute] = Date::Format($arRecordSet[$i][$strAttribute], 2);
							 	 break;
							 }

							 case 'real':		$arRecordSet[$i][$strAttribute] = Utils::MoneyFormat($arRecordSet[$i][$strAttribute], 1);
												break;

                             default:		    $arRecordSet[$i][$strAttribute] = Utils::TextFormat($arRecordSet[$i][$strAttribute], 1);
 												break;												
						 }  
					 }
				 }
			 }
			 
			 return $arRecordSet;
		}

   /**
	* Move o Index do recordSet para sua primeira posição 
	* @return void
	* @access public
	*/
	    public function Restart()
	    {	
		    $this->SetIndex(0);
	    }
		
   /**
	* Indica se o índice está ou não apontado para o primeiro registro
	* @return boolean true se estiver no primeiro registro, caso contrário false.
	* @access public
	*/
	    public function Bof()
	    {	
		    if($this->GetIndex() == 0)
			{
			    return true;
			}
			else
			{
			    return false;
			}
	    }

   /**
	* Indica se o índice está ou não apontado para o último registro
	* @return boolean true se estiver no último registro, caso contrário false.
	* @access public
	*/
	    public function Eof()
	    {	
		    if($this->GetIndex() == ($this->GetSize() - 1))
			{
			    return true;
			}
			else
			{
			    return false;
			}
	    }					
		
   /**
	* Aponta para o registro atual do recordSet
	* @access public
	* @return object Registro atual
	*/
	    public function Current()
	    {
			$arRecordSet = $this->GetRecordSet();
			
			return $arRecordSet[$this->GetIndex()];
		}

   /**
	* Aponta para o primeiro registro do recordSet
	* @access public
	* @return object Primeiro registro
	*/
	    public function First()
	    {
			$arRecordSet = $this->GetRecordSet();
			
			$this->SetIndex(0);
			
			return $arRecordSet[$this->GetIndex()];
		}
		
   /**
	* Aponta para o último registro do recordSet
	* @access public
	* @return object último registro
	*/
	    public function Last()
	    {
		    $arRecordSet = $this->GetRecordSet();
			
			$this->SetIndex($this->GetSize() - 1);
			
			return $arRecordSet[$this->GetIndex()];
		}
		
   /**
	* Aponta para o registro anterior do recordSet
	* @access public
	* @return object Registro anterior, retorna false caso o rs esteja apontando para o primeiro registro.
	*/
	    public function Previous()
	    {
		    // Se o índice não estiver apontando para o primeiro registro retorne o anterior:
			if(!$this->Bof())
			{
			    $arRecordSet = $this->GetRecordSet();
				
				$this->SetIndex($this->GetIndex() - 1);
				
			    return $arRecordSet[$this->GetIndex()];
			}
			else
			{
			    return false;
			}
		}

   /**
	* Aponta para o próximo registro do recordSet
	* @access public
	* @return object Próximo registro, retorna false caso o rs esteja apontando para o último registro.
	*/
	    public function Next()
	    {
			// Se o índice não estiver apontando para o último registro retorne o próximo:
			if(!$this->Eof())
			{
			    $arRecordSet = $this->GetRecordSet();
				
				$this->SetIndex($this->GetIndex() + 1);
				
				return $arRecordSet[$this->GetIndex()];
			}
			else
			{
			    return false;
			}	
		}
		
       /**
	* Move o índice do recordSet para o valor indicado
	* @param int $intIndex Altera o índice atual do recordSet para a posição indicada
	* retornado o registro desta posição
	* @access public
	* @return object Registro atual
	*/
	    public function Search($intIndex)
	    {
               $arRecordSet = $this->GetRecordSet();
                           
               if($intIndex < ($this->GetSize()))
               {
                   $this->SetIndex($intIndex);
                   
                   return $arRecordSet[$intIndex];
               }
               else
               {
                   throw new AdoRecordSetException("índice inexistente na consulta");
               }
            }

       /**
	* Retorna as informações sobre o campo solicitado
	* @param string $strFieldName Nome do campo que se deseja obter as informações
	* @access public
	* @return array Informações do campo
	*/
	    public function FieldInfo($strFieldName)
	    {
			$blnFieldFound = false;
			
			if(!empty($strFieldName))
			{
				foreach($this->GetFields() as $arField)
				{
				   if($arField['name'] == $strFieldName)
				   {
					   $blnFound = true;
					   return $arField;				   
				   }			   
				}
				
				if(!$blnFound)
				{
				    throw new AdoRecordSetException("Campo não encontrado no recordSet");
				}
			}
			else
			{
			    throw new AdoRecordSetException("Nenhum campo informado");
			}	
		} 

       /**
	* Verifica se o recordset possui algum registro
	* @return boolean
	* @access public
	*/
	    public function IsEmpty()
	    {	
		    return ($this->GetSize() > 0) ? false : true;
	    }

       /**
	* Apaga os dados do recordSet
	* @return void
	* @access public
	*/
	    public function Clear()
	    {	
		    $this->SetIndex(0);
			$this->SetSize(0);
			$this->SetRecordSet(NULL);			
	    }

   /**
	* Retorna o recordSet como uma string XML
	* @param string $strSaveToFile (Opcional) arquivo XML onde a string gerada será salva.
	* @param boolean $blnCrypt Se true o conteúdo das tags XML será criptografado
	* @return string RecordSet no formato de string XML 
	* @access public
	*/
	    public function ExportToXML($strSaveToFile = '', $blnCrypt = false)
	    {
		    try
			{
				$objXML = new XML();
	
				$objXML->push('recordSet');
				
				if($blnCrypt) $objCrypt = new Crypt;
				
				foreach($this as $objRecord) 
				{
					$objXML->push('row');
					
					foreach($objRecord as $strField => $strValue) 
					{   
						$strValue = $blnCrypt ? $objCrypt->ShortEncrypt($strValue) : "<![CDATA[".$strValue."]]>";
						
						$objXML->element($strField, $strValue);
					}

					$objXML->pop();
				}
				
				$objXML->pop();
				
				$strXml = $objXML->GetXml();
				
				// Salvando o xml em arquivo:
				if(!empty($strSaveToFile))
				{
				    $objFile = new File($strSaveToFile,'w+');
                    $objFile->Open();
                    $objFile->Write($strXml);
                    $objFile->Close();
				}
				
				return $strXml;
			}
			catch(Exception $e)
			{
			   throw new AdoRecordSetException($e->GetMessage());
			}
		}
		
   /**
	* Exibe o recordSet em uma tabela html
	* A coluna índice sempre é exibida 
	* com o propósito de informar o índice de cada registro no array do recordSet
	* @param $blnReturn se true retorna o grid ao invés de exibi-lo diretamente.
	* @access public
	*/
	    public function Display($blnReturn = false)
	    {
               // Formatando o sql para exibição:
               $strSql  = str_replace("\n","<br>",$this->GetSql());
               
               // Obtendo as informações do servidor de banco de dados:
               $strInfo = $this->GetServerInfo();
               
               // Adicionando 1 ao total de campos da consulta para exibição do índice na tabela:
               $intTotalFields = count($this->GetFields()) + 1;
               
               // Exibindo o cabeçalho:
               $strTable = "<fieldset>";
               $strTable.= "<legend>RecordSet:&nbsp;</legend>";
               
               $strTable.= "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\">";

               // Exibindo a consulta que gerou o recordSet:
               $strTable.= "<tr>";
               $strTable.= "<td colspan=\"".$intTotalFields."\" bgcolor=\"#993333\"  style=\"color:#FFFFFF; font-family: Verdana; font-size: 10px;\">";
               $strTable.= "> ".$strInfo."<br>> Query executada em ".$this->GetDataBase()." - ".date('d/m/Y, H:i:s')." <br>";
               $strTable.= "> ".$this->GetSize()." registro(s) retornado(s)<br>";
               $strTable.= "------------------------------------------------------------------------<br><br>";
               $strTable.= $strSql."</td>";
               $strTable.= "</tr>";
               
               // Exibindo o total de registros do recordSet:
               $strTable.= "<tr>";
               $strTable.= "<td colspan=\"7\" style=\"font-family: Verdana; font-size: 15px;\">&nbsp;</td>";
               $strTable.= "</tr>";
               
               if($this->GetSize() > 0)
               {
                       // Movendo o índice do recordSet para o início:
                       $this->Restart();
                       
                       // Exibindo a linha das colunas:
                       $strTable.= "<tr>";
                       $strTable.= "<td width=\"5%\" align=\"center\" bgcolor=\"#993333\"  style=\"color:#FFFFFF; font-family: Verdana; font-size: 10px; font-weight: bold;\">&Iacute;ndice</td>";
                       
                       foreach($this->GetFields() as $arField)
                       {
                               $strTable.= "<td align=\"center\" bgcolor=\"#E7E2DC\" style=\"color:#666666; font-family: Verdana; font-size: 10px; font-weight: bold;\">";
                               
                               if(in_array("primary_key",$arField['flags'])) { $strTable.= "[PK] "; }
                               
                               $strTable.= $arField['name']." - ".$arField['type']."(".$arField['size'].")";
                               $strTable.= "</td>";
                       }    
                       
                       $strTable.= "</tr>";
                       
                       $i = 0;
                       
                       // Exibindo os registros
                       foreach($this as $objRecord)
                       {
                               if(($i % 2) == 0)
                               {				
                                       $strTable.= "<tr bgcolor=\"#F2F2F2\">";
                               }
                               
                               $strTable.= "<td align=\"center\" style=\"font-family: Verdana; font-size: 10px;\" >";
                               $strTable.= $i;
                               $strTable.= "</td>";
                               
                               foreach($this->GetFields() as $arField)
                               {
                                       $strTable.= "<td align=\"center\" style=\"font-family: Verdana; font-size: 10px;\">";
                                       $strTable.= $objRecord->$arField['name'];
                                       $strTable.= "</td>";
                               }
                               
                               $strTable.= "</tr>";
                               
                               $i++; 
                       }
               }
           
               $strTable.= "</table>";
               $strTable.= "</fieldset>";
                  
               // Movendo o índice do recordSet para o início:
               $this->Restart();
               
               if($blnReturn)
               {
                  return $strTable;                           
               }
               else
               {
                  echo $strTable;
               }                        
	    }		
}
