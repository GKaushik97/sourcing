<?php
/**
 * Contract List
 */
$sort_order = isset($params['sort_order']) ? $params['sort_order'] : 'ASC';
if($params['sort_order'] == 'DESC') {
	$tsort_order = 'ASC';
	$arrow = '<span class="mdi mdi-arrow-down"></span>';
}
else {
	$tsort_order = 'DESC';
	$arrow = '<span class="mdi mdi-arrow-up"></span>';
}
$rows = isset($params['rows']) ? $params['rows'] : 10;
$sort_by = isset($params['sort_by']) ? $params['sort_by'] : 'added_at';
$keywords = $params['keywords'];
$trecords = $tRecords;
$pageno = isset($params['pageno']) ? $params['pageno'] : 1;
$total_pages = ceil($trecords/$rows);
$state_val = isset($params['state']) ? $params['state'] : '';
$supplier_val = isset($params['supplier']) ? $params['supplier'] : '';
$name_val = $this->input->post('name') ? $this->input->post('name') : '';
$code_val = $this->input->post('code') ? $this->input->post('code') : '';
$data = $this->session->flashdata('flag');
$priorities_length = isset($totalPriorities) ? $totalPriorities : '';
$priority_val = isset($params['priority']) ? $params['priority'] : '';
$status_val = isset($params['status']) ? $params['status'] : '';
?>
<form method="post" onsubmit="return false">
	<input type="hidden" name="pageno" id="pageno" value="<? echo $pageno; ?>">
	<div class="clearfix">
		<div class="float-start">
			<div class="d-flex align-items-center">
				<div class="me-1">
					<input class="form-control form-control-sm" type="text" name="keywords" id="keywords" placeholder="Enter Name" value="<? echo $keywords; ?>">
				</div>
				<div class="me-1">
					<select name="state" id="state" class="form-select form-select-sm w-150 me-1" aria-label="States" data-live-search="true" onchange="geoAreaFilterBody(this.value)">
						<option value="">States</option>
						<?
						foreach($states as $key=>$value) {
							?>
							<option <? if($state_val == $value['id']) { echo "selected"; }?> value="<? echo $value['id']; ?>"><? echo $value['name']; ?></option>
						<?}?>
					</select>
				</div>
				<div id="geo_areas_filter" class="me-1">
					<? $this->load->view('contract/geo_areas_filter'); ?>
				</div>
				<div class="me-1">
					<button class="btn btn-sm btn-success" onclick="searchContractBody('<? echo $rows; ?>', '<? echo $sort_by; ?>', '<? echo $sort_order; ?>', 1)" title="search"><span class="mdi mdi-magnify"></span></button>
				</div>
				<div class="me-1">
					<button type="button" class="btn btn-sm btn-warning" onclick="resetContractBody()"><span class="mdi mdi-refresh"></span></button>
				</div>
				<div class="me-0"><strong>(&nbsp;<? echo $trecords; ?>&nbsp;Records&nbsp;)</strong></div> 
			</div>			
		</div>
		<div class="float-end d-flex align-items-center">
			<div class="me-1">
				<?
				// Check action access
		        if($this->userlibrary->checkAccess('cnad')) {
		        	?><button type="button" class="btn btn-sm btn-success" onclick="addContract(event)"><span class="mdi mdi-plus"></span>&nbsp;Add Contract</button>
		        <? } ?>
			</div>
			<div class="me-1">
				<?
				// Check action access
		        if($this->userlibrary->checkAccess('cnex')) {
		        	?><button type="button" class="btn btn-sm btn-primary" onclick="contractExport('<? echo $sort_by; ?>', '<? echo $sort_order; ?>')"><span class="mdi mdi-file-export-outline"></span>&nbsp;Export</button>
		        <? } ?>
		        </div>
			<div class="me-1">
				<select class="form-select form-select-sm" name="rows" id="rows" onchange="searchContractBody(this.value, '<? echo $sort_by; ?>','<? echo $sort_order; ?>',<? echo $pageno; ?>)">
					<option value="10" <? if($rows == 10) print 'selected="selected"'?>>10<? echo "Records"; ?></option>
					<option value="20" <? if($rows == 20) print 'selected="selected"'?>>20<? echo "Records"; ?></option>
					<option value="50" <? if($rows == 50) print 'selected="selected"'?>>50<? echo "Records"; ?></option>
					<option value="100" <? if($rows == 100) print 'selected="selected"'?>>100<? echo "Records"; ?></option>
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
							<a class="page-link pagination-pad" href="javascript:void(0);" onclick="searchContractBody('<? echo $rows; ?>','<? echo $sort_by; ?>','<? echo $sort_order; ?>','1')">
								<span class="mdi mdi-chevron-double-left"></span>
							</a>
	                    </li>
	                    <li class="page-item">
	                        <a class="page-link pagination-pad" href="javascript:void(0);" onclick="searchContractBody('<? echo $rows; ?>','<? echo $sort_by; ?>','<? echo $sort_order; ?>','<? print $pageno - 1; ?>')">
	                            <span class="mdi mdi-chevron-left"></span>
	                        </a>
	                    </li>
						<?
					}
					?>
					<li class="page-item active select-pagination" aria-current="page">
                        <span class="page-link">
							<select class="form-select form-select-sm" name="rows" onchange="searchContractBody('<? echo $rows; ?>','<? echo $sort_by; ?>','<? echo $sort_order; ?>',this.value)">
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
	                        <a class="page-link pagination-pad" href="javascript:void(0);" onclick="searchContractBody('<? echo $rows; ?>','<? echo $sort_by; ?>','<? echo $sort_order; ?>','<? print $pageno + 1; ?>')">
	                            <span class="mdi mdi-chevron-right"></span>
	                        </a>
	                    </li>
	                    <li class="page-item">
	                    	<a class="page-link pagination-pad" href="javascript:void(0);" onclick="searchContractBody('<? echo $rows; ?>','<? echo $sort_by; ?>','<? echo $sort_order; ?>','<? print $total_pages; ?>')">
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
	<div class="mt-2">
		<div class="table-responsive" id="contract_filter">
		<table class="table table-bordered table-hover table-striped table-condensed">
			<thead>
				<tr class="table-secondary">
					<th width="1%" class="text-center"><a href="javascript:void(0)">S.No</a></th>
					<th class="w-150"><a href="javascript:void(0)" onclick="searchContractBody('<? echo $rows; ?>','code','<? echo $tsort_order; ?>','<? echo $pageno; ?>')"><? if('code' == $sort_by){ echo $arrow; }?>Code</a></th>
					<th><a href="javascript:void(0)" onclick="searchContractBody('<? echo $rows; ?>','name','<? echo $tsort_order; ?>','<? echo $pageno; ?>')"><? if('name' == $sort_by){ echo $arrow; }?>Name</a></th>
					<th><a href="javascript:void(0)" onclick="searchContractBody('<? echo $rows; ?>','supplier','<? echo $tsort_order; ?>','<? echo $pageno; ?>')"><? if('supplier' == $sort_by){ echo $arrow; }?>Supplier</a></th>
					<th class="text-end"><a href="javascript:void(0)" onclick="searchContractBody('<? echo $rows; ?>','dcq','<? echo $tsort_order; ?>',<? echo $pageno; ?>)"><? if('dcq' == $sort_by){ echo $arrow; }?>DCQ<small>(units)</small></a></th>
					<th class="text-end"><a href="javascript:void(0)" onclick="searchContractBody('<? echo $rows; ?>','mgo','<? echo $tsort_order; ?>','<? echo $pageno; ?>')"><? if('mgo' == $sort_by){ echo $arrow; }?>MGO<small>(%)</small></a></th>
					<th><a href="javascript:void(0)" onclick="searchContractBody('<? echo $rows; ?>','state','<? echo $tsort_order; ?>','<? echo $pageno; ?>')"><? if('state' == $sort_by){ echo $arrow; }?>State</a></th>
					<th><a href="javascript:void(0)" onclick="searchContractBody('<? echo $rows; ?>','ga','<? echo $tsort_order; ?>',<? echo $pageno; ?>)"><? if('ga' == $sort_by){ echo $arrow; }?>Geo Area</a></th>
					<th><a href="javascript:void(0)" onclick="searchContractBody('<? echo $rows; ?>','priority','<? echo $tsort_order; ?>','<? echo $pageno; ?>')"><? if('priority' == $sort_by){ echo $arrow; }?>Priority</a></th>
					<th class="text-center"><a href="javascript:void(0)" onclick="searchContractBody('<? echo $rows; ?>','added_at','<? echo $tsort_order; ?>','<? echo $pageno; ?>')"><? if('added_at' == $sort_by){ echo $arrow; }?>Added Date</a></th>
					<th class="text-center"><a href="javascript:void(0)" onclick="searchContractBody('<? echo $rows; ?>','status','<? echo $tsort_order; ?>','<? echo $pageno; ?>')"><? if('status' == $sort_by){ echo $arrow; }?>Status</a></th>
					<th class="text-center"><a href="javascript:void(0)">Actions</a></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td width="1%" class="text-center"><input type="hidden">#</td>
					<td><input class="form-control form-control-sm" type="text" name="code" id="code" placeholder="Enter Code" value="<? echo $code_val; ?>"></td>
					<td><input class="form-control form-control-sm" type="text" name="name" id="name" placeholder="Enter Name" value="<? echo $name_val; ?>"></td>
					<td>
						<div class="me-1">
							<select name="supplier" id="supplier" class="form-select form-select-sm w-150 me-1" aria-label="Suppliers" data-live-search="true" onchange="searchContractBody('<? echo $rows; ?>', '<? echo $sort_by; ?>', '<? echo $sort_order; ?>', 1)">
								<option value="">Suppliers</option>
								<?
								foreach($suppliers as $key=>$value) {
									?>
									<option <? if($supplier_val == $value['id']) { echo "selected"; }?> value="<? echo $value['id']; ?>"><? echo $value['name']; ?></option>
								<?}?>
							</select>
						</div>
					</td>
					<td class="text-end"><input class="form-control form-control-sm" type="hidden"></td>
					<td class="text-end"><input class="form-control form-control-sm" type="hidden"></td>
					<td class="text-center"><input class="form-control form-control-sm" type="hidden"></td>
					<td><input class="form-control form-control-sm" type="hidden"></td>
					<td>
						<select name="priority" id="priority" class="form-select form-select-sm w-150 me-1" onchange="searchContractBody('<? echo $rows; ?>', '<? echo $sort_by; ?>', '<? echo $sort_order; ?>', 1)">
							<option value="">Priority</option><?
							for($i=1; $i <= $priorities_length; $i++){
								?><option value="<? echo $i; ?>" <? if($priority_val == $i){ echo "selected"; }?>>Priority&nbsp;<? echo $i; ?></option><?
							}?>
						</select>
					</td>
					<td></td>
					<td>
						<select name="status" id="status1" class="form-select form-select-sm w-150 me-1"  onchange="searchContractBody('<? echo $rows; ?>', '<? echo $sort_by; ?>', '<? echo $sort_order; ?>', 1)">
							<option value="">status</option>
							<option value="0" <? if($status_val == "0"){ echo "selected"; }?>>InActive</option>
							<option value="1" <? if($status_val == "1"){ echo "selected"; }?>>Active</option>
						</select>
					</td>
					<td class="text-center">
						<button class="btn btn-sm btn-success" onclick="searchContractBody('<? echo $rows; ?>', '<? echo $sort_by; ?>', '<? echo $sort_order; ?>', 1)"><span class="mdi mdi-magnify"></span></button>
						<button type="button" class="btn btn-sm btn-warning" onclick="resetContractBody()"><span class="mdi mdi-refresh"></span></button>
					</td>
				</tr>
				<?
           	    $i = ($pageno-1)*$rows+1;
				if($contract) {
					foreach ($contract as $key => $value) {
						?>
						<tr>
							<td class="text-center"><? echo $i++; ?></td>
							<td><? echo $value['code']; ?></td>
							<td><? echo $value['name']; ?></td>
							<td><? echo $value['supplier_name']; ?></td>
							<td class="text-end"><? echo $value['dcq']; if($value['price_unit'] == 1) { echo "(SCM)"; }else if($value['price_unit'] == 2){ echo "(MMBTU)"; } ?></td>
							<td class="text-end"><? echo $value['mgo']; ?></td>
							<td><? echo $value['state_name']; ?></td>
							<td><? echo $value['geo_area']; ?></td>
							<td>Priority&nbsp;<? echo $value['priority']; ?></td>
							<td class="text-center"><? echo displayDate($value['added_at']); ?></td>
							<td class="text-center"><? if($value['status'] == 1){
								?>
								<span class="status status-success status-icon-check w-95">Active</span>
							<?}else {
								?>
								<span class="status status-danger status-icon-close w-95">InActive</span>
							<?}?>
							</td>
							<td class="text-center">
								<div class="dropdown">
							  		<button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="actions_btn" data-bs-toggle="dropdown" aria-expanded="false">Actions</button>
							  		<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actions_btn" style="">
										<button type="button" class="dropdown-item" onclick="viewContract(<? echo $value['id']; ?>)"><span class="mdi mdi-account-outline"></span>&nbsp;View</button>
										<?
										// Check action access
								        if($this->userlibrary->checkAccess('cned')) {
								        	?><button type="button" class="dropdown-item" onclick="editContract(<? echo $value['id']; ?>)"><span class="mdi mdi-pencil"></span>&nbsp;Edit</button>
								        <? } ?>
										<?
										if($value['status'] == 1) {
											?><button type="submit" onclick="changeContractStatus('<? echo $value['id']; ?>',0)" class="dropdown-item"><span class="mdi mdi-close"></span>&nbsp;InActive</button><?
										}
										else {
											?><button type="submit" onclick="changeContractStatus('<? echo $value['id']; ?>',1)" class="dropdown-item"><span class="mdi mdi-check"></span>&nbsp;Active</button><?
										}
										?>
							  		</ul>
								</div>
							</td>
						</tr>
						<?
					}
				}
				else {
					?>
					<tr>
           				<td colspan="12">
           				    <div class="alert alert-warning">No records found</div>
           				</td>
       				</tr>
					<?
				}
				?>
			</tbody>
		</table>			
		</div>
	</div>
</form>
<?
if($data != '') {
	$this->load->view('alert', $data);
}
?>