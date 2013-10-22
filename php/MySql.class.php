<?php
	class MySql{
		
		private $HOST = 'localhost';
		private $USER = 'root';
		private $PASS = '123';
		private $DB   = 'legiaogames';
		
		private $conn;
		private $banco;
		
		public $erro = '';
		
		function __construct(){
			if(is_null($this->conn)){
				$this->conn = mysql_connect($this->HOST,$this->USER,$this->PASS) or die($this->erro = mysql_error());
			}
			$this->banco = mysql_select_db($this->DB) or die($this->erro = mysql_error());
			return $this->conn;
		}
	}