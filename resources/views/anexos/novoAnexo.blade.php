<x-template titulodapagina="Adicionar Anexo" tituloHeader="Adicionar Anexo">
    <div class="mx-auto col-md-12 bg-secondary">

        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('mensagem.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('anexos.storeNovoAnexo', ['mensagem_id'=>$mensagem_id])}}" method="post" enctype="multipart/form-data" class="m-3 p-4 color-forms-background">

            @csrf

            <div>
                <label for="anexos">Anexos:</label>
                <input type="file" id="anexos[]" name="anexos[]" multiple>
            </div>

            <div class="d-flex justify-content-center">
                <input type="submit" value="Adicionar Anexos a Mensagem" class="btn btn-primary">
            </div>

        </form>

        <x-errors/>
    </div>
</x-template>
