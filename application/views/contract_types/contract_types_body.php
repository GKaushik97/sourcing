<?php
/**
 * Geo Areas
 */
?>
<div class="select-picker-records"><? echo $tRecords . ' ' . 'Records';?></div>
<div class="text-end">
	<button type="button" class="btn btn-sm btn-success" onclick="addContractType(event)"><span class="mdi mdi-plus"></span>&nbsp;Add Contract Type</button>
</div>
<div class="mt-2">
	<?	
	if($contract_type) {
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped table-condensed">
				<thead>
					<tr class="table-secondary">
						<th width="1%" class="text-center">S.No.</th>
						<th>Name</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?
					$i = 1;
					foreach ($contract_type as $key => $value) {
						?>
						<tr>
							<td class="text-center"><? echo $i++; ?></td>
							<td><? echo $value['name']; ?></td>
							<td>
								<button type="button" class="btn btn-primary btn-sm" onclick="editContractType(<? echo $value['id']; ?>)"><span class="mdi mdi-pencil"></span>&nbsp;Edit</button>
								<button type="button" class="btn btn-danger btn-sm" onclick="deleteContractType(<? echo $value['id']; ?>)"><span class="mdi mdi-delete-outline"></span>&nbsp;Delete</button>
							</td>
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