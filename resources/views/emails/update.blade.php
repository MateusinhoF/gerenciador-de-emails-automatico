<x-template titulodapagina="" tituloHeader="Editar Nomes">
    <div class="mx-auto col-md-12 bg-secondary">
        
        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('emails.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('emails.update',['id'=>$email->id])}}" method="post" class="m-3 p-4 color-forms-background">

            @csrf
            <x-input nome="email" texto="Email" tipo="text" valor="{{$email->email}}"/>
            <x-input nome="descricao" texto="Descrição" tipo="text" valor="{{$email->descricao}}"/>

            <div class="d-flex justify-content-center">
                <input type="submit" value="Alterar Email" class="btn btn-primary">
            </div>

        </form>

        <x-errors/>
    </div>
</x-template>
