<?
$state_val = isset($params['state']) ? $params['state'] : '';
$ga_val = isset($params['ga']) ? $params['ga'] : '';
$supplier_val = isset($params['supplier']) ? $params['supplier'] : '';
$selected_date = isset($params['selected_date'])?$params['selected_date']: '';
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
<?
if (isset($nominated_contracts) && !empty($nominated_contracts)) { ?>
    <form name="allocation_form" id="allocation_form" method="post">
        <input type="hidden" name="state" value="<? echo $state_val; ?>">
        <input type="hidden" name="ga" value="<? echo $ga_val; ?>">
        <input type="hidden" name="supplier" value="<? echo $supplier_val; ?>">
        <input type="hidden" name="selected_date" value="<? echo $selected_date; ?>">
        <input type="hidden" name="consumption" value="<? echo $consumption; ?>">
        <input type="hidden" name="gcv" value="<? echo $gcv; ?>">
        <div class="mt-2">
            <div class="table-responsive"> 
                <table class="table table-bordered table-hover table-striped table-condensed mb-2">
                    <thead>
                        <tr class="table-secondary">
                            <th class="text-center" rowspan="2" width="1%">S.No</th>
                            <th rowspan="2">Code</th>
                            <th rowspan="2">Name</th>
                            <th rowspan="2">Contract Type</th>
                            <th colspan="2" class="text-center">DCQ</th>
                            <th class="text-end" rowspan="2">MGO<small>(%)</small></th>
                            <th colspan="2" class="text-center">Nomination</th>
                            <th colspan="2" class="text-center">Allocation</th>
                        </tr>
                        <tr class="table-secondary">
                            <th class="text-end">SCM</th>
                            <th class="text-end">MMBTU</th>
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
                        foreach($nominated_contracts as $key => $contract) {
                            $dcq_scm = $dcq_mmbtu = $nomination_scm = $nomination_mmbtu = $allocation_scm = $allocation_mmbtu = '0';
                            //For DCQ  
                            if($contract['price_unit'] == 1){
                                $dcq_scm = $contract['dcq'];
                                $dcq_mmbtu = round(convertToMmbtu($dcq_scm,$gcv),2);
                            }
                            else if($contract['price_unit'] == 2){
                                $dcq_mmbtu = $contract['dcq'];
                                $dcq_scm = round(convertToScm($dcq_mmbtu,$gcv),2);
                            }
                            //For Nomination
                            if($contract['nomination_unit'] == 1){
                                $nomination_scm = $contract['nomination_qty'];
                                $nomination_mmbtu = round(convertToMmbtu($nomination_scm,$gcv),2);
                            }
                            else if($contract['nomination_unit'] == 2){
                                $nomination_mmbtu = $contract['nomination_qty'];
                                $nomination_scm = round(convertToScm($nomination_mmbtu,$gcv),2);
                            }
                            $total_nomination_scm += $nomination_scm;
                            $total_nomination_mmbtu += $nomination_mmbtu;
                            //
                            if(isset($params['allocation'][$contract['id']])){
                                $allocation_scm = $params['allocation'][$contract['id']]['qty'];
                            }
                            else if(isset($consumption_details)&& !empty($consumption_details)){
                                $allocation_scm = $contract['allocation_qty'];
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
                                <td class="text-end"><?php print displayNumber($dcq_scm,2);?></td>
                                <td class="text-end"><?php print displayNumber($dcq_mmbtu,2);?></td>
                                <td class="text-end"><? echo displayNumber($contract['mgo'],2); ?></td>
                                <td class="text-end"><?php print displayNumber($nomination_scm,2);?></td>
                                <td class="text-end"><?php print displayNumber($nomination_mmbtu,2);?></td>
                                <td class="text-end">
                                    <div class="input-group input-group-sm">
                                        <input class="form-control form-control-sm text-end allocations" type="text" name="allocation[<? echo $contract['id']; ?>][qty]"  value="<? echo $allocation_scm; ?>" onkeypress="return isNumberKey(event)" onchange="caliculateAllocationMmbtu(<?php print $contract['id'];?>, <?php print $gcv;?>, this.value)">
                                    </div>
                                </td>
                                <td class="text-end" id="allocation_mmbtu_<?php print $contract['id'];?>"><?php print displayNumber($allocation_mmbtu,2);?></td>
                            </tr>
                            <?
                        }
                        ?>
                        <tr>
                            <td colspan="7" class="text-end">Total</td>
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
        ?>
        <?php if(isset($alert)){ 
            ?><span class="<?php print $alert['color'];?>"><?php print $alert['msg'];?></span><?
        } 
        ?>
        <div class="text-end">
            <button type="button" class="btn btn-success btn-sm" onclick="allocateConsumptionExt()"><span class="mdi mdi-plus"></span>&nbsp;Submit</button>
        </div>
    </form>
    <?php
}
?>
<hr/>
<script type="text/javascript">
    function caliculateAllocationMmbtu(cid, gcv, value){
        var mmbtu = Math.round(value*(gcv/252000),2);
        $('#allocation_mmbtu_'+cid).html(mmbtu);
        //
        var scm_val = caliculated_val = 0;
        $(".allocations").each(function() {
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
</script>
<style type="text/css">
    .row-span-bg {
        background-color: #e2e3e5;
    }
</style>