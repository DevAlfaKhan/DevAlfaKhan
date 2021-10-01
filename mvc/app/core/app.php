<?php

class App
{
    /* 
    /
    / This is default controller
    */
    private $ControllerName = "home";

    /* 
    /
    / This is default method
    /
    */
    private $methodName = "index";

    /* 
    /
    / Here will store all the rest of url as arguments
    / after finding controller and method 
    / This variable sarve url as array in define method or default method
    */
    private $param;


    /* 
    /
    / This construct will run when someone visit the website
    / Why this controller run
    / 1. constructer will find the class crossponde the url
    / 2. constructer will find the method crossponde the url
    /
    */
    public function __construct()
    {
        $url = $this->parshURL();

        /* 
        /
        /  Check if controller exists
        /  controller mean the class given from url
        /  if controller is exists include the class
        /   instianciat it right down. 
        */
        $url[0] = str_replace("-", "_", $url[0]);
        if (file_exists("../app/controllers/" . strtolower($url[0]) . ".php")) {
            $this->ControllerName = strtolower($url[0]);
            unset($url[0]);
        }

        /* 
        / 
        / if controller not exists than run the default controller which is home controller 
        / Instianciat the class
        /
        */
        include "../app/controllers/" . $this->ControllerName . ".php";
        $this->ControllerName = new $this->ControllerName;

        /* 
        /
        / Check if method exists 
        / If the method exists given from url
        / than set it to methodName variable above
        / if not exists than there is default method call index
        /
        */
        if (isset($url[1])) {
            if (method_exists($this->ControllerName, strtolower($url[1]))) {
                $this->methodName = strtolower($url[1]);
                unset($url[1]);
            }
        }

        /* 
        /
        / If there any values in url variable set them as array 
        / on param variable above;
        / Rest of url values pass as arguments by given or deafult method
        /
        */
        $this->param = (count($url) > 0) ? array_values($url) : [NULL];
        call_user_func_array([$this->ControllerName, $this->methodName], $this->param);
    }

    
    /*
    /
    / This parshURL method will check for valid url.
    / and than convert then to an array 
    / retrun the values where tis from called;
    /
    */
    private function parshURL()
    {
        // check url empty or not
        $url = isset($_GET['url']) ? $_GET['url'] : "home";
        
        // if not convert the url an array
        $url = explode("/", filter_var(trim($url, "/"), FILTER_SANITIZE_URL));
        return $url;
    }
}
