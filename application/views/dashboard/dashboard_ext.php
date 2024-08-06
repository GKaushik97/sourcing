<?php
if(isset($nomination_counts) && !empty($nomination_counts)){
    foreach ($nomination_counts as $result) {
        $nominations[$result['ga']] = $result;
    }
}
//
if(isset($dcq_counts) && !empty($dcq_counts)){
    foreach ($dcq_counts as $resultt) {
        $dcqs[$resultt['ga']] = $resultt;
    }
}
$days = $params['days']+1;
?>
<div class="table-responsive sourcing-table pt-3"> 
    <table class="table table-bordered table-condensed mb-0">
        <thead>
            <tr class="sourcing-table-bg">
                <th class="text-center" rowspan="2" width="1%">S.No.</th>
                <!-- <th rowspan="2">State</th> -->
                <th rowspan="2">Geo Area</th>
                <th colspan="2" class="text-center">DCQ</th>
                <th colspan="2" class="text-center">Nomination</th>
                <th colspan="2" class="text-center">Allocation</th>
            </tr>
            <tr class="sourcing-table-bg">
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
            foreach($geo_areas as $key => $value) {
                $dcq_mmbtu = isset($dcqs[$value['id']])? $dcqs[$value['id']]['dcq_mmbtu']:'0';
                $dcq_scm = convertToScm($dcq_mmbtu,0);
                $nomination_mmbtu = isset($nominations[$value['id']])? $nominations[$value['id']]['nomination_mmbtu']:'0';
                $nomination_scm = convertToScm($nomination_mmbtu,0);
                $allocation_mmbtu = isset($nominations[$value['id']])? $nominations[$value['id']]['allocation_mmbtu']:'0';
                $allocation_scm = convertToScm($allocation_mmbtu,0);
                ?>
                <tr>
                    <td class="text-center"><? echo $i++; ?></td>
                    <!-- <td><?php //print $value['state'];?></td> -->
                    <td><?php print $value['name'].' ('.$value['code'].')';?></td>
                    <td class="text-end"><div class="bg-g1"><div class="number"><?php print displayNumber($dcq_scm*$days,2) ?></div></div></td>
                    <td class="text-end"><div class="bg-g1"><div class="number"><?php print displayNumber($dcq_mmbtu*$days,2) ?></div></div></td>
                    <td class="text-end"><div class="bg-g5"><div class="number"><?php print displayNumber($nomination_scm,2) ?></div></div></td>
                    <td class="text-end"><div class="bg-g5"><div class="number"><?php print displayNumber($nomination_mmbtu,2) ?></div></div></td>
                    <td class="text-end"><div class="bg-g3"><div class="number"><?php print displayNumber($allocation_scm,2) ?></div></div></td>
                    <td class="text-end"><div class="bg-g3"><div class="number"><?php print displayNumber($allocation_mmbtu,2) ?></div></div></td>
                </tr>
                <?
            }
            ?>
        </tbody>
    </table>
</div>
<style type="text/css">
    /*...table css...*/
    .sourcing-table-bg, .table-bg {
        background-color: #e7edf4;
    }
    .sourcing-table .table {
        border: 1px solid #cfdce9;
    }
    .sourcing-table .table-bordered td {
      border: 1px solid #cfdce9;
      vertical-align: middle;
    }
    .sourcing-table .table-bordered th, .table-head-bordered .table thead tr th {
        border: 1px solid #cfdce9;
        vertical-align: middle;
    }
    /*.sourcing-table .table thead tr th {
        border-bottom: none;
    }
    .sourcing-table .table-striped tbody tr:nth-of-type(2n+1) {
        --bs-table-accent-bg: none !important;
    }
    .sourcing-table .table-striped tbody tr:nth-of-type(2n+2) {
        background-color: rgba(199, 220, 254,0.35);
    }
    .sourcing-table .table-striped tbody tr:hover {
        --bs-table-accent-bg: none !important;
    }
    .sourcing-table .table-hover tbody tr:hover {
        background-color: rgba(199, 220, 254,0.55);
    }
    .sourcing-table .table thead tr th {
        color: #000000;
        vertical-align: middle;
    }
    .sourcing-table .table thead tr th a {
        text-decoration: none;
        color: #000000;
    }
    .sourcing-table .table-striped > tbody > tr:nth-of-type(2n+1) > *, .sourcing-table .table-hover > tbody > tr:hover > * {
        --bs-table-accent-bg: tranparent;
    }
    .sourcing-table .table > :not(caption) > * > * {
      padding: .75rem .75rem;
    }*/
    /*...table css ending...*/
</style>