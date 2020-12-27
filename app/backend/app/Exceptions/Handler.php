<?php

namespace App\Exceptions;

use HttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Throwable;
use TypeError;

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

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof HttpException) {
            return response()->json(["error" => $exception->getMessage()], $exception->getStatusCode());
        } elseif ($exception instanceof NotFoundResourceException) {
            return response()->json(["error" => $exception->getMessage()], 404);
        } elseif ($exception instanceof QueryException) {
            return response()->json(["error" => "Ошибка БД [{$exception->getCode()}]"], 500);
        } elseif ($exception instanceof ValidationException) {
            return response()->json(["error" => "Ошибка валидации запроса"], $exception->status);
        } elseif ($exception instanceof TypeError) {
            $trace = $exception->getTrace();
            return response()->json([
                "error" => 'Неправильный тип: Класс - ' . (current($trace)['class'] ?? 'Нет') . ' Функция - ' . current($trace)['function']
            ], 500);
        } elseif ($exception instanceof InvalidArgumentException) {
            return response()->json(["error" => "Неправильный аргумент: {$exception->getMessage()}"], 500);
        } elseif ($exception instanceof UnauthorizedException) {
            return response()->json(["error" => "Ошибка авторизации"], 401);
        } elseif ($exception instanceof AuthenticationException) {
            return response()->json(["error" => "Ошибка авторизации"], 401);
        } elseif ($exception instanceof NotFoundHttpException) {
            return response()->json(["error" => "Недопустимый метод"], 405);
        } else {
            return response()->json(["error" => $exception->getMessage()], 500);
        }
    }
}
