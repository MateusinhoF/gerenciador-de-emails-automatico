<x-template titulodapagina="Anexos de Email" tituloHeader="Anexos de Email">

    <div class="mx-auto col-md-12 bg-secondary">
        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('anexos.create', ['vinculador_anexos_id'=>$vinculador_anexos_id])}}" texto="Adicionar Anexo"/>
            <x-link href="{{route('mensagem.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <div>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Opções</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($anexos as $anexo)
                    <tr>
                        <td>{{$anexo->nome}}</td>
                        <td>{{substr($anexo->hashname,-3)}}</td>

                        <td>
                            <x-link-editar href="{{route('anexos.edit', ['id'=>$anexo->id, 'vinculador_anexos_id'=>$vinculador_anexos_id])}}"/>
                            <x-link-excluir href="{{route('anexos.destroy', ['id'=>$anexo->id, 'vinculador_anexos_id'=>$vinculador_anexos_id])}}"/>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <x-errors/>
    </div>
</x-template>
