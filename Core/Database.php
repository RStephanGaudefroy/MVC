<?php

/**
 * Class Database 
 * use design pattern singleton
 */
namespace Core;

use PDO;

class Database
{
    private $pdo;

    /**
     * Database instanciation
     * @param CONST from App/config/Config file
     * use singleton pattern for instanciation
     */
    private function getPDO()
    {
        if ($this->pdo === null)
        {
            try
            {
                $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo = $pdo;
                
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
        }
        
        return $this->pdo;
    }

    /**
     * Prepared and execute query
     * @param $statement -> sql query
     * @param array $params
     * @return OBJECT StdClass
     */
    public function request( string $statement, array $params = [] )
    {
        if ( $params && !empty($params))
        {
            $req = $this->getPDO()->prepare( $statement );
            $req->execute( $params );
        }
        else 
        {
            $req = $this->getPDO()->query( $statement );
        }
     
        $data = $req->fetch(PDO::FETCH_OBJ);
        return $data;
    }

    /**
     * execute query in database
     * @return $id -> last id insert on db
     */
    
    public function add( string $statement, array $params = [] )
    {
        if ( $params && !empty($params))
        {
            $req = $this->getPDO()->prepare( $statement );
            $req->execute( $params );
        }
        $id = $this->getPDO()->lastInsertId();
        return $id;
    }
}