<?php
/**
 * Gas Source Consumption Details
 */

$state_val = isset($params['state']) ? $params['state'] : '';
$ga_val = isset($params['ga']) ? $params['ga'] : '';
$supplier_val = isset($params['supplier']) ? $params['supplier'] : '';
$selected_date = isset($params['selected_date']) ? date('d-m-Y',strtotime($params['selected_date'])): date('d-m-Y',strtotime('-1days'));
$consumption = isset($params['consumption']) ? $params['consumption'] : '';
$gcv = isset($params['gcv']) ? $params['gcv'] : '';
?>
<div class="consumption-allocation-card mb-2">
	<div class="clearfix p-3"> 
		<div class="float-start">
			<div class="d-flex align-items-top">
				<div class="me-1">
	                <label class="form-label mb-0">State&nbsp;<span class="text-danger">*</span>:</label>
					<select name="state" id="state" class="form-select form-select-sm w-150 me-1" aria-label="All States" data-live-search="true" onchange="stateGaFilter(this.value)">
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
				<div id="ga_consumption_filter" class="me-1">
					<? $this->load->view('gas_source/consumption_ga_filter'); ?>
				</div>
				<div class="me-1">
					<label class="form-label mb-0">Supplier&nbsp;<span class="text-danger">*</span>:</label>
					<select name="supplier" id="supplier" class="form-select form-select-sm w-150 me-1" aria-label="All Suppliers" data-live-search="true">
						<option value="">Suppliers</option>
						<?php
						if(isset($suppliers)){
							foreach($suppliers as $key => $supplier) {
								?>
								<option <? if($supplier_val == $supplier['id']) { echo "selected"; }?> value="<? echo $supplier['id']; ?>"><? echo $supplier['name']; ?></option>
								<?
							}
						}
						?>
					</select>
					<div id="supplier_alert"></div>
				</div>
				<div class="me-1">
	            	<label class="form-label mb-0">Date&nbsp;<span class="text-danger">*</span>:</label>
	            	<div class="input-group input-group-sm w-150">
		                <input type="text" class="form-control form-control-sm" id="selected_date" name="selected_date" autocomplete="off" placeholder="DD-MM-YYYY" aria-label="selected_date" aria-describedby="selected_date"  value="<? echo $selected_date; ?>">
		                <span class="input-group-text"><span class="mdi mdi-calendar-month-outline"></span></span>
	            	</div>
					<div id="date_alert"></div>
				</div>
				<div class="me-1">
					<label class="form-label mb-0">&nbsp;</label>
					<div>
						<button type="button" class="btn btn-sm btn-success" onclick="consumptionBody()"><span class="mdi mdi-magnify"></span></button>					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="consumption_allocation_details">
	<? $this->load->view('gas_source/consumption_allocation_details'); ?>
</div>
<script type="text/javascript">
	var d = new Date();
	var date = d.setDate(d.getDate() - 3);
	$('#selected_date').datepicker({format: 'dd-mm-yyyy', startDate:date, endDate:'today', autoHide: true});
</script>