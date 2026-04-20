@extends('layouts.app')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $product->name }}</div>

                <div class="panel-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><strong>Hotel</strong></td>
                                <td>{{ $product->hotel->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Categoria</strong></td>
                                <td>{{ \PMS\Payment::$categories[$product->category] }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nombre</strong></td>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Código del producto</strong></td>
                                <td>{{ $product->sku }}</td>
                            </tr>
                            <tr>
                                <td><strong>Descripción</strong></td>
                                <td>{{ $product->description }}</td>
                            </tr>
                            <tr>
                                <td><strong>Precio</strong></td>
                                <td>${{ number_format($product->price, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection