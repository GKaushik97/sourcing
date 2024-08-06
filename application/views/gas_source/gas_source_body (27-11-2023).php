<?php
/**
 * Gas Source Nomination Details
 */

$state_val = isset($params['state']) ? $params['state'] : '';
$ga_val = isset($params['ga']) ? $params['ga'] : '';
$nomination_date = isset($params['nomination_date']) ? $params['nomination_date'] : date('d-m-Y');
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
						foreach($contracts as $key => $nomination) {
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
                                    }
                                    else if($unit_price == 2){
                                        $total_mmbtu_nomination_qty2 = $nomination_qty;
                                        $total_scm_nomination_qty2 = round(convertToScm($total_mmbtu_nomination_qty2,''),2);
                                    }
                                    $total_scm_nomination_qty += ($total_scm_nomination_qty1 + $total_scm_nomination_qty2);
                                    $total_mmbtu_nomination_qty += ($total_mmbtu_nomination_qty1 + $total_mmbtu_nomination_qty2);
									if(isset($ga_nomination) and isset($ga_nomination[$nomination['id']])) {
										?>
										<div class="input-group input-group-sm max-w-300">
											<input class="form-control form-control-sm text-end contractss" type="text" id="nvv_<?php print $nomination['id'];?>" name="dcq_value[UP][<? echo $nomination['id']; ?>]" value="<? echo $nomination_qty; ?>" onkeypress="return isNumberKey(event)" onchange="caliculateTotalNomination()">
											<input class="form-control form-control-sm text-end" type="hidden" name="update_id[UP][<? echo $nomination['id']; ?>]" value="<? echo $nomination_id; ?>">
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
								<td id="cur_day"></td>
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
    var d = new Date();
	var date = d.setDate(d.getDate() + 2);
	$('#nomination_date').datepicker({format: 'dd-mm-yyyy', startDate:'today', endDate:date, autoHide: true});
	// Calculate Nomination totals
	function caliculateTotalNomination() {
		var mmbtu = nominated_val = caliculated_val = 0;
		$(".contractss").each(function() {
            var uid = this.id;
            var unit = $("#"+uid+"_unit").val();
            nominated_val = $(this).val();
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
        $('#total_mmbtu_qty').html(mmbtu.toFixed(2));
        var scm = parseFloat(mmbtu * (252000 / 9294.11));
        $('#total_scm_qty').html(scm.toFixed(2));
	}
</script>
<script type="text/javascript">
    var d = new Date();
	var date = d.setDate(d.getDate() + 2);
	$('#nomination_date').datepicker({format: 'yyyy-mm-dd', startDate:'today', endDate:date, autoHide: true});
	// Calculate Nomination totals
	function caliculateTotalNomination() {
		var mmbtu = nominated_val = caliculated_val = 0;
		$(".contractss").each(function() {
            var uid = this.id;
            var unit = $("#"+uid+"_unit").val();
            nominated_val = $(this).val();
            scm_val = $('#scm_'+uid).val();
            var current_day = (nominated_val/scm_val)*100;
        	$('#cur_day_'+uid).html(current_day.toFixed(2));
            if(nominated_val > 0) {
	            if(unit == 1){
	            	alert(unit);
	                caliculated_val = nominated_val * (9294.11 / 252000);
	            }
	            else {
	            	alert(unit);
	                caliculated_val = nominated_val;
	            }
	            mmbtu = mmbtu + parseFloat(caliculated_val);
	        }
        });
        $('#total_mmbtu_qty').html(mmbtu.toFixed(2));
        var scm = parseFloat(mmbtu * (252000 / 9294.11));
        $('#total_scm_qty').html(scm.toFixed(2));
	}

	/*// Get the current date
	var current_date = new Date($('#nomination_date').val());

	// Get the last date of the current month
	var lastDateOfMonth = new Date(current_date.getFullYear(), current_date.getMonth() + 1, 0);

	// Calculate the difference in milliseconds
	var timeDifference = lastDateOfMonth.getTime() - current_date.getTime();

	// Convert milliseconds to days
	var daysDifference = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));

	console.log(`The difference between the last date of the month and the current date is ${daysDifference} days.`);*/

</script>