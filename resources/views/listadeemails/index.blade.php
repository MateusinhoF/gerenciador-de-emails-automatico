<x-template titulodapagina="" tituloHeader="Index Lista de Emails">

    <div class="d-flex justify-content-around">
        <x-link href="{{route('listadeemails.create')}}" texto="Cadastrar Lista"/>
        <x-link href="{{route('paraenviar.index')}}" texto="Voltar"/>
        <x-link href="{{route('logout')}}" texto="Sair"/>
    </div>


    <div class="d-flex justify-content-around pt-3 pb-3">
        <x-link class="link-info link-offset-2 link-underline link-underline-opacity-0 link-opacity-50-hover" href="{{route('titulolistadeemails.create')}}" texto="Cadastrar Titulo"/>
        <x-link class="link-info link-offset-2 link-underline link-underline-opacity-0 link-opacity-50-hover" href="{{route('emails.create')}}" texto="Cadastrar Emails"/>
    </div>

    <div>
        <table class="table table-striped table-hover">
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
                            <x-link href="{{route('listadeemails.edit', ['id'=>$tituloemail->titulo_lista_de_emails_id])}}" texto="Editar"/>
                            <x-link href="{{route('listadeemails.destroy', ['id'=>$tituloemail->titulo_lista_de_emails_id])}}" texto="Excluir"/>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <x-errors/>
</x-template>
