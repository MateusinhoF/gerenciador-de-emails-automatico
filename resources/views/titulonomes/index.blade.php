<x-template titulodapagina="" tituloHeader="Titulo de lista de nomes Index">

    <div class="d-flex justify-content-around">
        <x-link href="{{route('titulonomes.create')}}" texto="Cadastrar Titulo"/>
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
                        <x-link href="{{route('titulonomes.edit', ['id'=>$titulo->id])}}" texto="Editar"/>
                        <x-link href="{{route('titulonomes.destroy', ['id'=>$titulo->id])}}" texto="Excluir"/>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <x-errors/>
</x-template>
