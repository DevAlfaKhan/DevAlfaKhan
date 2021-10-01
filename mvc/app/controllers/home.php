<?php

class Home extends Controller
{

    public function index()
    {
        
        $DB = Database::Instance();
        $result = $DB->select()->table("users")->pagination();
        show($result);
        // $data['result'] = $result;
        $this->view("index");
    }
}