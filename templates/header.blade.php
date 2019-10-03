<?php if ($name == 'cdn'): ?>
 
 <!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- Different that what is stated by Bootstrap, Argon \ Form \ Helper needs that the javascript (the base ones)  to be putted on header -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js" integrity="sha384-gyd4qL89L3l3RHg1DIarsIoh4BT3/hmoq/DtYpJdyT5oPemVJIMdh6/qC4UJ12WJ" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.11.4/ckeditor.js" integrity="sha384-M11tXipzYtyYa+j/sTD+QhKr2/YvuyTkgR5RHlWb2g/QeaJBKAH3rgkGXqjWnaaq" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pwstrength-bootstrap/3.0.4/pwstrength-bootstrap.min.js" integrity="sha384-ApHz1T8vNQIu36FWRAtPFgXrlV5b3LXKSIgxm7ZoWD42dD3nG2YTh7sY84+rzgsT" crossorigin="anonymous"></script>
<style>
	div.form-group label.col-form-label {
	  text-align: right;
	}
	@media (max-width: 575.98px) {
		div.form-group.row label {
		  text-align: left;
		}
	}
	
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
		box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
	}

	div.cke_focus_valid {
		outline: 0;
  		border-color: #28a745;
  		box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
	}

	div.cke_focus_invalid {
		outline: 0;
		border-color: #dc3545;
		box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
	}

	div.form-group div.col-sm-10 div.progress {
		margin-top: 10px;
	}

</style>

<?php endif ?>