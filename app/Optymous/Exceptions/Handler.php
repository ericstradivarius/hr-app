<?php

namespace App\Optymous\Exceptions;

use Exception;
use HttpResponseException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception) {
        if(env('SENTRY_DSN') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception) {
        if($exception instanceof NotFoundHttpException || $exception instanceof ModelNotFoundException) {
            return $this->notFound($request, $exception);
        }

        if($exception instanceof UnauthorizedException || $exception instanceof AuthorizationException) {
            return $this->unauthorized($request, $exception);
        }

        if(!App::isLocal() && $request->expectsJson()) {
            if ($exception instanceof HttpResponseException) {
                return $this->renderJsonErrors([
                    'general' => [
                        $exception->getResponse()
                    ]
                ], $exception->getCode());
            } elseif ($exception instanceof AuthenticationException) {
                return $this->unauthenticated($request, $exception);
            } elseif ($exception instanceof ValidationException) {
                return $this->convertValidationExceptionToResponse($exception, $request);
            }

            return $this->renderJsonErrors([
                'general' => [
                    'Internal server error.'
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception) {
        if ($request->expectsJson()) {
            return $this->renderJsonErrors([
                'general' => [
                    'Unauthenticated.'
                ]
            ], Response::HTTP_UNAUTHORIZED);
        }

        return redirect()->guest(route('login'));
    }

    protected function notFound($request, $exception) {
        if ($request->expectsJson()) {
            return $this->renderJsonErrors([
                'general' => [
                    'Not found.'
                ]
            ], Response::HTTP_NOT_FOUND);
        }

        return parent::render($request, $exception);
    }

    protected function unauthorized($request, $exception) {
        if ($request->expectsJson()) {
            return $this->renderJsonErrors([
                'general' => [
                    'Forbidden.'
                ]
            ], Response::HTTP_FORBIDDEN);
        }

        return redirect()->guest(route('login'));
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request) {
        if($request->expectsJson()) {
            $errors = $e->validator->errors()->getMessages();

            return $this->renderJsonErrors($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return parent::convertValidationExceptionToResponse($e, $request);
    }

    public function renderJsonErrors($errors, $status) {
        return response()->json([
            "errors" => $errors,
            "data" => null,
            "status" => $status,
            "statusText" => Response::$statusTexts[$status]
        ], $status);
    }
}
