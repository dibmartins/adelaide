<?php
/**
 * Conjunto de constantes gerais do sistema
 * Esta classe não pode ser instanciada através do comando new.
 * 
 * @package Framework
 * @subpackage Config
 * @version 1.0 - 2008-09-23 13:08:35 
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright - 2009 RG Sistemas - Todos os direitos reservados
 */

class SystemConfig
{
 
//------------------------------------------------------------------------------
// Configurações Esus
//------------------------------------------------------------------------------


	 /** 
      * Attributes:
      */
     const SYSTEM_URL      = 'http://rglinux/';
     const SYSTEM_LOGO     = 'logo.jpg';
     const SYSTEM_EMAIL    = 'contato@rgweb.com.br';

     const COMPANY_NAME    = 'RG Consultoria e Planejamento';
     const COMPANY_SITE    = 'www.rgweb.com.br';
     const COMPANY_EMAIL   = 'contato@rgweb.com.br';
     const COMPANY_PHONE   = '(22) 2566-3385';
     const COMPANY_ADDRESS = 'Rua Nnonnoonnono, 999 - Xxx - Bom Jardim / RJ';
	
//------------------------------------------------------------------------------     
     
     /**
      * Diretórios
      */
     
     const PATH        = '/var/www/esus/Framework/';
     const UPLOAD_PATH = '/UploadedFiles/';
	
//------------------------------------------------------------------------------     
     
     /**
      * Localização
      */
     
     const TIME_ZONE = 'America/Sao_Paulo';
     
 //------------------------------------------------------------------------------     
     
     /**
      * Constantes do plugin AMF
      */    
     const AMF_METHOD_TABLE = '/amfphp/core/shared/util/MethodTable';
     const AMF_ERROR_FILE   = 'erros.xml';

//------------------------------------------------------------------------------     
     
     /**
      * Constantes de criptografia do sistema
      */
     const ENCRYPT_KEY       = '#@lock7ne57dz6!&';
     const ENCRYPT_ALGORITHM = 'sha512';
     const ENCRYPT_BIN_MODE  = false;
	     
//------------------------------------------------------------------------------
	     
     /** 
      * AdoConfig:
      */
     
	 // ATENÇÃO utilize 127.0.0.1 
     // sempre que o PHP estiver no mesmo servidor
     // que o mysql pois o ganho de performance na
     // conexão é de aprox. 5 segundos.
     const ADO_HOST        = '127.0.0.1';
     
     const ADO_PORT        = '3306';
     const ADO_USER        = 'rgesus';
     const ADO_PASSWORD        = '!@RG!@esus';
     const ADO_DATABASE        = 'dev_esus_clientes';
     const ADO_SERVER      = 'Mysql';
     const ADO_DSN         = 'DRIVER={MySQL ODBC 3.51 Driver};CommLinks=tcpip(Host=localhost);DatabaseName=esus; uid=root; pwd=';
     const ADO_PATH_BACKUP = 'backup';

     // Se estiver setado como true, envia e-mails relatando
     // os erros do banco de dados e grava os erros no arquivo de log 
     const ADO_REPORT_ERROR = false;     
	     
//------------------------------------------------------------------------------
	     
     /**
      * Constantes de conexão com o servidor SMTP
      */
     const SMTP_AUTHENTICATION = true;
     const SMTP_PORT           = '';
     const SMTP_USER           = '';
     const SMTP_PASSWORD       = '';

//------------------------------------------------------------------------------
	     
     /**
      * Constantes de confinguração da Smarty Template
      */
     const SMARTY_ROOT          = '/Web/Plugins/smarty/libs/';
     const SMARTY_COMPILE       = '/Web/Plugins/smarty/files/templates_c/';
     const SMARTY_CONFIG        = '/Web/Plugins/smarty/files/configs/';
     const SMARTY_CACHE         = '/Web/Plugins/smarty/files/cache/';
     const SMARTY_CACHE_ON      = false;
     const SMARTY_FORCE_COMPILE = true;
     const SMARTY_COMPILE_CHECK = true;
     const SMARTY_LIFE_TIME     = 3600;
     const SMARTY_DEBUG         = false;
     const SMARTY_TEMPLATE_DIR  = 'Templates/';
	     
//------------------------------------------------------------------------------
	     
     /**
      * Constantes de configuração da biblioteca Xajax
      */
     const AJAX_ROOT          = '/Framework/Web/Plugins/Xajax';
     const AJAX_DEBUG_ON      = false;
     const AJAX_STATUS_MSG_ON = false;

//------------------------------------------------------------------------------     
     
     /**
      * Constantes de confinguração de paginação do sistema
      */
     const PAGINATION_STYLESHEET = '/Framework/Web/Css/pagination.css';
	     
//------------------------------------------------------------------------------
	     
     /**
      * Constantes de configuração dos arquivos de log
      */
     const LOG_SYSTEM_DIR       = 'Web/Utils/Logs/';
     const LOG_SYSTEM_FILE      = 'system.xml';
     const LOG_USER_FILE        = 'user.xml';
     const LOG_SEND_EMAIL       = true;
     const LOG_DEFAULT_PRIORITY = 1;

//------------------------------------------------------------------------------
	     
     /**
      * Arquivo XML com os diretórios de classes do projeto
      */
     const RESOURCE_FILE = '_resources.xml';
	     
//------------------------------------------------------------------------------
	     
     /**
      * Constantes de configuração de exibição de mensagens
      */
     const MSG_DEBUG_TRACE = true;
	     	
//------------------------------------------------------------------------------
	     
     /**
      * Constantes de configuração de exibição de mensagens
      */
     // #DOUGLAS 8h não está funcionando, a sessão sempre expira em até 20min
     const SESSION_TIME_EXPIRE = 480; // 8 horas
     const SESSION_LIMITER     = 'private';
     
     // #DOUGLAS - 04/12/2013
     // Como a sessão sempre expira em até 20min, e no fronend não temos
     // controle disso, foi criado um método que verifica o tempo até a
     // expiração real da sessão, e aqui a constante de configuração
     // desse tempo. Isso permite que se saiba o tempo exato até que a sessão
     // realmente expire.
     const SESSION_MAX_TIME = 1200;
     
     // #DOUGLAS - 04/12/2013
     // Para testar a expiração de sessão manual em 1min, descomente a linha
     // abaixo:
     // const SESSION_MAX_TIME = 60;
	
//------------------------------------------------------------------------------	     
	     
     /**
      * Construtor privado
      * Para não permitir o instanciamento desta classe
      * @access private
      */
      private function __construct(){}
}	           

//------------------------------------------------------------------------------