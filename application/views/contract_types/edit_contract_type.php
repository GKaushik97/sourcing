<?php
/**
 * Update the ContractType
 */
$contract_name = isset($contract_type['name']) ? $contract_type['name'] : set_value('name'); 
$id_val = (isset($contract_type['id'])) ? $contract_type['id'] : (isset($_POST['id']) ? $_POST['id'] : '');
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Contract Type</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="update_contract_type" method="post" onsubmit="updateContractType(event)">
            <div class="modal-body">
                <div class="row mb-2">
                    <label class="col-form-label col-sm-4 text-end">Contract Type&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-7">
                        <input type="text" id="name" name="name" class="form-control form-control-sm" placeholder="Enter Name" value="<? echo $contract_name; ?>" />
						<small class="text-danger"><? echo form_error('name'); ?></small>
                    </div>
                </div>
                <input type="hidden" name="id" value="<? echo $id_val; ?>">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-success"><span class="mdi mdi-plus"></span><?php print "Update";?></button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><span class="mdi mdi-close"></span><?php print "Close";?></button>
            </div>
        </form>
    </div>
</div>