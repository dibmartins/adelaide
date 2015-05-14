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
 * @subpackage Captcha
 * @version 1.0 - 2009-04-06 10:25:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class CaptchaException extends Exception{}

/**
 * * Adelaide Framework  
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
 * Classe responsável por gerar imagens (captcha) de autenticação de usuários
 * @package Framework
 * @subpackage Captcha
 * @version 1.0 - 2009-04-06 10:25:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class Captcha
{
    /** 
     * Attributes:
     */   
   
//---------------------------------------------------------------------------------------------	
	
    /** 
     * Properties:
     */

//---------------------------------------------------------------------------------------------	
		
   /** 
    * Methods:
    */

   /**
	* Método construtor da classe
	* @return void
	* @access public
	*/
		public function __construct(){}

   /**
	* Método destrutor da classe
	* @return void
	* @access public
	*/
	    private function __destruct()
	    {	
		    unset($this);
	    }

	/**
	 * Gera uma "palavra" randômica
	 * @param int $intSize tamanho da palavra
	 * @static método estático
	 * @return string palavra gerada randômicamente
	 * @access private
     */
		private function MakeRandomWord($intSize)
		{	
			$strWord = '';
			
			for($i = 0; $i < $intSize; $i++) 
			{
				// Sorteio de parte do intervalo da tabela ASCII para alfanuméricos
				$ch = rand(48, 122);
				
				// Remove qualquer símbolo (como ~[) entre as letras e números
				if($ch > 57 && $ch < 65 ||  $ch > 90 && $ch < 97 || 
				
				// Remove zero e letras "O" (maiúsculo e minúsculo)
				$ch == 79 || $ch == 111 || $ch == 48) $i--;
				
				else $strWord .= chr( $ch );
			}
			
			return $strWord;
		}
		
	/**
	 * Exibe a imagem capcha
	 * @return void
	 * @access public
     */
		public function Generate()
		{	
			// Gera o código que será digitado
			$strWord = $this->MakeRandomWord(rand(4, 8));
			
			// Largura e altura da imagem
			$intSizeX = 200;
			$intSizeY = 75;
			
			// Varia a distáncia entre as letras de acordo com a qtd (entre 4 e 8 letras)
			$strSpace = $intSizeX / (strlen($strWord ) + 1);
			
			// Cria a tela de imagem
			$binImage = imagecreatetruecolor($intSizeX, $intSizeY);
			
			// Aloca as cores para o strBackground e para a borda
			$strBackground = imagecolorallocate($binImage, 255, 240, 240); // Clara para o strBackground
			$strBorder = imagecolorallocate($binImage, 50, 50, 50);    // Cinza para borda
			
			// Aloca as cores para as letras e para os traços
			$arColors[] = imagecolorallocate($binImage, 10, 10, 150); // Azul escuro
			$arColors[] = imagecolorallocate($binImage, 150, 10, 10); // Vermelho escuro
			$arColors[] = imagecolorallocate($binImage, 10, 150, 10); // Verde escuro
			
			// Preenche o strBackground
			imagefilledrectangle($binImage, 1, 1, $intSizeX - 2, $intSizeY - 2, $strBackground);
			imagerectangle($binImage, 0, 0, $intSizeX - 1, $intSizeY - 1, $strBorder);
			
			/// Desenha o texto
			for ($i = 0; $i < strlen($strWord ); $i++)
			{
				// Alterna a cor usada para cada letra
				$cor = $arColors[$i % count($arColors)];
				
				// Para cada caracter por vez...
				imagettftext(
					$binImage,
					20 + rand(0, 20),       // Tamanho da fonte (varia entre 20 e 40)
					-20 + rand(0, 40),      // Rotação (0 deixaria a letra em pé)
					($i + 0.3) * $strSpace, // Distáncia da margem esquerda
					50 + rand(0, 10),       // Distáncia do topo (para o centro da letra)
					$cor,                   // Cor escolhida acima
					'../Web/Plugins/jpgraph/fonts/arial.ttf',            // Arquivo de fonte (usar tamanho de arq pequeno)
					$strWord [$i]           // Caracter exibido (poderia ser uma palavra)
				);
			}
			
			// Adiciona suavidade ao contorno da imagem
			//imageantialias($binImage, true);
			
			// Adiciona algumas linhas da mesma cor do texto, provocando distorções
			for ($i = 0; $i < 300; $i++)
			{
				// Margem mínima de 5px (ponto inicial)
				$x1 = rand(5, $intSizeX - 5);
				$y1 = rand(5, $intSizeY - 5);
				
				// Tamanho variável (ponto final)
				$x2 = $x1  + rand(-10, 10);
				$y2 = $y1  + rand(-10, 10);
				
				// Cria a linha (ponto inicial, ponto final e cor)
				imageline($binImage, $x1, $y1, $x2, $y2, $arColors[$i % count($arColors)]);
			}
			
			// Saída para o navegador
			header('Content-type: image/png');
			imagepng($binImage);
	}			 
}