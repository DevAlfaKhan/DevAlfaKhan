<?php

trait traitRead
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

    /*
    /
    /  variable to store store retrive data
    /
    */
    public $ReadData = array();


    public function __construct()
    {
        self::$conn = $this->connection();
    }

    /*
    /
    /  method to make select query
    /
    */
    public function select(array $columnName = array())
    {

        if (!empty($columnName)) {
            $columnName = implode(",", $columnName);
            $this->QueryString = "select $columnName from";
        } else {
            $this->QueryString = "select * from";
        }

        return $this;
    }

    /*
    /
    /  method to make select query with table
    /
    */
    public function table(string $tableName)
    {
        $this->QueryString .= " $tableName";
        return $this;
    }


    /*
    /
    /  method to nake jion query with select opration
    /
    */
    public function join(string $tableName, array $on)
    {
        $conditionString = "";
        foreach ($on as $key => $value) {
            $conditionString .= "= $key.$value ";
        }
        $conditionString = trim($conditionString, "=");
        $conditionString = trim($conditionString);
        $this->QueryString .= " join $tableName on $conditionString";
        return $this;
    }

    /*
    /
    /  method to add where cluse in select or update query
    /
    */
    public function where(string $condition, $conditionValue, bool $isBinary = false)
    {

        $condition2 = str_replace(".", "_", trim($condition));
        if ($isBinary) {
            $this->QueryString .= " where binary $condition = :$condition2";
        } else {
            $this->QueryString .= " where $condition = :$condition2";
        }

        $this->ExecuteData[$condition2] = $conditionValue;
        return $this;
    }


    /*
    /
    /  method to add where cluse in select or update query
    /
    */
    public function id(int $id)
    {
        show($this->QueryString);
        if (preg_match_all('/join/i', $this->QueryString)) {
            $array = explode(" ", $this->QueryString);
            $gotTableName = $array[3];
            $this->QueryString .= " where $gotTableName.id =:id";
        } else {
            $this->QueryString .= " where id =:id";
        }
        $this->ExecuteData['id'] = $id;
        return $this;
    }


    /*
    /
    /  method to add limit cluse in select or update query
    /
    */
    public function limit(int $limit, int $offset = null)
    {
        if ($offset != null) {
            $this->QueryString .= " limit $offset, $limit";
        } else {
            if ($limit == 0) {

                $this->QueryString .= " limit 1";
            } else {
                $this->QueryString .= " limit $limit";
            }
        }
        return $this;
    }


    /*
    /
    /  method to exeute the query and retrun the data
    /
    */
    public function get()
    {
        $this->readQueryExecute();
        return $this->ReadData;
    }

    /*
    /
    /  method to exeute the query not return;
    /
    */
    private function readQueryExecute()
    {
        $stmt = self::$conn->prepare($this->QueryString);
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try {
            $result = $stmt->execute($this->ExecuteData);

            if ($result) {
                $data = $stmt->fetchAll(PDO::FETCH_OBJ);

                if (is_array($data) && count($data) > 0) {
                    unset($_SESSION['PDO_QUERY_ERROR']);
                    $this->ReadData = $data;
                    return $this;
                }
                return false;
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
    /  as you know this is pagination method
    /
    */
    public function pagination()
    {
        
        return $this;
    }

    /*
    /
    /  method show query
    /  show the execution data
    /
    */
    public function checkQuery()
    {
        show($this->ExecuteData);
        show($this->QueryString);
    }
}
