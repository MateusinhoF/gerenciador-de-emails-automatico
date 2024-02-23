<x-template titulodapagina="Cadastrar Corpo de Email" tituloHeader="Cadastrar Corpo de Email">
    <div class="mx-auto col-md-12 bg-secondary">

        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('anexos.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('anexos.store')}}" method="post" enctype="multipart/form-data" class="m-3 p-4 color-forms-background">

            @csrf

            <div class="d-flex justify-content-center">
                <input type="submit" value="Cadastrar Corpo de Email" class="btn btn-primary">
            </div>

        </form>

        <x-errors/>
    </div>
</x-template>
