<x-template titulodapagina="" tituloHeader="Cadastrar Email">

    <div class="d-flex justify-content-around">
        <x-link href="{{route('emails.index')}}" texto="Voltar"/>
        <x-link href="{{route('logout')}}" texto="Sair"/>
    </div>

    <form action="{{route('emails.store')}}" method="post" class="p-4 p-md-5 border rouded-3 bg-light">

        @csrf

        <x-input nome="email" texto="Email" tipo="text"/>
        <x-input nome="descricao" texto="Descrição" tipo="text"/>


        <div class="d-flex justify-content-center">
            <input type="submit" value="Cadastrar Email" class="btn btn-primary">
        </div>

    </form>

    <x-errors/>
</x-template>
