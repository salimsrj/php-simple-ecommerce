<?php

Class DbCon{
 
	private $server = "mysql:host=localhost;dbname=simple_ecomm";
	private $username = "root";
	private $password = "";
	private $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);
	protected $conn;

	
 	
	public function open(){
 		try{
             $this->conn = new PDO($this->server, $this->username, $this->password, $this->options);
             
             // Check connection
            if (!$this->conn ) {
                die("Connection failed: " . mysqli_connect_error());
            }else{
                //echo "Connected successfully";
            }
            
 			return $this->conn;
 		}
 		catch (PDOException $e){
 			echo "There are a problem in db connection: " . $e->getMessage();
 		}
 
    }
 
	public function close(){
   		$this->conn = null;
 	}
 
}

$pdo = new DbCon();