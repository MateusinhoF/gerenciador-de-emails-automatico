<x-template titulodapagina="Email de Envio" tituloHeader="Email de Envio">
    <div class="mx-auto col-md-12 bg-secondary">

        <div class="d-flex justify-content-around m-3">
            @if(!isset($configuracoes[0]))
                <x-link href="{{route('configuracoesusuario.create')}}" texto="Cadastrar Emails"/>
            @else
                <x-link href="{{route('configuracoesusuario.edit', ['id'=>$configuracoes[0]->id])}}" texto="Editar Emails"/>
            @endif
            <x-link href="{{route('configuracoesusuario.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <div>
            <table class="table table-striped table-hover text-center">
                <thead>
                <tr>
                    <th>Email</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        @if(isset($configuracoes[0]))
                            <td>{{$configuracoes[0]->email}}</td>
                        @else
                            <td></td>
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>
        <x-errors/>
    </div>
</x-template>
