<?php
/**
 * Gas Source Nomination Details
 */

$state_val = isset($params['state']) ? $params['state'] : '';
$ga_val = isset($params['ga']) ? $params['ga'] : '';
$from_date = isset($params['from_date']) ? $params['from_date'] : '';
?>
<div class="clearfix"> 
	<div class="float-start">
		<div class="d-flex align-items-center">
			<div class="me-1">
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
			</div>
			<div id="gas_area_filter" class="me-1">
				<? $this->load->view('gas_source/geo_area_filter'); ?>
			</div>
			<div class="mb-3">
                <!-- <label class="form-label mb-0">Date&nbsp;<span class="text-danger">*</span>&nbsp;:</label> -->
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" id="from_date" name="from_date" autocomplete="off" placeholder="DD-MM-YYYY" aria-label="start_date" aria-describedby="from_date"   onchange="gasSourceTillDate()" value="<? echo $from_date; ?>">
                    <span class="input-group-text"><span class="mdi mdi-calendar-month-outline"></span></span>
                </div>
            </div>  
		</div>
	</div>
</div>
<div>&nbsp;</div>
<div>&nbsp;</div>

<?php
if (isset($params['state']) && !empty($params['state']) && isset($params['ga']) && !empty($params['ga'])) {
	if (isset($contractors) and !empty($contractors)) {
		?>
		<form name="nomination_add_form" id="nomination_add_form" method="post" onsubmit="nomination_insert(event)">
			<input type="hidden" name="state_ext" value="<? echo $state_val; ?>">
			<input type="hidden" name="ga_ext" value="<? echo $ga_val; ?>">
			<div class="mt-2">
				<div class="table-responsive"> 
					<table class="table table-bordered table-hover table-striped table-condensed">
						<thead>
							<tr>
								<th>S.No</th>
								<th>Code</th>
								<th>Name</th>
								<th>Supplier</th>
								<th>Contract Type</th>
								<th>MGO<small>(%)</small></th>
								<th>DCQ<small>(units)</small></th>
							</tr>
						</thead>
						<tbody>
							<?
							$i = 1;
							foreach($contractors as $key => $contractor) {
								?>
								<tr>
									<td><? echo $i++; ?></td>
									<td><? echo $contractor['code']; ?></td>
									<td><? echo $contractor['name']; ?></td>
									<td><? echo $contractor['supplier']; ?></td>
									<td><? echo $contractor['type_name']; ?></td>
									<td><? echo $contractor['mgo']; ?></td>
									<td>
										<?php
										if (isset($contracts[$contractor['id']]) && $contractors_data[$contractor['id']]) {
											echo $contractors_data[$contractor['id']];
										}
										else {
											?><input type="text" name="dcq_value[<? echo $contractor['id']; ?>]" value="<? echo $contractor['dcq']; ?>" onkeypress="return isNumberKey(event)"><?
										}
										?>
									</td>
								</tr>
								<?
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<div id="nomination_add_success">
			<?
			if(count($contractors) == count($contractors_data)) {
			}else {?>
				<button type="submit" class="btn btn-success btn-sm"><span class="mdi mdi-plus"></span>&nbsp;Submit</button>
			<?}
			?>
			</div>
		</form>
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
	}
}
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
<div id="gas_sourcing_history">
	<? $this->load->view('gas_source/gas_sourcing_history'); ?>
</div>
<script type="text/javascript">
    $('#from_date').datepicker({format: 'dd-mm-yyyy',startDate:today,endDate:+2d,autoHide: true});
</script>
