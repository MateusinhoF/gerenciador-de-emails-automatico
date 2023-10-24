<x-template titulodapagina="Titulo Lista de Emails" tituloHeader="Titulo Lista de Emails">

    <div class="mx-auto col-md-12 bg-secondary">
        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('titulolistadeemails.create')}}" texto="Cadastrar Titulo"/>
            <x-link href="{{route('paraenviar.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <div>
            <table class="table table-striped table-hover text-center">
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
                            <x-link-editar href="{{route('titulolistadeemails.edit', ['id'=>$titulo->id])}}"/>
                            <x-link-excluir href="{{route('titulolistadeemails.destroy', ['id'=>$titulo->id])}}"/>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <x-errors/>
    </div>
</x-template>
