<x-template titulodapagina="" tituloHeader="Editar Nomes">

    <div class="d-flex justify-content-around">
        <x-link href="{{route('corpoemail.index')}}" texto="Voltar"/>
        <x-link href="{{route('logout')}}" texto="Sair"/>
    </div>

    <form action="{{route('corpoemail.update',['id'=>$corpoemail->id])}}" method="post" class="p-4 p-md-5 border rouded-3 bg-light">

        @csrf
        <x-input nome="titulo" texto="Titulo" tipo="text" valor="{{$corpoemail->titulo}}"/>
        <x-input nome="assunto" texto="Assunto" tipo="text" valor="{{$corpoemail->assunto}}"/>
        <x-input nome="texto" texto="Texto" tipo="text" valor="{{$corpoemail->texto}}"/>

        <div class="d-flex justify-content-center">
            <input type="submit" value="Alterar Corpo de Email" class="btn btn-primary">
        </div>

    </form>

    <x-errors/>

</x-template>
