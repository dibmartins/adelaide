<?php 
ob_start();
require_once("../Class/System.php");

try
{
	$objForm = new CodeGenMXMLForm();
	$objForm->SetFolder("Output/Interfaces/Mxml/");
	$objForm->GenerateAllForms();
}
catch(Exception $e)
{
    $objMessage = new Message();
    $objMessage->Alert($e, $blnTrace = true);    
}
ob_flush();
?>