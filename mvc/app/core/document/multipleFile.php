<?php
include "traitMultiplefilesHandle.php";
class MultipleFIle
{
    use MultipleFIlesHandle;


    public static function Instance()
    {
        return new self();
    }

    public function files($files, array $validate, bool $requiredAllFiles = false)
    {

        $this->inputsName = array_keys($files);

        if ($requiredAllFiles) {
            $this->checkEmpty($files);

            
            if (empty($this->FilesErrer)) { // added at the end
                $this->isError();

                if ($this->isError) {
                    $this->validateFiles($files, $validate);
                }
            }
        } else {
            $notEmptyFiles = array();

            foreach ($files as $key => $value) {
                if (!empty($files[$key]['name'])) {
                    $notEmptyFiles[$key] = $files[$key];
                }
            }

            if (!empty($notEmptyFiles)) {
                $this->validateFiles($notEmptyFiles, $validate);
            }
        }

        return $this;
    }

    public function uploadFiles($path, bool $addDataTime = false)
    {

        $this->saveFiles($path, $addDataTime);
    }


    // $conditaion = ['size'=>'2','byte'=>'mb','type'=>'jpg'];
    // $Files->files($_FILES,$conditaion)->uploadFiles("uploads/",true);
    // show($Files->FilesErrer);
    // show($Files->uploadedFilesName);

    // $Files = MultipleFIle::Instance();
    // $conditaion = ['size'=>'100','byte'=>'mb','type'=>'mp4'];
    // $Files->files($_FILES,$conditaion)->uploadFiles("uploads/",true);
    // show($Files->FilesErrer);
    // show($Files->uploadedFilesName);
}
