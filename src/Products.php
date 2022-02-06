<?php
declare(strict_types=1);

namespace Cart;


use Exception;
use PDO;
use PDOException;


final class Products implements CartProduct
{

    private static $instance = null;


    private function __construct()
    {
        try {
            $this->db = new PDO('mysql:host=127.0.0.1;dbname=cart', 'root', '');

        } catch (PDOException $e) {
            die('Сайт не работает.');
        }
    }

    public static function instanceDb(): ?Products
    {

        if (self::$instance === null) {
            self::$instance = new Products();
        }
        return self::$instance;
    }

    public function __wakeup()
    {
        throw new Exception("Cannot unserialize a singleton.");
    }



    private function __clone()
    {
    }

    use GetProducts;

}