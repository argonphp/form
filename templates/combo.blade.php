{{--

Options:
      width: The width of the form-group (used to make columns)
      label: The label of the form-group
        tip: The tip text for the input, will disapear if there is a message from validation
      value: The value of the input
      focus: Set the initial focus

--}}
<div class="form-group {{ (isset($width)) ? 'col-md-'.$width : "" }}">

	@isset ($label)
	    <label for="{{ $id }}">{{ $label }}</label>
	@endisset



	<select class="form-control @error($name) is-invalid @enderror" name="{{ $name }}" id="{{ $id }}">


			
			@isset ($value)
			    <option value="">&nbsp;</option>
			@else
				<option selected value="">&nbsp;</option>
			@endisset

			@foreach ($options as $val => $txt)
				@php
					$value = $value ?? old($name, '');
					if ((string) $val === (string) $value) {
						$selected = 'selected';
					} else {
						$selected = '';
					}
				@endphp
				<option value="{{ $val }}" {{ $selected }}>{{ $txt }}</option>
			@endforeach
	</select>
	
	@error($name)
		<div class="invalid-feedback">
    		{{ $message }}
    	</div>
    @else
		@isset ($tip)
			<small class="form-text text-muted">{{ $tip }}</small>
		@endisset    
    @enderror

</div>

@push('script')
	@isset ($focus)
	    <script type="text/javascript">
	    	$(document).ready(function() {
	    		$("#{{ $id }}").focus();
	    	});
	    </script>
	@endisset
@endpush