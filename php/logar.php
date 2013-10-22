<?php 
//Inclui o arquivo com a classe de login
require_once("Usuario.class.php");
// Instancia a classe
$userClass = new Usuario();

// Pega os dados vindos do formulário
$usuario = $_POST['email'];
$senha = $_POST['senha'];
// Se o campo "lembrar" não existir, o script funcionará normalmente
$lembrar = (isset($_POST['lembrar']) AND !empty($_POST['lembrar']));

// Tenta logar o usuário com os dados
if ( $userClass->logaUsuario( $usuario, $senha, $lembrar) ) {
	// Usuário logado com sucesso, redireciona ele para a página restrita
	header("Location: ../");
	exit;
} else {
	// Não foi possível logar o usuário, exibe a mensagem de erro
	header("Location: ../index.php?e=".$userClass->erro);
}
?>