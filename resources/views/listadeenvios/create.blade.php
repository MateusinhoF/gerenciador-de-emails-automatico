<x-template titulodapagina="Cadastrar Lista de Envios" tituloHeader="Cadastrar Lista de Envios">

    <div class="mx-auto col-md-12 bg-secondary">
        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('listadeenvios.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('listadeenvios.store')}}" method="post" class="m-3 p-4 color-forms-background">

            @csrf

            <div class="form-control color-input-background">
                <div class="form-group">
                    <x-input nome="titulo" texto="Titulo" tipo="text"/>
                </div>
            </div>

            <div class="form-control mt-2 mb-3 color-input-background">
                @foreach($informacoesdeenvios as $informacoesdeenvio)
                    <div class="form-check">
                        <input type="checkbox" id="{{$informacoesdeenvio->id}}" name="informacoesdeenvios[]" value="{{$informacoesdeenvio->id}}">
                        <label for="{{$informacoesdeenvio->id}}">{{$informacoesdeenvio->email}}</label>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center">
                <input type="submit" value="Cadastrar Lista" class="btn btn-primary">
            </div>

        </form>

        <x-errors/>
    </div>
</x-template>
