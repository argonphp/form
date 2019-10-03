<div class="form-group {{ (isset($width)) ? 'col-md-'.$width : "" }}">
@isset ($label)
  <label class="">{{ $label }}</label>  
@endisset
@foreach ($options ?? [] as $val => $txt)
  @php
    $id = uniqid();
    $checked = '';
    if (array_key_exists($val, $value ?? old($name, []))) $checked = 'checked';
  @endphp
  <div class="custom-control @isset($label) ml-3 @endisset custom-checkbox">
    <input type="checkbox" class="custom-control-input" id="{{ $id }}" name={{ $name."[$val]" }} {{ $checked }}>
    <label class="custom-control-label" for="{{ $id }}">{{ $txt }}</label>
  </div>
@endforeach
  @error ($name)
  <div class="form-group">
  	<input type="hidden" name="" class="form-control is-invalid">
  	<div class="invalid-feedback">
  		{{ $message }}
  	</div>
  </div>
  @enderror
</div>


@style
  <style type="text/css">
    input[type=checkbox] + label {
      font-weight: normal !important;
    }
  </style>
@endstyle
