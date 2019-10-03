{{-- 
Options:
	label: The label of the form-group
	  tip: The tip text for the input, will disapear if there is a message from validation
	value: The value of the input
	focus: Set the initial focus
	width: The width of the form-group (used to make columns)

--}}
<div class="form-group {{ (isset($width)) ? 'col-md-'.$width : "" }}">

	@isset ($label)
	    <label id="label_{{ $id }}">{{ $label }}</label>
	@endisset


	<textarea class="form-control @error($name) is-invalid @enderror" name="{{ $name }}" id="{{ $id }}">{{ $value ?? old($name) }}</textarea>

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

@style
<style type="text/css">
	/* CKEDITOR 4 styles */
	div.cke {
		border-radius: 4px;
		-webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
		     -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
		        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
	}

	div.cke div.cke_inner {
		border-radius: 4px;
	}


	div.cke span.cke_bottom {
		border-bottom-left-radius: 4px;
		border-bottom-right-radius: 4px;
	}

	div.cke span.cke_top {
		border-top-left-radius: 4px;
		border-top-right-radius: 4px;
	}


	div.cke_focus_normal {
		border-color: #80bdff;
		outline: 0;
		/*box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);*/
	}

	div.cke_focus_valid {
		outline: 0;
  		border-color: #28a745;
  		/*box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);*/
	}

	div.cke_focus_invalid {
		outline: 0;
		border-color: #dc3545;
		/*box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);*/
	}

</style>
@endstyle

@script
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.11.4/ckeditor.js" integrity="sha384-M11tXipzYtyYa+j/sTD+QhKr2/YvuyTkgR5RHlWb2g/QeaJBKAH3rgkGXqjWnaaq" crossorigin="anonymous"></script>
@endscript

@push('script')
	<script>
		$(document).ready(function() {

			$("#label_{{ $id }}").click(function() {
				CKEDITOR.instances['{{ $id }}'].focus();
			});

			CKEDITOR.config.language = "{{ Config::get('app.locale') ?? "en" }}";
			CKEDITOR.replace("{{ $id }}");

			@error ($name)
				CKEDITOR.on('instanceReady', function(evt) {
					$("div#cke_{{ $id }}").css("border-color", 'red');
				});

				CKEDITOR.instances['{{ $id }}'].on('focus', function() {
					$("div#cke_{{ $id }}").addClass("cke_focus_invalid");
				});

				CKEDITOR.instances['{{ $id }}'].on('blur', function() {
					$("div#cke_{{ $id }}").removeClass("cke_focus_invalid");
				});
			@else
				CKEDITOR.instances['{{ $id }}'].on('focus', function() {
					$("div#cke_{{ $id }}").addClass("cke_focus_normal");
				});

				CKEDITOR.instances['{{ $id }}'].on('blur', function() {
					$("div#cke_{{ $id }}").removeClass("cke_focus_normal");
				});		
			@enderror

		});
	</script>

	@isset ($focus)
		<script>
			$(document).ready(function() {
				CKEDITOR.on('instanceReady', function(evt) {
					CKEDITOR.instances['{{ $id }}'].focus();
				});			
			});
		</script>
	@endisset
@endpush