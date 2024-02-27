<x-template titulodapagina="Editar Anexo de Email" tituloHeader="Editar Anexo de Email">
    <div class="mx-auto col-md-12 bg-secondary">
        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('anexos.index', ['vinculador_anexos_id'=>$vinculador_anexos_id])}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('anexos.update',['id'=>$anexo->id, 'vinculador_anexos_id'=>$vinculador_anexos_id])}}" method="post" class="m-3 p-4 color-forms-background">

            @csrf
            <x-input nome="nome" texto="Nome" tipo="text" valor="{{$anexo->nome}}"/>

            <div class="d-flex justify-content-center">
                <input type="submit" value="Alterar Nome do Anexo" class="btn btn-primary">
            </div>

        </form>

        <x-errors/>
    </div>
</x-template>
