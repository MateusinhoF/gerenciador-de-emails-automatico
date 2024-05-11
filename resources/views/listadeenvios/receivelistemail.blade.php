<x-template titulodapagina="Enviar Lista de Emails" tituloHeader="Enviar Lista de Emails">

    <div class="mx-auto col-md-12 bg-secondary">
        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('listadeeenvios.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('listadeenvios.storelistenvios')}}" method="post" class="m-3 p-4 color-forms-background">

            @csrf

            <div class="form-control color-input-background">
                <div class="form-group">
                    <x-input nome="titulo" texto="Titulo" tipo="text"/>
                </div>

                <div class="form-group">
                    <x-input nome="lista" texto="Lista" tipo="text"/>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <input type="submit" value="Enviar Lista" class="btn btn-primary">
            </div>

        </form>

        <x-errors/>
    </div>
</x-template>
