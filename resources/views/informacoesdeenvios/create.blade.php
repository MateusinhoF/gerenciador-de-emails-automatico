<x-template titulodapagina="Cadastrar Envio" tituloHeader="Cadastrar Envio">
    <div class="mx-auto col-md-12 bg-secondary">
        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('informacoesdeenvios.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('informacoesdeenvios.store')}}" method="post" class="m-3 p-4 color-forms-background">

            @csrf

            <x-input nome="nome" texto="Nome" tipo="text"/>
            <x-input nome="email" texto="Email" tipo="text"/>
            <x-input nome="telefone" texto="Telefone" tipo="text"/>
            <label for="telefone">*O telefone deve ser inserido no padrão 45999707070</label>


            <div class="d-flex justify-content-center">
                <input type="submit" value="Cadastrar Envio" class="btn btn-primary">
            </div>

        </form>

        <x-errors/>
    </div>
</x-template>
