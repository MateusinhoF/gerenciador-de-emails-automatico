<x-template titulodapagina="Lista de Envios" tituloHeader="Lista de Envios">
    <div class="mx-auto col-md-12 bg-secondary">

        <div class="m-3">
            <div class="d-flex justify-content-around mb-3">
                <x-link-proximo href="{{route('paraenviar.index')}}" texto="Próximo"/>
                <x-link href="{{route('listadeenvios.create')}}" texto="Cadastrar Lista"/>
                <x-link href="{{route('listadeenvios.receivelistemails')}}" texto="Enviar Lista"/>
                <x-link href="{{route('envios.create')}}" texto="Cadastrar Envios"/>
                <x-link href="{{route('paraenviar.index')}}" texto="Voltar"/>
                <x-link-sair/>
            </div>
            <div class="font-size-small">
                <p class="m-0 p-0">*Para cadastrar uma lista de envios é necessário cadastrar os envios antes, depois cadastrar um título para a lista de envio e após isso vincular os envios ao título.</p>
            </div>
        </div>

        <div>
            <table class="table table-striped table-hover text-center">
                <thead>
                <tr>
                    <th>Titulo</th>
                    <th>Emails</th>
                    <th>Opções</th>
                </tr>
                </thead>
                <tbody>
                @php($tituloIdAnterior = 0)
                @foreach ($listatitulosenvios as $tituloenvio)
                    <tr>
                        @php($tituloIdAgora = $tituloenvio->titulo_lista_de_envios_id)
                        @if($tituloIdAgora != $tituloIdAnterior)
                            <td>{{$tituloenvio->titulo}}</td>
                            @php($tituloIdAnterior = $tituloIdAgora)

                            <td>
                                @foreach($listatitulosenvios as $email)
                                    @if($tituloIdAgora == $email->titulo_lista_de_envios_id)
                                        {{$email->email}}<br>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <x-link-editar href="{{route('listadeenvios.edit', ['id'=>$tituloenvio->titulo_lista_de_envios_id])}}"/>
                                <x-link-excluir href="{{route('listadeenvios.destroy', ['id'=>$tituloenvio->titulo_lista_de_envios_id])}}"/>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <x-errors/>
    </div>
</x-template>
