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
 * Classe de geração de relatórios gráficos no formato pdf
 * @package Framework
 * @subpackage Reports
 * @version 1.0 - 2006-11-14 13:36:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class ReportPDF extends Report
{
   
   /** 
    * Attributes:
    */

   /**
    * Instancia da classe PDF
    * @var 	$strTitle
	* @access 	private
	*/		
	private $objPDF;
	
   /**
    * Orientação do papel
    * @var 	$strOrientation
	* @access 	private
	*/		
	private $strOrientation;	

   /**
    * Array de configuração das tabelas do relatório
    * @var 	$arTableConfig
	* @access 	private
	*/		
	private $arTableConfig;	

   /**
    * Texto inicial
    * @var 	$strInitialText
	* @access 	private
	*/		
	private $strInitialText;

   /**
    * Tabela inicial
    * @var 	$strInitialTable
	* @access 	private
	*/		
	private $strInitialTable;

//---------------------------------------------------------------------------------------   

   /** 
    * Properties:
    */

   /**
	* Método para setar o valor do atributo $objPDF
	* @return void		 
	* @access public
	*/
		public function SetPDF(PDF $objPDF)
		{
			 $this->objPDF = $objPDF;
		}

   /**
	* Método para retornar o valor do atributo $objPDF
	* @return string $objPDF
	* @access public
	*/
		public function GetPDF()
		{
			 return $this->objPDF;
		} 

   /**
	* Método para setar o valor do atributo $strOrientation
	* @param string $strOrientation Orientação do papel: 'portrait' default (retrato), ou 'landscape' (paisagem)
	* @return void		 
	* @access public
	*/
		public function SetOrientation($strOrientation)
		{
			 $this->strOrientation = $strOrientation;
		}

   /**
	* Método para retornar o valor do atributo $strOrientation
	* @return string $strOrientation
	* @access public
	*/
		public function GetOrientation()
		{
			 return $this->strOrientation;
		}

   /**
	* Método para setar o valor do atributo $arTableConfig
	* @param string $arTableConfig
	* @return void		 
	* @access public
	*/
		public function SetTableConfig($arTableConfig)
		{
			 $this->arTableConfig = $arTableConfig;
		}

   /**
	* Método para retornar o valor do atributo $arTableConfig
	* @return string $arTableConfig
	* @access public
	*/
		public function GetTableConfig()
		{
			 return $this->arTableConfig;
		}

   /**
	* Método para setar o valor do atributo $strInitialText
	* @param string $strInitialText Texto a ser exibido no início do relatório
	* @return void		 
	* @access public
	*/
		public function SetInitialText($strInitialText)
		{
			 $this->strInitialText = $strInitialText;
		}

   /**
	* Método para retornar o valor do atributo $strInitialText
	* @return string $strInitialText
	* @access public
	*/
		public function GetInitialText()
		{
			 return $this->strInitialText;
		}

   /**
	* Método para setar o valor do atributo $strInitialTable
	* @param string $strInitialTable Tabela a ser exibida no início do relatório
	* @return void		 
	* @access public
	*/
		public function SetInitialTable($strInitialTable)
		{
			 $this->strInitialTable = $strInitialTable;
		}

   /**
	* Método para retornar o valor do atributo $strInitialTable
	* @return string $strInitialTable
	* @access public
	*/
		public function GetInitialTable()
		{
			 return $this->strInitialTable;
		}

//---------------------------------------------------------------------------------------   
   
   /** 
    * Methods:
    */
   
   /**
	* Método construtor da classe
	* @param string $strOrientation Orientação do papel: 'portrait' default (retrato), ou 'landscape' (paisagem)
	* @return void
	* @access public
	*/
	    public function __construct($strOrientation = 'portrait')
	    {	
		    parent::__construct();
			
			$objPDF = & new PDF('a4', $strOrientation);
			
			$this->SetPDF($objPDF);	
			$this->SetOrientation($strOrientation);
			
			// Setando as configurações das tabelas do relatório
            $arOptions = array( 'shaded'             => 1,
								'showLines'          => 1,
								'shadeCol'           => array(0.9,0.9,0.9),
								'shadeCol2'          => array(0.7,0.7,0.7),
								'fontSize'           => 8,
								'titleFontSize'      => 10,
								'titleGap'           => 5,
								'lineCol'            => array(0,0,0),
								'gap'                => 5,
								'xPos'               => 'centre',
								'xOrientation'       => 'centre',
								'showHeadings'       => 1,
								'textCol'            => array(0,0,0),
								'width'              => 0,
								'maxWidth'           => 0,
								'cols'               => array(),
								'minRowSpace'        => -100,
								'rowGap'             => 2,
								'colGap'             => 5,
								'innerLineThickness' => 1,
								'outerLineThickness' => 1,
								'splitRows'          => 0,
								'protectRows'        => 1);

			$this->SetTableConfig($arOptions);
			$this->SetInitialText("");
			$this->SetInitialTable("");
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
	* Verifica se o logotipo informado é um arquivo PNG, se for copia para o diretorio temporário,
	* se não for então ele é convertido para esse formato, feito isso a imagem é movida para o diretório 
	* temporário setado em parent::GetTempDir()
	* @param string $strOriginalImage Imagem Original a ser copiada para o diretório temporário
	* @return object $objGraph instância inicializada do tipo informado em $this->SetGraphType()
	* @access public
	*/
	    public function CreateTempImage($strOriginalImage)
	    {
		    try
			{
				$objFile = new File($strOriginalImage);
				
				if($objFile->Extension() == 'png')
				{
					// Obtendo o nome da cópia temporária:
					$strTempImage = parent::GetTempDir() . $objFile->Name();
					
					// Copiando o arquivo para o diretório temporário:
					$objFile->Copy($strTempImage);
				}
				else
				{
					// O arquivo não é uma imagem png. convertendo... 
					$objImageConverter = new ImageConverter($strOriginalImage, 'png');
					
					// Obtendo o nome do arquivo convertido:
					$strPngImage = $objFile->Path() . "/" . $objFile->Name(false) . ".png";
					
					// Instanciando o objeto File com o arquivo png gerado:
					$objFile = new File($strPngImage);
					
					// Obtendo o nome do arquivo temporário a ser gerado:
					$strTempImage = parent::GetTempDir() . $objFile->UniqueName() . ".png";
					
					// Copiando o arquivo png para o diretório temporário:
					$objFile->Copy($strTempImage);
					
					// Deletando o png criado no diretório do arquivo original:
					$objFile->Delete();
				}
				
				// Retornando o arquivo temporário gerado:
				return $strTempImage;
			}
			catch(Exception $e)
			{
			    throw new ReportException($e->GetMessage());
			}	
		}

   /**
	* Deleta o arquivo especificado do diretório temporário
	* @param string $strFile Arquivo a ser deletado
	* @return void
	* @access public
	*/
	    public function DeleteFile($strFile)
	    {
			try
			{
				$objFile = new File($strFile);
				$objFile->Delete();
			}
			catch(Exception $e)
			{
				throw new ReportException($e->GetMessage());
			}			
		}

   /**
	* Adiciona um logotipo no relatório
	* @return void
	* @access public
	*/
	    private function AddLogo()
	    {
		    $strLogo = parent::GetLogo();
			
			if(!empty($strLogo))
			{
				// Obtendo o arquivo temporário do logotipo:
				$strLogoFile = $this->CreateTempImage(parent::GetLogo());
				
				if($this->GetOrientation() == 'portrait')
				{
					$this->GetPDF()->addPngFromFile($strLogoFile, 30, 760, 120, 0);
				}
				elseif($this->GetOrientation() == 'landscape')
				{
					$this->GetPDF()->addPngFromFile($strLogoFile, 50, 510, 120, 0);
				}
				
				// Apagando o arquivo temporário
				$this->DeleteFile($strLogoFile);
			}	
		}

   /**
	* Adiciona um logotipo no relatório
	* @param string $strLogoFile arquivo di logotipo
	* @return void
	* @access public
	*/
	    private function AddGraph()
	    {
		    if(parent::Graph() != NULL)
			{
				// Salvando o gráfico e obtendo o nome do arquivo:
				$strGraphFile = parent::Graph()->Save(parent::GetTempDir());

				if($this->GetOrientation() == 'portrait')
				{
					$this->GetPDF()->addPngFromFile($strGraphFile, 50, 150, 500, 0);
				}
				elseif($this->GetOrientation() == 'landscape')
				{
					$this->GetPDF()->addPngFromFile($strGraphFile, 170, 75, 500, 0);
				}
				
				// Apagando o arquivo temporário
				$this->DeleteFile($strGraphFile);
			}
		}
		
   /**
	* Adiciona um texto no início do relatório 
	* @return void
	* @access public
	*/
	    private function AddInitialText()
	    {
			 $arInitialText = explode('\n', $this->GetInitialText());
			 
			 if($this->GetOrientation() == 'portrait')
			 {
			     $this->GetPDF()->ezSetY(600);
				 
				 $y = 720;			 
				 foreach($arInitialText as $strLine)
				 {
					 $this->GetPDF()->addText(50, $y, 8, $strLine);
					 $y -= 9;
				 }
			 }
			 elseif($this->GetOrientation() == 'landscape')
			 {
			     $y = 450;			 
				 foreach($arInitialText as $strLine)
				 {
					 $this->GetPDF()->addText(50, $y, 8, $strLine);
					 $y -= 9;
				 }
			 }
		}

   /**
	* Adiciona uma tabela no início do relatório 
	* @return void
	* @access public
	*/
	    private function AddInitialTable()
	    {
			 $arInitialTable = $this->GetInitialTable();
			 
			 if(is_array($arInitialTable[1]) && count($arInitialTable[1]) > 0)
			 {
			     $this->GetPDF()->ezTable($arInitialTable[1], '', $arInitialTable[0], $this->GetTableConfig());
			 }
		}

   /**
	* Adiciona o cabeçalho e o rodapé do relatório:
	* @return void
	* @access public
	*/
	    private function Config()
	    {		
		    $this->GetPDF()->selectFont('../../Framework/Web/Utils/Fonts/Helvetica.afm');
			$this->GetPDF()->ezSetMargins(50, 70, 50, 50);
			
			$all = $this->GetPDF()->openObject();
			$this->GetPDF()->saveState();
			$this->GetPDF()->SetStrokeColor(0, 0, 0, 1);
			
			if($this->GetOrientation() == 'portrait')
			{
			    $this->GetPDF()->ezStartPageNumbers(560, 28, 8, '', '', 1);
				$this->GetPDF()->line(20, 40, 578, 40);
				$this->GetPDF()->line(20, 822, 578, 822);
				$this->GetPDF()->addText(50, 810, 8, parent::GetHeader());
				$this->GetPDF()->addText(50, 28, 8, parent::GetFooter());
				
				// Adicionando a hora de geração do relatório:
				$this->GetPDF()->addText(390, 800, 10, parent::CreationDate());
				
			}
			elseif($this->GetOrientation() == 'landscape')
			{
			    $this->GetPDF()->ezStartPageNumbers(790, 28, 8, '', '', 1);
				$this->GetPDF()->line(20, 40, 815, 40);
				$this->GetPDF()->line(20, 570, 815, 570);
				$this->GetPDF()->addText(50, 560, 8, parent::GetHeader());
				$this->GetPDF()->addText(50, 28, 8, parent::GetFooter());
				
				// Adicionando a hora de geração do relatório:
				$this->GetPDF()->addText(600, 550, 10, parent::CreationDate());
			}	
				
			$this->GetPDF()->restoreState();
			$this->GetPDF()->closeObject();
			$this->GetPDF()->addObject($all,'all');
		}

   /**
	* Gera a listagem de registros em uma tabela
	* @param string $strSQL Comando sql com os dados a serem exibidos no relatório
	* @return object $objGraph instância inicializada do tipo informado em $this->SetGraphType()
	* @access public
	*/
	    public function AddList($strSQL)
	    {
			if(empty($strSQL))
			{
				throw new ReportException("Fonte SQL não informada.");
			}

			// Quebrando a página
			$this->GetPDF()->ezNewPage();
			
			// Obtendo a conexão com o servidor de banco de dados:
			$objDBServer = AdoFactory::Server();
			
			// Realizando a consulta:
			$objRecordSet = $objDBServer->Query($strSQL, "array");
			
			$this->GetPDF()->ezTable($objRecordSet->GetRecordSet(), '', parent::GetTitle(), $this->GetTableConfig());
		}

   /**
	* Gera o relatório no formato PDF
	* @param string $strSQL Comando sql com os dados a serem exibidos no relatório
	* @return object $objGraph instância inicializada do tipo informado em $this->SetGraphType()
	* @access public
	*/
	    public function Generate($strSQL)
	    {
		    try
			{
				// Configurando a página do relatório:
				$this->Config();
				
				// Adicionando o logotipo do locatário:
				$this->AddLogo();
				
				// Adicionando o texto inicial:
				$this->AddInitialText();
				
				// Adicionando a tabela inicial:
				$this->AddInitialTable();
				
				// Adicionando o gráfico:
				$this->AddGraph();
				
                // Adicionando a listagem de registros:
                $this->AddList($strSQL); 
				
				// Gerando o arquivo PDF:
				$this->GetPDF()->ezStream();
				
			}
			catch(Exception $e)
			{
			    throw new ReportException($e->GetMessage());
			}	
		}
}
