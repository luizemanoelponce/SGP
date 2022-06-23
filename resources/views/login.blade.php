@extends('base')

@section('page-title', 'Bem Vindo/a')

@section('conteudo')

<main id="login">
    <section>
        <main id="sgp">
            <h1>SGP</h1>
            <h2>Sistema de Gestão Patrimonial</h2>
        </main>
        <footer>
            <small>
                v.1.0.0
            </small>
        </footer>
    </section>
    <section>
        <main id="login-form">
            <h1>Bem Vindo/a</h1>
            <form action="login" method="post">
                @csrf
                user teste: <br>
                master@master.local <br>
                Master <br><br>
                <label for="email">Email:*</label><br>
                <input type="email" name="email" id="email" required><br>
                <label for="senha">Senha:*</label><br>
                <input type="password" name="password" id="senha" required><br><br>
                <button type="submit">Entrar</button>
            </form>
        </main>
    </section>
</main>

@endsection