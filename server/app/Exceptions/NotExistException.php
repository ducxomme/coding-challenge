<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class NotExistException extends Exception
{
    protected $title;
    protected $detail;
    protected $code;

    /**
     * NotExistException constructor.
     * @param string $title
     * @param string $detail
     * @param int $code
     */
    public function __construct(string $title, string $detail, int $code)
    {
        // constructに渡すcodeがintのため、$codeはint型にする
        parent::__construct($title, $code);
        $this->title = $title;
        $this->detail = $detail;
        $this->code = $code;
    }

    public function render()
    {
        return response()->json([
            "errors" => [[
                "status" => Response::HTTP_INTERNAL_SERVER_ERROR,
                "code" => $this->code,
                "title" => $this->title,
                "detail" => $this->detail,
                "source" => null
            ]]
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}