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
        try {
            if (!self::$hasConnection) {

                self::$connection = new PDO("mysql:host=$server;dbname=video_annotation", $username, $password);

                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$hasConnection = true;
                //echo "Connected successfully";
            }
            return self::$connection;
        } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
        }
    }


}

//$myMarker = new FilmMarker();
//$myMarker -> setAllFromArray($testArray);

//$myConnection = new Db();

//$myConnection->pdoConnect();

//$myConnection->insertMarker($myMarker);

//$mostRecent = $myConnection->getAllMarkers($myMarker);



//$results = $dbConnect -> getAllMarkers($myMarker);

//$return = json_decode($mostRecent);

//var_dump($return);
