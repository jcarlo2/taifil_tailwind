<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="Tai-Fil Manpower Services Corp" name="description" />
    <meta content="Alphy Jay Paulin & Lenard Robenta" name="author" />
    <meta name="language" lang="eng" />

    <!-- CSRF Token -->
    @stack('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="/images/tf logo.png">
    <title>@yield('title') | Tai-Fil Manpower Services Corp</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset("css/iziToast.min.css")}}" async>
    <link rel="stylesheet" href="{{asset("css/app.css")}}" async>
    @stack('styles')
</head>
<body class="min-h-full flex flex-col overflow-x-hidden">
    <x-user-banner/>
    @include('navFoot.client_nav')
    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('navFoot.client_foot')

</body>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="{{asset("js/app.js")}}"></script>
<script>
    $("#page_lang").on("change",function(){
        console.log($(this).val())
        $("meta[name='language']").attr('lang', $(this).val());
    })

   </script>
@stack('scripts')
</html>