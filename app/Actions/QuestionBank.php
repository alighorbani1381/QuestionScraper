<?php

namespace App\Actions;

use Src\StorageFileSaver;
use Src\DOM\DomDispatcher;
use PhpTool\Vardumper\Debug;
use App\Requests\QuestionList;
use App\Requests\GetSingleQuestion;
use Src\Services\RequestDispatcher;
use App\DomParser\SingleQuestionParser;

class QuestionBank
{
    const START_INDEX_FROM = 0;

    const COUNT_OF_RESULT = 1000;

    public $questionInfo;

    public $fileContent;

    public function __construct()
    {
        $this->initializeQuestion();
    }

    /**
     * run QuestionList Request and set result on questionInfo property
     * it means this method initialize question into it self
     * 
     * @return void
     */
    public function initializeQuestion()
    {
        $questionList = RequestDispatcher::dispatch(QuestionList::class, [self::COUNT_OF_RESULT, self::START_INDEX_FROM]);

        $this->questionInfo = json_decode($questionList);
    }

    /**
     * Get Useful information from question
     * 
     * @param object $question
     * 
     * @return string
     */
    public function getSingleQuestionInfo($question)
    {
        $questionID = (int) $question->id;

        $questionHTML = RequestDispatcher::dispatch(GetSingleQuestion::class, (array)$questionID);

        return DomDispatcher::getUsefulInfo(SingleQuestionParser::class, [$questionHTML]);
    }

    /**
     * Check is Question Loading Fail
     * Whene Question Loading Any Where return true
     * 
     * @return bool
     */
    public function questionLoadingFailed()
    {
        return (!isset($this->questionInfo->items));
    }

    /**
     * Collect question with specify format set in property
     * 
     * @return self
     */
    public function collectQuestions()
    {
        if ($this->questionLoadingFailed()) {
            die("Question is Not Loaded Error!");
        }

        foreach ($this->questionInfo->items as $question) {

            $questionInfo = $this->getSingleQuestionInfo($question);

            $this->fileContent[] = $this->formatOfQuestion($questionInfo);
        }

        return $this;
    }

    /**
     * Save Questions collection into new txt file
     * 
     * @return void
     */
    public function saveNewTxtFile()
    {

        $fileName =  date("Y-m-d") . '-' . rand(0, 512) . "Question";

        $file = new StorageFileSaver($fileName);

        foreach ($this->fileContent as $content) {
            $file->write($content);
        }

        $file->saveAndCloseFile();
    }

    /**
     * Format of Question (write for save into txt file)
     * 
     * @return stringF
     */
    public function formatOfQuestion($questionInfo)
    {
        return $questionInfo['question'] . "\n\n" . implode(" \n ", $questionInfo['item']) . "\n\n" . $questionInfo['answer'] . "\n\n" . "**********" . "\n\n";
    }

    /**
     * return report of working in the question bank
     * 
     * @return void
     */
    public function report()
    {
        echo "Question Bank Work is finish";

        echo "<br>";

        echo "Please Check Storage Folder";

        echo "<br>";

        echo 'Count of Questions Get From Hsmai Server is: ' . count($this->questionInfo->items);

        echo "questions";
    }
}
