<?php

class Controller
{
    /*
    /
    / View method load the view page for UI
    /  
    / This method first check for valid view
    / if exists the view include it right here.
    / if not than show an error page(view)
    /
    */
    public function view($viewName, $data = array())
    {
        if (!isset($_SESSION['PDO_QUERY_ERROR'])) {

            /*
            / This is php 7 in-built function to extract the array
            / and make array's keys as variables.
            / extract data to for help full
            / 
            */
            extract($data);

            /*
            / This logic will when arrays have an assocative array
            / 
            */
            if (isset($data['error'])) {
                extract($error);
            }

            // Check if file extsts 
            if (file_exists('../app/views/' . strtolower($viewName) . ".php")) {

                // If exists than load the view
                include "../app/views/" . strtolower($viewName) . ".php";
            } else {

                // If not exists than load 404 view
                include "../app/errors/viewNotFound.php";
                die;
            }
        }
    }


    /*
    /
    / load model method load the model
    / 1. search for the model name mean check for class gevin the value.
    / 2. if exists the model include it here.
    / 3. and than retrun the instance(object) of that class
    */
    public function loadModel($modelName)
    {

        // Check for file exists
        if (file_exists("../app/models/" . strtolower($modelName) . ".class.php")) {

            //If exists new load the model and instianceat the model
            require "../app/models/" . strtolower($modelName) . ".class.php";
            $modelName = new $modelName;
            return $modelName;
        } else {
            
            // if model not exists than load the model error
            include "../app/errors/modelNotFound.php";
            die;
        }
    }
}
