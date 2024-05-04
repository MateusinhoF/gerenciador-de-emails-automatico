<x-template titulodapagina="Emails" tituloHeader="Emails">
    <div class="mx-auto col-md-12 bg-secondary">

        <div class="d-flex justify-content-around m-3">
            <x-link-proximo href="{{route('listadeemails.index')}}" texto="Próximo"/>
            <x-link href="{{route('emails.create')}}" texto="Cadastrar Emails"/>
            <x-link href="{{route('paraenviar.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <div>
            <table class="table table-striped table-hover text-center">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Opções</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($emails as $email)
                    <tr>
                        <td>{{$email->nome}}</td>
                        <td>{{$email->email}}</td>
                        <td>{{$email->telefone}}</td>
                        <td>
                            <x-link-editar href="{{route('emails.edit', ['id'=>$email->id])}}"/>
                            <x-link-excluir href="{{route('emails.destroy', ['id'=>$email->id])}}"/>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <x-errors/>
    </div>
</x-template>
