<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="card m-4 p-3">
    <a href="{{route('dashboard.index')}}" class="btn btn-primary col-1">Voltar</a>
    <h1>Cliente: {{$client->nome_fantasia}}</h1>
    <ul>
        <li>Email : {{$client->email}}</li>
        <li>Endereco : {{$client->endereco}}</li>
        <li>Cidade : {{$client->cidade}}</li>
        <li>Estado : {{$client->estado}}</li>
        <li>Pais : {{$client->pais}}</li>
        <li>Telefone : {{$client->telefone}}</li>
        <li>Area atuacao cnae : {{$client->area_atuacao_cnae}}</li>
    </ul>
    <h3>Qsas:</h3>
    <div class="d-flex ">
        @forelse($client->qsas as $qsa)
            <div class="card m-2 p-2">
                <h4>Nome : {{$qsa->nome}}</h4>
                <h4>Qualificacao : {{$qsa->qualificacao}}</h4>
            </div>
        @empty
            <h1>Sem Qsa</h1>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
</body>
</html>
