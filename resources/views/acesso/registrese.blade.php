<x-template titulodapagina="Registre-se" tituloHeader="Criar Cadastro">

    <x-link  href="{{route('login')}}" texto="Login"/>

    <form action="{{route('store')}}" method="post" class="p-4 p-md-5 border rouded-3 bg-light">
        @csrf

        <x-input nome="name" texto="Nome" tipo="text"/>

        <x-input nome="email" texto="E-mail" tipo="email"/>

        <x-input nome="password" texto="password" tipo="password"/>

        <input type="submit" value="Cadastrar" class="btn btn-primary">
    </form>

    <x-errors/>
</x-template>
