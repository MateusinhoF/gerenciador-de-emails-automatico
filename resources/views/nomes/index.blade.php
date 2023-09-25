<x-template titulodapagina="" tituloHeader="Nomes Index">

    <div class="d-flex justify-content-around">
        <x-link href="{{route('nomes.create')}}" texto="Cadastrar nomes"/>
        <x-link href="{{route('paraenviar.index')}}" texto="Voltar"/>
        <x-link href="{{route('logout')}}" texto="Sair"/>
    </div>

    <div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Nome 1</th>
                <th>Nome 2</th>
                <th>Nome 3</th>
                <th>Nome 4</th>
                <th>Nome 5</th>
                <th>Opções</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($nomes as $nome)
                <tr>
                    <td>{{$nome->nome1}}</td>
                    <td>{{$nome->nome2}}</td>
                    <td>{{$nome->nome3}}</td>
                    <td>{{$nome->nome4}}</td>
                    <td>{{$nome->nome5}}</td>
                    <td>
                        <x-link href="{{route('nomes.edit', ['id'=>$nome->id])}}" texto="Editar"/>
                        <x-link href="{{route('nomes.destroy', ['id'=>$nome->id])}}" texto="Excluir"/>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <x-errors/>
</x-template>
