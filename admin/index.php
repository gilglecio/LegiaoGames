<?php 
//Inclui o arquivo com a classe de login
require_once("../php/Usuario.class.php");
// Instancia a classe
$userClass = new Usuario();

if($userClass->usuarioLogado()){
	include('painel.php');
	exit();
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LegiaoGames - Login</title>
</head>

<body>
<?php
if(isset($_POST['logar'])){

// Pega os dados vindos do formulário
$usuario = $_POST['email'];
$senha = $_POST['senha'];
// Se o campo "lembrar" não existir, o script funcionará normalmente
$lembrar = (isset($_POST['lembrar']) AND !empty($_POST['lembrar']));

// Tenta logar o usuário com os dados
if ( $userClass->logaUsuario( $usuario, $senha, $lembrar) ) {
	// Usuário logado com sucesso, redireciona ele para a página restrita
	header("Location: ./");
	exit;
} else {
	// Não foi possível logar o usuário, exibe a mensagem de erro
	header("Location: index.php?e=".$userClass->erro);
}}
echo $_GET['e'];
?>
<form name="login" method="POST" action="<?php echo $loginFormAction; ?>">
<input type="text" name="email" />
<input type="password" name="senha" />
<input type="submit" name="logar" value="Logar" />
</form>
</body>
</html>