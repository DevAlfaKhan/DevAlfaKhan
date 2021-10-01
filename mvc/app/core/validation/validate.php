<?php

include "traitErrorMessage.php";
include "traitValidateMethods.php";

class Validation
{
    use ErrorMessage, validateMethods;
    public $validAbleData = array();

    public static function Instance()
    {
        return new self();
    }

    public function validate(array $inputsName)
    {
        $this->validAbleData = $this->makeArray($inputsName);
        return $this;
    }


    public  function values(array $values)
    {
        if (count($this->validAbleData) === count($values)) {
            if (empty(array_diff_key($values, $this->validAbleData))) {
                foreach ($values as $key => $value) {
                    foreach ($this->validAbleData as $dataKey => $dataValue) {
                        if ($key == $dataKey) {
                            $this->validateVlaues($dataKey, $dataValue, [$key => $values[$key]]);
                        }
                    }
                }
            } else {
                include "../app/errors/validateError.php";
                die;
            }
        } else {
            include "../app/errors/validateError.php";
            die;
        }
    }

    //  $Valid = Validation::Instance();
    //  $data = array('name' => $_POST['name'], 'email' => $_POST['email'], 'phone' => $_POST['phone']);
    //  $Valid->validate([
    //      'name  | max,30 | min,5 | required',
    //      'email | email | max,30 | min,5 | required',
    //      'phone | phone | required'
    //  ])->values($data);

    // to show the error 
    //$this->ErrorMessage
}
