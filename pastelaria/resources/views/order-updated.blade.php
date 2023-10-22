<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="col-md-8">
    <h2>Olá, {{$data->customer->nome}}!</h2>
</div>
<div class="col-md-6 align-items-center">
    <h2>Seu Pedido foi atualizado com sucesso.</h2>
</div>
<div class="col-md-6">
    <table>
        <thead>
        <tr>
            <th>Produto</th>
            <th>Valor</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data->items as $item)
            <tr>
                <td>{{$item->product->nome}}</td>
                <td>R$ {{$item->product->preco}}</td>
            </tr>
        @endforeach
        <tr>
            <th>Total: R${{$data->total_cost}}</th>
            <th></th>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>

