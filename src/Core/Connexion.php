<?php 

namespace App\Core;

use PDO;
use PDOException;

/**
 * Cette classe se charge de la connexion à la base de données
 */
class Connexion extends PDO
{
    /**
     * instance du class connexion
     *
     * @var self
     */
    private static $instance;

    private const HOST = "localhost";
    private const USER = "root";
    private const PASSWORD = "Rhjaforlife123##";
    private const DBNAME = "poo_db";

    /**
     * constructeur
     */
    public function __construct()
    {
        $dsn = 'mysql:dbname=' . self::DBNAME . ';host=' . self::HOST;

        try {
            parent::__construct($dsn, self::USER, self::PASSWORD);

            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    /**
     * get the instance of this class
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if(self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

}