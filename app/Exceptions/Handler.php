<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (ModelNotFoundException $exception, Request $request) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        });

        $this->renderable(function (NotFoundHttpException $exception, Request $request) {
            $message = !empty($exception->getMessage())
            ? $exception->getMessage()
            : __('error.route_not_found');

            return response()->json([
                'message' => $message,
            ], Response::HTTP_NOT_FOUND);
        });

        $this->renderable(function (AuthenticationException $exception, Request $request) {
            return response()->json([
                'message' => __('auth.unauthenticated'),
            ], Response::HTTP_UNAUTHORIZED);
        });

        $this->renderable(function (MethodNotAllowedHttpException $exception, Request $request) {
            return response()->json([
                'message' => __('error.method_not_allowed'),
            ], Response::HTTP_METHOD_NOT_ALLOWED);
        });

        $this->renderable(function (ValidationException $exception, Request $request) {
            return response()->json([
                'message' => $exception->validator->errors()->first(),
            ], Response::HTTP_BAD_REQUEST);
        });

        // Exceção para lidar com métodos HTTP inesperados
        $this->renderable(function (Throwable $exception, Request $request) {
            if ($exception instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'message' => 'Método HTTP não permitido para esta rota.',
                ], Response::HTTP_METHOD_NOT_ALLOWED);
            }

            if (app()->bound('sentry') && !app()->isLocal()) {
                app('sentry')->captureException($exception);
            }

            $status = method_exists($exception, 'getStatusCode')
            ? $exception->getStatusCode()
            : Response::HTTP_INTERNAL_SERVER_ERROR;

            $message = $exception->getMessage();

            return response()->json([
                'message' => $message,
            ], $status);
        });
    }
}
