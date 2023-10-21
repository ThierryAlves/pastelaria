<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof NotFoundHttpException) {
            return response()->json(
                [
                    'message' => $e->getMessage()
                ],
                $e->getStatusCode()
            );
        }

//        if ($e instanceof Throwable) {
//            return response()->json(
//                [
//                    'message' => 'Ocorreu um erro na sua requisição. Favor, informe o administrador'
//                ],
//                500
//            );
//        }

        return parent::render($request, $e);
    }
}
