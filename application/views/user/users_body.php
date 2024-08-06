<?php
/**
 * Users body
 */
// $this->load->helper('pagination');

$tRecords = $params['tRecords'];
$rows = $params['rows'];
$sortby = $params['sortby'];
$sort_order = $params['sort_order'];
$pageno = $params['pageno'];
$total_pages = (ceil($params['tRecords'] / $params['rows']) > 0) ? ceil($params['tRecords'] / $params['rows']) : 1;

$keywords = (isset($_POST['keywords'])) ? $_POST['keywords'] : "" ;
// print_r($total_pages);
?>
<form class="row" onsubmit="return false">
	<div class="clearfix mb-2">
		<div class="float-start d-flex align-items-center">
			<div class="me-1">
				<input class="form-control form-control-sm" type="text" name="keywords" id="keywords" placeholder="Search here..." value="<? echo $keywords; ?>">
			</div>			
			<div class="me-1">
				<button class="btn btn-sm btn-success" onclick="users_body('<? echo $rows; ?>', '1', '<? echo $sortby; ?>', '<? echo $sort_order; ?>')">
					<span class="mdi mdi-magnify"></span>
				</button>
				<button class="btn btn-sm btn-warning" onclick="reset_user_body()"><span class="mdi mdi-refresh"></span></button>
			</div>
			<div class="me-1">
				<strong><span class="crusade-records-count"><? print '(' . $tRecords . ' ' . ("Records") .')';?></span></strong>
			</div>
		</div>
		<div class="float-end d-flex align-items-center">
			<div class="me-1">
				<button type="button" class="btn btn-sm btn-success" onclick="users_add()"><span class="mdi mdi-plus"></span>&nbsp;Add new user</button>
			</div>
			<div class="me-1">
				<select class="form-select form-select-sm" aria-label="20" name="rows" onchange="users_body(this.value, '1', '<? echo $sortby; ?>', '<? echo $sort_order; ?>')">
					<option value="10" <? if($rows == 10) echo 'selected="selected"'; ?>>10 <? echo ("Records"); ?></option>
					<option value="20" <? if($rows == 20) echo 'selected="selected"'; ?>>20 <? echo ("Records"); ?></option>
					<option value="50" <? if($rows == 50) echo 'selected="selected"'; ?>>50 <? echo ("Records"); ?></option>
					<option value="100" <? if($rows == 100) echo 'selected="selected"'; ?>>100 <? echo ("Records"); ?></option>
					<option value="1000" <? if($rows == 1000) echo 'selected="selected"'; ?>>1000 <? echo ("Records"); ?></option>
				</select>
			</div>
			<div class="me-0">
				<nav aria-label="Page navigation">
					<ul class="pagination pagination-sm mb-0">
						<?
						if($pageno == 1) { ?>
							<li class="page-item disabled">
								<a class="page-link pagination-pad" aria-disabled="true" href="javascript:void(0);"><span class="mdi mdi-chevron-double-left"></span></a>
							</li>
							<li class="page-item disabled">
								<a class="page-link pagination-pad" aria-disabled="true" href="javascript:void(0);"><span class="mdi mdi-chevron-left"></span></a>
							</li>
		                    <?
						}
						else {
							?>
							<li class="page-item">
								<a class="page-link pagination-pad" href="javascript:void(0);" onclick="users_body('<? print $rows;?>', '1', '<? print $sortby;?>', '<? print $sort_order;?>')">
									<span class="mdi mdi-chevron-double-left"></span>
								</a>
		                    </li>
		                    <li class="page-item">
		                        <a class="page-link pagination-pad" href="javascript:void(0);" onclick="users_body('<? print $rows;?>', '<? print $pageno-1;?>', '<? print $sortby;?>', '<? print $sort_order;?>')" >
		                            <span class="mdi mdi-chevron-left"></span>
		                        </a>
		                    </li>
							<?
						}
						?>
						<li class="page-item active select-pagination" aria-current="page">
                            <span class="page-link">
								<select class="form-select form-select-sm" name="rows" onchange="users_body('<? echo $rows; ?>', this.value, '<? echo $sortby; ?>', '<? echo $sort_order; ?>')">
									<?
									for($i = 1; $i <= $total_pages; $i++) {
										?>
										<option value="<? echo $i; ?>" <? if($i == $pageno) echo 'selected="selected"'; ?>>
											<? echo $i . '/' . $total_pages; ?>
										</option>
										<?
									}
									?>
								</select>
							</span>
						</li>
						<?
		                if ($pageno == $total_pages) { ?>
		                	<li class="page-item disabled">
		                		<a class="page-link pagination-pad" aria-disabled="true" href="javascript:void(0);"><span class="mdi mdi-chevron-right"></span></a>
		                	</li>
		                	<li class="page-item disabled">
		                		<a class="page-link pagination-pad" aria-disabled="true" href="javascript:void(0);"><span class="mdi mdi-chevron-double-right"></span></a>
		                	</li>
		                    <?
		                }
		                else {
		                    ?>
		                    <li class="page-item">
		                        <a class="page-link pagination-pad" href="javascript:void(0);" onclick="users_body('<? print $rows;?>', '<? print $pageno+1;?>', '<? print $sortby;?>', '<? print $sort_order;?>')">
		                            <span class="mdi mdi-chevron-right"></span>
		                        </a>
		                    </li>
		                    <li class="page-item">
		                    	<a class="page-link pagination-pad" href="javascript:void(0);" onclick="users_body('<? print $rows;?>', '<? print $total_pages;?>', '<? print $sortby;?>', '<? print $sort_order;?>')" >
		                        	<span class="mdi mdi-chevron-double-right"></span>
		                    	</a>
		                    </li>
		                    <?
		                }
		                ?>
		            </ul>
		        </nav>
			</div>
		</div>
	</div>
