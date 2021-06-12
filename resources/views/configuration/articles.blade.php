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
                                    <label for="name">Nombre (*):</label>
                                    <input type="text" class="form-control" name="name" placeholder="Nombre" id="name" maxlength="30" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="state">Sub Categoría (*):</label>
                                    <select name="sub_category" id="sub_category" class="form-control" required>
                                        @foreach($sub_categories as $sub_category)
                                            <option value="{{$sub_category->id}}">{{$sub_category->description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="name">Cantidad (*):</label>
                                    <input type="number" class="form-control" name="quantity" placeholder="Cantidad" id="quantity" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="state">Estado (*):</label>
                                    <select name="state" id="state" class="form-control" required>
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="price1">Precio Normal (*):</label>
                                    <input type="text" class="form-control" name="price1" placeholder="Precio Normal" id="price1" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-3" style="display: none">
                                <div class="form-group">
                                    <label for="price2">Precio por Mayor:</label>
                                    <input type="text" class="form-control" name="price2" placeholder="Precio por mayor" id="price2">
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="price3">Precio Liquidación:</label>
                                    <input type="text" class="form-control" name="price3" placeholder="Precio liquidación" id="price3">
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="detail">Detalle:</label>
                                    <textarea class="form-control" name="detail" placeholder="Detalle..." id="detail"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table" id="images">
                                    <thead>
                                        <th>Imagen</th>
                                        <th>Opción</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="file" class="form-control myImage" name="image[]" accept="image/*"></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary" type="button" id="btnAddImage">AGREGAR IMAGEN</button>
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
                                        <th>Nombre</th>
                                        <th>Sub Categoría</th>
                                        <th>Cantidad</th>
                                        <th>Imagen</th>
                                        <th>Precios</th>
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
                'url': '/dtArticle',
                'type' : 'get',
            },
            'columns': [
                {
                    data: 'name'
                },
                {
                    data: 'sub_category.description'
                },
                {
                    data: 'quantity'
                },
                {
                    data: 'id'
                },
                {
                    data: 'id'
                },
                {
                    data: 'stateDiscount'
                },
                {
                    data: 'id'
                },
            ],
            'fnRowCallback': function( nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                switch (aData['state']) {
                    case 0:
                        $(nRow).find('td:eq(5)').html('<span class="badge badge-danger">Inactivo</span>');
                        break;
                    case 1:
                        $(nRow).find('td:eq(5)').html('<span class="badge badge-success">Activo</span>');
                        break;
                }

                $(nRow).find('td:eq(3)').html('<img src="/storage/' + aData['image'] + '" style="width: 100px"/>');
                let prices = '<span class="font-weight-bold">PRECIO NORMAL ' + aData['price1'] + '</span></br>';
                prices += '<span class="font-weight-bold">PRECIO LIQUIDACIÓN ' + aData['price3'] + '</span></br>';
                $(nRow).find('td:eq(4)').html(prices);
                let buttons = '<button class="btn btn-primary btn-sm prepare"><i class="fa fa-edit"></i></button>';
                if (aData['stateDiscount'] == 0) {
                    buttons += '<button type="button" class="btn btn-default btn-sm discount" title="Activar liquidación"><i class="fa fa-arrow-circle-down"></i></button>';
                } else {
                    $(nRow).addClass('bg-warning');
                }
                $(nRow).find('td:eq(6)').html(buttons);
            }
        });

        $('body').on('click', '.prepare', function () {
            clear();
            let data = tblData.row( $(this).parents('tr') ).data();
            if(data === undefined) {
                tblData = $("#tblData").DataTable();
                data = tblData.row( $(this).parents('tr') ).data();
            }

            $('#name').val(data['name']);
            $('#state').val(data['state']);
            $('#sub_category').val(data['sub_category_id']);
            $('#price1').val(data['price1']);
            $('#price2').val(data['price2']);
            $('#price3').val(data['price3']);
            $('#quantity').val(data['quantity']);
            $('#detail').val(data['detail']);
            $('#id').val(data['id']);
            console.log(data['images']);
            if (data['images'].length > 0) {
                for(let x = 0; x < data['images'].length; x++) {
                    $('#images tbody').append('<tr><td><img style="width: 100px;" src="/storage/' + data['images'][x]['url'] + '"></td><td><button type="button" id="' + data['images'][x]['id'] + '" class="btn btn-danger btn-sm trashPermanently"><i class="fa fa-trash"></i></button></td></tr>');
                }
            }
            toastr.info('Estás editando este registro');
        });

        $('body').on('click', '.trashPermanently', function() {
            const that = $(this);
            const id = that.attr('id');
            $.confirm({
                title: 'Confirmación!',
                content: 'Estás seguro de eliminar esta imagen?',
                buttons: {
                    Confirmar: function () {
                        $.ajax({
                            type: 'post',
                            url: '{{route('deleteImage')}}',
                            data: {
                                id: id,
                                _token: '{{csrf_token()}}'
                            },
                            success: function (response) {
                                if (response === true) {
                                    that.parent().parent().remove();
                                    toastr.success('Imagen eliminada con éxito!');
                                } else {
                                    toastr.error('Ocurrió un error');
                                }
                            }
                        })
                    },
                    Cancelar: function () {

                    },
                }
            });
        });

        $('body').on('click', '.discount', function () {
            let data = tblData.row( $(this).parents('tr') ).data();
            if(data === undefined) {
                tblData = $("#tblData").DataTable();
                data = tblData.row( $(this).parents('tr') ).data();
            }
            $.confirm({
                title: 'Confirmación!',
                content: 'Estás seguro de activar el precio de liquidación?',
                buttons: {
                    Confirmar: function () {
                        $.ajax({
                            type: 'post',
                            url: '{{route('updateDiscount')}}',
                            data: {
                                id: data['id'],
                                _token: '{{csrf_token()}}'
                            },
                            success: function (response) {
                                if (response === true) {
                                    tblData.ajax.reload();
                                    toastr.success('Datos actualizados satisfactoriamente');
                                } else {
                                    toastr.error('Ocurrió un error');
                                }
                            }
                        })
                    },
                    Cancelar: function () {

                    },
                }
            });
        });

        $('#btnAddImage').click(function() {
            $('#images tbody').append('<tr><td><input type="file" class="form-control myImage" name="image[]" accept="image/*"></td><td><button type="button" class="btn btn-danger btn-sm trashImage"><i class="fa fa-minus"></i></button></td></tr>');
        });

        $('body').on('click', '.trashImage', function() {
            $(this).parent().parent().remove();
        });

        $('#frmData').validate({
            submitHandler: function(form) {
                let data = new FormData();
                // let image = $('.myImage')[0].files.length;

                $('.myImage').each(function() {
                    const that = $(this);
                    if (that[0].files.length > 0) {
                        data.append('images[]', that[0].files[0]);
                    }
                });
                data.append('id', $('#id').val());
                data.append('detail', $('#detail').val());
                data.append('name', $('#name').val());
                data.append('state', $('#state').val());
                data.append('sub_category', $('#sub_category').val());
                data.append('quantity', $('#quantity').val());
                data.append('price1', $('#price1').val());
                data.append('price2', $('#price2').val());
                data.append('price3', $('#price3').val());
                data.append('_token', '{{csrf_token()}}');
                $.ajax({
                    url: '/saveArticle',
                    type: 'post',
                    data: data,
                    contentType: false,
                    processData: false,
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
            $('#name').val('');
            $('#price1').val('');
            $('#price2').val('');
            $('#price3').val('');
            $('#quantity').val('');
            $('#state').val(1);
            $('#sub_category').val(1);
            $('#id').val('');
            $('#detail').val('');
            $('#images tbody').html('<tr><td><input type="file" class="form-control myImage" name="image[]" accept="image/*"></td><td></td></tr>');
        }
    </script>
@endsection
