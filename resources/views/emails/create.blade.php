<x-template titulodapagina="Cadastrar Email" tituloHeader="Cadastrar Email">
    <div class="mx-auto col-md-12 bg-secondary">
        <div class="d-flex justify-content-around m-3">
            <x-link href="{{route('emails.index')}}" texto="Voltar"/>
            <x-link-sair/>
        </div>

        <form action="{{route('emails.store')}}" method="post" class="m-3 p-4 color-forms-background">

            @csrf

            <x-input nome="nome" texto="Nome" tipo="text"/>
            <x-input nome="email" texto="Email" tipo="text"/>
            <x-input nome="telefone" texto="Telefone" tipo="text"/>


            <div class="d-flex justify-content-center">
                <input type="submit" value="Cadastrar Email" class="btn btn-primary">
            </div>

        </form>

        <x-errors/>
    </div>
</x-template>
