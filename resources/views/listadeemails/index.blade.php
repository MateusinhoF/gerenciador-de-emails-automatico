<x-template titulodapagina="Lista de Emails" tituloHeader="Lista de Emails">
    <div class="mx-auto col-md-12 bg-secondary">

        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('listadeemails.create')}}" texto="Cadastrar Lista"/>
            <x-link href="{{route('titulolistadeemails.create')}}" texto="Cadastrar Titulo"/>
            <x-link href="{{route('emails.create')}}" texto="Cadastrar Emails"/>
            <x-link href="{{route('paraenviar.index')}}" texto="Voltar"/>
            <x-link-sair/>
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
