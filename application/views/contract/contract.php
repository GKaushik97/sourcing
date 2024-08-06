<?php
/**
 * To get the Total Contracts
 */ 
?>
<div id="contract_body">
	<? $this->load->view('contract/contract_body'); ?>
</div>
<script>
	//To add the Contract
	function addContract(event) {
		event.preventDefault();
		$.post(WEB_ROOT + "Contract/addContract", function(data){
			loadModal(data);
		});
	}
	//Insert-Contract
	function insertContract(event) {
		event.preventDefault();
		preLoader();
		var data = new FormData();
        //Form data
		var form_data = $('#add_contract').serializeArray();
		$.each(form_data, function (key, input) {
		    data.append(input.name, input.value);
		});		
		//File data
		var file_data = $('input[name="document"]')[0].files;
		for (var i = 0; i < file_data.length; i++) {
		    data.append("document", file_data[i]);
		}
		//Custom data
		data.append('key', 'value');
		$.ajax({
            url: WEB_ROOT + "Contract/insertContract",
            type: 'post',
            data: data,
            processData: false,
            contentType: false,
            success: function (data) {
				$(".modal-dialog").parent().html(data);
				resetContractBody();
            	closePreLoader();
            }
        });
	}
	//Edit Contract
	function editContract(id) {
		event.preventDefault();
		preLoader();
		$.get(WEB_ROOT + "Contract/editContract", {'id' : id}, function(data){
			loadModal(data);
			closePreLoader();
		});
	}

	//TO Update Contract
	function updateContract(event) {
		event.preventDefault();
		preLoader();
		var params = $('#edit_contract').serializeArray();
		$.post(WEB_ROOT + "Contract/updateContract", params, function(data){
			$('.modal-dialog').parent().html(data);
			resetContractBody();
			closePreLoader();
		});
	}

	//To change the Contract Status
	function changeContractStatus(id,status) {
		event.preventDefault();
		preLoader();
		$.post(WEB_ROOT + "Contract/changeContractStatus", {'id': id,'status' : status}, function(data){
			resetContractBody();
			closePreLoader();
		});
	}

	//To get the Details of Contract
	function viewContract(id) {
		preLoader();
		$.get(WEB_ROOT + "Contract/getContractById", {'id' : id}, function(data){
			loadModal(data);
			closePreLoader();
		});
	}

	//State Change Filter
	function geoAreaFilter(id) {
		$.post(WEB_ROOT + "Contract/getGeoAreas", {'id' : id}, function(data){
			$('#geo_area').html(data);
		});
	}

	//To Filter the BodyPage
	function geoAreaFilterBody(id) {
		$.post(WEB_ROOT + "Contract/geoAreaFilter", {'id' : id}, function(data){
			$('#geo_areas_filter').html(data);
		});
	}

	//To search the Data
	function searchContractBody(rows,sort_by,sort_order,pgNo)
	{
		event.preventDefault();
    	preLoader();
		var params = {
			'rows' :rows,
			'sort_by' : sort_by,
			'sort_order' : sort_order,
			'pageno' : pgNo,
			'keywords': $('#keywords').val(),
			'state' : $('#state').val(),
			'geo_area' : $('#ga').val(),
			'name' : $('#name').val(),
			'code' : $('#code').val(),
			'supplier' : $('#supplier').val(),
			'priority' : $('#priority').val(),
			'status' : $('#status1').val(),
		};
		$.post(WEB_ROOT+"Contract/index_body", params, function(data){
			$('#contract_body').html(data);
			closePreLoader();
		});
	}

	//To refresh the Page
	function resetContractBody()
	{
		$('#keywords').val('');
		$('#name').val('');
		$('#code').val('');
		$('#state').val('');
		$('#ga').val('');
		$('#supplier').val('');
		$('#priority').val('');
		$('#status1').val('');
		var pgNo = $('#pageno').val();
		searchContractBody(10,'added_at','DESC', pgNo);
	}

	//To Export the Contract Data
	function contractExport(sort_by, sort_order)
	{
		window.location = WEB_ROOT + "Contract/getContractExport?sort_by="+sort_by+"&sort_order="+sort_order+"&keywords="+$('#keywords').val()+"&state="+$('#state').val()+"&geo_area="+$('#ga').val()+"&name="+$('#name').val()+"&code="+$('#code').val()+"&supplier="+$('#supplier').val()+"&priority="+$('#priority').val()+"&status="+$('#status1').val()+"";
	}
	//To get the Priorities
	function getContractPriority(supplier) {
		var state = $('#state_ext').val();
		var ga = $('#ga_ext').val();
		var supplier = $('#supplier_ext').val();
		$.post(WEB_ROOT + "Contract/getContractPriorityNum", {'state': state,'ga': ga,'supplier': supplier}, function(data){
			$('#priorities_list').html(data);
		});
	}
	
	// Update File
	function updateDocument(fid) {
		preLoader();
		event.preventDefault();
		var form = $('#' + fid)[0];
		var formdata = new FormData(form);
		$.ajax({
            url: WEB_ROOT + "Contract/updateDocument",
            type: 'post',
            data: formdata,
            processData: false,
            contentType: false,
            success: function (data) {
            	$('#contract_file_upload').html(data);
            	closePreLoader();
            }
        });
	}

</script>