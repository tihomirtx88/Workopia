<?php 
class Database{
    public $conection;

    /**
     * Constructor for database class
     * 
     * @param array $config
     */

     public function __construct($config){
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];

        try {
            $this->conection = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: {$e->getMessage()}");
        }
     }

     /**
      * Query the Database
      *
      *@param string $query
      *
      *@return PDOStatement
      *@throws PDOException
      */

      public function query($query){
         try {
            $statement = $this->conection->prepare($query);
            $statement->execute();
            return $statement;
         } catch (PDOException $e) {
            throw new Exception("Query failed to execudes: {$e->getMessage()}");
         }
      }
}