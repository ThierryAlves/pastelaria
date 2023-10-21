<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Service\OrderService;

class OrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function create(CreateOrderRequest $request)
    {
        $createdOrder = $this->orderService->add($request->validated());
        return response($createdOrder);
    }

    public function get(int $id)
    {
        $order = $this->orderService->getById($id);
        return response($order);
    }

    public function list()
    {
        $orders =  $this->orderService->list();
        return response($orders);
    }

    public function changeProducts(UpdateOrderRequest $request)
    {
        $updatedOrder =  $this->orderService->changeProducts($order);
        return response($updatedOrder);
    }

    public function delete(int $id)
    {
        $this->orderService->delete($id);
        return response(['message' => 'pedido excluido']);
    }
}
