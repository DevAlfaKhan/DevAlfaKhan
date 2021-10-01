<?php

include "traitDatabase.php"; // include the Database triat to use the methods here
include "traitRead.php";     // include the Read triat to use the methods here
include "traitInsert.php";   // include the Insert triat to use the methods here
include "traitDelete.php";   // include the Detete triat to use the methods here
include "traitUpdate.php";   // include the Update triat to use the methods here

class Database
{
    // use here above included traits
    use databaseConntection, traitRead, traitInsert, traitDelete, traitUpdate;

    /*
    /
    /  Store the connection here
    /
    */
    public static $conn;

    /*
    /
    / When the class instanctie 
    / this connection method will run
    /
    */
    public function __construct()
    {
        try {
            self::$conn = $this->connection();
        } catch (PDOException $th) {
            die($th->getMessage());
        }
    }

    /*
    /
    / This method give the adventage to developer
    / This method will show if the connection was created or not   
    */
    public function checkConnection()
    {
        show(self::$conn);
    }

    /*
    /
    / This instance method return the object of this class
    /
    */
    public static function Instance()
    {
        return new self();
    }


    /*
    /
    / Method to read from database
    /
    */
    public function read($query, $data = array())
    {
        $stmt = self::$conn->prepare($query);
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try {
            $result = $stmt->execute($data);

            if ($result) {
                $data = $stmt->fetchAll(PDO::FETCH_OBJ);

                if (is_array($data) && count($data) > 0) {
                    unset($_SESSION['PDO_QUERY_ERROR']);
                    return $data;
                }
                return false;
            }
        } catch (PDOException $e) {
            $_SESSION['PDO_QUERY_ERROR'] = array(
                'message' => $e->getMessage(),
                'fileName' => $e->getTrace()[1]['file'],
                'lineNumber' => $e->getTrace()[1]['line'],
                'userOf' => $e->getTrace()[1]['function'],
                'queryString' => $e->getTrace()[1]['args'][0],
            );
            include "../app/errors/PDOQueryError.php";
        }
    }


    /*
    /
    / Method to save into database
    / opration : Insert,update,delete,alter
    */
    public function write($query, $data = array())
    {
        $stmt = self::$conn->prepare($query);
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try {
            $result = $stmt->execute($data);

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
                'queryString' => $e->getTrace()[1]['args'][0],
            );
            include "../app/errors/PDOQueryError.php";
        }
    }

    // USEAGS

    // $result = $DB->select(['users.id','users.student_name'])->table("users")->join("studentclass",['users'=>'course','studentclass'=>"id"])->id(3)->get();
    //$result = $DB->select(['users.id','users.student_name','studentclass.classname'])->table("users")->join("studentclass",['users'=>'course','studentclass'=>"id"])->id(6)->get();
    //$result = $DB->read("select u.*,s.classname from users as u inner join studentclass s on u.course = s.id");
    // $result = $DB->delete()->table("user")->id(32,false)->finish();
    // $result = $DB->select()->table("user")->where('email','Iloveyou@gmail.com',true)->get();
    // $result = $DB->insert()->table("user")->data($data)->finish();
    // $result = $DB->select()->table('users')->id(3)->get();
    // $data = [
    //     'student_name' => "Dm Alfa Khan 2",
    // ];
    // $result = $DB->update()->table("user")->set($data)->id(31)->finish();
    // if($result){
    //     echo "inserted";
    // }else{
    //     echo "not Inserted";
    // }
    // $result = $DB->select()->table('users')->find('id',6)->save($data);

    // show($result);
    // $DB->checkQuery();
}
