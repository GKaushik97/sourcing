<?php
/**
 * Geo Areas
 */
?>
<div>
	<?	
	if($geo_areas) {
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped table-condensed">
				<thead>
					<tr class="table-secondary">
						<th width="1%" class="text-center">S.No.</th>
						<th>Geo Area</th>
						<th>GA Code</th>
						<th>State</th>
					</tr>
				</thead>
				<tbody>
					<?
					$i = 1;
					foreach ($geo_areas as $key => $value) {
						?>
						<tr>
							<td class="text-center"><? echo $i++; ?></td>
							<td><? echo $value['name']; ?></td>
							<td><? echo $value['code']; ?></td>
							<td><? echo $value['state_name']; ?></td>
						</tr>
					<?}
					?>
				</tbody>
			</table>
		</div>
		<?
	}
	else {
		echo "No Records Found";
	} 
	?>
</div>