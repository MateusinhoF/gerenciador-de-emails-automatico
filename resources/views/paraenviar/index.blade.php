<x-template titulodapagina="" tituloHeader="Index Envio">

    <div class="mx-auto col-md-12 bg-secondary">

    <div class="p-0 d-flex justify-content-end">

    </div>

    <div class="d-flex justify-content-around m-3">
        <x-link href="{{route('paraenviar.create')}}" texto="Cadastrar Envio"/>
        <x-link href="{{route('listadeemails.index')}}" texto="Ver Listas de Emails"/>
        <x-link href="{{route('corpoemail.index')}}" texto="Ver Corpo de Emails"/>
        <x-link href="{{route('nomes.index')}}" texto="Ver Nomes"/>
        <x-link-sair/>
    </div>

    <div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Titulo</th>
                <th>Corpo Email</th>
                <th>Emails</th>
                <th>Emails CC</th>
                <th>Emails CCO</th>
                <th>Nomes</th>
                <th>Data Inicio</th>
                <th>Data Fim</th>
                <th>Continuar Envio</th>
                <th>Opções</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($paraenviar as $envio)
                <tr>
                    <td>
                        {{$envio->titulo}}
                    </td>
                    <td>
                        {{$envio->corpo_email_titulo}}
                    </td>
                    <td>
                        {{$envio->titulo_envio}}
                    </td>
                    <td>
                        {{$envio->titulo_cc}}
                    </td>
                    <td>
                        {{$envio->titulo_cco}}
                    </td>
                    <td>
                        {{$envio->nome1}}
                        {{$envio->nome2}}
                        {{$envio->nome3}}
                        {{$envio->nome4}}
                        {{$envio->nome5}}
                    </td>
                    <td>
                        {{$envio->data_inicio}}
                    </td>
                    <td>
                        {{$envio->data_fim}}
                    </td>
                    <td>
                        @if($envio->continuar_envio)
                            <a
                                class="btn btn-secondary"
                                href="{{route('paraenviar.alterarenvio', ['id'=>$envio->id])}}"
                            >Encerrar</a>
                        @else
                            <a
                                class="btn btn-info"
                                href="{{route('paraenviar.alterarenvio', ['id'=>$envio->id])}}"
                            >Retomar</a>
                        @endif
                    </td>
                    <td>
                        <x-link href="{{route('paraenviar.edit', ['id'=>$envio->id])}}" texto="Editar"/>
                        <x-link href="{{route('paraenviar.destroy', ['id'=>$envio->id])}}" texto="Excluir"/>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <x-errors/>
    </div>
</x-template>
