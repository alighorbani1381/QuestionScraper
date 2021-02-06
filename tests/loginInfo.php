<?php

$loginInfo =require( __DIR__ . "/../storage/loginInfo.txt");

$a = unserialize($loginInfo);

var_dump($a->show_one());