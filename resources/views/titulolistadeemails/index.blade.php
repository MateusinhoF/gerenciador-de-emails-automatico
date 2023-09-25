<x-template titulodapagina="" tituloHeader="Emails Titulo Lista de Emails">

    <div class="d-flex justify-content-around">
        <x-link href="{{route('titulolistadeemails.create')}}" texto="Cadastrar Titulo"/>
        <x-link href="{{route('paraenviar.index')}}" texto="Voltar"/>
        <x-link href="{{route('logout')}}" texto="Sair"/>
    </div>

    <div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Titulo</th>
                <th>Opções</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($titulos as $titulo)
                <tr>
                    <td>{{$titulo->titulo}}</td>
                    <td>
                        <x-link href="{{route('titulolistadeemails.edit', ['id'=>$titulo->id])}}" texto="Editar"/>
                        <x-link href="{{route('titulolistadeemails.destroy', ['id'=>$titulo->id])}}" texto="Excluir"/>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <x-errors/>
</x-template>
