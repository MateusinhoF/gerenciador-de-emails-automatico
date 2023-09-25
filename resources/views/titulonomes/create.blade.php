<x-template titulodapagina="" tituloHeader="Cadastrar titulo lista de nomes">

    <div class="d-flex justify-content-around">
        <x-link href="{{route('titulonomes.index')}}" texto="Voltar"/>
        <x-link href="{{route('logout')}}" texto="Sair"/>
    </div>

    <form action="{{route('titulonomes.store')}}" method="post" class="p-4 p-md-5 border rouded-3 bg-light">

        @csrf

        <x-input nome="titulo" texto="Titulo" tipo="text"/>

        <div class="d-flex justify-content-center">
            <input type="submit" value="Cadastrar Titulo" class="btn btn-primary">
        </div>

    </form>

    <x-errors/>
</x-template>
