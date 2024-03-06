<style>
    .options-text{
        background-color: #FFFFFF;
        font-size: 14px;
        font-family: Arial;
        color: #000000;

    }
</style>
<div class="options-text">
    {{$corpo}}
</div>

<br>
<br>
<br>

<div class="options-text">
    @if($assinatura != null)
        <div>Att. {{$assinatura}}</div>
    @endif
    @if($imagem_assinatura != null)
        <img src="{{$message->embed(base_path().'/assinaturas/'.$imagem_assinatura)}}"/>
    @endif
</div>

