<?
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
//
if(isset($nominated_contracts) && !empty($nominated_contracts)){
    foreach ($nominated_contracts as $result) {
        $nomination_details[$result['id']] = $result;
    }
}
?>
<h5>Allocation</h5>
<form name="change_allocation_form" id="change_allocation_form" method="post">
    <input type="hidden" name="state" id="state" value="<?php print $params['state'];?>">
    <input type="hidden" name="ga" id="ga" value="<?php print $params['ga'];?>">
    <input type="hidden" name="supplier" id="supplier" value="<?php print $params['supplier'];?>">
    <input type="hidden" name="selected_date" id="selected_date" value="<?php print $params['selected_date'];?>">
    <input type="hidden" name="consumption" id="consumption" value="<?php print $consumption;?>">
    <input type="hidden" name="gcv" id="gcv" value="<?php print $gcv;?>">
    <div class="mt-2">
        <div class="table-responsive"> 
            <table class="table table-bordered table-hover table-striped table-condensed mb-2">
                <thead>
                    <tr class="table-secondary">
                        <th class="text-center" rowspan="2" width="1%">S.No</th>
                        <th rowspan="2">Code</th>
                        <th rowspan="2">Name</th>
                        <th rowspan="2">Contract Type</th>
                        <th colspan="2" class="text-center">Nomination</th>
                        <th colspan="2">Allocation</th>
                    </tr>
                    <tr class="table-secondary">
                        <th class="text-end">SCM</th>
                        <th class="text-end">MMBTU</th>
                        <th class="text-end">SCM</th>
                        <th class="text-end">MMBTU</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $i = 1;
                    $remaining_scm = $consumption;
                    $total_nomination_scm = $total_nomination_mmbtu = $total_allocation_scm = $total_allocation_mmbtu = 0;
                    foreach($contracts as $key => $contract) {
                        $nomination_scm = $nomination_mmbtu = $allocation_scm = $allocation_mmbtu = '0';
                        //For Nomination
                        if(isset($nomination_details[$contract['id']]['nomination_unit'])){
                            if($nomination_details[$contract['id']]['nomination_unit'] == 1){
                                $nomination_scm = $nomination_details[$contract['id']]['nomination_qty'];
                                $nomination_mmbtu = round(convertToMmbtu($nomination_scm,$gcv),2);
                            }
                            else if($nomination_details[$contract['id']]['nomination_unit'] == 2){
                                $nomination_mmbtu = $nomination_details[$contract['id']]['nomination_qty'];
                                $nomination_scm = round(convertToScm($nomination_mmbtu,$gcv),2);
                            }
                        }
                        $total_nomination_scm += $nomination_scm;
                        $total_nomination_mmbtu += $nomination_mmbtu;
                        //
                        if(isset($params['allocation'][$contract['id']])){
                            $allocation_scm = $params['allocation'][$contract['id']]['qty'];
                        }
                        else if(isset($consumption_details)&& !empty($consumption_details)){
                            $allocation_scm = $nomination_details[$contract['id']]['allocation_qty'];
                        }
                        else {
                            if($remaining_scm >= $nomination_scm){
                                $allocation_scm = $nomination_scm;
                                $remaining_scm = $remaining_scm-$allocation_scm;
                            }
                            else {
                                $allocation_scm = round($remaining_scm,2);
                                $remaining_scm = 0;
                            }
                        }
                        $allocation_mmbtu = round(convertToMmbtu($allocation_scm,$gcv),2);
                        //
                        $total_allocation_scm += $allocation_scm;
                        $total_allocation_mmbtu += $allocation_mmbtu;
                        ?>
                        <tr>
                            <td class="text-center"><? echo $i++; ?></td>
                            <td><? echo $contract['code']; ?></td>
                            <td><? echo $contract['name']; ?></td>
                            <td><? echo $contract['type_name']; ?></td>
                            <td class="text-end"><?php print displayNumber($nomination_scm,2);?></td>
                            <td class="text-end"><?php print displayNumber($nomination_mmbtu,2);?></td>
                            <td class="text-end">
                                <div class="input-group input-group-sm">
                                    <input class="text-end allocationss" type="text" name="allocation[<? echo $contract['id']; ?>][qty]" value="<? echo $allocation_scm; ?>" onkeypress="return isNumberKey(event)" onchange="changeAllocationMmbtu(<?php print $contract['id'];?>, <?php print $gcv;?>, this.value)">
                                </div>
                            </td>
                            <td class="text-end" id="chg_allocation_mmbtu_<?php print $contract['id'];?>"><?php print displayNumber($allocation_mmbtu,2);?></td>
                        </tr>
                        <?
                    }
                    ?>
                    <tr>
                        <td colspan="4" class="text-end">Total</td>
                        <td class="text-end"><?php print displayNumber($total_nomination_scm,2);?></td>
                        <td class="text-end"><?php print displayNumber($total_nomination_mmbtu,2);?></td>
                        <td class="text-end" id="total_allocation_scm"><?php print displayNumber($total_allocation_scm,2);?></td>
                        <td class="text-end" id="total_allocation_mmbtu"><?php print displayNumber($total_allocation_mmbtu,2);?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    if($consumption > 0){
        if($nominated_scm < $consumption){
            $scm = $consumption-$nominated_scm;
            ?><div class="alert alert-danger">Overdraw consumption detected : <?php print displayNumber($scm,2);?> SCM</div><?
        }
        else if($nominated_scm > $consumption){
            $scm = $nominated_scm-$consumption;
            ?><div class="alert alert-success">Underdraw consumption detected : <?php print displayNumber($scm,2);?> SCM</div><?
        }
        else if($nominated_scm = $consumption){
            ?><div class="alert alert-success">No overdraw or underdraw consumption detected</div><?
        }
    }
    ?>
    <?php if(isset($alert)){ 
        ?><span class="<?php print $alert['color'];?>"><?php print $alert['msg'];?></span><?
    } 
    ?>
    <?php if($nominated_scm > 0){?>
        <?php if(($consumption >0) && ($gcv >0)){?>
        <div class="text-end">
            <button type="button" class="btn btn-success btn-sm" onclick="updateAllocationDetails()"><span class="mdi mdi-plus"></span>&nbsp;Submit</button>
        </div>
        <? } ?>
    <? } ?>
</form>

<script type="text/javascript">
    function changeAllocationMmbtu(cid, gcv, value){
        var mmbtu = parseFloat(value*(gcv/252000)).toFixed(2);
        $('#chg_allocation_mmbtu_'+cid).html(mmbtu);
        //
        var scm_val = caliculated_val = 0;
        $(".allocationss").each(function() {
            var uid = this.id;
            var allocated_val = $(this).val();
            if(allocated_val > 0) {
                scm_val = scm_val + parseFloat(allocated_val);
            }
        });
        $('#total_allocation_scm').html(scm_val.toFixed(2));
        var mmbtu_val = parseFloat(scm_val * (9294.11 / 252000));
        $('#total_allocation_mmbtu').html(mmbtu_val.toFixed(2));
    }
    function updateAllocationDetails()
    {  
        preLoader();
        var params = $("#change_allocation_form").serializeArray();
        $.post(WEB_ROOT + "GasSource/updateAllocationDetails", params, function(data){
            $('#change_allocation_details').html(data);
            closePreLoader();
        });
    }
</script>
<style type="text/css">
    .row-span-bg {
        background-color: #e2e3e5;
    }
</style>