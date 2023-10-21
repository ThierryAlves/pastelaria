<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;
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

        if ($e instanceof ModelNotFoundException) {
            return response(
                [
                    'message' => "Unable to locate the {$this->formatModelNotFoundResponseMessage($e)} you requested."
                ],
                404
            );
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            if ($request->is('api/product/update/*')) {
                return response([
                    'message' => 'Falha ao utilizar o método PUT/PATCH com form-data',
                    'detalhes' => 'O método PUT/PATCH do laravel possui um bug onde não é posivel enviar form-data como PUT/PATCH. ' .
                        'Nesses casos, é necessário adicionar um parâmetro _method: PATCH na requisição ' .
                        'ou alterar a mesma para POST (tanto no código como na ferramenta que está sendo utilizada para testar) para que funcione corretamente.',
                    'postman_collection' => 'O postman collection adicionado no e-mail já está com a configuração do _method no request',
                    'link_detalhando_bug' => 'https://laravel.io/forum/02-13-2014-i-can-not-get-inputs-from-a-putpatch-request'
                ], $e->getStatusCode());
            }

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

    private function formatModelNotFoundResponseMessage(ModelNotFoundException $exception): string
    {
        if (! is_null($exception->getModel())) {
            return Str::lower(ltrim(preg_replace('/[A-Z]/', ' $0', class_basename($exception->getModel()))));
        }

        return 'resource';
    }
}
