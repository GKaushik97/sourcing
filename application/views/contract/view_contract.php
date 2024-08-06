<?php
/**
 * Contract Details 
 */ 
?>
<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Contract Details - <? echo $contract_details['code']; ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12 mb-3">
                    <div class="contract-name">State</div>
                    <div class="contract-details"><? echo $contract_details['state_name']; ?></div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 mb-3">
                    <div class="contract-name">Geo Area</div>
                    <div class="contract-details"><? echo $contract_details['geo_area']; ?></div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 mb-3">
                    <div class="contract-name">Suppliers</div>
                    <div class="contract-details"><? echo $contract_details['supplier_name']; ?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="contract-name">Contract Name</div>
                    <div class="contract-details"><? echo $contract_details['name']; ?></div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="contract-name">Contract Type</div>
                    <div class="contract-details"><? echo $contract_details['contract_type']; ?></div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="contract-name">Status</div>
                    <div class="contract-details"><? if($contract_details['status'] == 1){ echo "<span class='status status-success status-icon-check'>Active</span>"; } else { echo "<span class='status status-danger status-icon-close'>InActive</span>"; }?></div>
                </div>
            </div>
            <div class="hr1"></div>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="contract-name">Start Date</div>
                    <div class="contract-details"><? echo displayDate($contract_details['start_date']); ?></div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="contract-name">End Date</div>
                    <div class="contract-details"><? echo displayDate($contract_details['end_date']); ?></div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="contract-name">Priority</div>
                    <div class="contract-details">

                        <? if(isset($contract_details['priority'])) { echo "Priority"." ".$contract_details['priority']; }else { echo "No Priority Found"; } ?></div>
                </div>
            </div>
            <div class="hr1"></div>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="contract-name">DCQ</div>
                    <div class="contract-details"><? echo displayNumber($contract_details['dcq'],2); ?>&nbsp;<? if($contract_details['price_unit'] == "1"){ echo "SCM"; }else {echo "MMBTU";} ?></div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="contract-name">MGO</div>
                    <div class="contract-details"><? echo $contract_details['mgo']."%"; ?></div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="contract-name">Excess Limit</div>
                    <div class="contract-details"><? echo $contract_details['excess_limit']."%"; ?></div>
                </div>
            </div>
            <div class="hr1"></div>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="contract-name">Unit Price</div>
                    <div class="contract-details"><? echo displayNumber($contract_details['price'],2); ?></div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="contract-name">OverDraw Price</div>
                    <div class="contract-details"><? echo displayNumber($contract_details['overdraw_price'],2); ?></div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="contract-name">Transport Price</div>
                    <div class="contract-details"><? echo isset($contract_details['transport_price']) ? displayNumber($contract_details['transport_price'],2) : ''; ?></div>
                </div>
            </div>
            <div class="hr1"></div>
            <div id="contract_file_upload">
                <? $this->load->view('contract/contract_file'); ?>
            </div>
            <div class="hr1"></div>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="contract-name">Added By</div>
                    <div class="contract-details"><? echo $contract_details['added_name']; ?></div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="contract-name">Added Date</div>
                    <div class="contract-details"><? print displayDate($contract_details['added_at']); ?></div>
                </div>
            </div>
            <div class="hr1"></div>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="contract-name">Updated By</div>
                    <div class="contract-details"><? echo $contract_details['updated_name']; ?></div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="contract-name">Updated Date</div>
                    <div class="contract-details"><? print displayDate($contract_details['updated_at']); ?></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><span class="mdi mdi-close"></span>&nbsp;<?php print "Close";?></button>
        </div>
    </div>
</div> 
<style type="text/css">
    .contract-name {
        color: #666666;
        font-size: 0.8rem;
    }
    .contract-details {
        font-weight: 600;
        font-size: 0.85rem;
    }
    .hr1 {
        margin: 1rem 0;
        color: inherit;
        border: 0;
        border-top-color: currentcolor;
        border-top-style: none;
        border-top-width: 0px;
        border-top-color: currentcolor;
        border-top-style: none;
        border-top-width: 0px;
        border-top: 1px solid #cecece;
        opacity: .25;
    }
</style>