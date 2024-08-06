<?php
/**
 * SOurcing report
 */
$contract_class = [1 => 'bg6', 2 => 'bg4', 3 => 'bg6', 4 => 'bg4', 5 => 'bg5', 6 => 'bg4'];
if(isset($nominations) && !empty($nominations)){
    foreach ($nominations as $results) {
        $nomination_data[date('d-m-Y',strtotime($results['source_date']))][$results['id']] = $results;
    }
}
//
if(isset($consumptions) && !empty($consumptions)){
    foreach ($consumptions as $resultss) {
        $consumption_data[date('d-m-Y',strtotime($resultss['consumption_date']))] = $resultss;
    }
}
$state = $params['state'];
$ga = $params['ga'];
$supplier = $params['supplier'];
$date1 = date('d-m-Y',strtotime($params['date1']));
$date2 = date('d-m-Y',strtotime($params['date2']));
$begin = new DateTime($date1);
$end = new DateTime($date2);
?>
<?
if(isset($contracts) && !empty($contracts)){ ?>
    <div class="mt-3">
        <div class="table-responsive reports-table"> 
            <table class="table table-bordered table-hover table-striped table-condensed mb-0">
                <thead>
                    <tr class="table-secondary">
                        <th class="text-center" rowspan="2" width="1%">S.No.</th>
                        <th rowspan="2">Date</th>
                        <?
                        if(isset($contracts) and !empty($contracts)){
                            foreach ($contracts as $cid => $value) {
                                ?><th colspan="2" class="text-center"><? print $value['name'];?></th><?
                            }
                        }
                        ?>
                        <th colspan="2" class="text-center reports-bg-success">Total Nomination</th>
                        <th colspan="2" class="text-center reports-bg-warning">Total Offtake</th>
                        <th rowspan="2" class="text-end reports-bg-primary">GCV</th>
                        <?
                        if(isset($contracts) and !empty($contracts)){
                            foreach ($contracts as $cid => $value) {
                                ?><th colspan="2" class="text-center"><? print $value['name'];?></th><?
                            }
                        }
                        ?>
                        <th rowspan="2">Actions</th>
                    </tr>
                    <tr class="table-secondary">
                        <?
                        if(isset($contracts) and !empty($contracts)){
                            foreach ($contracts as $cid => $value) {
                                ?><th class="text-end">SCM</th><?
                                ?><th class="text-end">MMBTU</th><?
                            }
                        }
                        ?>
                        <th class="text-end reports-bg-success">SCM</th>
                        <th class="text-end reports-bg-success">MMBTU</th>
                        <th class="text-end reports-bg-warning">SCM</th>
                        <th class="text-end reports-bg-warning">MMBTU</th>
                        <?
                        if(isset($contracts) and !empty($contracts)){
                            foreach ($contracts as $cid => $value) {
                                ?><th class="text-end">SCM</th><?
                                ?><th class="text-end">MMBTU</th><?
                            }
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $i = 1;
                    for($j = $begin; $j <= $end; $j->modify('+1 day')){ 
                        $date = $j->format("d-m-Y");
                        ?>
                        <tr>
                            <td class="text-center"><? echo $i++;?></td>
                            <td class="text-center"><? echo $date;?></td>
                            <?
                            $cls = 1;
                            $nom_total_scm = $nom_total_mmbtu = 0;
                            foreach ($contracts as $cid => $value) {
                                $gcv = isset($nomination_data[$date][$value['id']]['gcv']) ? $nomination_data[$date][$value['id']]['gcv'] : 0;
                                $nom_scm = $nom_mmbtu = 0;
                                if(isset($nomination_data[$date][$value['id']]['nomination_unit']) && $nomination_data[$date][$value['id']]['nomination_unit']){
                                    if($nomination_data[$date][$value['id']]['nomination_unit'] == 1){
                                        $nom_scm = $nomination_data[$date][$value['id']]['nomination_qty'];
                                        $nom_mmbtu = round(convertToMmbtu($nom_scm, $gcv), 2);
                                    }
                                    else if($nomination_data[$date][$value['id']]['nomination_unit'] == 2){
                                        $nom_mmbtu = $nomination_data[$date][$value['id']]['nomination_qty'];
                                        $nom_scm = round(convertToScm($nom_mmbtu, $gcv), 2);
                                    }
                                }
                                $nom_total_scm += $nom_scm;
                                ?>
                                <td class="text-end text-bg-<? echo $contract_class[$cls];?>"><? echo displayNumber($nom_scm);?></td>
                                <td class="text-end text-bg-<? echo $contract_class[$cls];?>"><? echo displayNumber($nom_mmbtu);?></td>
                                <?
                                $cls++;
                            }
                            ?>
                            <td class="text-end reports-bg-success"><? echo displayNumber($nom_total_scm, 2);?></td>
                            <td class="text-end reports-bg-success"><? echo displayNumber(convertToMmbtu($nom_total_scm, $gcv), 2);?></td>
                            <td class="text-end reports-bg-warning">
                                <? 
                                $offtake_scm = isset($consumption_data[$date]['quantity']) ? $consumption_data[$date]['quantity'] : '0.00'; 
                                echo displayNumber($offtake_scm,2);
                                ?>
                            </td>
                            <td class="text-end reports-bg-warning"><? echo displayNumber(convertToMmbtu($offtake_scm, $gcv), 2)?></td>
                            <td class="text-end reports-bg-primary"><? echo isset($consumption_data[$date]['gcv']) ? displayNumber($consumption_data[$date]['gcv'], 2) : '0.00';?></td>
                            <?
                            $cls = 1;
                            foreach ($contracts as $cid1 => $value1) {
                                $alloc_scm = $alloc_mmbtu = 0;
                                if(isset($nomination_data[$date][$value1['id']]['allocation_unit']) and $nomination_data[$date][$value1['id']]['allocation_unit']){
                                    if($nomination_data[$date][$value1['id']]['allocation_unit'] == 1) {
                                        $alloc_scm = $nomination_data[$date][$value1['id']]['allocation_qty'];
                                        $alloc_mmbtu = round(convertToMmbtu($alloc_scm, $gcv));
                                    }
                                    else if($nomination_data[$date][$value1['id']]['allocation_unit'] == 2) {
                                        $alloc_mmbtu = $nomination_data[$date][$value1['id']]['allocation_qty'];
                                        $alloc_scm = round(convertToScm($alloc_mmbtu, $gcv));
                                    }
                                }
                                ?>
                                <td class="text-end text-bg-<? echo $contract_class[$cls];?>"><? echo displayNumber($alloc_scm, 2);?></td>
                                <td class="text-end text-bg-<? echo $contract_class[$cls];?>"><? echo displayNumber($alloc_mmbtu, 2);?></td>
                                <?
                                $cls++;
                            }
                            ?>
                            <td class="text-center">
                                <?
                                // Check action access
                                if($this->userlibrary->checkAccess('rpch')) { ?>
                                    <button class="btn btn-sm btn-primary" onclick="changeDetails(<? echo $state;?>, <? echo $ga;?>, <? echo $supplier;?>, '<? echo $date;?>')"><span class="mdi mdi-pencil"></span></button>
                                <? } ?>
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<? }
else {
    ?><div class="alert alert-warning">No Contracts Found.</div><?
} 
?>
<script type="text/javascript">
    function changeDetails(state, ga, supplier, date){
        preLoader();
        var params = {
            'state': state,
            'ga':ga,
            'supplier':supplier,
            'selected_date':date,
        };
        $.post(WEB_ROOT + "GasSource/changeDetails", params, function(data){
            loadModal(data);
            closePreLoader();
        });
    }
</script>
<style type="text/css">
    .reports-bg-success {
        background-color: #a9eee6 !important;
    }
    .reports-bg-warning {
        background-color: #f7f09b !important;
    }
    .reports-bg-primary {
        background-color: #8dc6ff !important;
    }
    .text-bg-bg4 {
        background-color: #c7f3ff !important;
    }
    .text-bg-bg6 {
        background-color: #ffdcf5 !important;
    }
    .reports-table .table tbody tr td, .reports-table .table thead tr th {
        vertical-align: middle;
        border-color: rgba(0, 0, 0, 0.1);
    }
    .reports-table .table tbody tr, .reports-table .table thead tr {
        border-color: rgba(0, 0, 0, 0.1);
    }
</style>