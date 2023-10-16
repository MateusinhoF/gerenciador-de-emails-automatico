<x-template titulodapagina="Corpo de Email" tituloHeader="Corpo de Email">

    <div class="mx-auto col-md-12 bg-secondary">
        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('corpoemail.create')}}" texto="Cadastrar Corpo de Email"/>
            <x-link href="{{route('paraenviar.index')}}" texto="Voltar"/>
            <x-link-sair/>
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
                            <x-link-editar href="{{route('corpoemail.edit', ['id'=>$corpo->id])}}"/>
                            <x-link-excluir href="{{route('corpoemail.destroy', ['id'=>$corpo->id])}}"/>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <x-errors/>
    </div>
</x-template>
