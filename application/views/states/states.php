<?php
/**
 * States list
 */
?>
<div>
	<?	
	if($states) {
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped table-condensed">
				<thead>
					<tr class="table-secondary">
						<th width="1%" class="text-center">S.No</th>
						<th>State Name</th>
					</tr>
				</thead>
				<tbody>
					<?
					$i = 1;
					foreach ($states as $key => $value) {
						?>
						<tr>
							<td class="text-center"><? echo $i++; ?></td>
							<td><? echo $value['name']; ?></td>
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