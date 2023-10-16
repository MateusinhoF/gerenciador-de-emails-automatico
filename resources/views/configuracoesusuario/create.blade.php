<x-template titulodapagina="Cadastrar Email de Envio" tituloHeader="Cadastrar Email de Envio">
    <div class="mx-auto col-md-12 bg-secondary">
        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('configuracoesusuario.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('configuracoesusuario.store')}}" method="post" class="m-3 p-4 color-forms-background">

            @csrf

            <x-input nome="email" texto="Email para envio" tipo="text"/>

            <x-input nome="senha" texto="Senha email para envio" tipo="password"/>

            <div class="d-flex justify-content-center">
                <input type="submit" value="Cadastrar" class="btn btn-primary">
            </div>

        </form>

        <x-errors/>
    </div>
</x-template>
