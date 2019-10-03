{{-- 

Options:
	      width: The width of the form-group (used to make columns)
	      label: The label of the form-group
	placeholder: The placeholder of the input
	       mask: The mask that will be applied to the input
	reverseMask: Reverse the application of the mask, useful for money masks, or number separators
	    prepend: The text that will be prepended to the input
	prependIcon: The icon that will be prepended on the input
	     append: The text that will be appended to the input
	 appendIcon: The icon that will be appended to the input
	        tip: The tip text for the input, will disapear if there is a message from validation
	      value: The value of the input
	  plainText: Changes the style of the input (created to be used with 'readOnly' option)
	      focus: Set the initial focus

--}}
<div class="form-group  {{ (isset($width)) ? 'col-md-'.$width : "" }}">

	@isset ($label)		
	    <label for="{{ $id }}">
	    	{{ $label }}
	    </label>
	@endisset

	@if (!empty($prepend) or !empty($prependIcon) or !empty($append) or !empty($appendIcon))
	    <div class="input-group">
	@endif

	@if (!empty($prepend) or !empty($prependIcon))
		<div class="input-group-prepend">
			<div class="input-group-text">
				@isset ($prepend)
					{{ $prepend }}
				@endisset
				@isset ($prependIcon)
					<i class="fa fa-fw {{ $prependIcon }}"></i>
				@endisset
			</div>
		</div>
	@endif

	@php
		if (isset($plainText)) $plainText = '-plaintext form-control-lg font-weight-bold';
	@endphp

	<input 
		type="text" 
		class="form-control{{ $plainText ?? "" }} @error($name) is-invalid @enderror" 
		id="{{ $id }}" 
		name="{{ $name }}" 
		value="{{ $value ?? old($name) }}" 
		placeholder="{{ $placeholder ?? "" }}"
		@isset ($readOnly) readonly @endisset
		>

	@if (!empty($append) or !empty($appendIcon))
		<div class="input-group-append">
			<div class="input-group-text">
				@isset ($append)
					{{ $append }}
				@endisset
				@isset ($appendIcon)
					<i class="fa fa-fw {{ $appendIcon }}"></i>
				@endisset
			</div>
		</div>
	@endif

	@if (!empty($prepend) or !empty($prependIcon) or !empty($append) or !empty($appendIcon))
		</div>
	@endif


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

@script
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js" integrity="sha384-gyd4qL89L3l3RHg1DIarsIoh4BT3/hmoq/DtYpJdyT5oPemVJIMdh6/qC4UJ12WJ" crossorigin="anonymous"></script>
@endscript

@push('script')
	@isset ($mask)
		<script>
			$(document).ready(function() {
				$("#{{ $id }}").mask("{{ $mask }}", @isset($reverseMask) {reverse: true} @endisset);
			});
		</script>
	@endisset

	@isset ($focus)
		<script>
			$(document).ready(function() {
				$("#{{ $id }}").focus();
			});
		</script>
	@endisset
@endpush