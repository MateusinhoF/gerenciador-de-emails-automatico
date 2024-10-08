<x-template titulodapagina="" tituloHeader="Editar Lista de Emails">

    <div class="mx-auto col-md-12 bg-secondary">
        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('listadeenvios.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('listadeenvios.update',['id'=>$listatitulosenvios["0"]->titulo_lista_de_envios_id])}}" method="post" class="m-3 p-4 color-forms-background">

            @csrf
            @php($titulo = $listatitulosenvios["0"]->titulo)
            <x-input nome="titulo" texto="Titulo" tipo="text" valor="{{$titulo}}"/>


            <div class="form-control mt-2 mb-3">
                @foreach($informacoesdeenvios as $informacoesdeenvio)
                    <div class="form-check">
                        <input class="color-input-background" type="checkbox" id="{{$informacoesdeenvio->id}}" name="informacoesdeenvio[]" value="{{$informacoesdeenvio->id}}"
                            @foreach($listatitulosenvios as $enviomarcado)
                                @if($informacoesdeenvio->id == $enviomarcado->informacoes_de_envios_id)
                                    checked
                                @endif
                            @endforeach
                        >
                        <label for="{{$informacoesdeenvio->id}}">{{$informacoesdeenvio->email}}</label>
                    </div>
                @endforeach
            </div>


            <div class="d-flex justify-content-center">
                <input type="submit" value="Alterar Lista" class="btn btn-primary">
            </div>

        </form>

        <x-errors/>
    </div>
</x-template>
