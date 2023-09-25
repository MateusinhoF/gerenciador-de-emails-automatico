<x-template titulodapagina="" tituloHeader="Cadastrar Corpo de Email">

    <div class="d-flex justify-content-around">
        <x-link href="{{route('corpoemail.index')}}" texto="Voltar"/>
        <x-link href="{{route('logout')}}" texto="Sair"/>
    </div>

    <form action="{{route('corpoemail.store')}}" method="post" class="p-4 p-md-5 border rouded-3 bg-light">

        @csrf

        <x-input nome="titulo" texto="Titulo" tipo="text"/>
        <x-input nome="assunto" texto="Assunto" tipo="text"/>
        <x-input nome="texto" texto="Texto" tipo="text"/>

        <div class="d-flex justify-content-center">
            <input type="submit" value="Cadastrar Corpo de Email" class="btn btn-primary">
        </div>

    </form>

    <x-errors/>
</x-template>
