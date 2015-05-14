<?php 
ob_start();
require_once("../Class/System.php");

try
{
	$objForm = new CodeGenHTMLForm();
	$objForm->SetFile("Output/Interfaces/Html/forms.php");
	$objForm->GenerateAllForms();
}
catch(Exception $e)
{
    $objMessage = new Message();
    $objMessage->Alert($e, $blnTrace = true);    
}
ob_flush();
?>