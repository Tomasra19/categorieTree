<?php

//Singleton Db class for creating only one connection
class Database
{
    private $connection;
    private static $instance; //The single instance
    private $serverName = "localhost";
    private $username = "root";
    private $password = "";
    private $databaseName = "mydb";

    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance()
    {
        if (!self::$instance) { // If no instance then make one
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Constructor
    private function __construct()
    {
        $this->connection = new mysqli($this->serverName, $this->username,
            $this->password, $this->databaseName);

        // Error handling
        if (mysqli_connect_error()) {
            trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(),
                E_USER_ERROR);
        }
    }

    // Magic method clone is empty to prevent duplication of connection
    private function __clone()
    {
    }

    // Get mysqli connection
    public function getConnection()
    {
        return $this->connection;
    }
}

?>