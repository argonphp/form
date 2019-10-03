<div class="form-group {{ (isset($width)) ? 'col-md-'.$width : "" }}">
@isset ($label)
  <label class="">{{ $label }}</label>  
@endisset
@foreach ($options ?? [] as $val => $txt)
  @php
    $id = uniqid();
    $checked = '';
    if ((string) $val == (string)($value ?? old($name))) $checked = 'checked';
  @endphp
  <div class="custom-control @isset($label) ml-3 @endisset custom-radio">
    <input type="radio" class="custom-control-input" id="{{ $id }}" name="{{ $name }}" value="{{ $val }}" {{ $checked }}>
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
  input[type=radio] + label {
    font-weight: normal !important;
  }
</style>
@endstyle