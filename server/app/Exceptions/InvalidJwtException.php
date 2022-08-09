<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class InvalidJwtException extends Exception
{
    /** @var string */
    protected $title;

    /** @var string */
    protected $detail;

    /** @var int */
    protected $code;

    /**
     * @param int $code
     * @param \Throwable|null $e
     */
    public function __construct(int $code, \Throwable $e = null)
    {
        $this->title = 'Unauthorized';
        $this->detail = 'Bad credentials';
        $this->code = $code;
        parent::__construct($this->title, $code, $e);
    }

    public function render()
    {
        return response()->json([
            'errors' => [[
                'status' => strval(Response::HTTP_UNAUTHORIZED),
                'code' => strval($this->code),
                'title' => $this->title,
                'detail' => $this->detail,
                'source' => null
            ]]
        ], Response::HTTP_UNAUTHORIZED);
    }
}