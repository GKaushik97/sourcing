<?php
/**
 * Update the Contract
 */
$id_val = (isset($contract['id'])) ? $contract['id'] : (isset($_POST['id']) ? $_POST['id'] : '');
$state_val = isset($contract['state']) ? $contract['state'] : (isset($_POST['state']) ? $_POST['state'] : ''); 
$ga_val = isset($contract['ga']) ? $contract['ga'] : (isset($_POST['ga']) ? $_POST['ga'] : '');
$supplier_val = isset($contract['supplier']) ? $contract['supplier'] : (isset($_POST['supplier']) ? $_POST['supplier'] : '');
$code_val = isset($contract['code']) ? $contract['code'] : set_value('code');
$name_val = isset($contract['name']) ? $contract['name'] : set_value('name');
$contract_type = isset($contract['type']) ? $contract['type'] : set_value('type');
$start_date_val = isset($contract['start_date']) ? $contract['start_date'] : set_value('start_date');
$end_date_val = isset($contract['end_date']) ? $contract['end_date'] : set_value('end_date');
$dcq_val = isset($contract['dcq']) ? $contract['dcq'] : set_value('dcq');
$price_unit_val = isset($contract['price_unit']) ? $contract['price_unit'] : set_value('price_unit');
$mgo_val = isset($contract['mgo']) ? $contract['mgo'] : set_value('mgo');
$ex_lt_val = isset($contract['excess_limit']) ? $contract['excess_limit'] : set_value('excess_limit');
$price_val = isset($contract['price']) ? $contract['price'] : set_value('price');
$ODP = isset($contract['overdraw_price']) ? $contract['overdraw_price'] : set_value('overdraw_price');
$UDP = isset($contract['underdraw_price']) ? $contract['underdraw_price'] : set_value('underdraw_price');
$transport = isset($contract['transport_price']) ? $contract['transport_price'] : set_value('transport_price');
$state_name_val = isset($contract['state_name']) ? $contract['state_name'] : '';
$ga_name_val = isset($contract['geo_area']) ? $contract['geo_area'] : '';
$supplier_name_val = isset($contract['supplier_name']) ? $contract['supplier_name'] : '';
?>
<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Contract&nbsp;-&nbsp;<? echo $code_val; ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="edit_contract" method="post" onsubmit="updateContract(event)">
            <div class="modal-body">
                 <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12 mb-3">
                        <div class="contract-name">State</div>
                        <input type="hidden" name="state" value="<? echo $state_val; ?>">
                        <div class="contract-details"><b><? echo $state_name_val; ?></b></div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="contract-name">State</div>
                        <input type="hidden" name="ga" value="<? echo $ga_val; ?>">
                        <div class="contract-details"><b><? echo $ga_name_val; ?></b></div>                       
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="contract-name">State</div>
                        <input type="hidden" name="supplier" value="<? echo $supplier_val; ?>">
                        <div class="contract-details"><b><? echo $supplier_name_val; ?></b></div>        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">Code&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                            <input type="text" name="code" class="form-control form-control-sm" placeholder="Enter Code" value="<? echo $code_val; ?>" />
                            <small class="text-danger"><? echo form_error('code'); ?></small>
                        </div>                        
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">Name&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="Enter Name" value="<? echo $name_val; ?>" />
                            <small class="text-danger"><? echo form_error('name'); ?></small>
                        </div>                        
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">Contract Type&nbsp;:</label>
                            <select class="form-select form-select-sm" name="type">
                                <option value="">Select</option>
                                <?
                                foreach ($contract_types as $key => $val) {
                                    ?>
                                    <option <?if($contract_type == $val['id']) {?> selected="selected"<?}?> value="<? echo $val['id']; ?>"><? echo $val['name']; ?></option>
                                <?}?>
                            </select>
                            <small class="text-danger"><? echo form_error('type'); ?></small>
                        </div>                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">Start Date&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control form-control-sm" id="start_date" name="start_date" autocomplete="off" placeholder="DD-MM-YYYY" value="<? print date('d-m-Y', strtotime($start_date_val)); ?>" aria-label="start_date" aria-describedby="start_date">
                                <span class="input-group-text"><span class="mdi mdi-calendar-month-outline"></span></span>
                            </div>
                            <small class="text-danger"><? echo form_error('start_date'); ?></small>
                        </div>                        
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">End Date&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control form-control-sm" id="end_date" name="end_date" autocomplete="off" placeholder="DD-MM-YYYY" value="<? print date('d-m-Y', strtotime($end_date_val)); ?>" aria-label="end_date" aria-describedby="end_date">
                                <span class="input-group-text"><span class="mdi mdi-calendar-month-outline"></span></span>
                            </div>
                            <small class="text-danger"><? echo form_error('end_date'); ?></small>
                        </div>                        
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12" id="priorities_list">
                        <? $this->load->view('contract/priorities_list'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">DCQ&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="dcq" class="form-control form-control-sm text-end" placeholder="Enter DCQ in units" value="<? echo $dcq_val; ?>" />
                                <select class="form-select form-select-sm max-w-110" name="price_unit">
                                    <option value="">Units</option>
                                    <?
                                    $price_unit = json_decode(PRICE_UNIT);
                                    foreach($price_unit as $key => $val) {
                                        ?>
                                        <option <? if($price_unit_val == $key) { echo "selected";}?> value="<? echo $key; ?>"><? echo $val; ?></option>
                                    <?}?>
                                </select>
                            </div>
                            <small class="text-danger"><? echo form_error('dcq'); ?></small>
                            <small class="text-danger"><? echo form_error('price_unit'); ?></small>
                        </div>                        
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">MGO&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="mgo" class="form-control form-control-sm text-end" placeholder="Enter MGO in Percentage" value="<? echo $mgo_val; ?>" />              
                                <span class="input-group-text">%</span>              
                            </div>
                            <small class="text-danger"><? echo form_error('mgo'); ?></small>
                        </div>                        
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">Excess Limit&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="excess_limit" class="form-control form-control-sm text-end" placeholder="Enter Excess-Limit in Percentage" value="<? echo $ex_lt_val; ?>" />
                                <span class="input-group-text">%</span>
                            </div>
                            <small class="text-danger"><? echo form_error('excess_limit'); ?></small>
                        </div>                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">Unit Price&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="price" class="form-control form-control-sm text-end" placeholder="Enter Price" value="<? echo $price_val; ?>" />
                                <span class="input-group-text">&#8377;</span>
                            </div>
                            <small class="text-danger"><? echo form_error('price'); ?></small>
                        </div>                        
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">OverDraw Price&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="overdraw_price" class="form-control form-control-sm text-end" placeholder="Enter OverDraw Price" value="<? echo $ODP; ?>" />
                                <span class="input-group-text">&#8377;</span>
                            </div>
                            <small class="text-danger"><? echo form_error('overdraw_price'); ?></small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">UnderDraw Price&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="underdraw_price" class="form-control form-control-sm text-end" placeholder="Enter UnderDraw Price" value="<? echo $UDP; ?>" />
                                <span class="input-group-text">&#8377;</span>
                            </div>
                            <small class="text-danger"><? echo form_error('underdraw_price'); ?></small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">Transport Price&nbsp;<span class="text-danger"></span>&nbsp;:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="transport_price" class="form-control form-control-sm text-end" placeholder="Enter Transport Price" value="<? echo $transport; ?>" />
                                <span class="input-group-text">&#8377;</span>
                            </div>
                        </div>                        
                    </div>
                </div>
                <input type="hidden" name="id" id="id" value="<? echo $id_val; ?>"> 
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-success"><span class="mdi mdi-check"></span>&nbsp;<?php print "Update";?></button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><span class="mdi mdi-close"></span>&nbsp;<?php print "Close";?></button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('#start_date').datepicker({format: 'dd-mm-yyyy',autoHide: true});
    $('#end_date').datepicker({format: 'dd-mm-yyyy',autoHide: true});
</script>