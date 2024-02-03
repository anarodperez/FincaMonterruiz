@extends('layouts.admin')

@section('title')
    Admin | Facturas
@endsection
<style>
    form {
        margin: 20px 0;
        background: #f4f4f4;
        padding: 20px;
        border-radius: 8px;
    }

    input[type="text"] {
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 4px;
        width: calc(100% - 24px);
    }

    button {
        padding: 10px 20px;
        border: none;
        border-radius: 10px;
        background-color: #6fa78a;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #406854;
    }
</style>
@section('content')
    <div class="container">
        <div class="text-center my-4">
            <h2 class="display-4 font-weight-bold titulo">Listado de Facturas</h2>
        </div>

        <form action="{{ route('admin.facturas.index') }}" method="GET">
            <input type="text" name="factura_id" placeholder="ID Factura" value="{{ request('factura_id') }}">
            <input type="text" name="reserva_id" placeholder="ID Reserva" value="{{ request('reserva_id') }}">
            <button type="submit">Buscar</button>
        </form>
        <div class="content">
            <div class="contenedor-tabla">
                <table class="tabla table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Reserva ID</th>
                            <th>Monto</th>
                            <th>IVA</th>
                            <th>Monto Total</th>
                            <th>Estado</th>
                            <th>Detalles</th>
                            <th>Fecha Emisión</th>
                            <th>Fecha Cancelación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($facturas as $factura)
                            <tr>
                                <td>{{ $factura->id }}</td>
                                <td>{{ $factura->reserva_id }}</td>
                                <td>{{ $factura->monto }}€</td>
                                <td>{{ $factura->iva }}€</td>
                                <td>{{ $factura->monto_total }}€</td>
                                <td>{{ $factura->estado }}</td>
                                <td>{{ $factura->detalles }}</td>
                                <td>{{ $factura->fecha_emision }}</td>
                                <td>{{ $factura->fecha_cancelacion }}</td>
                                <td>
                                    <!-- Botón para generar PDF -->
                                    <a href="{{ route('facturas.pdf', $factura->id) }}" class="btn btn-primary">Imprimir
                                        PDF</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
