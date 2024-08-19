<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="/assets/css/styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <title>{{$titulodapagina ?? 'Gerenciador de Notificações'}}</title>
</head>
<body class="bg-dark">
<header>
    <div class="container mt-4 mb-4 mx-auto d-flex justify-content-center align-items-center">
        <h1 class="text-white">
            AwGem
        </h1>
    </div>
    <div class="container mt-4 mb-4 mx-auto d-flex justify-content-center align-items-center">
        <h2 class="text-white">
            {{$tituloHeader ?? 'Sem definição de acesso'}}
        </h2>
    </div>
</header>
<section>
    <div class="container">
        <div class="row align-items-center justify-content-center">
            {{$slot}}
        </div>
    </div>
</section>
<footer class="container mt-4 mb-4 mx-auto d-flex justify-content-center align-items-center">
    <a href="https://www.utfpr.edu.br/" class="d-flex justify-content-center align-items-center">
        <img class="img-utfpr" src="/assets/images/utfpr_logo.png" height="50%" width="50%">
    </a>
</footer>
</body>
</html>
