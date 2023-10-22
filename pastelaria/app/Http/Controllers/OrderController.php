<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Service\OrderService;
use App\Models\Order;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function create(CreateOrderRequest $request) : Response
    {
        $createdOrder = $this->orderService->add($request->validated());
        return response($createdOrder);
    }

    public function get(int $id) : Response
    {
        $order = $this->orderService->getById($id);
        return response($order);
    }

    public function list() : Response
    {
        $orders =  $this->orderService->list();
        return response($orders);
    }

    public function delete(int $id) : Response
    {
        $this->orderService->delete($id);
        return response(['message' => 'pedido excluido']);
    }

    public function changeProducts(UpdateOrderRequest $request, Order $order)
    {
        $order = $this->orderService->changeProducts($request->validated(), $order);
        return response($order);
    }
}
