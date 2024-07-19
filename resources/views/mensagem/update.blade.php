<x-template titulodapagina="Editar Texto de Notificação" tituloHeader="Editar Texto de Notificação">
    <div class="mx-auto col-md-12 bg-secondary">
        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('corpoemail.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('corpoemail.update',['id'=>$corpoemail->id])}}" method="post" enctype="multipart/form-data" class="m-3 p-4 color-forms-background">

            @csrf
            <x-input nome="titulo" texto="Titulo" tipo="text" valor="{{$corpoemail->titulo}}"/>
            <x-input nome="assunto" texto="Assunto" tipo="text" valor="{{$corpoemail->assunto}}"/>
            <x-input nome="texto" texto="Texto" tipo="text" valor="{{$corpoemail->texto}}"/>

            <div>
                <label for="anexos">Anexos:</label>
                <input type="file" id="anexos" name="anexos" multiple>
            </div>

            <div class="d-flex justify-content-center">
                <input type="submit" value="Alterar Corpo de Email" class="btn btn-primary">
            </div>

        </form>

        <x-errors/>
    </div>
</x-template>
