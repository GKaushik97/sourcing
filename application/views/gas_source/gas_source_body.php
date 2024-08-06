<?php
/**
 * Gas Source Nomination Details
 */

$state_val = isset($params['state']) ? $params['state'] : '';
$ga_val = isset($params['ga']) ? $params['ga'] : '';
$nomination_date = isset($params['nomination_date']) ? $params['nomination_date'] : date('Y-m-d');
$supplier_val = isset($params['supplier']) ? $params['supplier'] : '';
$price_per_unit = json_decode(PRICE_UNIT);
?>
<div class="consumption-allocation-card mb-2">
	<div class="clearfix p-3"> 
		<div class="float-start">
			<div class="d-flex align-items-top">
				<div class="me-1">
	                <label class="form-label mb-0">State&nbsp;<span class="text-danger">*</span>:</label>
					<select name="state" id="state" class="form-select form-select-sm w-150 me-1" aria-label="All States" data-live-search="true" onchange="gasSourceFilter(this.value)">
						<option value="">All States</option>
						<?php
						foreach($states as $key => $value) {
							?>
							<option <? if($state_val == $value['id']) { echo "selected"; }?> value="<? echo $value['id']; ?>"><? echo $value['name']; ?></option>
							<?
						}
						?>
					</select>
					<div id="state_alert"></div>
				</div>
				<div id="gas_area_filter" class="me-1">
					<? $this->load->view('gas_source/geo_area_filter'); ?>
				</div>
				<div class="me-1">
					<label class="form-label mb-0">Supplier&nbsp;<span class="text-danger">*</span>:</label>
					<select name="supplier" id="supplier" class="form-select form-select-sm w-150 me-1" aria-label="All Suppliers" data-live-search="true">
						<option value="">Suppliers</option>
						<?php
						foreach($suppliers as $key => $supplier) {
							?>
							<option <? if($supplier_val == $supplier['id']) { echo "selected"; }?> value="<? echo $supplier['id']; ?>"><? echo $supplier['name']; ?></option>
							<?
						}
						?>
					</select>
					<div id="supplier_alert"></div>
				</div> 
				<div class="me-1">
	            	<label class="form-label mb-0">Date&nbsp;<span class="text-danger">*</span>:</label>
	            	<div class="input-group input-group-sm w-150">
		                <input type="text" class="form-control form-control-sm" id="nomination_date" name="nomination_date" autocomplete="off" placeholder="DD-MM-YYYY" aria-label="nomination_date" aria-describedby="nomination_date" value="<? echo $nomination_date; ?>">
		                <span class="input-group-text"><span class="mdi mdi-calendar-month-outline"></span></span>
	            	</div>
					<div id="date_alert"></div>
				</div>
				<div class="me-1">
					<label class="form-label mb-0">&nbsp;</label>
					<div>
						<button type="button" class="btn btn-sm btn-success" onclick="getNominationDate()"><span class="mdi mdi-magnify"></span></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
