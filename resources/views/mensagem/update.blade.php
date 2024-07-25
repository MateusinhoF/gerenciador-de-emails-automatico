<x-template titulodapagina="Editar Texto de Notificação" tituloHeader="Editar Texto de Notificação">
    <div class="mx-auto col-md-12 bg-secondary">
        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('mensagem.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('mensagem.update',['id'=>$mensagem->id])}}" method="post" enctype="multipart/form-data" class="m-3 p-4 color-forms-background">

            @csrf
            <x-input nome="titulo" texto="Titulo" tipo="text" valor="{{$mensagem->titulo}}"/>
            <x-input nome="assunto" texto="Assunto" tipo="text" valor="{{$mensagem->assunto}}"/>
            <x-input nome="texto" texto="Texto" tipo="text" valor="{{$mensagem->texto}}"/>

            <div>
                <label for="anexos">Anexos:</label>
                <input type="file" id="anexos" name="anexos" multiple>
            </div>

            <div class="d-flex justify-content-center">
                <input type="submit" value="Alterar Mensagem" class="btn btn-primary">
            </div>

        </form>

        <x-errors/>
    </div>
</x-template>
