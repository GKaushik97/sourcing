<?php
/**
 * Suppliers list
 */
?>
<div class="text-end">
	<button type="button" class="btn btn-sm btn-success" onclick="addSupplier(event)"><span class="mdi mdi-plus"></span>&nbsp;Add Supplier</button>
</div>
<div class="mt-2">
	<div class="table-responsive">
		<table class="table table-bordered table-hover table-striped table-condensed">
			<thead>
				<tr class="table-secondary">
					<th width="1%" class="text-center">S.No</th>
					<th>Name</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?
				$i = 1;
				if($suppliers) {
					foreach ($suppliers as $key => $supplier) {
					?>
					<tr>
						<td class="text-center"><? echo $i++; ?></td>
						<td><? echo $supplier['name']; ?></td>
						<td>
							<button type="button" class="btn btn-primary btn-sm" onclick="editSupplier(<? echo $supplier['id']; ?>)"><span class="mdi mdi-pencil"></span>&nbsp;Edit</button>
							<!-- <button type="button" class="btn btn-danger btn-sm" onclick="deleteSupplier(<? echo $supplier['id']; ?>)"><span class="mdi mdi-delete-outline"></span>&nbsp;Delete</button> -->
						</td>
					</tr>
				<?}	
			  	}
			  	else {
			  	?>
			  		<tr>
          				<td colspan="12">
          				    <div class="alert alert-warning"><? echo "No records found";?></div>
          				</td>
       				</tr>
			  	<?}
				?>
			</tbody>
		</table>			
	</div>
</div>