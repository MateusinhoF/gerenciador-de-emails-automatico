<x-template titulodapagina="Editar Titulo Lista de Emails" tituloHeader="Editar Titulo Lista de Emails">

    <div class="mx-auto col-md-12 bg-secondary">
        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('titulolistadeemails.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('titulolistadeemails.update',['id'=>$titulo->id])}}" method="post" class="m-3 p-4 color-forms-background">

            @csrf
            <x-input nome="titulo" texto="Titulo" tipo="text" valor="{{$titulo->titulo}}"/>

            <div class="d-flex justify-content-center">
                <input type="submit" value="Alterar Titulo" class="btn btn-primary">
            </div>

        </form>

        <x-errors/>
    </div>
</x-template>
