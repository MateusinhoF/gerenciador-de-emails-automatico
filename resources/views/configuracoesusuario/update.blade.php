<x-template titulodapagina="Editar Email" tituloHeader="Editar Email">
    <div class="mx-auto col-md-12 bg-secondary">

        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('paraenviar.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('configuracoesusuario.update',['id'=>$user->id])}}" method="post" class="m-3 p-4 color-forms-background" enctype="multipart/form-data" >

            @csrf
            <x-input nome="login" texto="Login" tipo="login" valor="{{$user->login}}"/>

            <x-input nome="email" texto="Email" tipo="text" valor="{{$user->email}}"/>

            <x-input nome="assinatura" texto="Assinatura" tipo="text" valor="{{$user->assinatura}}"/>


            <x-input nome="password" texto="Senha de Login" tipo="password"/>

            <x-input nome="senha_email" texto="Senha de Email" tipo="password"/>



            @if($user->imagem_assinatura != null)
                <div class="form-group">
                    <a
                        class="link-primary p-1 link-offset-2 link-underline link-underline-opacity-0 link-opacity-50-hover"
                        href="{{route('configuracoesusuario.downloadassinatura', ['id'=>$user->id])}}"
                    >
                        Ver
                    </a>
                    <x-link-excluir href="{{route('configuracoesusuario.destroyimg', ['id'=>$user->id])}}"/>
                </div>
            @endif

            <div class="form-group">
                <label for="imagem_assinatura">Imagem Assinatura:</label>
                <input type="file" id="imagem_assinatura" name="imagem_assinatura">
            </div>

            <div class="d-flex justify-content-center">
                <input type="submit" value="Alterar" class="btn btn-primary">
            </div>


        </form>

        <x-errors/>
    </div>
</x-template>
