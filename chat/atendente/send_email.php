<?php
require '../util/header.php';
require 'includes.php';

$session = new Session();
$session->checkSession('user');

$vld = new Validation();

$vld->Validate();

if($vld->hasErrors() == false){

	extract($_POST, EXTR_SKIP);
	
	$headers = "From: <$from>\r\n"; 
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

	if(@mail($to, $subject, $message, $headers)){
		$vld->addMessage('E-mail enviado com sucesso');	
	}else{
		$vld->addError('Falha ao enviar E-mail, tente novamente');	
	}

}

$vld->jsonResult();
?>