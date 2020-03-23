<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\QueryException;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Modules\responses\JsonResponse;
use Modules\responses\ResponseConfig;

class Handler extends ExceptionHandler
{
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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof MethodNotAllowedHttpException) {
            JsonResponse::getInstance()->setStatus(JsonResponse::STATUS_NG)
                ->setData([])
                ->setCode(ResponseConfig::CODES['EXCEPTION_METHOD_NOT_ALLOWED'])
                ->setMessage(ResponseConfig::MESSAGES['EXCEPTION_METHOD_NOT_ALLOWED'])
                ->setErrors(['exception' => $exception->getMessage()]);
            return JsonResponse::getInstance()->response();
        }

        if ($exception instanceof NotFoundHttpException) {
            JsonResponse::getInstance()->setStatus(JsonResponse::STATUS_NG)
                ->setData([])
                ->setCode(ResponseConfig::CODES['EXCEPTION_PAGE_NOT_FOUND'])
                ->setMessage(ResponseConfig::MESSAGES['EXCEPTION_PAGE_NOT_FOUND'])
                ->setErrors(['exception' => $exception->getMessage()]);
            return JsonResponse::getInstance()->response();
        }

        if ($exception instanceof QueryException) {
            JsonResponse::getInstance()->setStatus(JsonResponse::STATUS_NG)
                ->setData([])
                ->setCode(ResponseConfig::CODES['EXCEPTION_QUERY'])
                ->setMessage(ResponseConfig::MESSAGES['EXCEPTION_QUERY'])
                ->setErrors(['exception' => $exception->getMessage()]);
            return JsonResponse::getInstance()->response();
        }

        return parent::render($request, $exception);
    }
}
