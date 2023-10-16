<x-template titulodapagina="Cadastrar Nomes" tituloHeader="Cadastrar Nomes">

    <div class="mx-auto col-md-12 bg-secondary">

        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('nomes.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('nomes.store')}}" method="post" class="m-3 p-4 color-forms-background">

            @csrf

            <x-input nome="nome1" texto="Nome 1" tipo="text"/>
            <x-input nome="nome2" texto="Nome 2" tipo="text"/>
            <x-input nome="nome3" texto="Nome 3" tipo="text"/>
            <x-input nome="nome4" texto="Nome 4" tipo="text"/>
            <x-input nome="nome5" texto="Nome 5" tipo="text"/>

            <div class="d-flex justify-content-center">
                <input type="submit" value="Cadastrar Nomes" class="btn btn-primary">
            </div>

        </form>

        <x-errors/>
    </div>
</x-template>
