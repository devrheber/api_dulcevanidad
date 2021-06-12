@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Gestionar Sub Categoría</h3>
                </div>
                <div class="card-body">
                    <form id="frmData">
                        @csrf
                        <input type="hidden" id="id" name="id">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="description">Descripción:</label>
                                    <input type="text" class="form-control" name="description" placeholder="Descripción" id="description" maxlength="30" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="state">Categoría:</label>
                                    <select name="category" id="category" class="form-control" required>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="state">Estado:</label>
                                    <select name="state" id="state" class="form-control" required>
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
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
                                        <th>Descripción</th>
                                        <th>Categoría</th>
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
        let tblData = $('#tblData').DataTable({
            'language': {
                'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
            },
            'ajax': {
                'url': '/dtSubCategory',
                'type' : 'get',
            },
            'columns': [
                {
                    data: 'description'
                },
                {
                    data: 'category.description'
                },
                {
                    data: 'state'
                },
                {
                    data: 'id'
                }
            ],
            'fnRowCallback': function( nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                switch (aData['state']) {
                    case 0:
                        $(nRow).find('td:eq(2)').html('<span class="badge badge-danger">Inactivo</span>');
                        break;
                    case 1:
                        $(nRow).find('td:eq(2)').html('<span class="badge badge-success">Activo</span>');
                        break;
                }

                if (aData['id'] !== 1) {
                    $(nRow).find('td:eq(3)').html('<button class="btn btn-primary btn-sm prepare"><i class="fa fa-edit"></i></button>');
                } else {
                    $(nRow).find('td:eq(3)').html('');
                }
            }
        });

        $('body').on('click', '.prepare', function () {
            let data = tblData.row( $(this).parents('tr') ).data();
            if(data === undefined) {
                tblData = $("#tblData").DataTable();
                data = tblData.row( $(this).parents('tr') ).data();
            }

            $('#description').val(data['description']);
            $('#state').val(data['state']);
            $('#category').val(data['category_id']);
            $('#id').val(data['id']);
            toastr.info('Estás editando este registro');
        });

        $('#frmData').validate({
            submitHandler: function(form) {
                $.ajax({
                    url: '/saveSubCategory',
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
            $('#description').val('');
            $('#state').val(1);
            $('#category').val(1);
            $('#id').val('');
        }
    </script>
@endsection
