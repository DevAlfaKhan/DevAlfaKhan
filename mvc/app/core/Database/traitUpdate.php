<?php

trait traitUpdate
{
    use databaseConntection;
    public static $conn;
    public $QueryString = "";
    public $ExecuteData = array();


    public function __construct()
    {
        self::$conn = $this->connection();
    }

    public function update()
    {
        $this->QueryString = "update";
        return $this;
    }


    /*
    /
    /  method to add where cluse in select or update query
    /
    */
    public function find(string $condition, $conditionValue)
    {
        $this->QueryString .= " where $condition = :$condition";
        $this->ExecuteData[$condition] = $conditionValue;
        $this->readQueryExecute();
        return $this;
    }


    /*
    /
    /  update the data with select query
    /
    */
    public function save(array $data)
    {
        $conditionArray = explode(" ", $this->QueryString);
        $condition = "";

        for ($i = 4; $i < count($conditionArray); $i++) {
            $condition .= "$conditionArray[$i] ";
        }

        $getTableName = explode(" ", $this->QueryString);
        $gotTableName = $getTableName[3];

        $this->QueryString = "update $gotTableName set ";
        foreach ($data as $key => $value) {
            $this->QueryString .= " $key=:$key,";
        }

        $this->QueryString = trim($this->QueryString, ",");
        $this->QueryString .= " $condition";

        foreach ($data as $key => $value) {
            $this->ExecuteData[$key] = $data[$key];
        }

        $result = $this->finish($this->ExecuteData);
        if ($result) {
            return true;
        }
        return false;
    }


    /*
    /
    /  method to add set cluse in update query
    /
    */
    public  function set(array $data)
    {
        $this->QueryString .= " set";
        foreach ($data as $key => $value) {
            $this->QueryString .= " $key=:$key,";
        }
        $this->QueryString = trim($this->QueryString, ',');
        $this->ExecuteData = $data;
        return $this;
    }
}
