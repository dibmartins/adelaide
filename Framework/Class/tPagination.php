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
 * @version 1.0 - 2009-04-17 10:21:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class PaginationException extends Exception{}

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
 * Classe de geração de paginação
 * @package Framework
 * @subpackage Pagination
 * @version 1.0 - 2009-04-17 10:21:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class Pagination
{
    /** 
     * Attributes:
     */   
   
    /**
     * Nome do script que solicita a paginação
     * @var string
     * @access private
     */
         private $strScript;

    /**
     * número de links para páginas visíveis
     * @var int
     * @access private
     */
         private $intMaxLinks;
	 
    /**
     * número de registros por página
     * @var int
     * @access private
     */
         private $intEntriesPerPage;	 

    /**
     * número total de páginas
     * @var int
     * @access private
     */
         private $intTotalPages;

    /**
     * número total de registros
     * @var int
     * @access private
     */
         private $intTotalRows;

    /**
     * Variável que irá representar as páginas na query string
     * @var string
     * @access private
     */
         private $strQueryStringVar;

    /**
     * Folha de estilos da paginação
     * A folha precisa respeitar a nomeclatura
     * da folha padrão Web/Css/pagination.css
     * @var string
     * @access private
     */
         private $strStyleSheet;		 
   
    /**
     * Se verdadeiro ativa a paginação via Ajax
     * O método javascript de callback a ser implementado é GoToPage(strPage)
     * que deve receber como parâmetro o número (criptografado) da página
     * @var boolean
     * @access private
     */
         private $blnAjaxMode;   

    /**
     * Método a ser chamado no modo ajax
     * @var string
     * @access private
     */
         private $strAjaxCallBack;    
   
//---------------------------------------------------------------------------------------------	
	
   /** 
    * Properties:
    */

   /**
    * Método para setar o valor do atributo $strScript
    * @return void		 
    * @access public
    */
	public function SetScript($strScript)
	{
	    $this->strScript = $strScript;
	}
    
    /**
     * Método para retornar o valor do atributo $strScript
     * @return string $strScript
     * @access public
     */
	public function GetScript()
	{
	    return $this->strScript;
	} 

   /**
    * Método para setar o valor do atributo $intMaxLinks
    * @return void		 
    * @access public
    */
	public function SetMaxLinks($intMaxLinks)
	{
	    $this->intMaxLinks = $intMaxLinks;
	}
    
    /**
     * Método para retornar o valor do atributo $strScript
     * @return string $intMaxLinks
     * @access public
     */
	public function GetMaxLinks()
	{
	    return $this->intMaxLinks;
	} 

   /**
    * Método para setar o valor do atributo $intEntriesPerPage
    * @return void		 
    * @access public
    */
	public function SetEntriesPerPage($intEntriesPerPage)
	{
	    $this->intEntriesPerPage = $intEntriesPerPage;
	}
    
    /**
     * Método para retornar o valor do atributo $intEntriesPerPage
     * @return string $intEntriesPerPage
     * @access public
     */
	public function GetEntriesPerPage()
	{
	    return $this->intEntriesPerPage;
	}

   /**
    * Método para setar o valor do atributo $this->intTotalPages
    * @return void		 
    * @access public
    */
	public function SetTotalPages($intTotalPages)
	{
	    $this->intTotalPages = $this->intTotalPages;
	}
    
    /**
     * Método para retornar o valor do atributo $this->intTotalPages
     * @return string $this->intTotalPages
     * @access public
     */
	public function GetTotalPages()
	{
	    return $this->intTotalPages;
	}

   /**
    * Método para setar o valor do atributo $this->intTotalRows
    * @return void		 
    * @access public
    */
	public function SetTotalRows($intTotalRows)
	{
	    $this->intTotalRows = $intTotalRows;
	}
    
    /**
     * Método para retornar o valor do atributo $this->intTotalRows
     * @return string $this->intTotalRows
     * @access public
     */
	public function GetTotalRows()
	{
	    return $this->intTotalRows;
	}

   /**
    * Método para setar o valor do atributo $intEntriesPerPage
    * @return void		 
    * @access public
    */
	public function SetQueryStringVar($strQueryStringVar)
	{
	    $this->strQueryStringVar = $strQueryStringVar;
	}
    
    /**
     * Método para retornar o valor do atributo $strQueryStringVar
     * @return string $strQueryStringVar
     * @access public
     */
	public function GetQueryStringVar()
	{
	    return $this->strQueryStringVar;
	} 

   /**
    * Método para setar o valor do atributo $intEntriesPerPage
    * @return void		 
    * @access public
    */
	public function SetStyleSheet($strStyleSheet)
	{
	    $this->strStyleSheet = $strStyleSheet;
	}

    /**
     * Método para retornar o valor do atributo $strStyleSheet
     * @return string $strStyleSheet
     * @access public
     */
	public function GetStyleSheet()
	{
	    return $this->strStyleSheet;
	}
 
     /**
     * Método para setar o valor do atributo $blnAjaxMode
     * @return void		 
     * @access public
     */
	public function SetAjaxMode($blnAjaxMode)
	{
	    $this->blnAjaxMode = $blnAjaxMode;
	}
    
    /**
     * Método para retornar o valor do atributo $blnAjaxMode
     * @return string $blnAjaxMode
     * @access public
     */
	public function GetAjaxMode()
	{
	    return $this->blnAjaxMode;
	}
 
    /**
     * Método para setar o valor do atributo $strAjaxCallBack
     * @return void		 
     * @access public
     */
	public function SetAjaxCallBack($strAjaxCallBack)
	{
	    $this->strAjaxCallBack = $strAjaxCallBack;
	}
    
    /**
     * Método para retornar o valor do atributo $strAjaxCallBack
     * @return string $strAjaxCallBack
     * @access public
     */
	public function GetAjaxCallBack()
	{
	    return $this->strAjaxCallBack;
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
	    $this->SetScript(basename($_SERVER['PHP_SELF']));
	    $this->SetStyleSheet(SystemConfig::PAGINATION_STYLESHEET);
	    $this->SetMaxLinks(10);
	    $this->SetEntriesPerPage(10);
	    $this->SetAjaxMode(false);
	    $this->SetAjaxCallback('GoToPage');
	    $this->SetQueryStringVar('page');
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
     * Retorna a página atual
     * @return int
     * @access public
     */
	private function GetPage()
	{
            try
            {
                $objCrypt = new Crypt();
                
                // Se o total de registros por página for o total de registros
                // seta o numero de páginas para 1
                if($this->GetCurrentEntriesPerPage() == $this->intTotalRows)
                {
                    $intPage = 1;                
                }            
                elseif(!$this->GetAjaxMode())
                {
                    $intPage = ((isset($_GET[$this->GetQueryStringVar()]) ? $objCrypt->ShortDecrypt($_GET[$this->GetQueryStringVar()]) : 1));        
                }
                else
                {
                    //implementar...                
                }
                
                return $intPage;
            }
            catch(Exception $e)
            {
                throw $e;
            }
	} 

    /**
     * Retorna a quantidade de registros por página
     * @return int
     * @access public
     */
	public function GetCurrentEntriesPerPage()
	{
            try
            {
                $objCrypt = new Crypt();
                
                if(!$this->GetAjaxMode())
                {
                    $intEntriesPerPage = (int) ((isset($_GET['epp']) ? $objCrypt->ShortDecrypt($_GET['epp']) : $this->GetEntriesPerPage()));
                }
                else
                {
                    //implementar...                
                }
                
                if($intEntriesPerPage == 0)
                {
                    throw new PaginationException('número de registros por página inválido.');
                }
               
                $this->SetEntriesPerPage($intEntriesPerPage);
                
                return $intEntriesPerPage;
            }
            catch(Exception $e)
            {
                throw $e;
            }
	}

    /**
     * Constrói o select para escolha de quantos registros por página
     * @return string
     * @access private
     */
	private function GetSelectEntriesPerPage()
	{
            try
            {
                $objCrypt = new Crypt();
                
                $intEntriesPerPage = $this->GetCurrentEntriesPerPage();
                
                if(!$this->GetAjaxMode())
                {
                    $strOnChangeCallBack = 'window.location.href = \'';
                    $strOnChangeCallBack.= $this->strScript.'?';
                    $strOnChangeCallBack.= $this->strQueryStringVar.'=';
                    $strOnChangeCallBack.= $objCrypt->ShortEncrypt($this->GetPage());
                    $strOnChangeCallBack.= '&epp=\'+this.value;';
                }
                else
                {
                    //implementar...                
                }
                
                $strSel5     = $intEntriesPerPage == 5  ? 'selected' : '';
                $strSel10    = $intEntriesPerPage == 10 ? 'selected' : '';
                $strSel15    = $intEntriesPerPage == 15 ? 'selected' : '';
                $strSel20    = $intEntriesPerPage == 20 ? 'selected' : '';
                $strSel25    = $intEntriesPerPage == 25 ? 'selected' : '';
                $strSel30    = $intEntriesPerPage == 30 ? 'selected' : '';
                $strSel50    = $intEntriesPerPage == 50 ? 'selected' : '';
                $strSelTotal = $intEntriesPerPage == $this->intTotalRows ? 'selected' : '';
                
                $strSelect = '<select class="select-num-rows" onChange="'.$strOnChangeCallBack.'">';
                $strSelect.= '<option '.$strSel5.' value="'.$objCrypt->ShortEncrypt(5).'">5</option>';
                $strSelect.= '<option '.$strSel10.' value="'.$objCrypt->ShortEncrypt(10).'">10</option>';
                $strSelect.= '<option '.$strSel15.' value="'.$objCrypt->ShortEncrypt(15).'">15</option>';
                $strSelect.= '<option '.$strSel20.' value="'.$objCrypt->ShortEncrypt(20).'">20</option>';
                $strSelect.= '<option '.$strSel25.' value="'.$objCrypt->ShortEncrypt(25).'">25</option>';
                $strSelect.= '<option '.$strSel30.' value="'.$objCrypt->ShortEncrypt(30).'">30</option>';
                $strSelect.= '<option '.$strSel50.' value="'.$objCrypt->ShortEncrypt(50).'">50</option>';
                $strSelect.= '<option '.$strSelTotal.' value="'.$objCrypt->ShortEncrypt($this->intTotalRows).'">Todos</option>';
                $strSelect.= '</select>';
                
                return $strSelect;
            }
            catch(Exception $e)
            {
                throw $e;
            }
	}

    /**
     * Retorna o limite inicial de cada página
     * @return int
     * @access public
     */
	public function GetOffset()
	{
            try
            {
                return (($this->GetPage() * $this->GetCurrentEntriesPerPage()) - $this->GetCurrentEntriesPerPage());
            }
            catch(Exception $e)
            {
                throw $e;
            }
	} 

  /**
    * Retorna a paginação de registros de forma genérica pois não
    * se envolve com banco de dados, a paginação pode ser de qualquer
    * meio de armazenamento, banco, xml etc
    * @return string Paginação em formato html
    * @access public
    */
	public function Generate()
	{
	    try
            {
                // Codifica a página por motivos de segurança
                $objCrypt = new Crypt();                
                
                $strPagination = '<div class="page-numbers"><ul>';
                $strPagination .= '<span class="page-num-rows">Exibir #'.$this->GetSelectEntriesPerPage().'</span>';
                
                // Obtém o total de páginas arredondado
                $this->intTotalPages = ceil($this->intTotalRows / $this->GetCurrentEntriesPerPage()); 
                
                $strLinkEpp = '&epp='.$objCrypt->ShortEncrypt($this->GetCurrentEntriesPerPage());
                
                if($this->intTotalPages != 1)
                {
                    // Obtém a página atual seja via ajax ou via GET
                    $intPage = $this->GetPage();
                    
                    //É o topo do link
                    $intMaxLinksMarker = $this->intMaxLinks + 1;            
    
                    //É o início
                    $intH = 1;       
                    
                    //É o bloco de links na página
                    //quando este é um inteiro nós precisamos de um novo bloco de link
                    $mxdLinkBlock = (($intPage - 1) / $this->intMaxLinks);
                    
                    //se a página é maior do que o topo do loop e o bloco de links
                    //é um inteiro
                    if(($intPage >= $intMaxLinksMarker) && (is_int($mxdLinkBlock)))
                    {
                        //reseta o topo do loop para um novo bloco de link
                        $intMaxLinksMarker = $intPage + $this->intMaxLinks;
                        
                        //seta a base do loop
                        $intH    = $intMaxLinksMarker - $this->intMaxLinks;
                        $intPrev = $intH - 1;                                                                    
                    }
                    
                    //se não é um inteiro ainda estamos entre um link de bloco
                    elseif(($intPage >= $intMaxLinksMarker)&&(!is_int($mxdLinkBlock)))
                    {
                        //arredonda o link de blocos para cima
                        $intRoundUp    = ceil($mxdLinkBlock);
                        $intNewTopLink = $intRoundUp * $this->intMaxLinks;
                            
                        //seta o topo do loop para o link top
                        $intMaxLinksMarker = $intNewTopLink + 1;
                            
                        //e a base do loop para links top - max 
                        $intH    = $intMaxLinksMarker - $this->intMaxLinks;
                        $intPrev = $intH - 1;                            
                    }
                    
                    //Se maior do que o número total de páginas então seta o topo
                    //do loop para $this->intTotalPages
                    if($intMaxLinksMarker > $this->intTotalPages)
                    {
                        $intMaxLinksMarker = $this->intTotalPages + 1;
                    }
                    
                    //links para primeiro e anterior
                    if($intPage > '1')
                    {
                        $strPage  = $objCrypt->ShortEncrypt($intPage - 1);
                    
                        // Monta o link para os botões inicio e anterior.
                        $strStartURL = $this->strScript.'?'.$this->strQueryStringVar.'='.$objCrypt->ShortEncrypt(1).$strLinkEpp;
                        $strPrevURL  = $this->strScript.'?'.$this->strQueryStringVar.'='.$strPage.$strLinkEpp;
                        
                        $strPagination .= '<li class="current"><a href="'.$strStartURL.'">In&iacute;cio</a></li>';
                        $strPagination .= '<li class="current"><a href="'.$strPrevURL.'">Anterior</a></li>';
                    }
                    else
                    {
                        $strPagination .= '<li class="desable">In&iacute;cio</li>';
                        $strPagination .= '<li class="desable">Anterior</li>';
                    }		
                    
                    //link para o bloco de links anterior
                    $intPrevStart = $intH - $this->intMaxLinks; 
                    $intPrevEnd   = $intH - 1;
                    
                    if($intPrevStart <= 1)
                    {
                        $intPrevStart = 1;
                    }
                    
                    $intPrevBlock = $intPrevStart . ' a ' . $intPrevEnd;
                    
                    if($intPage > $this->intMaxLinks)
                    {
                        $strPrev = $objCrypt->ShortEncrypt($intPrev);
                        
                        $strPagination .= '<li class="current"><a href="'.$this->strScript.'?'.$this->strQueryStringVar.'='.$strPrev.$strLinkEpp.'">'.$intPrevBlock.'</a></li>';
                    }
                    
                    //loop pelos resultados
                    for($i = $intH; $i < $intMaxLinksMarker; $i++)
                    {
                        if($i == $intPage)
                        {
                            $strPagination.= '<li><a class="current">'.$i.'</a></li>';
                        }
                        else
                        {
                            $strI = $objCrypt->ShortEncrypt($i);
                            
                            $strPagination.= '<li><a href="'.$this->strScript.'?'.$this->strQueryStringVar.'='.$strI.$strLinkEpp.'">'.$i.'</a></li>';
                        }
                    }
                    
                    //link para o próximo bloco de links
                    $intNextStart = $intMaxLinksMarker; 
                    $intNextEnd   = $intMaxLinksMarker + $this->intMaxLinks;
                    
                    if($intNextEnd >= $this->intTotalPages)
                    {
                        $intNextEnd = $this->intTotalPages;
                    }
                    
                    $strNextBlock = $intNextStart . ' a ' . $intNextEnd;
                    
                    if($this->intTotalPages > $intMaxLinksMarker - 1)
                    {
                        $strMaxLinksMarker = $objCrypt->ShortEncrypt($intMaxLinksMarker);
                        
                        $strPagination .= '<li class="current"><a href="'.$this->strScript.'?'.$this->strQueryStringVar.'='.$strMaxLinksMarker.$strLinkEpp.'">'.$strNextBlock.'</a></li>';
                    }
                    
                    //link para próxima e última página
                    if(($intPage >= '1') && ($intPage != $this->intTotalPages))
                    {
                        $strNextPage   = $objCrypt->ShortEncrypt($intPage + 1);
                        $strTotalPages = $objCrypt->ShortEncrypt($this->intTotalPages);
                       
                        // Monta o link para os botões final e próximo.
                        $strNextURL  = $this->strScript.'?'.$this->strQueryStringVar.'='.$strNextPage.$strLinkEpp;
                        $strFinalURL = $this->strScript.'?'.$this->strQueryStringVar.'='.$strTotalPages.$strLinkEpp;
                        
                        $strPagination .= '<li class="current"><a href="'.$strNextURL.'">Pr&oacute;xima</a></li>';
                        $strPagination .= '<li class="current"><a href="'.$strFinalURL.'">Final</a></li>';
                    }
                    else
                    {
                        $strPagination .= '<li class="desable">Pr&oacute;xima</li>';
                        $strPagination .= '<li class="desable">Final</li>';
                    }		
                    
                }
                
                $strPagination .= '</ul>';
                $strPagination .= '</div>';
                $strPagination .= '<span class="page-info">P&aacute;gina ' . $this->GetPage() . ' de ' . $this->intTotalPages.'</span>';
                
                return($strPagination);
            }
            catch(Exception $e)
            {
                throw $e;
            }
        }
}