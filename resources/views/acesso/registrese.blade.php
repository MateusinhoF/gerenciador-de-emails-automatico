<x-template titulodapagina="Registre-se" tituloHeader="Criar Cadastro">

    <div class="mx-auto p-4 col-md-7 bg-secondary">

        <x-link  href="{{route('login')}}" texto="Login"/>

        <form action="{{route('store')}}" method="post" class="mt-3 p-4 p-md-5 bg-light form-group mb-3">
            @csrf

            <x-input nome="name" texto="Nome" tipo="text"/>

            <x-input nome="email" texto="E-mail" tipo="email"/>

            <x-input nome="password" texto="Senha" tipo="password"/>

            <input type="submit" value="Cadastrar" class="btn btn-primary">
        </form>

        <x-errors/>

    </div>
</x-template>
