@props([

'name', 'options' ,'checked' => false
])


@foreach ($options as $value => $label)
<div class="form-check">
    <input type="radio" name="{{$name}}" value="{{$value}}" @checked(old($name,$checked)==$value ) {{ $attributes->class([
            'form-check-input', 'is-valid' =>
            $errors->has('$name')])
          }}>
    <label class="form-check-label">
        {{$label}}
    </label>
</div>

@endforeach