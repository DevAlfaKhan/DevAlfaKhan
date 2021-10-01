<?php

trait ErrorMessage
{
    public $ErrorMessage = array();
    public function getMeassage($key, $validType, $validTypeValues, $dataForValdated)
    {
 
        if ($validType == "max") {
            if (strlen($dataForValdated) > $validTypeValues) {                
                $this->ErrorMessage[$key] = "The $key field must less than $validTypeValues cherectors long.";
            }
        }

        if ($validType == "min") {
            if (strlen($dataForValdated) < $validTypeValues) {
                $this->ErrorMessage[$key] = "The $key field must grather than $validTypeValues cherectors long.";
            }
        }

        if ($validType == "required") {
            if (empty($dataForValdated)) {
                $this->ErrorMessage[$key] = "The $key field is required";
            }
        }

        if ($validType == "equl") {
            $dataForValdated = (string)$dataForValdated;
            if (strlen($dataForValdated) != $validTypeValues) {
                $this->ErrorMessage[$key] = "The $key field must be $validTypeValues cherectors";
            }
        }

        if ($validType == "phone") {           
            $dataForValdated = (string)$dataForValdated;
            if (strlen($dataForValdated) != 10) {
                $this->ErrorMessage[$key] = "The $key field must be 10 cherectors";
            }
        }

        if ($validType == "email") {           
            if (!filter_var($dataForValdated,FILTER_VALIDATE_EMAIL)) {
                $this->ErrorMessage[$key] = "Invalid email id";
            }
        }
    }
}
