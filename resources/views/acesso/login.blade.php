<x-template titulodapagina="Login" tituloHeader="Login">
    <div class="mx-auto p-5 col-md-7 bg-secondary">
        <x-link href="{{route('registrese')}}" texto="Registre-se"/>

        <form action="{{route('logar')}}" method="post"
              class="mt-3 p-4 p-md-5 form-group mb-3 color-forms-background"
        >
            @csrf
            <x-input nome="text" texto="Login" tipo="text"/>

            <x-input nome="password" texto="Senha" tipo="password"/>


            <input type="submit" value="Entrar" class="btn btn-primary">
        </form>

        <x-errors/>
    </div>
</x-template>
