<?php
// Inclui o arquivo com a classe de login
require_once("../php/Usuario.class.php");
// Instancia a classe
$userClass = new Usuario();

// Usuário fez logout com sucesso?
if ( $userClass->logout() ) {
	// Redireciona pra tela de login
	header("Location: ../");
	exit;
}
?>