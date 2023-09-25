<x-template titulodapagina="" tituloHeader="Corpo de Emails Index">

    <div class="d-flex justify-content-around">
        <x-link href="{{route('corpoemail.create')}}" texto="Cadastrar Corpo de Email"/>
        <x-link href="{{route('paraenviar.index')}}" texto="Voltar"/>
        <x-link href="{{route('logout')}}" texto="Sair"/>
    </div>

    <div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Titulo</th>
                <th>Assunto</th>
                <th>Texto</th>
                <th>Opções</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($corpoemails as $corpo)
                <tr>
                    <td>{{$corpo->titulo}}</td>
                    <td>{{$corpo->assunto}}</td>
                    <td>{{$corpo->texto}}</td>
                    <td>
                        <x-link href="{{route('corpoemail.edit', ['id'=>$corpo->id])}}" texto="Editar"/>
                        <x-link href="{{route('corpoemail.destroy', ['id'=>$corpo->id])}}" texto="Excluir"/>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <x-errors/>
</x-template>
