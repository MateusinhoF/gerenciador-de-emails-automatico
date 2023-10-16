<x-template titulodapagina="Cadastrar Lista de Emails" tituloHeader="Cadastrar Lista de Emails">

    <div class="d-flex justify-content-around">
        <x-link href="{{route('listadeemails.index')}}" texto="Voltar"/>
        <x-link href="{{route('logout')}}" texto="Sair"/>
    </div>

    <form action="{{route('listadeemails.store')}}" method="post" class="p-4 p-md-5 border rouded-3 bg-light">

        @csrf

        <div class="form-control">
            <div class="form-group">
                <label for="titulo">Selecione um titulo:</label>
                <select name="titulo" id="titulo" class="form-select">
                    @foreach($listatitulos as $titulo)
                        <option value="{{$titulo->id}}">{{$titulo->titulo}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-control mt-2 mb-3">
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
</x-template>