</form>
<div class="table-responsive">
	<table class="table table-bordered table-hover table-striped table-condensed">
		<thead>
			<tr class="table-secondary">
				<th class="text-center" width="1%">S.No.</th>
				<th>Name</th>
				<th>UserName</th>
				<th>Email</th>
				<th>Role</th>
				<th>Phone Number</th>
				<th class="text-center">Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<? $i = $params['offset'] + 1;
			if(isset($users) && !empty($users)) {
				foreach ($users as $key => $u_details) {
					?>
					<tr>
						<td class="text-center"><? echo $i++; ?></td>
						<td><? echo $u_details['fname']." ".$u_details['lname']; ?></td>
						<td><? echo $u_details['username']; ?></td>
						<td><? echo $u_details['email']; ?></td>
						<td><? echo $u_details['r_name']; ?></td>
						<td><? echo $u_details['mobile']; ?></td>
						<td class="text-center">
							<?
							if($u_details['status'] == 1) {
								echo "<div class='label-success icon-check w65'>Enable</div>";
							} else{
								echo "<div class='label-danger icon-close w65'>Disable</div>";
							}
							?>
						</td>
						<td>
							<div class="dropdown">
							  	<button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="actions_btn" data-bs-toggle="dropdown" aria-expanded="false">
							    	Actions
							  	</button>
							  	<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actions_btn">
							    	<li>
										<?
										if($u_details['status'] == 1) {
											?>
											<a class="dropdown-item" href="#" onclick="userChangeStatus('<? echo $u_details['id']; ?>', 0)"><span class="mdi mdi-close"></span>&nbsp;Disable</a>
											<?
										} else {
											?>
											<a class="dropdown-item" href="#" onclick="userChangeStatus('<? echo $u_details['id']; ?>', 1)"><span class="mdi mdi-plus"></span>&nbsp;Enable</a>
											<?
										}
										?>
							    	</li>
									<a class="dropdown-item" href="#" onclick="userView('<? echo $u_details['id']; ?>')"><span class="mdi mdi-information"></span>&nbsp;View</a>
									<a class="dropdown-item" href="#" onclick="usersEdit(<? echo $u_details['id']; ?>)"><span class="mdi mdi-pencil"></span>&nbsp;Edit</a>
									<a class="dropdown-item" href="#" onclick="usersDelete(<? echo $u_details['id']; ?>)"><span class="mdi mdi-delete"></span>&nbsp;Delete</a>
									<a class="dropdown-item" href="#" onclick="user_resetPassword('<?php print $u_details['id'];?>')"><span class="mdi mdi-refresh"></span>&nbsp;Reset Password</a>
							  	</ul>
							</div>
						</td>
					</tr>
					<?
				}
			} else {
				?>
				<tr>
					<td colspan="8"><div class="alert alert-warning">No Records Found!</div></td>
				</tr>
				<?
			}
			?>
		</tbody>
	</table>
</div>