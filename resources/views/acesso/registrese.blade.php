<x-template titulodapagina="Registre-se" tituloHeader="Criar Cadastro">

    <div class="mx-auto p-4 col-md-7 bg-secondary">

        <x-link  href="{{route('login')}}" texto="Login"/>

        <form action="{{route('store')}}" method="post"
              class="mt-3 p-4 p-md-5 form-group mb-3 color-forms-background"
        >
            @csrf

            <x-input nome="login" texto="Login" tipo="text"/>

            <x-input nome="email" texto="E-mail" tipo="email"/>

            <x-input nome="password" texto="Senha de Login" tipo="password"/>

            <x-input nome="senha_email" texto="Senha de Email" tipo="password"/>

            <input type="submit" value="Cadastrar" class="btn btn-primary">
        </form>

        <x-errors/>

    </div>
</x-template>
