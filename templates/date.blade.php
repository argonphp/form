<div class="form-group  {{ (isset($width)) ? 'col-md-'.$width : "" }}">
	
	@isset ($label)		
	    <label for="{{ $id }}">
	    	{{ $label }}
	    </label>
	@endisset	

	
	<div class="input-group date">

		<input 
			type="text" 
			class="form-control{{ $plainText ?? "" }} @error($name) is-invalid @enderror datepickerinput" 
			id="{{ $id }}" 
			name="{{ $name }}" 
			value="{{ $value ?? old($name) }}" 
			placeholder="{{ $placeholder ?? "" }}"
			@isset ($readOnly) readonly @endisset
			>
		
	</div>

	@error($name)
		<div class="invalid-feedback" style="display: block">
    		{{ $message }}
    	</div>
    @enderror

</div>


@style
	<link href=" https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css " rel="stylesheet" type="text/css" />
@endstyle

@script
	<script src=" https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js " type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/messages/messages.pt-br.js" type="text/javascript"></script>
@endscript

@push('script')
<script type="text/javascript">

$(document).ready(function() {

	// Enable DatePicker on the given element no all the elements 
	// (try to not interferes with developer choices)
	$('#{{$id}}').datepicker({
	    uiLibrary: 'bootstrap4',
	    locale: 'pt-br',
	    format: 'dd/mm/yyyy'
	});

	$('#{{$id}}').mask('00/00/0000');

	// Disable ENTER submit form that interferes with ENTER selecting a date
	$('#{{$id}}').keydown(function(event) {
		if (event.keyCode == 13) {
			event.preventDefault();
		}
	});
});
</script>

@endpush
