<div id="supplier_body">
	<? $this->load->view('supplier/supplier_body'); ?>
</div>
<script type="text/javascript">
	//AddSupplier 
	function addSupplier(event) {
		event.preventDefault();
		preLoader();
		$.post(WEB_ROOT + "suppliers/addSupplier",function(data) {
			loadModal(data);
			closePreLoader();
		});
	}

	//Insert Supplier
	function insertSupplier(event) {
		event.preventDefault();
		preLoader();
		var params = $('#add_supplier').serializeArray();
		$.post(WEB_ROOT + "suppliers/insertSupplier", params, function(data) {
			$('.modal-dialog').parent().html(data);
			closePreLoader();
		});
	}

	//Edit Supplier
	function editSupplier(id) {
		preLoader();
		$.get(WEB_ROOT + "suppliers/editSupplier", {'id' : id}, function(data) {
			loadModal(data);
			closePreLoader();
		});
	}
	//Update Supplier
	function updateSupplier(event) {
		event.preventDefault();
		preLoader();
		var params = $('#update_supplier').serializeArray();
		$.post(WEB_ROOT+"suppliers/updateSupplier", params, function(data) {
			$('.modal-dialog').parent().html(data);
			closePreLoader();
		});
	} 
</script>