if (isset($params['state']) && !empty($params['state']) && isset($params['ga']) && !empty($params['ga'])) {
	if (isset($contracts) and !empty($contracts)) {
		?>
		<form name="nomination_add_form" id="nomination_add_form" method="post" onsubmit="nomination_insert(event)">
			<input type="hidden" name="state_ext" value="<? echo $state_val; ?>">
			<input type="hidden" name="ga_ext" value="<? echo $ga_val; ?>">
			<input type="hidden" name="nomination_date" value="<? echo $nomination_date; ?>">
			<div class="table-responsive th-virticle-middle"> 
				<table class="table table-bordered table-hover table-striped table-condensed mb-2">
					<thead>
						<tr class="table-secondary">
							<th class="text-center" rowspan="2" width="1%">S.No.</th>
							<th rowspan="2">Code</th>
							<th rowspan="2">Name</th>
							<th rowspan="2">Contract Type</th>
							<th colspan="2" style="text-align: center;">DCQ</th>
							<th rowspan="2" class="text-end">MGO<small>(%)</small></th>
							<th rowspan="2" class="text-end">Excess Limit<small>(%)</small></th>
							<th rowspan="2">Nomination</th>
							<th rowspan="2">Current Day(%)</th>
							<th colspan="2">15 Days Average(%)</th>
						</tr>
						<tr class="table-secondary">
							<th class="text-end">SCM</th>
							<th class="text-end">MMBTU</th>
							<th class="text-center">(<? echo date('d-m-Y',strtotime($params['from_date']))." - ". date('d-m-Y',strtotime($params['to_date'])); ?>)</th>
						</tr>
					</thead>
					<tbody>
						<?
						$i = 1;
						$total_dcq_scm = $total_dcq_mmbtu = $total_scm_nomination_qty = $total_mmbtu_nomination_qty = $diff_qty = 0;
						foreach($contracts as $key => $nomination) {
							$nom_qty = (isset($tot_nomination[$nomination['id']])) ? $tot_nomination[$nomination['id']] : "0";
							$total_scm_nomination_qty1 = $total_mmbtu_nomination_qty1 = $total_scm_nomination_qty2 = $total_mmbtu_nomination_qty2 = 0;
							$gcv = $dcq_scm = $dcq_mmbtu = 0;
							if($nomination['price_unit'] == 1) {
								$dcq_scm = $nomination['dcq'];
								$dcq_mmbtu = convertToMmbtu($dcq_scm,$gcv);
							}
							else if($nomination['price_unit'] == 2){
                                $dcq_mmbtu = $nomination['dcq'];
                                $dcq_scm = convertToScm($dcq_mmbtu,$gcv);
                            }
                            //
                            $total_dcq_scm += $dcq_scm;
                            $total_dcq_mmbtu += $dcq_mmbtu;
							?>
							<tr>
								<td class="text-center"><? echo $i++; ?></td>
								<td><? echo $nomination['code']; ?></td>
								<td><? echo $nomination['name']; ?></td>
								<td><? echo $nomination['type_name']; ?></td>
								<td class="text-end"><? echo displayNumber($dcq_scm,2); ?></td>
								<input type="hidden" name="scm" id="scm_nvv_<?php print $nomination['id'];?>" value="<? echo $dcq_scm; ?>">
								<td class="text-end"><? echo displayNumber($dcq_mmbtu,2); ?></td>
								<td class="text-end"><? echo displayNumber($nomination['mgo'],2); ?></td>
								<td class="text-end"><? echo displayNumber($nomination['excess_limit'],2); ?></td>
								<td>
									<?
									$nomination_qty = isset($ga_nomination[$nomination['id']]['nomination_qty']) ? $ga_nomination[$nomination['id']]['nomination_qty'] : "0";
									$unit_price = isset($ga_nomination[$nomination['id']]['nomination_unit']) ? $ga_nomination[$nomination['id']]['nomination_unit'] : '';
									$nomination_id = isset($ga_nomination[$nomination['id']]['id']) ? $ga_nomination[$nomination['id']]['id'] : '';
									if($unit_price == 1){
                                        $total_scm_nomination_qty1 = $nomination_qty;
                                        $total_mmbtu_nomination_qty1 = round(convertToMmbtu($total_scm_nomination_qty1,''),2);
                                        $diff_qty = round(($nom_qty-$total_scm_nomination_qty1),2);
                                    }
                                    else if($unit_price == 2){
                                        $total_mmbtu_nomination_qty2 = $nomination_qty;
                                        $total_scm_nomination_qty2 = round(convertToScm($total_mmbtu_nomination_qty2,''),2);
                                        $diff_qty = round(($nom_qty-$total_scm_nomination_qty2),2);
                                    }
                                    $total_scm_nomination_qty += ($total_scm_nomination_qty1 + $total_scm_nomination_qty2);
                                    $total_mmbtu_nomination_qty += ($total_mmbtu_nomination_qty1 + $total_mmbtu_nomination_qty2);
									if(isset($ga_nomination) and isset($ga_nomination[$nomination['id']])) {
										?>
										<div class="input-group input-group-sm max-w-300">
											<input class="form-control form-control-sm text-end contractss" type="text" id="nvv_<?php print $nomination['id'];?>" name="dcq_value[UP][<? echo $nomination['id']; ?>]" value="<? echo $nomination_qty; ?>" onkeypress="return isNumberKey(event)" onchange="caliculateTotalNomination()">
											<input class="form-control form-control-sm text-end" type="hidden" name="update_id[UP][<? echo $nomination['id']; ?>]" value="<? echo $nomination_id; ?>">
			                    			<input type="hidden" name="nom_value_nvv_<?php print $nomination['id']; ?>" id="nom_value_nvv_<?php print $nomination['id']; ?>" value="<? echo $nomination_qty; ?>">

			                                <select class="form-select form-select-sm max-w-105" id="nvv_<?php print $nomination['id'];?>_unit" name="nomination_unit[UP][<? echo $nomination['id']; ?>]" onchange="caliculateTotalNomination()">
			                                	<option <?if($unit_price == 2) {?> selected="selected"<?}?> value="2">MMBTU</option>
                                                <option <?if($unit_price == 1) {?> selected="selected"<?}?> value="1">SCM</option>
			                                </select>
                        				</div>
									<?}else {
										?>
										<div class="input-group input-group-sm max-w-300">
											<input class="form-control form-control-sm text-end contractss" type="text" id="nvv_<?php print $nomination['id'];?>" name="dcq_value[IN][<? echo $nomination['id']; ?>]" value="<? echo $nomination_qty; ?>" onkeypress="return isNumberKey(event)" onchange="caliculateTotalNomination()">
			                                <select class="form-select form-select-sm max-w-105" id="nvv_<?php print $nomination['id'];?>_unit" name="nomination_unit[IN][<? echo $nomination['id']; ?>]" onchange="caliculateTotalNomination()">
			                                    <option <?php if($unit_price == 2) {?> selected="selected"<?}?> value="2">MMBTU</option>
                                                <option <?php if($unit_price == 1) {?> selected="selected"<?}?> value="1">SCM</option>
			                                </select>
                        				</div>
									<?}?>
								</td>
								<td>
									<span id="cur_day_nvv_<?php print $nomination['id'];?>"></span>
								</td>
								<td><span id="avg_nom_val_nvv_<?php print $nomination['id']; ?>"></span>
									<input type="hidden" name="tot_contract" id="tot_contract_nvv_<?php print $nomination['id']; ?>" value="<? echo $nom_qty; ?>">
									<input type="hidden" name="tot_diff_contract" id="tot_diff_contract_nvv_<?php print $nomination['id']; ?>" value="<? echo $diff_qty; ?>">
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
                            <td></td>
                            <td>
                            	<span id="total_mmbtu_qty"><?php print displayNumber($total_mmbtu_nomination_qty,2);?></span> MMBTU / 
                                <span id="total_scm_qty"><?php print displayNumber($total_scm_nomination_qty,2);?></span> SCM
                                <span> @ 9294.11 GCV</span>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
					</tbody>
				</table>
			</div>
			<div class="text-end" id="nomination_add_success">
				<button type="submit" class="btn btn-success btn-sm"><span class="mdi mdi-plus"></span>&nbsp;Submit</button>
			</div>
		</form>
		<hr/>
		<?php
	}
	else {
		?>
		<tr>
			<td colspan="9">
			    <div class="alert alert-warning">No records found</div>
			</td>
		</tr>
		<?
	}?>
	<div id="gas_sourcing_history">
		<? $this->load->view('gas_source/allocation_history'); ?>
	</div>
<?}
else {
	?>
	<tr>
		<td colspan="9">
		    <div class="alert alert-warning">Please Select STATE and GA Values</div>
		</td>
	</tr>
	<?
}
?>
<script type="text/javascript">
	$(document).ready(function() {
		total_nom_val =nominated_value = diff_nom_val = cur_date = caliculated_val = scm_value = nom_diff_val = 0;
		$('.contractss').each(function() {
	        var uid = this.id;
            var unit = $("#"+uid+"_unit").val();
	        scm_val = $('#scm_'+uid).val();
	        nom_diff_val = $('#tot_contract_'+uid).val();
	        nominated_value = $('#nom_value_'+uid).val();
	        if(nominated_value > 0) {
		        if(unit == 1){
		            caliculated_val = nominated_value * (9294.11 / 252000);
		        }
		        else {
		            caliculated_val = nominated_value;
		        }
		        scm_value = parseFloat(caliculated_val*(252000/9294.11));
	        	total_nom_val = parseFloat(nom_diff_val/(scm_val*15))*100;
	        }else {
	        	nominated_value = 0;
	        	total_nom_val = parseFloat(nom_diff_val/(scm_val*15))*100;
	        }
	        //cuurent Date Percentage
	        cur_date = (scm_value/scm_val) * 100;
	        if(isNaN(total_nom_val) || isNaN(cur_date)) {
	        	$('#avg_nom_val_'+uid).html(0);
        		$('#cur_day_'+uid).html(0);
	        }else {
	        	$('#avg_nom_val_'+uid).html(Math.abs(total_nom_val.toFixed(2)));
        		$('#cur_day_'+uid).html(cur_date.toFixed(2));
	        }
		});
	});
    var d = new Date();
	var date = d.setDate(d.getDate() + 2);
	$('#nomination_date').datepicker({format: 'yyyy-mm-dd', startDate:'today', endDate:date, autoHide: true});
	// Calculate Nomination totals
	function caliculateTotalNomination() {
		var mmbtu = nominated_val = caliculated_val = cur_date = total_nom = scm_value = tot_diff_contract = 0;
		$(".contractss").each(function() {
            var uid = this.id;
            var unit = $("#"+uid+"_unit").val();
            nominated_val = $(this).val();
            tot_diff_contract = $('#tot_diff_contract_'+uid).val();
            scm_val = $('#scm_'+uid).val();
            if(nominated_val > 0) {
	            if(unit == 1){
	                caliculated_val = nominated_val * (9294.11 / 252000);
	            }
	            else {
	                caliculated_val = nominated_val;
	            }
	            //cuurent Date percentage
	            scm_value = parseFloat(caliculated_val*(252000/9294.11));
	            cur_date = (scm_value/scm_val) * 100;

	            mmbtu = mmbtu + parseFloat(caliculated_val);
		        total_nom = ((parseFloat(tot_diff_contract)+parseFloat(scm_value))/(scm_val*15))*100;
        		$('#cur_day_'+uid).html(cur_date.toFixed(2));
		        if(isNaN(total_nom)) {
			        $('#avg_nom_val_'+uid).html(0);
			    }else {
			        $('#avg_nom_val_'+uid).html(Math.abs(total_nom.toFixed(2)));
			    }
	        }
        });
        $('#total_mmbtu_qty').html(mmbtu.toFixed(2));
        var scm = parseFloat(mmbtu * (252000 / 9294.11));
        $('#total_scm_qty').html(scm.toFixed(2));
	}

</script>