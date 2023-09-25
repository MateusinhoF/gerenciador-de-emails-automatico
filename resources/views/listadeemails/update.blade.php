<x-template titulodapagina="" tituloHeader="Editar Lista de Emails">

    <div class="d-flex justify-content-around">
        <x-link href="{{route('listadeemails.index')}}" texto="Voltar"/>
        <x-link href="{{route('logout')}}" texto="Sair"/>
    </div>

    <form action="{{route('listadeemails.update',['id'=>$listatitulosemails["0"]->titulo_lista_de_emails_id])}}" method="post" class="p-4 p-md-5 border rouded-3 bg-light">

        @csrf
        @php($titulo = $listatitulosemails["0"]->titulo)
        <x-input nome="titulo" texto="Titulo" tipo="text" valor="{{$titulo}}"/>


        <div class="form-control mt-2 mb-3">
            @foreach($emails as $email)
                <div class="form-check">
                    <input type="checkbox" id="{{$email->id}}" name="email[]" value="{{$email->id}}"
                        @foreach($listatitulosemails as $emailmarcado)
                            @if($email->id == $emailmarcado->emails_id)
                                checked
                            @endif
                        @endforeach
                    >
                    <label for="{{$email->id}}">{{$email->email}}</label>
                </div>
            @endforeach
        </div>


        <div class="d-flex justify-content-center">
            <input type="submit" value="Alterar Lista" class="btn btn-primary">
        </div>

    </form>

    <x-errors/>

</x-template>
