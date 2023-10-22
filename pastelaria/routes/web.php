<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('order-created', ['data' => json_decode('{"id":15,"cliente_id":2,"created_at":"2023-10-22T01:03:23.000000Z","updated_at":"2023-10-22T01:03:23.000000Z","deleted_at":null,"items":[{"id":43,"pedido_id":15,"produto_id":1,"created_at":"2023-10-22T01:03:23.000000Z","updated_at":"2023-10-22T01:03:23.000000Z","deleted_at":null,"product":{"id":1,"nome":"Pastel de Carne","preco":8,"foto_produto":"http:\/\/localhost:8000\/produtos\/phpQy6vue.jpg","created_at":"2023-10-21T16:39:00.000000Z","updated_at":"2023-10-21T16:39:00.000000Z","deleted_at":null}},{"id":44,"pedido_id":15,"produto_id":1,"created_at":"2023-10-22T01:03:23.000000Z","updated_at":"2023-10-22T01:03:23.000000Z","deleted_at":null,"product":{"id":1,"nome":"Pastel de Carne","preco":8,"foto_produto":"http:\/\/localhost:8000\/produtos\/phpQy6vue.jpg","created_at":"2023-10-21T16:39:00.000000Z","updated_at":"2023-10-21T16:39:00.000000Z","deleted_at":null}},{"id":45,"pedido_id":15,"produto_id":1,"created_at":"2023-10-22T01:03:23.000000Z","updated_at":"2023-10-22T01:03:23.000000Z","deleted_at":null,"product":{"id":1,"nome":"Pastel de Carne","preco":8,"foto_produto":"http:\/\/localhost:8000\/produtos\/phpQy6vue.jpg","created_at":"2023-10-21T16:39:00.000000Z","updated_at":"2023-10-21T16:39:00.000000Z","deleted_at":null}}],"customer":{"id":2,"nome":"Ze Alterado Novamente Exemplo","email":"thierryalves.oliveira21@gmail.com","telefone":"35931074","data_nascimento":"03\/01\/1998","endereco":"Rua Exemplo Alterada","complemento":"apto 3","bairro":"Bairro Exemplo","cep":"09310260","created_at":"2023-10-21T13:57:09.000000Z","updated_at":"2023-10-21T22:50:38.000000Z","deleted_at":null}}')]);
});
