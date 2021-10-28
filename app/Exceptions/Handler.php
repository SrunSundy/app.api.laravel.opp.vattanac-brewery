<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use App\Http\Traits\ResponseTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    use ResponseTrait;

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
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {

        if ($exception instanceof HttpException) {
            $code = $exception->getStatusCode();
            $message = Response::$statusTexts[$code];

            return $this->fail($message, $code);
        }

        if ($exception instanceof ModelNotFoundException) {
            $model = strtolower(class_basename($exception->getModel()));

            return $this->fail(__('auth.record_not_found'), Response::HTTP_NOT_FOUND);
            //return responseFail(trans('response.model_not_found', ['attribute' => $model]), Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof AuthorizationException) {
            return $this->fail(__('auth.forbidden'), Response::HTTP_FORBIDDEN);
            //return responseFail($exception->getMessage(), Response::HTTP_FORBIDDEN);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->fail(__('auth.unauthorized'), Response::HTTP_UNAUTHORIZED);
            //return responseFail($exception->getMessage(), Response::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof ValidationException) {
            //$errors = $exception->validator->errors()->getMessages();

            // return parent::render($request, $exception);
            return $this->fail($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
            // return responseFail($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        // return $this->fail("Server Error" , Response::HTTP_INTERNAL_SERVER_ERROR);
        //return $this->fail($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);

        return parent::render($request, $exception);
    }
}
