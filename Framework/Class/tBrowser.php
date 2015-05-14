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
 * Classe responsável por detectar o browser do usuário
 * This class is very loosely based on scripts by Gary White
 * @package Framework
 * @subpackage Browser
 * @version 1.0 - 2007-02-06 10:35:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @author Paul Scott
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class Browser 
{
   /** 
    * Attributes:
    */

	/**
	 *
	 * @var string $strName
	 * @access private
	 */
	private $strName = NULL;
	
	/**
	 *
	 * @var string $strVersion
	 * @access private	 
	 */
	private static $strVersion = NULL;
	
	/**
	 *
	 * @var array $strUserAgent
	 * @access private	 
	 */
	private static $strUserAgent = NULL;
	
	/**
	 *
	 * @var string $strPlatform
	 * @access private	 
	 */
	private static $strPlatform;
	
	/**
	 *
	 * @var string aol
	 * @access private
	 */
	private static $strAol = false;
	
	/**
	 * @var string browser
	 * @access private
	 */
	private static $strBrowserType;

//---------------------------------------------------------------------------------------   

   /** 
    * Properties:
    */

//---------------------------------------------------------------------------------------   
   
   /** 
    * Methods:
    */
	
	/**
	 * Construtor da classe
	 * @param void
	 * @return void
	 * @access public
	 */
		private function __construct()
		{
			
		}
	
	/**
	 * Method to get the browser details from the USER_AGENT string in 
	 * the PHP superglobals
	 * @param void
	 * @return string property platform 
	 * @access private
	 */
		private static function GetBrowserOS()
		{
			$win   = eregi("win"   , self::$strUserAgent);
			$linux = eregi("linux" , self::$strUserAgent);
			$mac   = eregi("mac"   , self::$strUserAgent);
			$os2   = eregi("OS/2"  , self::$strUserAgent);
			$beos  = eregi("BeOS"  , self::$strUserAgent);
			
			//now do the check as to which matches and return it
			if($win)
			{
				self::$strPlatform = "Windows";
			}
			elseif($linux)
			{
				self::$strPlatform = "Linux"; 
			}
			elseif($mac)
			{
				self::$strPlatform = "Macintosh"; 
			}
			elseif($os2)
			{
				self::$strPlatform = "OS/2"; 
			}
			elseif($beos)
			{
				self::$strPlatform = "BeOS"; 
			}
			
			return self::$strPlatform;
		}
	
	/**
	 * Method to test for Opera
	 * @param void
	 * @return property $broswer
	 * @return property version
	 * @return bool false on failure
	 * @access private
	 */
		private static function IsOpera()
		{
			// test for Opera		
			if(eregi("opera",self::$strUserAgent))
			{
				$val = stristr(self::$strUserAgent, "opera");
				
				if(eregi("/", $val))
				{
					$val = explode("/",$val);
					self::$strBrowserType = $val[0];
					
					$val = explode(" ",$val[1]);
					self::$strVersion = $val[0];
				}
				else
				{
					$val = explode(" ", stristr($val, "opera"));
					
					self::$strBrowserType = $val[0];
					self::$strVersion     = $val[1];
				}
				
				return true;
			}
			else 
			{
				return false;
			}
		}
	
	/**
	 * Method to check for FireFox
	 * @param void
	 * @return bool false on failure
	 * @access private
	 */ 
		private static function IsFirefox()
		{
			if(eregi("Firefox", self::$strUserAgent))
			{
				self::$strBrowserType = "Mozilla Firefox"; 
				$val = stristr(self::$strUserAgent, "Firefox");
				$val = explode("/", $val);
				self::$strVersion = $val[1];
				
				return true;
			}
			else 
			{
				return false;
			}
		}
	
	/**
	 * Method to check for Konquerer
	 * @param void
	 * @return prop $browser
	 * @return prop $strVersion
	 * @return bool true on success
	 * @access private
	 */
		private static function IsKonqueror()
		{
			if(eregi("Konqueror",self::$strUserAgent))
			{
				$val = explode(" ",stristr(self::$strUserAgent,"Konqueror"));
				$val = explode("/",$val[0]);
			
				self::$strBrowserType = $val[0];
				self::$strVersion = str_replace(")","",$val[1]);
			
				return true;
			}
			else 
			{
				return false;
			}			
		}
	
	/**
	 * Method to check for Internet Explorer v1
	 * @param void
	 * @return bool true on success
	 * @return prop $strBrowserType
	 * @return prop $strVersion
	 * @access private
	 */
		private static function IsIEv1()
		{
			if(eregi("microsoft internet explorer", self::$strUserAgent))
			{
				self::$strBrowserType = "Microsoft Internet Explorer"; 
				self::$strVersion = "1.0";
			
				$var = stristr(self::$strUserAgent, "/");
			
				if(ereg("308|425|426|474|0b1", $var))
				{
					self::$strVersion = "1.5";
				}
			
				return true;
			}
			else 
			{
				return false;
			}
		}
	
	/**
	 * Method to check for Internet Explorer later than v1
	 * @param void
	 * @return bool true on success
	 * @return prop $strBrowserType
	 * @return prop $strVersion
	 * @access private
	 */
		private static function IsMSIE()
		{
			if(eregi("msie", self::$strUserAgent) && !eregi("opera",self::$strUserAgent))
			{
				self::$strBrowserType = "MSIE"; 
				$val = explode(" ",stristr(self::$strUserAgent,"msie"));
				
				self::$strBrowserType = "Microsoft Internet Explorer";
				self::$strVersion = substr($val[1], 0, (strlen($val[1]) - 1));
				
				return true;
			}
			else 
			{
				return false;
			}
		}
	
	/**
	 * Method to check for Galeon
	 * @param void
	 * @return bool true on success
	 * @access private
	 */
		private static function IsGaleon()
		{
			if(eregi("galeon",self::$strUserAgent))
			{
				$val = explode(" ",stristr(self::$strUserAgent,"galeon"));
				$val = explode("/",$val[0]);
				
				self::$strBrowserType = $val[0];
				self::$strVersion = $val[1];
				
				return true;
			}
			else 
			{
				return false;
			}
		}
	
	 // Now we do the tests for browsers I can't test...
	 // If someone finds a bug, please report it ASAP to me please!
	 	
	/**
	 * Method to check for WebTV browser
	 * @param void
	 * @return bool true on success
	 * @return prop $strBrowserType
	 * @return prop $strVersion
	 * @access private
	 */
		private static function IsWebTV()
		{
			if(eregi("webtv",self::$strUserAgent))
			{
				$val = explode("/",stristr(self::$strUserAgent,"webtv"));
				self::$strBrowserType = $val[0];
				self::$strVersion = $val[1];
				
				return true;
			}
			else 
			{
				return false;
			}
		}
	
	/**
	 * Method to check for BeOS's NetPositive
	 * @param void
	 * @return bool true on success
	 * @return prop $strBrowserType
	 * @return prop $strVersion
	 * @access private
	 */
		private static function IsNetPositive()
		{
			if(eregi("NetPositive", self::$strUserAgent))
			{
				$val = explode("/",stristr(self::$strUserAgent,"NetPositive"));
				self::$strPlatform = "BeOS"; 
				self::$strBrowserType = $val[0];
				self::$strVersion = $val[1];
				
				return true;
			}
			else 
			{
				return false;
			}
		}
	
	/**
	 * Method to check for MSPIE (Pocket IE)
	 * @param void
	 * @return bool true on success
	 * @access private
	 */
		private static function IsMSPIE()
		{
			if(eregi("mspie",self::$strUserAgent) || eregi("pocket", self::$strUserAgent))
			{
				$val = explode(" ",stristr(self::$strUserAgent,"mspie"));
				
				self::$strBrowserType = "MSPIE"; 
				self::$strPlatform = "WindowsCE"; 
				
				if(eregi("mspie", self::$strUserAgent))
				{	
				    self::$strVersion = $val[1];
				}	
				else 
			    {
					$val = explode("/",self::$strUserAgent);
					self::$strVersion = $val[1];
				}
				
				return true;
			}
			else 
			{
				return false;
			}
		}
	
	/**
	 * Method to test for iCab
	 * @param void
	 * @return bool true on success
	 * @access private
	 */
		private static function IsIcab()
		{
			if(eregi("icab",self::$strUserAgent))
			{
				$val = explode(" ",stristr(self::$strUserAgent,"icab"));
				self::$strBrowserType = $val[0];
				self::$strVersion = $val[1];

				return true;
			}
			else 
			{
				return false;
			}
		}
	
	/**
	 * Method to test for the OmniWeb Browser
	 * @param void
	 * @return bool True on success
	 * @access private
	 */
		private static function IsOmniWeb()
		{
			if(eregi("omniweb",self::$strUserAgent))
			{
				$val = explode("/",stristr(self::$strUserAgent,"omniweb"));
				self::$strBrowserType = $val[0];
				self::$strVersion = $val[1];

				return true;
			}
			else 
			{
				return false;
			}
		}
	
	/**
	 * Method to check for Phoenix Browser
	 * @param void
	 * @return bool true on success
	 * @access private
	 */
		private static function IsPhoenix()
		{
			if(eregi("Phoenix", self::$strUserAgent))
			{
				self::$strBrowserType = "Phoenix"; 
				$val = explode("/", stristr(self::$strUserAgent,"Phoenix/"));
				self::$strVersion = $val[1];

				return true;
			}
			else 
			{
				return false;
			}
		}
	
	/**
	 * Method to check for Firebird
	 * @param void
	 * @return bool true on success
	 * @access private
	 */
		private static function IsFirebird()
		{
			if(eregi("firebird", self::$strUserAgent))
			{
				self::$strBrowserType = "Firebird"; 
				$val = stristr(self::$strUserAgent, "Firebird");
				$val = explode("/",$val);
				self::$strVersion = $val[1];

				return true;
			}
			else 
			{
				return false;
			}
		}
	
	/**
	 * Method to check for Mozilla alpha/beta
	 * @param void
	 * @return bool true on success
	 * @access private
	 */
		private static function IsMozAlphaBeta()
		{
			if(eregi("mozilla",self::$strUserAgent) && 
			   eregi("rv:[0-9].[0-9][a-b]",self::$strUserAgent) && 
			   !eregi("netscape",self::$strUserAgent))
			
			{
				self::$strBrowserType = "Mozilla"; 
				$val = explode(" ",stristr(self::$strUserAgent,"rv:"));
				eregi("rv:[0-9].[0-9][a-b]",self::$strUserAgent,$val);
				self::$strVersion = str_replace("rv:","",$val[0]);

				return true;
			}
			else 
			{
				return false;
			}
		}

	/**
	 * Method to check for Mozilla Stable versions
	 * @param void
	 * @return bool true on success
	 * @access private
	 */
		private static function IsMozStable()
		{
			if(eregi("mozilla",self::$strUserAgent) &&
			   eregi("rv:[0-9]\.[0-9]",self::$strUserAgent) && 
			   !eregi("netscape",self::$strUserAgent))
			{
				self::$strBrowserType = "Mozilla"; 
				$val = explode(" ",stristr(self::$strUserAgent,"rv:"));
				eregi("rv:[0-9]\.[0-9]\.[0-9]",self::$strUserAgent,$val);
				self::$strVersion = str_replace("rv:","",$val[0]);

				return true;
			}
			else 
			{
				return false;
			}
		}
	
	/**
	 * Method to check for Lynx and Amaya
	 * @param void
	 * @return bool true on success
	 * @access private
	 */
		private static function IsLynx()
		{
			if(eregi("libwww", self::$strUserAgent))
			{
				if(eregi("amaya", self::$strUserAgent))
				{
					$val = explode("/",stristr(self::$strUserAgent,"amaya"));
					self::$strBrowserType = "Amaya"; 
					$val = explode(" ", $val[1]);
					self::$strVersion = $val[0];
				} 
				else 
			    {
					$val = explode("/",self::$strUserAgent);

					self::$strBrowserType = "Lynx"; 
					self::$strVersion = $val[1];
				}

				return true;
			}
			else 
			{
				return false;
			}
		}
	
	/**
	 * method to check for safari browser
	 * @param void
	 * @return bool true on success
	 * @access private
	 */
		private static function IsSafari()
		{
			if(eregi("safari", self::$strUserAgent))
			{
				self::$strBrowserType = "Safari"; 
				self::$strVersion = "";

				return true;
			}
			else 
			{
				return false;
			}
		}
	
	/**
	 * Various tests for Netscrape
	 * @param void
	 * @return bool true on success
	 * @access private
	 */
		private static function IsNetscape()
		{
			if(eregi("netscape",self::$strUserAgent))
			{
				$val = explode(" ",stristr(self::$strUserAgent,"netscape"));
				$val = explode("/",$val[0]);

				self::$strBrowserType = $val[0];
				self::$strVersion = $val[1];

				return true;
			}
			elseif(eregi("mozilla",self::$strUserAgent) && !eregi("rv:[0-9]\.[0-9]\.[0-9]",self::$strUserAgent))
			{
				$val = explode(" ",stristr(self::$strUserAgent,"mozilla"));
				$val = explode("/",$val[0]);

				self::$strBrowserType = "Netscape"; 
				self::$strVersion = $val[1];

				return true;
			}
			else 
			{
				return false;
			}
		}
	
	/**
	 * Method to check for AOL connections
	 * @param void
	 * @return bool true on Success
	 * @access private
	 */
		private static function IsAOL()
		{
			if(eregi("AOL", self::$strUserAgent)){
				$var = stristr(self::$strUserAgent, "AOL");
				$var = explode(" ", $var);
				self::$strAol = ereg_replace("[^0-9,.,a-z,A-Z]", "", $var[1]);
				return true;
			}
			else 
			{ 
				return false;
			}
		}
	
	/**
	 * Method to tie them all up and output something useful
	 * @param void
	 * @return array
	 * @access private
	 */
		public static function Detect()
		{
			self::$strUserAgent = $_SERVER['HTTP_USER_AGENT'];
            
            self::GetBrowserOS();
			self::IsOpera();
			self::IsFirefox();
			self::IsKonqueror();
			self::IsIEv1();
			self::IsMSIE();
			self::IsGaleon();
			self::IsNetPositive();
			self::IsMSPIE();
			self::IsIcab();
			self::IsOmniWeb();
			self::IsPhoenix();
			self::IsFirebird();
			self::IsLynx();
			self::IsSafari();
			self::IsAOL();
			
			return array('strBrowser'  => self::$strBrowserType, 
						 'strVersion'  => self::$strVersion, 
						 'strPlatform' => self::$strPlatform, 
						 'strAOL'      => self::$strAol); 
		}
}