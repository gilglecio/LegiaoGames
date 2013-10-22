<?php
require '../util/header.php';
require 'includes.php';

$session = new Session();
$session->checkSession('user');

$vld = new Validation();

$vld->Validate();

if($vld->hasErrors() == false){

	extract($_POST, EXTR_SKIP);
	
	$pdo = PDOConnection::getInstance();
	
	$user_session = $session->get('user');
	
	$stmt = $pdo->prepare('SELECT * FROM user WHERE user_id = :user_id');
	$stmt->bindValue('user_id', $user_session['user_id']);
	$stmt->execute();
	$user = $stmt->fetch();
	
	if(md5($password) != $user['password']){
	
		$vld->addError('Senha atual não confere');	
		
	}else{
	
		$stmt = $pdo->prepare('UPDATE user SET password = :password WHERE user_id = :user_id');
		$stmt->bindValue('user_id', $user_session['user_id']);
		$stmt->bindValue('password', md5($new_password));
		$stmt->execute();
		
		$vld->addMessage('Senha alterada com sucesso');	
		
	}

}

$vld->jsonResult();
?>