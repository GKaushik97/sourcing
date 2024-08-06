<?php
/**
 * Geo Areas
 */
?>
<div id="contract_types_body">
    <?php $this->load->view('contract_types/contract_types_body'); ?>
</div>
<script>
	//AddContractType method
	function addContractType(event) {
		event.preventDefault();
		preLoader();
		$.post(WEB_ROOT + "ContractTypes/addContractType", function(data){
			loadModal(data);
			closePreLoader();
		});
	}

	//Insert ContractType
	function insertContractType(event) {
		event.preventDefault();
		preLoader();
		var params = $('#add_contract_type').serializeArray();
		$.post(WEB_ROOT +"ContractTypes/insertContractType", params ,function(data){
			$(".modal-dialog").parent().html(data);
			closePreLoader();
		});
	}

	//Edit ContractType
	function editContractType(id) {
		event.preventDefault();
		preLoader();
		$.get(WEB_ROOT +"ContractTypes/editContractType" , {'id' : id}, function(data){
			loadModal(data);
			closePreLoader();
		});
	}

	//Update Contract_type
	function updateContractType(event)
	{
		event.preventDefault();
		preLoader();
		var params = $('#update_contract_type').serializeArray();
		$.post(WEB_ROOT +"ContractTypes/updateContractType", params, function(data){
			$(".modal-dialog").parent().html(data);
			closePreLoader();
		});
	}

	//To Delete the ContractType
	function deleteContractType(id) {
  		if(confirm("Are you sure you want to delete the Record?")){
  			preLoader();
      		$.get(WEB_ROOT +"ContractTypes/deleteContractType", {'id':id}, function(data){
				$(".modal-dialog").parent().html(data);
				closePreLoader();
      		});
  		}
	}
</script>