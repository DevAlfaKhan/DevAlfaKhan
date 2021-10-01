<?php

trait validateMethods
{
    use ErrorMessage;   

    public function makeArray(array $inputsName)
    {
        $data = array();
        foreach ($inputsName as $key => $value) {
            
            $makeKey = explode(" ", $value);

            $validateData = explode("|", $inputsName[$key]);
            unset($validateData[0]);

            $validateData = array_values($validateData);
            $makekeyvalues = array();

            
            foreach ($validateData as $key2 => $value2) {
                if(preg_match_all('/\,/i',$value2)){
                    $expload = explode(",", $value2);
                    $makekeyvalues[trim($expload[0])] = $expload[1];
                }else{
                    $makekeyvalues[trim($value2)] =  $value2;
                }
            }

            $data[$makeKey[0]] = $makekeyvalues;
        }
        return $data;
    }

    public function validateVlaues($key, $validType, $data)
    {   
        foreach ($validType as $validTypeKey => $validTypeValue) {
            foreach ($data as $dataKey => $dataValue) {
                if ($key == $dataKey) {
                   $this->getMeassage(trim($key), trim($validTypeKey), trim($validTypeValue), trim($data[$key]));              
                } 
            }
        }
    }


}
