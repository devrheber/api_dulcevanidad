<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Title --}}
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'Catalogo'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>

    {{-- Custom stylesheets (pre AdminLTE) --}}
    @yield('adminlte_css_pre')

    {{-- Base Stylesheets --}}
    @if(!config('adminlte.enabled_laravel_mix'))
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

        {{-- Configured Stylesheets --}}
        @include('adminlte::plugins', ['type' => 'css'])

        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @else
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @endif

    {{-- Livewire Styles --}}
    @if(config('adminlte.livewire'))
        @if(app()->version() >= 7)
            @livewireStyles
        @else
            <livewire:styles />
        @endif
    @endif

    {{-- Custom Stylesheets (post AdminLTE) --}}
    @yield('adminlte_css')

    {{-- Favicon --}}
    @if(config('adminlte.use_ico_only'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
    @elseif(config('adminlte.use_full_favicon'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicons/android-icon-192x192.png') }}">
        <link rel="manifest" href="{{ asset('favicons/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    @endif

</head>

<body class="@yield('classes_body')" @yield('body_data')>
    <div class="container-fluid bg-success">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <h4>CATALOGO</h4>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <input class="form-control" type="text" name="search" id="search" placeholder="Buscar ...">
            </div>
            <div class="col-12"><br></div>
            <div class="col-12">
                <select name="" id="" class="form-control" style="width: 100%">
                    @foreach ($sub_categories as $sub_category)
                        <option value="{{ $sub_category->id }}">{{ $sub_category->description }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12"><br></div>
        </div>
    </div>
    <div class="container-fluid" style="max-width: 1600px;">
        <div class="row">
            <div class="col-12"><br></div>
            @foreach($articles as $article)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2" data-toggle="modal" data-target="#exampleModal" style="cursor: pointer;">
                    <div class="card card-success">
                        @if(count($article->images) > 0)
                            <img class="card-img-top" src="/storage/{{$article->images[0]['url']}}" style="width: 100%">
                        @else
                            <img class="card-img-top" src="/storage/{{$article->image}}" style="width: 100%">
                        @endif
                        <div class="card-body">
                            <div><span class="font-weight-bold">{{ $article->name }}</span></div>
                            {{-- <div><span class="font-italic">{{ $article->detail }}</span></div> --}}
                            <div><span>PRECIO: {{ $article->price1 }}</span></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
    <div class="container-fluid bg-success fixed-bottom">
        <div class="row">
            <div class="col-12"><span style="font-size: 20px;">Lista: 7 artículos seleccionados</span></div>
            <div class="col-12"><span style="font-size: 20px;">Compra: MONTO S/ 125.00</span></div>
            <div class="col-12 d-flex justify-content-center">
                <a href="{{route('shop')}}" class="btn btn-default">CONTINUAR</a>
            </div>
            <div class="col-12"><br></div>
        </div>
    </div>

    <div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="card card-success d-flex justify-content-center">
                    <div class="d-flex justify-content-center"><img class="card-img-top" src="{{asset('img/parlante.jpg')}}" style="width: 50%"></div>
                    <div class="card-body">
                        <div><span>PRECIO 1: S./30.00</span></div>
                        <div><span>PRECIO 2: S./30.00</span></div>
                    </div>
                    <div class="card-footer">
                        <div class="col-12 d-flex justify-content-center"><span>25 disponibles</span></div>
                        <div class="col-12 d-flex justify-content-center">
                            <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></button>
                            <span style="font-size: 30px;font-weight:boldl;">[ 1 ]</span>
                            <button type="button" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    {{-- Body Content --}}
    @yield('body')

    {{-- Base Scripts --}}
    @if(!config('adminlte.enabled_laravel_mix'))
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

        {{-- Configured Scripts --}}
        @include('adminlte::plugins', ['type' => 'js'])

        <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @else
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @endif

    {{-- Livewire Script --}}
    @if(config('adminlte.livewire'))
        @if(app()->version() >= 7)
            @livewireScripts
        @else
            <livewire:scripts />
        @endif
    @endif

    {{-- Custom Scripts --}}
    @yield('adminlte_js')

</body>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>

</html>
