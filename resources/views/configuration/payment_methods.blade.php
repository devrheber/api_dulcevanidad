@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Gestionar Artículo</h3>
                </div>
                <div class="card-body">
                    <form id="frmData" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id" name="id">
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="reference">Detalle (*):</label>
                                    <input type="text" class="form-control" name="reference" placeholder="Detalle" id="reference" maxlength="30" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="bank">Banco (*):</label>
                                    <select name="bank" id="bank" class="form-control" required>
                                        <option value="">SELECCIONAR</option>
                                        @foreach($banks as $bank)
                                            <option value="{{$bank->id}}">{{$bank->description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="bank">Tipo (*):</label>
                                    <select name="type" id="type" class="form-control" required>
                                        <option value="">SELECCIONAR</option>
                                        <option value="1">TRANSFERENCIA</option>
                                        <option value="2">AGENTE</option>
                                        <option value="3">YAPE</option>
                                        <option value="4">PLIN</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="bank">Estado (*):</label>
                                    <select name="state" id="state" class="form-control" required>
                                        <option value="1">ACTIVO</option>
                                        <option value="0">INACTIVO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12"><hr></div>
                            <div class="col-12">
                                <button type="button" class="btn btn-default" id="btnNew">NUEVO</button>
                                <button class="btn btn-primary" id="btnSave"><i class="fa fa-save"></i> GUARDAR</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table" id="tblData">
                                    <thead>
                                    <tr>
                                        <th>Detalle</th>
                                        <th>Tipo</th>
                                        <th>Banco</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
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
        let idImage = 0;
        let tblData = $('#tblData').DataTable({
            'language': {
                'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
            },
            'ajax': {
                'url': '/dtPaymentMethods',
                'type' : 'get',
            },
            'columns': [
                {
                    data: 'reference'
                },
                {
                    data: 'type'
                },
                {
                    data: 'bank.description'
                },
                {
                    data: 'id'
                },
                {
                    data: 'id'
                },
            ],
            'fnRowCallback': function( nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                switch (aData['state']) {
                    case 0:
                        $(nRow).find('td:eq(3)').html('<span class="badge badge-danger">Inactivo</span>');
                        break;
                    case 1:
                        $(nRow).find('td:eq(3)').html('<span class="badge badge-success">Activo</span>');
                        break;
                }

                let buttons = '<button class="btn btn-primary btn-sm prepare"><i class="fa fa-edit"></i></button>';
                $(nRow).find('td:eq(4)').html(buttons);
            }
        });

        $('body').on('click', '.prepare', function () {
            clear();
            let data = tblData.row( $(this).parents('tr') ).data();
            if(data === undefined) {
                tblData = $("#tblData").DataTable();
                data = tblData.row( $(this).parents('tr') ).data();
            }

            $('#reference').val(data['reference']);
            $('#state').val(data['state']);
            $('#bank').val(data['bank']['id']);
            $('#type').val(data['type']);
            $('#id').val(data['id']);
            toastr.info('Estás editando este registro');
        });

        $('#frmData').validate({
            submitHandler: function(form) {
                $.ajax({
                    url: '/savePaymentMethod',
                    type: 'post',
                    data: $('#frmData').serialize(),
                    success: function (response) {
                        if (response === true) {
                            clear();
                            tblData.ajax.reload();
                            toastr.success('Datos grabados satisfactoriamente');
                        }
                    }
                });
            }
        });

        $('#btnNew').click(function() {
            clear();
            toastr.info('Datos reiniciados');
        });

        function clear() {
            $('#reference').val('');
            $('#type').val('');
            $('#state').val(1);
            $('#bank').val('');
            $('#id').val('');
        }
    </script>
@endsection
