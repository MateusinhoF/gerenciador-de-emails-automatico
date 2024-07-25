<x-template titulodapagina="Emails" tituloHeader="Emails">
    <div class="mx-auto col-md-12 bg-secondary">

        <div class="d-flex justify-content-around m-3">
            <x-link-proximo href="{{route('listadeenvios.index')}}" texto="Próximo"/>
            <x-link href="{{route('informacoesdeenvios.create')}}" texto="Cadastrar Envio"/>
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
                @foreach ($envios as $envio)
                    <tr>
                        <td>{{$envio->nome}}</td>
                        <td>{{$envio->email}}</td>
                        <td>{{$envio->telefone}}</td>
                        <td>
                            <x-link-editar href="{{route('informacoesdeenvios.edit', ['id'=>$envio->id])}}"/>
                            <x-link-excluir href="{{route('informacoesdeenvios.destroy', ['id'=>$envio->id])}}"/>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <x-errors/>
    </div>
</x-template>
