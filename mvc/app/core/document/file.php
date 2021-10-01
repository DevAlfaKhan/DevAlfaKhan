<?php

include "traitFile.php";

class File
{

    use fileValidate;

    public static function Instance()
    {
        return new self();
    }

    public function file(array $file = array(), string $inputName = "")
    {
        if (!empty($file)) {
            $this->inputName     = $inputName;
            $this->fileName     = $file[$inputName]['name'];
            $this->fileTmpName  = $file[$inputName]['tmp_name'];
            $this->fileSize     = $file[$inputName]['size'];
            $this->fileType     = pathinfo($file[$inputName]['name'], PATHINFO_EXTENSION);
        }
        return $this;
    }

    public function validateFile(array $fileValidate, bool $addDataTime = false)
    {
        if ($addDataTime) {
            $this->fileName = date('d-m-Y-h-i-a-') . $this->fileName;
        }
        $file = explode("|", $fileValidate['size']);
        $type = explode("/", $fileValidate['type']);
        $getbytes = $this->getByteSize($file);
        $this->validateSize($getbytes, $file);
        $this->validateType($type);

        return $this;
    }

    public function upload($path)
    {
        if (empty($this->fileError)) {
            if (move_uploaded_file($this->fileTmpName, $path . $this->fileName)) {
                return $this->fileName;
            }
        }
    }



    public function showProperties()
    {
        show($this->fileError);
        show("inputName : " . $this->inputName);
        show("name : " . $this->fileName);
        show("fileType : " . $this->fileType);
        show("fileTmpName : " . $this->fileTmpName);
        show("fileSize : " . $this->fileSize);
    }


    // $File = File::Instance();
    // $conditaion = ['size'=>'3|KB','type'=>'jpg/jpeg/png'];
    // $fileName = $File->file($_FILES,'file')->validateFile($conditaion,true)->upload("uploads/");
    // $data['error']= $File->fileError;
}
