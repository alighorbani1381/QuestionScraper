<?php

use Src\StorageFileSaver;

require("../vendor/autoload.php");

$file = new StorageFileSaver('test');

$file->write('hello alekom!');

$file->saveAndCloseFile();