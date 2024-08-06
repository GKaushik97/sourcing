<?php
/**
 * Insert the Contract
 */ 
$price_per_unit = json_decode(PRICE_UNIT);
?>
<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add New Contract</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form name="add_contract" id="add_contract" method="post" onsubmit="insertContract(event)" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">State&nbsp;:</label>
                            <select class="form-select form-select-sm" name="state" id="state_ext" onchange="geoAreaFilter(this.value)">
                                <option value="">Select</option>
                                <?
                                foreach ($states as $key => $value1) {
                                    ?>
                                    <option <?if(set_value('state') == $value1['id']) {?> selected="selected"<?}?> value="<? echo $value1['id']; ?>"><? echo $value1['name']; ?></option>
                                <?}?>
                            </select>
                            <small class="text-danger"><? echo form_error('state'); ?></small>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div id="geo_area">
                            <? $this->load->view('contract/geo_areas'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">Supplier&nbsp;:</label>
                            <select class="form-select form-select-sm" name="supplier" id="supplier_ext" onchange="getContractPriority(this.value)">
                                <option value="">Select</option>
                                <?
                                foreach ($suppliers as $key => $val) {
                                    ?>
                                    <option <?if(set_value('supplier') == $val['id']) {?> selected="selected"<?}?> value="<? echo $val['id']; ?>"><? echo $val['name']; ?></option>
                                <?}?>
                            </select>
                            <small class="text-danger"><? echo form_error('supplier'); ?></small>
                        </div>                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">Contract Type&nbsp;:</label>
                            <select class="form-select form-select-sm" name="type">
                                <option value="">Select</option>
                                <?
                                foreach ($contract_types as $key => $val) {
                                    ?>
                                    <option <?if(set_value('type') == $val['id']) {?> selected="selected"<?}?> value="<? echo $val['id']; ?>"><? echo $val['name']; ?></option>
                                <?}?>
                            </select>
                            <small class="text-danger"><? echo form_error('type'); ?></small>
                        </div>                        
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">Contract Code&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                            <input type="text" name="code" class="form-control form-control-sm" placeholder="Enter Code" value="<? echo set_value('code'); ?>" />
                            <small class="text-danger"><? echo form_error('code'); ?></small>
                        </div>                        
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">Contract Name&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="Enter Name" value="<? echo set_value('name'); ?>" />
                            <small class="text-danger"><? echo form_error('name'); ?></small>
                        </div>                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">Start Date&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="start_date" name="start_date" autocomplete="off" placeholder="DD-MM-YYYY" value="<? print set_value('start_date') ?>" aria-label="start_date" aria-describedby="start_date">
                                <span class="input-group-text"><span class="mdi mdi-calendar-month-outline"></span></span>
                            </div>
                            <small class="text-danger"><? echo form_error('start_date'); ?></small>
                        </div>                        
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">End Date&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="end_date" name="end_date" autocomplete="off" placeholder="DD-MM-YYYY" value="<? print set_value('end_date') ?>" aria-label="end_date" aria-describedby="end_date">
                                <span class="input-group-text"><span class="mdi mdi-calendar-month-outline"></span></span>
                            </div>
                            <small class="text-danger"><? echo form_error('end_date'); ?></small>
                        </div>                        
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div id="priorities_list">
                            <? $this->load->view('contract/priorities_list'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">DCQ&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="dcq" class="form-control form-control-sm text-end" placeholder="Enter DCQ in units" value="<? echo set_value('dcq'); ?>" />
                                <select class="form-select form-select-sm max-w-110" name="price_unit">
                                    <option value="">Units</option>
                                    <?
                                    foreach($price_per_unit as $key => $value) {
                                        ?>
                                        <option <?if(set_value('price_unit') == $key) {?> selected="selected"<?}?> value="<? echo $key; ?>"><? echo $value; ?></option>
                                    <?}
                                    ?>
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
                                <input type="text" name="mgo" class="form-control form-control-sm text-end" placeholder="Enter MGO in percentage" value="<? echo set_value('mgo'); ?>" />
                                <span class="input-group-text">%</span>
                            </div>
                            <small class="text-danger"><? echo form_error('mgo'); ?></small>
                        </div>                        
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">Excess Limit&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="excess_limit" class="form-control form-control-sm text-end" placeholder="Enter Excess-Limit in percentage" value="<? echo set_value('excess_limit'); ?>" />
                                <span class="input-group-text">%</span>
                            </div>
                            <small class="form-text">Example&nbsp;:&nbsp;6% excess limit.</small>
                            <small class="text-danger"><? echo form_error('excess_limit'); ?></small>
                        </div>                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">Unit Price&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="price" class="form-control form-control-sm text-end" placeholder="Enter Price" value="<? echo set_value('price'); ?>" />
                                <span class="input-group-text">&#8377;</span>
                            </div>
                            <small class="text-danger"><? echo form_error('price'); ?></small>
                        </div>                        
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">OverDraw Price&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" name="overdraw_price" class="form-control form-control-sm text-end" placeholder="Enter OverDraw Price" value="<? echo set_value('overdraw_price'); ?>" />
                                <span class="input-group-text">&#8377;</span>
                            </div>
                            <small class="text-danger"><? echo form_error('overdraw_price'); ?></small>
                        </div>                        
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">UnderDraw Price&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" name="underdraw_price" class="form-control form-control-sm text-end" placeholder="Enter UnderDraw Price" value="<? echo set_value('underdraw_price'); ?>" />
                                <span class="input-group-text">&#8377;</span>
                            </div>
                            <small class="text-danger"><? echo form_error('underdraw_price'); ?></small>
                        </div>                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">Transport Price&nbsp;:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="transport_price" class="form-control form-control-sm text-end" placeholder="Enter Transport Price" value="<? echo set_value('transport_price'); ?>" />
                                <span class="input-group-text">&#8377;</span>
                            </div>
                        </div>                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="mb-3">
                            <label class="form-label mb-0">Document&nbsp;<span class="text-danger"></span>&nbsp;:</label>
                            <input type="file" name="document" id="document" class="form-control form-control-sm" value="<? echo set_value('document'); ?>" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-success"><span class="mdi mdi-plus"></span><?php print "Add";?></button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><span class="mdi mdi-close"></span><?php print "Close";?></button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('#start_date').datepicker({format: 'dd-mm-yyyy',autoHide: true});
    $('#end_date').datepicker({format: 'dd-mm-yyyy',autoHide: true});
</script>