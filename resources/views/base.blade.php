<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <title>@yield('page-title')</title>
</head>
<body>

    @yield('menu')

    @yield('conteudo')

    @yield('footer')

</body>
</html>