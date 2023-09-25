<x-template titulodapagina="" tituloHeader="Editar Nomes">

    <div class="d-flex justify-content-around">
        <x-link href="{{route('nomes.index')}}" texto="Voltar"/>
        <x-link href="{{route('logout')}}" texto="Sair"/>
    </div>

    <form action="{{route('nomes.update',['id'=>$nomes->id])}}" method="post" class="p-4 p-md-5 border rouded-3 bg-light">

        @csrf
        <x-input nome="nome1" texto="Nome" tipo="text" valor="{{$nomes->nome1}}"/>
        <x-input nome="nome2" texto="Nome" tipo="text" valor="{{$nomes->nome2}}"/>
        <x-input nome="nome3" texto="Nome" tipo="text" valor="{{$nomes->nome3}}"/>
        <x-input nome="nome4" texto="Nome" tipo="text" valor="{{$nomes->nome4}}"/>
        <x-input nome="nome5" texto="Nome" tipo="text" valor="{{$nomes->nome5}}"/>

        <div class="d-flex justify-content-center">
            <input type="submit" value="Alterar Nome" class="btn btn-primary">
        </div>

    </form>

    <x-errors/>

</x-template>
