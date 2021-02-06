<?php

namespace App\Requests;

use Src\Services\RequestInterface;
use Src\Services\RequestInitializer;

class QuestionList extends RequestInitializer  implements RequestInterface
{
    const TWELFTH_GRADE  = 71;

    const TYPE_OF_VIEW = "list";

    public $requestUrl = 'http://hsmai.ir/newpanels/?controller=data&action=questionPoolQuestionList';

    public $requestParameter = [];

    public $resultPerPage  = 100;

    public $paginationIndex = 0;

    public function __construct($resultPerPage, $paginationIndex)
    {
        parent::__construct();

        $this->requestParameter = [

            "filter" => [
                "text" => "All",
                "value" => "all"
            ],

            "view" => self::TYPE_OF_VIEW,

            "pageSize" => $resultPerPage,

            "pageIndex" => $paginationIndex,

            "poolId" => self::TWELFTH_GRADE
        ];
    }
}
