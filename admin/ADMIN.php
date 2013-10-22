<?php 
//Inclui o arquivo com a classe de login
require_once("../php/Usuario.class.php");
require_once("../php/MySql.class.php");
// Instancia a classe
$userClass = new Usuario();
$MySql = new MySql;
if(!$userClass->usuarioLogado()){
	header('Location: index.php');
	exit();
}elseif($_SESSION['usuarioLG_userNivel'] == 'admin'){
	
}else{
	header('Location: index.php');
	exit();
}?>