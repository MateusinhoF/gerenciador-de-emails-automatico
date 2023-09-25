<div class="form-group mb-3">

    <label
        for="{{$nome}}"
    >
        {{$texto}}
    </label>

    <input
        type="{{$tipo}}"
        name="{{$nome}}"
        id="{{$nome}}"
        value="{{$valor ?? ''}}"
        class="form-control"
    >

</div>
