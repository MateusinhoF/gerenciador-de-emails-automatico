<x-template titulodapagina="Editar Informações de Envio" tituloHeader="Editar Informações de Envio">
    <div class="mx-auto col-md-12 bg-secondary">

        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('informacoesdeenvios.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('informacoesdeenvios.update',['id'=>$informacoesdeenvios->id])}}" method="post" class="m-3 p-4 color-forms-background">

            @csrf
            <x-input nome="nome" texto="Nome" tipo="text" valor="{{$informacoesdeenvios->nome}}"/>
            <x-input nome="email" texto="Email" tipo="text" valor="{{$informacoesdeenvios->email}}"/>
            <x-input nome="telefone" texto="Telefone" tipo="text" valor="{{$informacoesdeenvios->telefone}}"/>
            <label for="telefone">*O telefone deve ser inserido no padrão 45999707070</label>

            <div class="d-flex justify-content-center">
                <input type="submit" value="Alterar Informações de Envio" class="btn btn-primary">
            </div>

        </form>

        <x-errors/>
    </div>
</x-template>
