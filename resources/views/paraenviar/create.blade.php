<x-template titulodapagina="Cadastrar Envio" tituloHeader="Cadastrar Envio">

    <div class="mx-auto col-md-12 bg-secondary">

        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('paraenviar.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('paraenviar.store')}}" method="post" class="m-3 p-4 color-forms-background">

            @csrf
            <x-input nome="titulo" texto="Titulo" tipo="text"/>

            <div class="form-control color-input-background">
                <div class="form-group">
                    <label for="corpoemail">Selecione um corpo de emails:</label>
                    <select name="corpoemail" id="corpoemail" class="form-select">
                        @foreach($corpoemails as $corpoemail)
                            <option value="{{$corpoemail->id}}">{{$corpoemail->titulo}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-control color-input-background">
                <div class="form-group">
                    <label for="listatitulos">Selecione uma lista de emails:</label>
                    <select name="listatitulos" id="listatitulos" class="form-select">
                        @foreach($listatitulos as $titulo)
                            <option value="{{$titulo->id}}">{{$titulo->titulo}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-control color-input-background">
                <div class="form-group">
                    <label for="listatituloscc">Selecione uma lista de emails para CC <span class="warning">(não obrigatório)</span>:</label>
                    <select name="listatituloscc" id="listatituloscc" class="form-select">
                        <option value="">Sem Lista</option>
                        @foreach($listatitulos as $titulo)
                            <option value="{{$titulo->id}}">{{$titulo->titulo}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-control color-input-background">
                <div class="form-group">
                    <label for="listatituloscco">Selecione uma lista de emails para CCO <span>(não obrigatório)</span>:</label>
                    <select name="listatituloscco" id="listatituloscco" class="form-select">
                        <option value="">Sem Lista</option>
                        @foreach($listatitulos as $titulo)
                            <option value="{{$titulo->id}}">{{$titulo->titulo}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-control color-input-background">
                <div class="form-group">
                    <label for="nomes">Selecione uma lista de nomes:</label>
                    <select name="nomes" id="nomes" class="form-select">
                        <option value="">Sem Nomes</option>
                        @foreach($nomes as $nome)
                            <option value="{{$nome->id}}">
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

            <div class="form-control color-input-background">
                <div class="form-group">
                    <div>
                        <label for="nomes">Selecione uma data de inicio de envio (opicional):</label>
                        <input type="date" name="data_inicio" id="data_inicio">
                    </div>
                    <div>
                        <label for="nomes">Selecione uma data de inicio de fim (opicional):</label>
                        <input type="date" name="data_fim" id="data_fim">
                    </div>
                </div>
            </div>

                <div class="d-flex justify-content-center pt-3">
                <input type="submit" value="Cadastrar Envio" class="btn btn-primary">
            </div>

        </form>

        <x-errors/>
    </div>
</x-template>
