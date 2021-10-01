<?php

trait databaseConntection
{
    /*
    /
    / Variable to keet connect to database. 
    /
    */
    public static $connection;


    /*
    /
    / method to save connection and save it above 
    / connection variable.
    /
    */
    public function connection()
    {
        try {

            $connectionStrign = DB_TYPE . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";";
            self::$connection = new PDO($connectionStrign, DB_USER, DB_PASS);

            return self::$connection;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
