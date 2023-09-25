<x-template titulodapagina="Login" tituloHeader="Login">

    <x-link href="{{route('registrese')}}" texto="Registre-se"/>

    <form action="{{route('logar')}}" method="post" class="p-4 p-md-5 border rouded-3 bg-light form-group mb-3">
        @csrf
        <x-input nome="email" texto="E-mail" tipo="email"/>

        <x-input nome="password" texto="Senha" tipo="password"/>


        <input type="submit" value="Entrar" class="btn btn-primary">
    </form>

    <x-errors/>
</x-template>
