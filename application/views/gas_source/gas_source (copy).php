<div id="gas_source_body">
	<? $this->load->view('gas_source/gas_source_body.php'); ?>
</div>

<script type="text/javascript">
	//Geo Area Filter Using State Id
	function gasSourceFilter(id)
	{
		$.post(WEB_ROOT + "GasSource/geoAreaFilter", {'id' : id}, function(data){
			$('#gas_area_filter').html(data);
			$('#nomination_add_form').html('<div class="alert alert-warning">Please Select State OR GA Values</div>');
		});
	}

	//Gas Source Date
	function gasSourceTodayDate()
	{
		var params = {
			'state' : $('#state').val(),
			'ga' : $('#ga').val(),
			'nomination_date' : $('#nomination_date').val()
		};
		$.post(WEB_ROOT + "GasSource/index_body", params, function(data){
			$('#gas_source_body').html(data);
		});
	}

	function nomination_insert(e)
	{
		e.preventDefault();
		$('button[type = "submit"]').prop('disabled', true);
		$('button[type = "submit"]').html('<i class="fa fa-spinner fa-spin"></i>&nbsp;<strong>processing...</strong>');
		var params = $("#nomination_add_form").serializeArray();
		$.post(WEB_ROOT + "GasSource/nomination_insert", params, function(data){
			$("#nomination_add_success").html(data);
			$('button[type = "submit"]').prop('disabled',false);
			$('button[type = "submit"]').html('<i class="fa fa-plus">&nbsp;</i>Add');
		});
	}

	function isNumberKey(evt) {
	  	var charCode = (evt.which) ? evt.which : evt.keyCode
	  	if (charCode > 31 && (charCode < 45 || charCode > 57))
	  	return false;
	  	return true;
	}
</script>