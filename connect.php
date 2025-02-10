<?php
    
    require_once("config.php");
    
    class MySQLiDatabase
    {
        public $db_connect;
        
        function __construct()
        {
            $this->open_connection();
        }
        
        public function open_connection()
        {
            $this->db_connect = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, 3307);
            
            if(!$this->db_connect)
            {
                die("Database connection failed: ");
            }
        }
        
        public function close_connection()
        {
            if(isset($this->db_connect))
            {
                mysqli_close($this->db_connect);
                unset($this->db_connect);
            }
        }
    }
    
    $database = new MySQLiDatabase();
    
?>