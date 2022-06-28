<nav id="navbar-dashboard">

    <a href="{{ route('dashboardHome') }}" target="">
        <img src="{{ asset('img/home.png') }}" alt="Home" >
    </a>

    <a href="{{ route('dashboardAdiciona') }}" target="_blank">
        <img src="{{ asset('img/add.png') }}" alt="Adicionar Item" >
    </a>

    <a href="{{ route('dashboardAdicionaCategoria') }}" target="_blank">
        <img src="{{ asset('img/add-categoria.png') }}" alt="Adicionar Categoria" >
    </a>

    <a href="{{ route('dashboardAdicionaAtributoCategoria') }}" target="_blank">
        <img src="{{ asset('img/add-atributo.png') }}" alt="Adicionar Atributo a Categoria" >
    </a>

</nav>