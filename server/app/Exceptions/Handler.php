<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Traits\ApiResponser;
use Exception;
use Psr\Log\LoggerInterface;
use Illuminate\Support\Reflector;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        // parent::report($exception);
        if ($this->shouldntReport($exception)) {
            return;
        }

        if (Reflector::isCallable($reportCallable = [$exception, 'report'])) {
            return $this->container->call($reportCallable);
        }

        try {
            $logger = $this->container->make(LoggerInterface::class);
        } catch (Exception $e) {
            throw $e;
        }

        // // nginx によって注入された request-id を使って一連の処理をトレースする
        $requestId = $_SERVER['HTTP_REQUEST_ID'] ?? 'no-request-id';

        $logger->error(
            $exception->getMessage(),
            array_merge(
                ['requestId' => $requestId],
                $this->exceptionContext($exception),
                $this->context(),
                ['exception' => $exception]
            )
        );
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $response = $this->handleException($request, $exception);
        return $response;
    }

    public function handleException($request, Throwable $exception)
    {
        if ($exception instanceof \TypeError) {
            // if a request header does not have Authorization
            return $this->errorResponse('Oh, your request seems invalid... Please check the request content again.', 400);
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        return $this->errorResponse('Unexpected Exception. Try later', 500);
    }
}
