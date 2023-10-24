<x-template titulodapagina="" tituloHeader="Editar Lista de Emails">

    <div class="mx-auto col-md-12 bg-secondary">
        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('listadeemails.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('listadeemails.update',['id'=>$listatitulosemails["0"]->titulo_lista_de_emails_id])}}" method="post" class="m-3 p-4 color-forms-background">

            @csrf
            @php($titulo = $listatitulosemails["0"]->titulo)
            <x-input nome="titulo" texto="Titulo" tipo="text" valor="{{$titulo}}"/>


            <div class="form-control mt-2 mb-3">
                @foreach($emails as $email)
                    <div class="form-check">
                        <input class="color-input-background" type="checkbox" id="{{$email->id}}" name="email[]" value="{{$email->id}}"
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
    </div>
</x-template>
