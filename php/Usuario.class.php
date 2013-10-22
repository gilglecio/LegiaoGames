<?php 
class Usuario {
	var $bancoDeDados = '418657';
	var $tabelaUsuarios = 'tb_users';
	var $campos = array('usuario' => 'userEmail','senha' => 'userSenha');
	var $dados = array('userId', 'userNome','userEmail','userNivel');
	var $iniciaSessao = true;
	var $prefixoChaves = 'usuarioLG_';
	var $cookie = true;
	var $caseSensitive = true;
	var $filtraDados = true;
	var $lembrarTempo = 7;
	var $cookiePath = '/';
	var $erro = '';

	private $conn;
	
	function getConn(){
		if(is_null($this->conn)){
			$this->conn = mysql_connect('localhost','418657','legiao2011');
		}
		return $this->conn;
	}
	
	function codificaSenha($senha) {
		return $senha;
	}
	
	// Define uma função que poderá ser usada para validar e-mails usando regexp
	function validaEmail($mail) {
		if($mail !== "") {
			if(ereg("^[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[@]{1}[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[.]{1}[A-Za-z]{2,5}$", $mail)) {
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	} 

	function validaUsuario($usuario, $senha) {
		$senha = $this->codificaSenha($senha);
		if ($this->filtraDados) {
			$usuario = mysql_escape_string($usuario);
			$senha = mysql_escape_string($senha);
		}
		$binary = ($this->caseSensitive) ? 'BINARY' : '';
		$this->getConn();
		$sql = "SELECT COUNT(*) AS total FROM `{$this->bancoDeDados}`.`{$this->tabelaUsuarios}`	WHERE {$binary} `{$this->campos['usuario']}` = '{$usuario}' AND {$binary} `{$this->campos['senha']}` = '{$senha}'";
		$query = mysql_query($sql) or die($this->erro = mysql_error());
		if ($query) {
			$total = mysql_result($query, 0, 'total');
			mysql_free_result($query);
		} else {
			$this->erro = 'Erro na validação!';
			return false;
		}
		return ($total == 1) ? true : false;
	}

	function logaUsuario($usuario, $senha, $lembrar = false) {			
		if ($this->validaUsuario($usuario, $senha)) {
			if ($this->iniciaSessao AND !isset($_SESSION)) {
				session_start();
			}
			if ($this->filtraDados) {
				$usuario = mysql_real_escape_string($usuario);
				$senha = mysql_real_escape_string($senha);
			}
			if ($this->dados != false) {
				if (!in_array($this->campos['usuario'], $this->dados)) {
					$this->dados[] = 'usuario';
				}
				$dados = '`' . join('`, `', array_unique($this->dados)) . '`';
				$binary = ($this->caseSensitive) ? 'BINARY' : '';
				$this->getConn();
				$sql = "SELECT {$dados} FROM `{$this->bancoDeDados}`.`{$this->tabelaUsuarios}` WHERE {$binary} `{$this->campos['usuario']}` = '{$usuario}'";
				$query = mysql_query($sql) or die($this->erro = mysql_error());
				if (!$query) {
					$this->erro = 'A consulta dos dados é inválida';
					return false;
				} else {
					$dados = mysql_fetch_assoc($query);
					mysql_free_result($query);
					foreach ($dados AS $chave=>$valor) {
						$_SESSION[$this->prefixoChaves . $chave] = $valor;
					}
				}
			}
			$_SESSION[$this->prefixoChaves . 'usuario'] = $usuario;
			$_SESSION[$this->prefixoChaves . 'logado'] = true;
			if ($this->cookie) {
				$valor = join('#', array($usuario, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']));
				//$valor = join('#', array('oi','ai'));
				$valor = sha1($valor);
				setcookie($this->prefixoChaves . 'token', $valor, 0, $this->cookiePath);
			}
			if ($lembrar) $this->lembrarDados($usuario, $senha);
			return true;
		} else {
			$this->erro = 'Usuário inválido!';
			return false;
		}
	}

	function usuarioLogado($cookies = true) {
		if ($this->iniciaSessao AND !isset($_SESSION)) {
			session_start();
		}
		if (!isset($_SESSION[$this->prefixoChaves . 'logado']) OR !$_SESSION[$this->prefixoChaves . 'logado']) {
			if ($cookies) {
				return $this->verificaDadosLembrados();
			} else {
				$this->erro = 'Você não está logado!';
				return false;
			}
		}
		if ($this->cookie) {
			if (!isset($_COOKIE[$this->prefixoChaves . 'token'])) {
				$this->erro = 'Você não está logado!';
				return false;
			} else {
				$valor = join('#',array($_SESSION[$this->prefixoChaves . 'usuario'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']));
				//$valor = join('#', array('oi','ai'));
				$valor = sha1($valor);
				if ($_COOKIE[$this->prefixoChaves . 'token'] !== $valor) {
					$this->erro = 'Você não está logado!';
					return false;
				}
			}
		}
		return true;
	}

	function logout($cookies = true) {
		if ($this->iniciaSessao AND !isset($_SESSION)) {
			session_start();
		}
		$tamanho = strlen($this->prefixoChaves);
		foreach ($_SESSION AS $chave=>$valor) {
			if (substr($chave, 0, $tamanho) == $this->prefixoChaves) {
				unset($_SESSION[$chave]);
			}
		}
		if (count($_SESSION) == 0) {
			session_destroy();
			if (isset($_COOKIE['PHPSESSID'])) {
				setcookie('PHPSESSID', false, (time() - 3600));
				unset($_COOKIE['PHPSESSID']);
			}
		}
		if ($this->cookie AND isset($_COOKIE[$this->prefixoChaves . 'token'])) {
			setcookie($this->prefixoChaves . 'token', false, (time() - 3600), $this->cookiePath);
			unset($_COOKIE[$this->prefixoChaves . 'token']);
		}
		if ($cookies) $this->limpaDadosLembrados();
		return !$this->usuarioLogado(false);
	}

	function lembrarDados($usuario, $senha) {	
		$tempo = strtotime("+{$this->lembrarTempo} day", time());
		$usuario = rand(1, 9) . base64_encode($usuario);
		$senha = rand(1, 9) . base64_encode($senha);
		setcookie($this->prefixoChaves . 'lu', $usuario, $tempo, $this->cookiePath);
		setcookie($this->prefixoChaves . 'ls', $senha, $tempo, $this->cookiePath);
	}

	function verificaDadosLembrados() {
		if (isset($_COOKIE[$this->prefixoChaves . 'lu']) AND isset($_COOKIE[$this->prefixoChaves . 'ls'])) {
			$usuario = base64_decode(substr($_COOKIE[$this->prefixoChaves . 'lu'], 1));
			$senha = base64_decode(substr($_COOKIE[$this->prefixoChaves . 'ls'], 1));
			return $this->logaUsuario($usuario, $senha, true);		
		}
		return false;
	}

	function limpaDadosLembrados() {
		if (isset($_COOKIE[$this->prefixoChaves . 'lu'])) {
			setcookie($this->prefixoChaves . 'lu', false, (time() - 3600), $this->cookiePath);
			unset($_COOKIE[$this->prefixoChaves . 'lu']);			
		}
		if (isset($_COOKIE[$this->prefixoChaves . 'ls'])) {
			setcookie($this->prefixoChaves . 'ls', false, (time() - 3600), $this->cookiePath);
			unset($_COOKIE[$this->prefixoChaves . 'ls']);			
		}
	}
	
	function getUsuario($UID){
		
		if($this->usuarioLogado()){
			$this->getConn();
			$sql = "SELECT * FROM `{$this->bancoDeDados}`.`{$this->tabelaUsuarios}`	WHERE `id` = 5";
			$query = mysql_query($sql) or die($this->erro = mysql_error());
			if($query){
				$getDados = mysql_fetch_array($query);
				//mysql_free_result($query);
			}
			return $getDados;
		}
	}
}
?>