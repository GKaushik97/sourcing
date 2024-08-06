<?php
if (isset($params['state']) && !empty($params['state']) && isset($params['ga']) && !empty($params['ga'])) {
	if (isset($nomination_history) and !empty($nomination_history)) {
		?>
		<div>
			<h4>Nomination History</h4>
		</div>
		<div class="mt-2">
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-striped table-condensed">
					<thead>
						<tr>
							<th rowspan="2">S.No</th>
							<th rowspan="2">Source Date</th>
							<th colspan="2">Nomination Quantity</th>
							<th rowspan="2">Nomination Unit<small>(SCM)</small></th>
						</tr>
						<tr>
							<td>MMBTU</td>
							<td>SCM</td>
						</tr>
					</thead>
					<tbody>
						<?
						$i=1;
						foreach ($nomination_history as $key => $history) {
						?>
						<tr>
							<td><? echo $i++; ?></td>
							<td><? echo $history['source_date']; ?></td>
							<td><? echo $history['nomination_qty']; ?></td>
							<td><? echo $history['nomination_qty']; ?></td>
							<td><? echo $history['nomination_unit']; ?></td>
						</tr>
						<?}
						?>
					</tbody>
				</table>
			</div>
		</div>
<? }else {
	?>
	<tr>
		<td colspan="9">
		    <div class="alert alert-warning">No records found</div>
		</td>
	</tr>
<?}
}
?>