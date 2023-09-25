<x-template titulodapagina="" tituloHeader="Cadastrar Nomes">

    <div class="d-flex justify-content-around">
        <x-link href="{{route('nomes.index')}}" texto="Voltar"/>
        <x-link href="{{route('logout')}}" texto="Sair"/>
    </div>

    <form action="{{route('nomes.store')}}" method="post" class="p-4 p-md-5 border rouded-3 bg-light">

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
</x-template>
