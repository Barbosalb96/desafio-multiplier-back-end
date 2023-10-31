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
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<h1 class="m-4">Listagem Clientes</h1>
<div class="card m-4">
    <form action="{{route('dashboard.index')}}" class="m-3">
        <div class=" col-12 d-flex">
            <div class="form-group mx-2">
                <label for="">name</label>
                <input class="form-control " type="text" name="nome_fantasia">
            </div>
            <div class="form-group mx-2">
                <label for="">cnpj</label>
                <input class="form-control" type="text" name="cnpj">
            </div>
            <div class="form-group mx-2">
                <label for="">telefone</label>
                <input class="form-control" type="text" name="telefone">
            </div>
        </div>
        <div class="d-flex mx-4">
            <button class='btn  btn-primary'>Buscar</button>
            <a class='btn mx-4 btn-primary' href="{{route('dashboard.index')}}">limpar</a>
        </div>
    </form>
    <table class="table table-striped ">
        <thead>
        <tr>
            <th scope="col">ID PUBLIC</th>
            <th scope="col">NOME FANTASIA</th>
            <th scope="col">EMAIL</th>
            <th scope="col">CNPJ</th>
            <th scope="col">ENDEREÇO</th>
            <th scope="col">CIDADE</th>
            <th scope="col">ESTADO</th>
            <th scope="col">PAIS</th>
            <th scope="col">TELEFONE</th>
            <th scope="col">AREA DE ATUACAÇÃO CNAE</th>
            <th scope="col">QUANTIDADE QSA</th>
            <th scope="col">Mais</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $client)
            <tr>
                <th scope="row">{{$client->id_public}}</th>
                <td>{{$client->nome_fantasia}}</td>
                <td>{{$client->email}}</td>
                <td>{{$client->cnpj}}</td>
                <td>{{$client->endereco}}</td>
                <td>{{$client->cidade}}</td>
                <td>{{$client->estado}}</td>
                <td>{{$client->pais}}</td>
                <td>{{$client->telefone}}</td>
                <td>{{$client->area_atuacao_cnae}}</td>
                <td>{{$client->qsas()->count()}}</td>
                <td><a href={{route('dashboard.show',$client->id_public)}}>Ver</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $data->appends(request()->query())->links() }}
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
</body>
</html>
