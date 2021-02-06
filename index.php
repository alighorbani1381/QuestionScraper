<?php

use Src\DependencyChecker;
use PhpTool\Vardumper\Debug;
use App\Actions\QuestionBank;
use App\Actions\Authentication;


require_once('vendor/autoload.php');

// check dependency to run application
DependencyChecker::check();

$auth = Authentication::getInstance();

$auth->loginIfDonsentLogin();

$questionBank = new QuestionBank();

$questionBank->collectQuestions()->saveNewTxtFile();

//>> php will be ((automaticly)) logout account from hsmai website