<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="{{asset('/css/app.css')}}">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        <script src="{{asset('/js/app.js')}}"></script>
    </head>
    <body class="{{isset($unique_class) ? $unique_class : ''}}">
        <div class="container">
            <div class="row">
                @include('components.header')
            </div>

            <div class="row search">
                <div class="col-sm">
                    <form action="{{route('numbers')}}" method="GET">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Номер/VIN/Модель">
                            <button class="btn btn-outline-secondary" type="button" id="button-addon2">Поиск</button>
                        </div>
                    </form>
                </div>
            </div>

            @yield('content')
        </div>
    </body>
</html>
