<x-template titulodapagina="" tituloHeader="Editar Nomes">

    <div class="d-flex justify-content-around">
        <x-link href="{{route('emails.index')}}" texto="Voltar"/>
        <x-link href="{{route('logout')}}" texto="Sair"/>
    </div>

    <form action="{{route('emails.update',['id'=>$email->id])}}" method="post" class="p-4 p-md-5 border rouded-3 bg-light">

        @csrf
        <x-input nome="email" texto="Email" tipo="text" valor="{{$email->email}}"/>
        <x-input nome="descricao" texto="Descrição" tipo="text" valor="{{$email->descricao}}"/>

        <div class="d-flex justify-content-center">
            <input type="submit" value="Alterar Email" class="btn btn-primary">
        </div>

    </form>

    <x-errors/>

</x-template>
