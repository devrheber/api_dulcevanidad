@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">OPERACIONES</h3>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table" id="tblData">
                                    <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Total</th>
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
                'url': '/dtOperations',
                'type' : 'get',
            },
            'columns': [
                {
                    data: 'url'
                },
                {
                    data: 'total'
                },
                {
                    data: 'id'
                },
                {
                    data: 'id'
                },
            ],
            'fnRowCallback': function( nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                if (aData['sale']) {
                    $(nRow).find('td:eq(2)').html('<span class="badge badge-success">Convertido en venta</span>');
                } else {
                    $(nRow).find('td:eq(2)').html('<span class="badge badge-success">No terminada</span>');
                }

                $(nRow).find('td:eq(3)').html(moment(aData['created_at']).format('DD-MM-Y hh:mm'));
            }
        });
    </script>
@endsection
