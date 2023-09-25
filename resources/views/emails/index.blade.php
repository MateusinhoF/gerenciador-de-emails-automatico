<x-template titulodapagina="" tituloHeader="Emails Index">

    <div class="d-flex justify-content-around">
        <x-link href="{{route('emails.create')}}" texto="Cadastrar Emails"/>
        <x-link href="{{route('paraenviar.index')}}" texto="Voltar"/>
        <x-link href="{{route('logout')}}" texto="Sair"/>
    </div>

    <div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Email</th>
                <th>Descrição</th>
                <th>Opções</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($emails as $email)
                <tr>
                    <td>{{$email->email}}</td>
                    <td>{{$email->descricao}}</td>
                    <td>
                        <x-link href="{{route('emails.edit', ['id'=>$email->id])}}" texto="Editar"/>
                        <x-link href="{{route('emails.destroy', ['id'=>$email->id])}}" texto="Excluir"/>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <x-errors/>
</x-template>
