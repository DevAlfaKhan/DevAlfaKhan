<?php

trait traitInsert
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
    / method to make insert query
    /
    */
    public function insert()
    {
        $this->QueryString = "insert into";
        return $this;
    }


    /*
    /
    /  method to make insertion query
    /
    */
    public function data(array $data)
    {
        $this->QueryString .= " (";
        foreach ($data as $key => $values) {
            $this->QueryString .= $key . ",";
        }
        $this->QueryString = trim($this->QueryString, ",");
        $this->QueryString .= ") values (";
        foreach ($data as $key => $values) {
            $this->QueryString .= ":" . $key . ",";
        }
        $this->QueryString = trim($this->QueryString, ",");
        $this->QueryString .= ")";
        $this->ExecuteData = $data;
        return $this;
    }


    /*
    /
    /  method to execute the insertion, updation, deletion with execution data
    /
    */
    public function finish()
    {
        $stmt = self::$conn->prepare($this->QueryString);
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try {
            $result = $stmt->execute($this->ExecuteData);

            if ($result) {
                if (isset($_SESSION['PDO_QUERY_ERROR'])) {
                    unset($_SESSION['PDO_QUERY_ERROR']);
                }
                return true;
            }
        } catch (PDOException $e) {
            $_SESSION['PDO_QUERY_ERROR'] = array(
                'message' => $e->getMessage(),
                'fileName' => $e->getTrace()[1]['file'],
                'lineNumber' => $e->getTrace()[1]['line'],
                'userOf' => $e->getTrace()[1]['function'],
                'queryString' => $this->QueryString,
            );
            include "../app/errors/PDOQueryError.php";
        }
    }

    /*
    /
    /  Method to redirect user to an other page
    /
    */
    public function redirect(string $path)
    {
        if ($path != "") {
            header("Location" . ROOT . $path);
        } else {
            header("Location" . ROOT);
        }
    }

    /*
    /
    /  method show query
    /  show the execution data
    /
    */
    public function insertQuery()
    {
        show($this->QueryString);
        show($this->ExecuteData);
    }
}
