<?php
/**
 * User details
 */
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">User details</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			<div>
				<?
				if($users_details) {
					?>
					<div class="table-response">
						<table class="table table-borderless">
							<tbody>
								<tr>
									<td width="130"><? echo "Name" ?></td>
									<td width="1%">:</td>
									<td><? echo $users_details['fname']." ".$users_details['lname']; ?></td>
								</tr>
								<tr>
									<td><? echo "Username" ?></td>
									<td>:</td>
									<td><? echo $users_details['username']; ?></td>
								</tr>
								<tr>
									<td><? echo "Email" ?></td>
									<td>:</td>
									<td><? echo $users_details['email']; ?></td>
								</tr>
								<tr>
									<td><? echo "Role" ?></td>
									<td>:</td>
									<td><? echo $users_details['r_name']; ?></td>
								</tr>
								<tr>
									<td><? echo "Phone Number" ?></td>
									<td>:</td>
									<td><? echo $users_details['mobile']; ?></td>
								</tr>
								<tr>
									<td><? echo 'Added at'; ?></td>
									<td>:</td>
									<td>
										<?
                                        if(isset($users_details['added_at']) and !empty($users_details['added_at'])) {
                                            echo date('d-m-Y', strtotime($users_details['added_at']));
                                        }
                                        else {
                                            echo '-';
                                        }
                                        ?>
									</td>
								</tr>
								<tr>
									<td><? echo 'Added by'; ?></td>
									<td>:</td>
									<td><? echo $users_details['added_by']; ?></td>
								</tr>
								<tr>
									<td><? echo 'Updated Date'; ?></td>
									<td>:</td>
									<td>
										<?
                                        if(isset($users_details['updated_at']) and !empty($users_details['updated_at'])) {
                                            echo date('d-m-Y', strtotime($users_details['updated_at']));
                                        }
                                        else {
                                            echo '-';
                                        }
                                        ?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<?
				}
				?>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><span class="mdi mdi-close"></span>&nbsp;Close</button>
		</div>
	</div>
</div>