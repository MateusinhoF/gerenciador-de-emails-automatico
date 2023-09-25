<x-template titulodapagina="" tituloHeader="Editar Envio">

    <div class="d-flex justify-content-around">
        <x-link href="{{route('paraenviar.index')}}" texto="Voltar"/>
        <x-link href="{{route('logout')}}" texto="Sair"/>
    </div>

    <form action="{{route('paraenviar.update',['id'=>$paraenviar->id])}}" method="post" class="p-4 p-md-5 border rouded-3 bg-light">

        @csrf

        <x-input nome="titulo" texto="Titulo" tipo="text" valor="{{$paraenviar->titulo}}"/>

        <div class="form-control">
            <div class="form-group">
                <label for="corpoemail">Selecione um corpo de emails:</label>
                <select name="corpoemail" id="corpoemail" class="form-select">
                    @foreach($corpoemails as $corpoemail)
                        <option value="{{$corpoemail->id}}"
                            @if($corpoemail->id == $paraenviar->corpo_email_id) selected @endif
                        >{{$corpoemail->titulo}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-control">
            <div class="form-group">
                <label for="listatitulos">Selecione uma lista de emails:</label>
                <select name="listatitulos" id="listatitulos" class="form-select">
                    @foreach($listatitulos as $titulo)
                        <option value="{{$titulo->id}}"
                            @if($titulo->id == $paraenviar->titulo_lista_de_emails_id) selected @endif
                        >{{$titulo->titulo}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-control">
            <div class="form-group">
                <label for="listatituloscc">Selecione uma lista de emails para CC <span class="warning">(não obrigatório)</span>:</label>
                <select name="listatituloscc" id="listatituloscc" class="form-select">
                    <option value="">Sem Lista</option>
                    @foreach($listatitulos as $titulo)
                        <option value="{{$titulo->id}}"
                            @if($titulo->id == $paraenviar->titulo_lista_de_emails_cc_id) selected @endif
                        >{{$titulo->titulo}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-control">
            <div class="form-group">
                <label for="listatituloscco">Selecione uma lista de emails para CCO <span>(não obrigatório)</span>:</label>
                <select name="listatituloscco" id="listatituloscco" class="form-select">
                    <option value="">Sem Lista</option>
                    @foreach($listatitulos as $titulo)
                        <option value="{{$titulo->id}}"
                            @if($titulo->id == $paraenviar->titulo_lista_de_emails_cco_id) selected @endif
                        >{{$titulo->titulo}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-control">
            <div class="form-group">
                <label for="nomes">Selecione uma lista de nomes:</label>
                <select name="nomes" id="nomes" class="form-select">
                    <option value="">Sem Nomes</option>
                    @foreach($nomes as $nome)
                        <option value="{{$nome->id}}"
                            @if($nome->id == $paraenviar->nomes_id) selected @endif
                        >
                            {{$nome->nome1}}
                            @if($nome->nome2), {{$nome->nome2}} @endif
                            @if($nome->nome3), {{$nome->nome3}} @endif
                            @if($nome->nome4), {{$nome->nome4}} @endif
                            @if($nome->nome5), {{$nome->nome5}} @endif
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-control">
            <div class="form-group">
                <label for="nomes">Selecione uma data de inicio de envio (opicional):</label>
                <input type="date" name="data_inicio" id="data_inicio" value="{{$paraenviar->data_inicio}}">

                <label for="nomes">Selecione uma data de inicio de fim (opicional):</label>
                <input type="date" name="data_fim" id="data_fim" value="{{$paraenviar->data_fim}}">
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <input type="submit" value="Alterar Envio" class="btn btn-primary">
        </div>

    </form>

    <x-errors/>

</x-template>
