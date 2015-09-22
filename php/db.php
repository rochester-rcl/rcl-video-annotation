<?php

//Classes for working with our users, markers, and database connections

include 'config.php';
error_reporting(E_ALL);

class Db {

    protected static $connection;
    private static $hasConnection = false;



    //Main connection method
    public static function pdoConnect() {
        global $server;
        global $username;
        global $password;
        global $database;
        try {
            if (!self::$hasConnection) {
                self::$connection = new PDO("mysql:host=$server;dbname=".$database, $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$hasConnection = true;
            }
            return self::$connection;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }


}

