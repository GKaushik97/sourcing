<?php
//
$gcv = isset($consumption_details['gcv'])?$consumption_details['gcv']:'';

if(isset($nominated_contracts) && !empty($nominated_contracts)){
    foreach ($nominated_contracts as $result) {
        $nomination_details[$result['id']] = $result;
    }
}
?>
<div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Change Details</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="candidate-details-header">
                <div class="row">
                    <div class="col-md-6 col-md-6-8 col-md-6 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>State</td>
                                        <td width="1%">:</td>
                                        <td><? echo $states[$params['state']]['name'];?></td>
                                    </tr> 
                                    <tr>
                                        <td>Supplier</td>
                                        <td>:</td>
                                        <td><? echo $suppliers[$params['supplier']]['name'];?></td>
                                    </tr> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 col-md-6-8 col-md-6 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Geo Area</td>
                                        <td width="1%">:</td>
                                        <td><? echo $gas[$params['ga']]['name'];?></td>
                                    </tr>                                         
                                    <tr>
                                        <td>Date </td>
                                        <td>:</td>
                                        <td><? echo displayDate($params['selected_date']); ?></td>
                                    </tr>                                        
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <h5>Nomination</h5>
            <form name="change_nomination_form" id="change_nomination_form" method="post">
                <input type="hidden" name="state" id="state" value="<?php print $params['state'];?>">
                <input type="hidden" name="ga" id="ga" value="<?php print $params['ga'];?>">
                <input type="hidden" name="supplier" id="supplier" value="<?php print $params['supplier'];?>">
                <input type="hidden" name="selected_date" id="selected_date" value="<?php print $params['selected_date'];?>">
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
                                    <th rowspan="2">Nomination</th>
                                </tr>
                                <tr class="table-secondary">
                                    <th class="text-end">SCM</th>
                                    <th class="text-end">MMBTU</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                $i = 1;
                                $total_dcq_scm = $total_dcq_mmbtu = $total_scm_nomination_qty = $total_mmbtu_nomination_qty = 0;
                                foreach($contracts as $key => $contract) {
                                    $total_scm_nomination_qty1 = $total_mmbtu_nomination_qty1 = $total_scm_nomination_qty2 = $total_mmbtu_nomination_qty2 = 0;
                                    $dcq_scm = $dcq_mmbtu = '0';
                                    //For DCQ  
                                    if($contract['price_unit'] == 1){
                                        $dcq_scm = $contract['dcq'];
                                        $dcq_mmbtu = round(convertToMmbtu($dcq_scm,$gcv),2);
                                    }
                                    else if($contract['price_unit'] == 2){
                                        $dcq_mmbtu = $contract['dcq'];
                                        $dcq_scm = round(convertToScm($dcq_mmbtu,$gcv),2);
                                    }
                                    $total_dcq_scm += $dcq_scm;
                                    $total_dcq_mmbtu += $dcq_mmbtu;
                                    ?>
                                    <tr>
                                        <td class="text-center"><? echo $i++; ?></td>
                                        <td><? echo $contract['code']; ?></td>
                                        <td><? echo $contract['name']; ?></td>
                                        <td><? echo $contract['type_name']; ?></td>
                                        <td class="text-end"><?php print displayNumber($dcq_scm,2);?></td>
                                        <td class="text-end"><?php print displayNumber($dcq_mmbtu,2);?></td>
                                        <td class="text-end"><? echo displayNumber($contract['mgo'],2); ?></td>
                                        <td class="text-end">
                                            <?
                                            $nomination_qty = isset($nomination_details[$contract['id']]['nomination_qty']) ? $nomination_details[$contract['id']]['nomination_qty'] : "0";
                                            $nomination_unit = isset($nomination_details[$contract['id']]['nomination_unit']) ? $nomination_details[$contract['id']]['nomination_unit'] : set_value('nomination_unit');
                                            $nomination_id = isset($nomination_details[$contract['id']]['nomination_id']) ? $nomination_details[$contract['id']]['nomination_id'] : '';
                                            if($nomination_unit == 1){
                                                $total_scm_nomination_qty1 = $nomination_qty;
                                                $total_mmbtu_nomination_qty1 = round(convertToMmbtu($total_scm_nomination_qty1,''),2);
                                            }
                                            else if($nomination_unit == 2){
                                                $total_mmbtu_nomination_qty2 = $nomination_qty;
                                                $total_scm_nomination_qty2 = round(convertToScm($total_mmbtu_nomination_qty2,''),2);
                                            }
                                            $total_scm_nomination_qty += ($total_scm_nomination_qty1 + $total_scm_nomination_qty2);
                                            $total_mmbtu_nomination_qty += ($total_mmbtu_nomination_qty1 + $total_mmbtu_nomination_qty2);
                                            ?>
                                            <div class="input-group input-group-sm">
                                                <input class="text-end contracts" type="text" id="nv_<?php print $contract['id'];?>" name="nomination[<? echo $contract['id']; ?>][qty]" value="<? echo $nomination_qty; ?>" onchange="caliculateTtlNomination()">
                                                <select class="form-select form-select-sm max-w-105" id="nv_<?php print $contract['id'];?>_u" name="nomination[<? echo $contract['id']; ?>][unit]" onchange="caliculateTtlNomination()">
                                                    <option <?if($nomination_unit == 2) {?> selected="selected"<?}?> value="2">MMBTU</option>
                                                    <option <?if($nomination_unit == 1) {?> selected="selected"<?}?> value="1">SCM</option>
                                                </select>
                                            </div>
                                            <input type="hidden" name="nomination[<? echo $contract['id']; ?>][id]" value="<? echo $nomination_id; ?>">
                                        </td>
                                    </tr>
                                    <?
                                }
                                ?>
                                <tr>
                                    <td colspan="4" class="text-end">Total</td>
                                    <td class="text-end"><?php print displayNumber($total_dcq_scm,2);?></td>
                                    <td class="text-end"><?php print displayNumber($total_dcq_mmbtu,2);?></td>
                                    <td></td>
                                    <td>
                                        <span id="total_mmbtu_nomination_qty"><?php print displayNumber($total_mmbtu_nomination_qty,2);?></span> MMBTU / 
                                        <span id="total_scm_nomination_qty"><?php print displayNumber($total_scm_nomination_qty,2);?></span> SCM
                                        <span> @ 9294.11 GCV</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-success btn-sm" onclick="updateNominationDetails()"><span class="mdi mdi-plus"></span>&nbsp;Update</button>
                    </div>
                </div>
            </form>
            <div id="change_consumption_details">
                <?php $this->load->view('gas_source/change_consumption_details');?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 45 || charCode > 57))
        return false;
        return true;
    }
    function updateNominationDetails(){
        preLoader();
        var params = $("#change_nomination_form").serializeArray();
        $.post(WEB_ROOT + "GasSource/updateNominationDetails", params, function(data){
            $('#change_consumption_details').html(data);
            closePreLoader();
        });
    }
    function caliculateTtlNomination(){
        var mmbtu = caliculated_val = 0;
        $(".contracts").each(function() {
            var uid = this.id;
            var unit = $("#"+uid+"_u").val();
            var nominated_val = $(this).val();
            if(nominated_val > 0) {
                if(unit == 1){
                    caliculated_val = nominated_val * (9294.11 / 252000);
                }
                else {
                    caliculated_val = nominated_val;
                }
                mmbtu = mmbtu + parseFloat(caliculated_val);
            }
        });
        $('#total_mmbtu_nomination_qty').html(mmbtu.toFixed(2));
        var scm = parseFloat(mmbtu * (252000 / 9294.11));
        $('#total_scm_nomination_qty').html(scm.toFixed(2));
    }
</script>










