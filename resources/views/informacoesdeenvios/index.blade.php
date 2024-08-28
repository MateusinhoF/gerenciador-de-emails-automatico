<x-template titulodapagina="Informações de Envio" tituloHeader="Informações de Envio">
    <div class="mx-auto col-md-12 bg-secondary">

        <div class="d-flex justify-content-around m-3">
            <x-link-proximo href="{{route('listadeenvios.index')}}" texto="Próximo"/>
            <x-link href="{{route('informacoesdeenvios.create')}}" texto="Cadastrar Informações de Envio"/>
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
                @foreach ($informacoesdeenvios as $informacoesdeenvio)
                    <tr>
                        <td>{{$informacoesdeenvio->nome}}</td>
                        <td>{{$informacoesdeenvio->email}}</td>
                        <td>{{$informacoesdeenvio->telefone}}</td>
                        <td>
                            <x-link-editar href="{{route('informacoesdeenvios.edit', ['id'=>$informacoesdeenvio->id])}}"/>
                            <x-link-excluir href="{{route('informacoesdeenvios.destroy', ['id'=>$informacoesdeenvio->id])}}"/>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <x-errors/>
    </div>
</x-template>
