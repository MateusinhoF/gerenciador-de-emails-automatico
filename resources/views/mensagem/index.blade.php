<x-template titulodapagina="Mensagem" tituloHeader="Mensagem">

    <div class="mx-auto col-md-12 bg-secondary">
        <div class="d-flex justify-content-around m-3">
            <x-link-proximo href="{{route('nomes.index')}}" texto="Próximo"/>
            <x-link href="{{route('mensagem.create')}}" texto="Cadastrar Mensagem"/>
            <x-link href="{{route('paraenviar.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <div>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Titulo</th>
                    <th>Assunto</th>
                    <th>Texto</th>
                    <th>Anexo</th>
                    <th>Opções</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($mensagens as $mensagem)
                    <tr>
                        <td>{{$mensagem->titulo}}</td>
                        <td>{{$mensagem->assunto}}</td>
                        <td>{{$mensagem->texto}}</td>
                        <td>
                            @if($mensagem->vinculador_anexos_id != null)
                                <a
                                    class="link-success p-1 link-offset-2 link-underline link-underline-opacity-0 link-opacity-50-hover"
                                    href="{{route('anexos.index', ['vinculador_anexos_id'=>$mensagem->vinculador_anexos_id])}}"
                                >
                                    Visualizar
                                </a>
                            @else
                                <a
                                    class="link-primary p-1 link-offset-2 link-underline link-underline-opacity-0 link-opacity-50-hover"
                                    href="{{route('anexos.novoAnexo', ['mensagem_id'=>$mensagem->id])}}"
                                >
                                    Adicionar
                                </a>
                            @endif
                        </td>
                        <td>
                            <x-link-editar href="{{route('mensagem.edit', ['id'=>$mensagem->id])}}"/>
                            <x-link-excluir href="{{route('mensagem.destroy', ['id'=>$mensagem->id])}}"/>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <x-errors/>
    </div>
</x-template>
