<?php


trait fileValidate
{

    public $fileError   = array();
    private $inputName   = "";
    private $fileName    = "";
    private $fileType    = "pdf";
    private $fileTmpName = "";
    private $fileSize    = "";

    private function getByteSize($size)
    {
        $sizeByte = $size[0];
        $givenSizeInByte = "";
        if ($size[1] != "") {     
            
            $size[1] = strtolower($size[1]);
            if ($size[1] == "mb") {
                $givenSizeInByte =  (1024 * 1024 * $sizeByte);
            } elseif ($size[1] == "kb") {
                $givenSizeInByte = (1024 * $sizeByte);
            }
        }
        return $givenSizeInByte;
    }

    private function validateSize($getbytes,$file)
    {
        if ($this->fileSize > $getbytes) {
            $this->fileError = [$this->inputName => "File size be less than $file[0]".strtoupper($file[1])];
        }
    }

    private function validateType($aceptType)
    {
        $fileTypeString = implode(", ",$aceptType);
        if(!in_array($this->fileType,$aceptType)){
            $this->fileError = [$this->inputName => "Accepted file type is $fileTypeString. Given file type is $this->fileType"];
        }
    }
}
