<?php
class Session {

	public function Session(){
		session_start();
	}
	
	public function register($key, $value){
		$_SESSION[$key] = $value;	
	}
	
	
	public function isRegistered($key){
		return isset($_SESSION[$key]);
	}
	
	public function get($key){
		return isset($_SESSION[$key]) ? $_SESSION[$key] : false;	
	}
	
	public function destroy($key){
		unset($_SESSION[$key]);
	}
	
	public function checkSession($key){
		if(isset($_SESSION[$key]) == false){
			$this->sendHeader(401);
		}
	}
	
	public function sendHeader($code){
		switch($code){
			case 400:
				header("Status: 400 Bad Request", false, 400);
				header("Content-Type: text/plain");
				print '400 Bad Request';
			break;
			case 401:
				header("Status: 401 Unauthorized", false, 401);
				header("Content-Type: text/plain");
				print '401 Unauthorized';
			break;
		}
		exit();
	}
	
}
?>