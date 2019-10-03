<div class="form-group {{ (isset($width)) ? 'col-md-'.$width : "" }}">

	@isset ($label)
		<label for="{{ $id }}" >{{ $label }}</label>    
	@endisset
		
	<div class="input-group">
		<input 
			type="password" 
			class="form-control @error($name) is-invalid @enderror" 
			id="{{ $id }}" 
			name="{{ $name }}" 
			value="{{ $value ?? old($name) }}"
		>

		@error ($name)
		  	<div class="invalid-feedback order-last">
		  		{{ $message }}
		  	</div>
		@enderror

		<div class="input-group-append">
			<button tabindex="-1" class="input-group-text" id="pw_button_{{ $id }}">
				<i class="fa fa-fw fa-eye"></i>
			</button>
		</div>
	
	</div>

	<div id="pwstrength_{{ $id }}" class="pwstrength">
		<div class="pwstrength_viewport_progress"></div>
		<div class="pwstrength_viewport_verdict">&nbsp;</div>
	</div>

</div>

@style
<style type="text/css">
	.pwstrength {
        margin-top: 10px;
    }
</style>
@endstyle

@script
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pwstrength-bootstrap/3.0.4/pwstrength-bootstrap.min.js" integrity="sha384-ApHz1T8vNQIu36FWRAtPFgXrlV5b3LXKSIgxm7ZoWD42dD3nG2YTh7sY84+rzgsT" crossorigin="anonymous"></script>
@endscript

@push('script')
	<script type="text/javascript">
		$(document).ready(function(event) {
			$("#pw_button_{{ $id }}").click(function(event) {
				event.preventDefault();
				if ($("#{{ $id }}").attr('type') == "password") {
					$("#{{ $id }}").attr('type', 'text');
					$("#pw_button_{{ $id }} i").removeClass('fa-eye');
					$("#pw_button_{{ $id }} i").addClass('fa-eye-slash');
				} else {
					$("#{{ $id }}").attr('type', 'password');
					$("#pw_button_{{ $id }} i").removeClass('fa-eye-slash');
					$("#pw_button_{{ $id }} i").addClass('fa-eye');
				};
				
				return false;
			});
		});
	</script>

	@if (!isset($meter) or (isset($meter) and $meter === true) )
		<script>
			$(document).ready(function() {

			    var options = {};
			    options.ui = {
			    	container: "#pwstrength_{{ $id }}",
			    	viewports: {
	        		    progress: ".pwstrength_viewport_progress",
	        		    verdict: ".pwstrength_viewport_verdict"
			        }

			    };
			    options.i18n = {
			        t: function (key) {
			            
			        	var translations = {
			        	    "wordMinLength": "Sua senha é muito curta",
						    "wordMaxLength": "Sua senha é muito longa",
						    "wordInvalidChar": "Sua senha contém um caractere inválido",
						    "wordNotEmail": "Não use seu e-mail como senha",
						    "wordSimilarToUsername": "Sua senha não pode conter o seu nome de usuário",
						    "wordTwoCharacterClasses": "Use diferentes classes de caracteres",
						    "wordRepetitions": "Muitas repetições",
						    "wordSequences": "Sua senha contém sequências",
						    "errorList": "Erros:",
						    "veryWeak": "Muito Fraca",
						    "weak": "Fraca",
						    "normal": "Normal",
						    "medium": "Média",
						    "strong": "Forte",
							"veryStrong": "Muito Forte"
			        	};
			            return translations[key];
			        }
			    };

				$('#{{ $id }}').pwstrength(options);
			});
		</script>    
	@endisset
@endpush
