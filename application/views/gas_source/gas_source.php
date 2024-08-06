<?php
/**
 * Get the Contracts Details
 */ 
?>
<div id="gas_source_body">
	<? $this->load->view('gas_source/gas_source_body.php'); ?>
</div>

<script type="text/javascript">
	//Geo Area Filter Using State Id
	function gasSourceFilter(id)
	{
		preLoader();
		$.post(WEB_ROOT + "GasSource/geoAreaFilter", {'id' : id}, function(data){
			$('#gas_area_filter').html(data);
			$('#nomination_add_form').html('<div class="alert alert-warning">Please Select State OR GA Values</div>');
			closePreLoader();
		});
	}

	//Contract Nomination Date
	function getNominationDate()
	{
		var state = $('#state').val();
        var ga = $('#ga').val();
        var supplier = $('#supplier').val();
        var nomination_date = $('#nomination_date').val();
        //Validating state,ga,supplier, nomination_date
        if(state == ''){
            $('#state_alert').html("<span class='text-danger'>Please Select State.</span>");
            return false;
        }
        else {
            $('#state_alert').html('');
        }
        if(ga == ''){
            $('#ga_alert').html("<span class='text-danger'>Please Select Geo Area.</span>");
            return false;
        }
        else {
            $('#ga_alert').html('');
        }
        if(supplier == ''){
            $('#supplier_alert').html("<span class='text-danger'>Please Select Supplier.</span>");
            return false;
        }
        else {
            $('#supplier_alert').html('');
        }
        if(nomination_date == ''){
            $('#date_alert').html("<span class='text-danger'>Please Select Date.</span>");
            return false;
        }
        else {
            $('#date_alert').html('');
        }
		preLoader();
		var params = {
			'state' : state,
			'ga' : ga,
			'supplier' : supplier,
			'nomination_date' : nomination_date,
		};
		$.post(WEB_ROOT + "GasSource/index_body", params, function(data){
			$('#gas_source_body').html(data);
			closePreLoader();
		});
	}
  	//To Insert and Update the Nomination Quantity
	function nomination_insert(e)
	{
		e.preventDefault(); 
		preLoader();
		$('button[type = "submit"]').prop('disabled', true);
		$('button[type = "submit"]').html('<i class="fa fa-spinner fa-spin"></i>&nbsp;<strong>processing...</strong>');		 
		var params = $("#nomination_add_form").serializeArray();
		$.post(WEB_ROOT + "GasSource/nomination_insert", params, function(data){
			$("#nomination_add_success").html(data);
			$('button[type = "submit"]').prop('disabled',false);
			$('button[type = "submit"]').html('<i class="fa fa-plus">&nbsp;</i>Add');
			closePreLoader();
		});
	}

	function isNumberKey(evt) {
	  	var charCode = (evt.which) ? evt.which : evt.keyCode
	  	if (charCode > 31 && (charCode < 45 || charCode > 57))
	  	return false;
	  	return true;
	}
</script>