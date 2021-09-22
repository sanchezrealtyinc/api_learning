<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [];

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

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'error',
                'error' => 'Unauthenticated'
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            abort(JsonResponse::HTTP_METHOD_NOT_ALLOWED, 'Method not allowed');
        }

        if($exception instanceof ModelNotFoundException){
            return response()->json([
                'status' => 'error',
                'message' => 'There is no instance with the specified Id'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        if ($request->isJson() && $exception instanceof ValidationException) {
            return response()->json([
                'status' => 'error',
                'message' => [
                    'errors' => $exception->getMessage(),
                    'fields' => $exception->validator->getMessageBag()->toArray()
                ]
            ], JsonResponse::HTTP_PRECONDITION_FAILED);
        }

        if($exception instanceof NotFoundHttpException){
            return response()->json([
                'status' => 'error',
                'message' => 'The specified URL Not Found'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        if($exception instanceof HttpException){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ], $exception->getStatusCode());
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Unexpected failure, try again'
        ],JsonResponse::HTTP_SERVICE_UNAVAILABLE);

        return parent::render($request, $exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

    }
}
