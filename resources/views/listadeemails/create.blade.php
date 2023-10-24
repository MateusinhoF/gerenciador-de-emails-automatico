<x-template titulodapagina="Cadastrar Lista de Emails" tituloHeader="Cadastrar Lista de Emails">

    <div class="mx-auto col-md-12 bg-secondary">
        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('listadeemails.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('listadeemails.store')}}" method="post" class="m-3 p-4 color-forms-background">

            @csrf

            <div class="form-control color-input-background">
                <div class="form-group">
                    <label for="titulo">Selecione um titulo:</label>
                    <select name="titulo" id="titulo" class="form-select">
                        @foreach($listatitulos as $titulo)
                            <option value="{{$titulo->id}}">{{$titulo->titulo}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-control mt-2 mb-3 color-input-background">
                @foreach($emails as $email)
                    <div class="form-check">
                        <input type="checkbox" id="{{$email->id}}" name="email[]" value="{{$email->id}}">
                        <label for="{{$email->id}}">{{$email->email}}</label>
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
