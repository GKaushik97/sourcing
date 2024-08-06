<?
$consumption = isset($consumption_details['quantity'])?$consumption_details['quantity']:'';
$gcv = isset($consumption_details['gcv'])?$consumption_details['gcv']:'';
if(!empty($gcv)){
    $gcvv = $gcv;
}
else {
    $gcvv = '9294.11';
}
//
if(isset($nominated_contracts) && !empty($nominated_contracts)){
    foreach ($nominated_contracts as $result) {
        $nomination_details[$result['id']] = $result;
    }
}
//For Total Nominated SCM and MMBTU values 
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
}
?>
<h5>Consumption</h5>
<div class="consumption-allocation-card">
    <div class="consumption-allocation-details">
        <ul>
            <li class="dot-green"><label>Total Nominated SCM&nbsp;:</label>&nbsp;<strong><?php print displayNumber($nominated_scm,2);?></strong></li>
            <li class="dot-red"><label>Total Nominated MMBTU&nbsp;:</label>&nbsp;<strong><?php print displayNumber($nominated_mmbtu,2);?></strong></li>
            <li class="dot-blue"><label>GCV&nbsp;:</label>&nbsp;<strong><?php print displayNumber($gcvv,2);?></strong></li>
        </ul>
    </div>
    <div class="consumption-allocation-card-body">
        <form name="change_consumption_form" id="change_consumption_form" method="post">
            <input type="hidden" name="state" id="state" value="<?php print $params['state'];?>">
            <input type="hidden" name="ga" id="ga" value="<?php print $params['ga'];?>">
            <input type="hidden" name="supplier" id="supplier" value="<?php print $params['supplier'];?>">
            <input type="hidden" name="selected_date" id="selected_date" value="<?php print $params['selected_date'];?>">
            <div class="d-flex align-items-center">
                <div class="me-1 d-flex align-items-center">
                    <label class="form-label mb-0">Consumption&nbsp;:&nbsp;</label>
                    <input class="form-control form-control-sm text-end" type="text" name="consumption" id="consumption" placeholder="Enter Consumption" value="<?php print $consumption;?>" onkeypress="return isNumberKey(event)">
                    <div id="chg_consumption_alert"></div>
                </div>
                <div class="me-1 d-flex align-items-center">
                    <label class="form-label mb-0">GCV&nbsp;:&nbsp;</label>
                    <input class="form-control form-control-sm text-end" type="text" name="gcv" id="gcv" placeholder="Enter Gcv" value="<?php print $gcv;?>" onkeypress="return isNumberKey(event)">
                    <div id="chg_gcv_alert"></div>
                </div>
                <?php if($nominated_scm > 0){?>
                <div class="me-0 ">
                    <button type="button" class="btn btn-sm btn-primary" onclick="allocateConsumptionDetails()"><?php print "Allocate";?>&nbsp;<span class="mdi mdi-arrow-right"></span></button>
                </div>
            <? } ?>
            </div>
        </form>
    </div> 
</div>
<div id="change_allocation_details">
    <?php $this->load->view('gas_source/change_allocation_details');?>
</div>
<script type="text/javascript">
    function allocateConsumptionDetails()
    {
        var consumption = $('#consumption').val();
        var gcv = $('#gcv').val();
        if(consumption == ''){
            $('#chg_consumption_alert').html("<span class='text-danger'>Please Enter Consumption.</span>");
            return false;
        }
        else {
            $('#chg_consumption_alert').html('');
        }
        if(gcv == '' || gcv == 0){
            $('#chg_gcv_alert').html("<span class='text-danger'>Please Enter Gcv.</span>");
            return false;
        }
        else {
            $('#chg_gcv_alert').html('');
        }
        preLoader();
        var params = $("#change_consumption_form").serializeArray();
        $.post(WEB_ROOT + "GasSource/allocateConsumptionDetails", params, function(data){
            $('#change_allocation_details').html(data);
            closePreLoader();
        });
    }
</script>