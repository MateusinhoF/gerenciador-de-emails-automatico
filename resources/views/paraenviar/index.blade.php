<x-template titulodapagina="Envio" tituloHeader="Envio">
    <div class="mx-auto col-md-12 bg-secondary">

        <div class="m-3">
            <div class="d-flex justify-content-around mb-3">
                <x-link-proximo href="{{route('corpoemail.index')}}" texto="Passo a Passo"/>
                <x-link href="{{route('paraenviar.create')}}" texto="Cadastrar Envio"/>
                <x-link href="{{route('listadeenvios.index')}}" texto="Ver Listas de Envios"/>
                <x-link href="{{route('corpoemail.index')}}" texto="Ver Texto de Notificação"/>
                <x-link href="{{route('nomes.index')}}" texto="Ver Nomes"/>
                <x-link href="{{route('configuracoesusuario.edit',['id'=>\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()])}}" texto="Configurações"/>
                <x-link-sair/>
            </div>
            <div class="font-size-small">
                <p class="m-0 p-0">*Para cadastrar um novo envio é necessário antes preencher um corpo de emaill e uma lista de email.</p>
                <p class="m-0 p-0">*Os nomes não são obrigatórios para envio.</p>
            </div>
        </div>
        <div>
            <table class="table table-striped table-hover text-center">
                <thead>
                <tr>
                    <th>Titulo</th>
                    <th>Corpo Email</th>
                    <th>Envios</th>
                    <th>Envios CC</th>
                    <th>Envios CCO</th>
                    <th>Nomes</th>
                    <th>Data Inicio</th>
                    <th>Data Fim</th>
                    <th>Situação</th>
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
                                <x-link-enviando href="{{route('paraenviar.alterarenvio', ['id'=>$envio->id])}}"/>
                            @else
                                <x-link-parado href="{{route('paraenviar.alterarenvio', ['id'=>$envio->id])}}"/>
                            @endif
                        </td>
                        <td>
                            <x-link-editar href="{{route('paraenviar.edit', ['id'=>$envio->id])}}"/>
                            <x-link-excluir href="{{route('paraenviar.destroy', ['id'=>$envio->id])}}"/>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <x-errors/>
    </div>
</x-template>
