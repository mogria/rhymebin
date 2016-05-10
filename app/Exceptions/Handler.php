<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $json = [];
        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        } elseif ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        } elseif ($e instanceof AuthorizationException) {
            $e = new HttpException(403, $e->getMessage());
        } elseif ($e instanceof ValidationException && $e->getResponse()) {
            $json['validationErrors'] = $e->validator->errors();
            $json['error'] = $e->getMessage();
            return response()->json($json, $e->response->getStatusCode());
        }
        
        $fe = \Symfony\Component\Debug\Exception\FlattenException::create($e);
        
        $message = empty($fe->getMessage()) ? $fe->getClass() : "{$fe->getClass()}: " .  $fe->getMessage();
        $json = ['error' => $message];
        $options = 0;
        if(env('APP_DEBUG', false)) {
            $json['trace'] = $fe->getTrace();
            $options |= JSON_PRETTY_PRINT;
        }
        
        return response()->json($json, $fe->getStatusCode(), $fe->getHeaders(), $options); 
    }
}
