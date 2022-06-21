@extends('base')

@section('page-title', 'SGP - Dashboard')

@section('menu')

    @component('navbar-dashboard')
    
    @endcomponent

@endsection

@section('conteudo')

    @yield('content')

@endsection

@section('footer')

@endsection