<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    {{-- <link href="hhps://maxcdn.bootstrapcdn.com/font-awsome/4.7.0/css/font-awsome.min.css" rel="stylesheet"> --}}
</head>
<body>
    <div id="app">

        @include('layouts.navbar')

        <div class="container">
            <div class="row">

                <div class="col-12 col-md-9">

                    <div class="col-md-offset-2">
                        <div class="panel page-primary">
                            <div class="page-heading">
                                @yield('panel-heading')
                            </div>
                            <div class="panel-body">
                                @include('layouts.messages')
                                @yield('content')
                            </div>
                        </div>
                    </div>

                    @includeWhen( !in_array('guest' , request()->route()->middleware()) , 'layouts.sidebar')


                </div>



            </div>
        </div>


    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
