<?php

use function PHPSTORM_META\type;

trait MultipleFIlesHandle
{
    private $inputsName = array();
    private $storeAllFiles = array();
    private $isError = true;
    public $uploadedFilesName = array();
    public $FilesErrer = array();


    private function checkEmpty($files){
        foreach ($files as $key => $value) {
            if(empty($value['name'])){
                $this->FilesErrer[$key] = "The type file input is required.";
            }
        }
    }

    private function isError()
    {
        foreach($this->FilesErrer as $key =>$value){
            foreach($this->inputsName as $key => $value){
                if($key == $value){
                    $this->isError = false;
                }
            }
        }
    }

    private function validateFiles($files,array $validateType){
        
        $forUser = str_replace("|",", ",$validateType['type']);
        $validateFileType = explode("|",$validateType['type']);
        foreach ($files as $key => $value) {

           $gotFileType =  $this->getFileType($files[$key]['name']);
            if(!in_array($gotFileType,$validateFileType)){
                $this->FilesErrer[$key] = "The file type must be $forUser. 'Given $gotFileType'"; 
            }

            $gotFileBytes = $this->getFileBytes($validateType['size'],$validateType['byte']);
            $message = $validateType['size'].$validateType['byte'];
            if($files[$key]['size'] >  $gotFileBytes){
                $this->FilesErrer[$key] = "The file must be less than $message"; 
            }
        }  

        if(empty($this->FilesErrer)){
            $this->storeAllFiles = $files;
        }
    }

    private function saveFiles($path, bool $addDataTime = false){
        foreach ($this->storeAllFiles as $key => $value) {

            $getFileName = $this->addDataTime($addDataTime,$value);
            if(move_uploaded_file($value['tmp_name'],$path.$getFileName)){
                $this->uploadedFilesName[$key] = $getFileName;
            }
        }   
    }

    private function addDataTime($addDataTime,$FileName)
    {
        $filesName = "";
        if($addDataTime){
            $filesName = date('d-m-Y-h-i-a-').$FileName['name'];
        }else{
            $filesName = $FileName['name'];
        }
        return $filesName;
    }

    private function getFileBytes($size,$type){
        $type = strtolower($type);
        if ($type == "mb") {
            $givenSizeInByte =  (1024 * 1024 * $size);
        } elseif ($type == "kb") {
            $givenSizeInByte = (1024 * $size);
        }
        return $givenSizeInByte;
    }

    private function getFileType($type)
    {
        return pathinfo($type, PATHINFO_EXTENSION);
    }
}