<?php
require_once '../../Plugins/phpmailer/class.phpmailer.php';

$strBody    = $_POST['body'];
$strSubject = $_POST['subject'];

$objMailer = new PHPMailer(true);
             
$objMailer->IsSMTP(); // telling the class to use SMTP

try 
{
	$objMailer->Host       = 'gmail.com';           // SMTP server
	$objMailer->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
	$objMailer->SMTPAuth   = true;                  // enable SMTP authentication
	$objMailer->SMTPSecure = 'ssl';                 // sets the prefix to the servier
	$objMailer->Host       = 'smtp.gmail.com';      // sets GMAIL as the SMTP server
	$objMailer->Port       = 465;                   // set the SMTP port for the GMAIL server
	  
	$objMailer->Username   = 'esus.rg@gmail.com';   // GMAIL username
	$objMailer->Password   = '!@RG!@Email';         // GMAIL password
	 
	$objMailer->AddAddress('douglas@rgsistemas.com.br', 'Douglas');
	$objMailer->AddAddress('emiliana@rgsistemas.com.br', 'Emiliana');
	$objMailer->AddAddress('flavia@rgsistemas.com.br', 'Flávia Monnerat');
	$objMailer->AddAddress('mariane@rgsistemas.com.br', 'Marianne');
	$objMailer->AddAddress('michell@rgsistemas.com.br', 'Michell');
	$objMailer->AddAddress('priscilla@rgsistemas.com.br', 'Priscilla');
	$objMailer->AddAddress('ronaldo@rgsistemas.com.br', 'Ronaldo Jr');
	$objMailer->AddAddress('tiago@rgsistemas.com.br', 'Tiago');
	  
	$objMailer->SetFrom('esus.rg@gmail.com', 'Esus');
	  
	$objMailer->AddReplyTo('esus.rg@gmail.com', 'Esus');
	$objMailer->Subject = utf8_decode($strSubject);
	$objMailer->Body = utf8_decode($strBody);
	  
	$objMailer->Send();
}
catch (phpmailerException $e)
{
	echo $e->errorMessage(); //Pretty error messages from PHPMailer
}
catch (Exception $e)
{
	echo $e->getMessage(); //Boring error messages from anything else!
}
