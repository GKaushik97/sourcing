<?
$state_val = isset($params['state']) ? $params['state'] : '';
$ga_val = isset($params['ga']) ? $params['ga'] : '';
$supplier_val = isset($params['supplier']) ? $params['supplier'] : '';
$selected_date = isset($params['selected_date'])?$params['selected_date']:'';
//Consumption
if(isset($params['consumption'])){
    $consumption = $params['consumption'];
}
else {
    if(isset($consumption_details) && !empty($consumption_details)){
        $consumption = $consumption_details['quantity'];
    }
    else {
        $consumption = '';
    }
}
//GCV
if(isset($params['gcv'])){
    $gcv = $params['gcv'];
}
else {
    if(isset($consumption_details) && !empty($consumption_details)){
        $gcv = $consumption_details['gcv'];
    }
    else {
        $gcv = '0';
    }
}
//
if(!empty($gcv)){
    $gcvv = $gcv;
}
else {
    $gcvv = '9294.11';
}
if (isset($params['state']) && !empty($params['state']) && isset($params['ga']) && !empty($params['ga']) && isset($params['supplier']) && !empty($params['supplier'])) {
    $nominated_scm = $nominated_mmbtu = $nominated_scm1 = $nominated_mmbtu1 = $nominated_scm2 = $nominated_mmbtu2 = 0;
    if(isset($nominated_data) && !empty($nominated_data)){ 
        foreach ($nominated_data as $result) {
            $results[$result['nomination_unit']] = $result['total'];
        }
        if(isset($results[1]) && !empty($results[1])){
            $nominated_scm1 = $results[1];
            $nominated_mmbtu1 = round(convertToMmbtu($nominated_scm1,$gcv),2);
        }
        if(isset($results[2]) && !empty($results[2])){
            $nominated_mmbtu2 = $results[2];
            $nominated_scm2 = round(convertToScm($nominated_mmbtu2,$gcv),2);
        }
        $nominated_scm = $nominated_scm1 + $nominated_scm2;
        $nominated_mmbtu = $nominated_mmbtu1 + $nominated_mmbtu2;
        ?>
        <div class="consumption-allocation-card">
            <div class="consumption-allocation-details">
                <ul>
                    <li class="dot-green"><label>Total Nominated SCM&nbsp;:</label>&nbsp;<strong><?php print displayNumber($nominated_scm,2);?></strong></li>
                    <li class="dot-red"><label>Total Nominated MMBTU&nbsp;:</label>&nbsp;<strong><?php print displayNumber($nominated_mmbtu,2);?></strong></li>
                    <li class="dot-blue"><label>GCV&nbsp;:</label>&nbsp;<strong><?php print displayNumber($gcvv,2);?></strong></li>
                </ul>
            </div> 
            <div class="consumption-allocation-card-body">
                <form name="allocation_details_form" id="allocation_details_form" method="post">
                    <input type="hidden" name="state" id="state" value="<? echo $state_val; ?>">
                    <input type="hidden" name="ga" id="ga" value="<? echo $ga_val; ?>">
                    <input type="hidden" name="supplier" id="supplier" value="<? echo $supplier_val; ?>">
                    <input type="hidden" name="selected_date" id="selected_date" value="<? echo $selected_date; ?>">
                    <div class="d-flex align-items-center">
                        <div class="me-1 d-flex align-items-center">
                            <label class="form-label mb-0">Consumption&nbsp;:&nbsp;</label>
                            <input class="form-control form-control-sm text-end" type="text" name="consumption" id="consumption" placeholder="Enter Consumption" value="<?php print $consumption;?>" onkeypress="return isNumberKey(event)">
                            <div id="consumption_alert"></div>
                        </div>
                        <div class="me-1 d-flex align-items-center">
                            <label class="form-label mb-0">GCV&nbsp;:&nbsp;</label>
                            <input class="form-control form-control-sm text-end" type="text" name="gcv" id="gcv" placeholder="Enter Gcv" value="<?php print $gcv;?>" onkeypress="return isNumberKey(event)">
                            <div id="gcv_alert"></div>
                        </div>
                        <div class="me-0 ">
                            <button type="button" class="btn btn-sm btn-primary" onclick="consumptionBodyExt()"><?php print "Allocate";?>&nbsp;<span class="mdi mdi-arrow-right"></span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <? if(isset($consumption_details) && !empty($consumption_details)){
            $allocation_form_class = 'show';
        }
        else {
            $allocation_form_class = 'd-none';
        }
        ?>
        <div id="consumption_allocation_form" class="<?php print $allocation_form_class;?>">
            <?php 
                $this->load->view('gas_source/consumption_allocation_form');
            ?>
        </div>
    <?
    }
    else {
        ?><div class="alert alert-warning">There is no nominated contracts for this Date(<?php print $selected_date;?>)</div><? 
    }
    ?>
    <? $this->load->view('gas_source/allocation_history'); ?>
<? } ?>