<?php

namespace Src;

class StorageFileSaver
{
    const STORAGE_PATH = "storage";

    public $savingType = "a+";

    public $fileExtension;

    public $fileHandler;

    public function __construct($fileName, $fileExtension = "txt")
    {
        $this->fileName = $fileName;

        $this->fileExtension = $fileExtension;

        $this->fileHandler = fopen($this->getFileStoragePath(), $this->savingType) or die('file open is failed');
        
    }

    public function getFileStoragePath()
    {
        return self::STORAGE_PATH . "/" . $this->fileName . "." . $this->fileExtension;
    }

    public function write($fileContent)
    {
        fwrite($this->fileHandler, $fileContent);
    }

    public function saveAndCloseFile()
    {
        fclose($this->fileHandler);
    }
}
