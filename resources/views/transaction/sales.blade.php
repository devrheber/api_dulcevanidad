@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">VENTAS</h3>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table" id="tblData">
                                    <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Cliente</th>
                                        <th>Total</th>
                                        <th>Código</th>
                                        <th>Comprobante</th>
                                        <th>Método de Pago</th>
                                        <th>Tipo de Entrega</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('adminlte_js')
    <script>
        let tblData = $('#tblData').DataTable({
            'language': {
                'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
            },
            'ajax': {
                'url': '/dtSales',
                'type' : 'get',
            },
            'columns': [
                {
                    data: 'url'
                },
                {
                    data: 'customer.name'
                },
                {
                    data: 'total'
                },
                {
                    data: 'code'
                },
                {
                    data: 'code'
                },
                {
                    data: 'id'
                },
                {
                    data: 'id'
                },
                {
                    data: 'id'
                },
                {
                    data: 'id'
                },
            ],
            'fnRowCallback': function( nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $(nRow).find('td:eq(1)').html(aData['customer']['name'] + ' ' + aData['customer']['surnames'] + ' - ' + aData['customer']['phone']);
                $(nRow).find('td:eq(4)').html('<img src="' + aData['voucher'] + '" style="width: 150px">');
                let type = '';

                switch (aData['payment_method']['type']) {
                    case 1:
                        type = 'TRANSFERENCIA';
                        break;
                    case 2:
                        type = 'agente';
                        break;
                    case 3:
                        type = 'YAPE'
                        break;
                    case 4:
                        type = 'PLIN';
                        break;
                    default:
                        break;
                }

                $(nRow).find('td:eq(5)').html(aData['payment_method']['bank']['abbreviation'] + ' ' + type);
                switch (aData['state']) {
                    case 1:
                        $(nRow).find('td:eq(6)').html('Recojo en tienda');
                        break;
                    case 2:
                        $(nRow).find('td:eq(6)').html('Estaciones del tren');
                        break;
                    case 4:
                        $(nRow).find('td:eq(6)').html('Metropolitano estación naranjal');
                        break
                    case 4:
                        $(nRow).find('td:eq(6)').html('Plaza Norte');
                        break;
                    case 5:
                        $(nRow).find('td:eq(6)').html('Delivery');
                        break;
                }

                switch (aData['state']) {
                    case 0:
                        $(nRow).find('td:eq(7)').html('<span class="badge badge-danger">Pendiente</span>');
                        break;
                    case 1:
                        $(nRow).find('td:eq(7)').html('<span class="badge badge-success">Concluido</span>');
                        break;
                }

                $(nRow).find('td:eq(8)').html(moment(aData['created_at']).format('DD-MM-Y hh:mm'));
            }
        });
    </script>
@endsection
