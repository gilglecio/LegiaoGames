<?php
class PDOConnection extends PDO {
 		
	private $host = 'localhost';
	private $database = '418657';
	private $user = '418657';
	private $password = 'legiao2011';
	private $persistent = false;
	
	public function __construct() {
	
		set_exception_handler(array(__CLASS__, 'exception_handler'));
		
		$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => $this->persistent);
		
		parent::__construct('mysql:host='.$this->host.';dbname='.$this->database, $this->user, $this->password,  $options);
		
		restore_exception_handler();

	}

    public static function getInstance() {
        static $instance = NULL;
 
        if($instance == NULL) {
	    	$instance = new PDOConnection;
        }
 
        return $instance;
    }

	
	public static function exception_handler($exception) {
		die('Uncaught exception: '. $exception->getMessage());
	}
	
}
?>