<x-template titulodapagina="Editar Envio" tituloHeader="Editar Envio">
    <div class="mx-auto col-md-12 bg-secondary">

        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('envios.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('envios.update',['id'=>$envio->id])}}" method="post" class="m-3 p-4 color-forms-background">

            @csrf
            <x-input nome="nome" texto="Nome" tipo="text" valor="{{$envio->nome}}"/>
            <x-input nome="email" texto="Email" tipo="text" valor="{{$envio->email}}"/>
            <x-input nome="telefone" texto="Telefone" tipo="text" valor="{{$envio->telefone}}"/>
            <label for="telefone">*O telefone deve ser inserido no padrão 45999707070</label>

            <div class="d-flex justify-content-center">
                <input type="submit" value="Alterar Envio" class="btn btn-primary">
            </div>

        </form>

        <x-errors/>
    </div>
</x-template>
