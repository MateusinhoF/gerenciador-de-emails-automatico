<x-template titulodapagina="Lista de Emails" tituloHeader="Lista de Emails">
    <div class="mx-auto col-md-12 bg-secondary">

        <div class="m-3">
            <div class="d-flex justify-content-around mb-3">
                <x-link-proximo href="{{route('paraenviar.index')}}" texto="Próximo"/>
                <x-link href="{{route('listadeemails.create')}}" texto="Cadastrar Lista"/>
                <x-link href="{{route('emails.create')}}" texto="Cadastrar Emails"/>
                <x-link href="{{route('paraenviar.index')}}" texto="Voltar"/>
                <x-link-sair/>
            </div>
            <div class="font-size-small">
                <p class="m-0 p-0">*Para cadastrar uma lista de emails é necessário cadastrar os emails antes, depois cadastrar um título para a lista e após isso vincular os emails ao título.</p>
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
                @foreach ($listatitulosemails as $tituloemail)
                    <tr>
                        @php($tituloIdAgora = $tituloemail->titulo_lista_de_emails_id)
                        @if($tituloIdAgora != $tituloIdAnterior)
                            <td>{{$tituloemail->titulo}}</td>
                            @php($tituloIdAnterior = $tituloIdAgora)

                            <td>
                                @foreach($listatitulosemails as $email)
                                    @if($tituloIdAgora == $email->titulo_lista_de_emails_id)
                                        {{$email->email}}<br>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <x-link-editar href="{{route('listadeemails.edit', ['id'=>$tituloemail->titulo_lista_de_emails_id])}}"/>
                                <x-link-excluir href="{{route('listadeemails.destroy', ['id'=>$tituloemail->titulo_lista_de_emails_id])}}"/>
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
