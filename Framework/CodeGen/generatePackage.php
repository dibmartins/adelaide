<?php 
/**
 * Gera um subPackage.
 * Uma unidade é constituida por duas classes que representam uma tabela no banco de dados
 * Uma é a classe de negócios, a outra é a classe de acesso a dados
 * Ex.: class.Cliente.php e class.DaoCliente.php
 *
 * Para gerar o código preencha as variáveis abaixo corretamente.
 * O código será criado em uma pasta lib dentro do diretório especificado em $strOutputDir
 */

require_once("../Class/System.php");

try
{
    $strClass      = "Cliente";
    $strPackage    = "SILAB";
    $strSubPackage = "Clientes";
    $strAuthor     = "Diego Botelho Martins <dibmartins@yahoo.com.br>";
    $strVersion    = "1.0";
    $strTable      = "cli_clientes";
    $strOutputDir  = "Output/Package/";
    
    Utils::StartExecution();
    
    // Gerando as classes de negócios:
    $objBusinessClass = new CodeGenBusiness();
    $objBusinessClass->SetName($strClass);
    $objBusinessClass->SetPackage($strPackage);
    $objBusinessClass->SetSubPackage($strSubPackage);
    $objBusinessClass->SetAuthor($strAuthor);
    $objBusinessClass->SetVersion($strVersion);
    $objBusinessClass->SetTable($strTable);
    
    // Gerando as classes de acesso a dados:
    $objDaoClass = new CodeGenDao();
    $objDaoClass->SetName($strClass);
    $objDaoClass->SetPackage($strPackage);
    $objDaoClass->SetSubPackage($strSubPackage);
    $objDaoClass->SetVersion($strVersion);
    $objDaoClass->SetTable($strTable);
    
    echo '<pre>';
    $objBusinessClass->Generate($strOutputDir);
    $objDaoClass->Generate($strOutputDir);
    echo '<br />Processo executado em ' . Utils::EndExecution() . ' segundos.';
    echo '</pre>';
}
catch(Exception $e)
{
    $objMessage = new Message();
	$objMessage->setException($e);
	$objMessage->display();
}

?>