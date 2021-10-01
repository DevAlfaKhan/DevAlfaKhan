<?php

trait traitDelete
{
    use databaseConntection;

    /*
    /
    /  Store the connection here
    /
    */
    public static $conn;

    /*
    /
    /  Variable to store query
    /
    */
    public $QueryString = "";

    /*
    /
    /  variable to store execution data
    /
    */
    public $ExecuteData = array();


    public function __construct()
    {
        self::$conn = $this->connection();
    }

    /*
    /
    / Method to delete from database
    /
    */
    public function delete()
    {
        $this->QueryString = "delete from";
        return $this;
    }
}
