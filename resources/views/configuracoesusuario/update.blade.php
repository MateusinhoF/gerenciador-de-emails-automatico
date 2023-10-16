<x-template titulodapagina="Editar Email" tituloHeader="Editar Email">
    <div class="mx-auto col-md-12 bg-secondary">

        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('configuracoesusuario.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('configuracoesusuario.update',['id'=>$email->id])}}" method="post" class="m-3 p-4 color-forms-background">

            @csrf
            <x-input nome="email" texto="Email" tipo="text" valor="{{$email->email}}"/>

            <x-input nome="senhaenvio" texto="Senha email para envio" tipo="password"/>

            <x-input nome="emailenvio" texto="Email para envio" tipo="text" valor="{{$email->email}}"/>

            <x-input nome="senhaenvio" texto="Senha email para envio" tipo="password"/>

            <div class="d-flex justify-content-center">
                <input type="submit" value="Alterar" class="btn btn-primary">
            </div>

        </form>

        <x-errors/>
    </div>
</x-template>
