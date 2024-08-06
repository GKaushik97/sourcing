<?php
/**
 * Roles list
 * Table view
 */

$arrow = ($params['sort_order']=='desc')?'&nbsp;<i class="fa fa-caret-down"></i>':'&nbsp;<i class="fa fa-caret-up"></i>';
$sort_order_alt = ($params['sort_order']=='desc')? "asc":"desc";
$sortby = $params['sortby'];
$rows = $params['rows'];
$tRecords = $params['tRecords'];
$sort_order = $params['sort_order'];
$pageno = $params['pageno'];
$total_pages = ceil($tRecords/$rows);
$i = $params['rows']*($params['pageno'] - 1) + 1;
//
$keywords = (isset($params['keywords'])) ? $params['keywords'] : "" ;
?>
<!--home-content-top starts from here-->
<form method="post" onsubmit="return false">
	<div class="clearfix mb-2">
		<div class="float-start d-flex align-items-center">
			<div class="me-1">
				<input type="text" class="form-control form-control-sm" id="keywords" name="keywords" placeholder="Name" title="Name" value="<? print $keywords;?>" >
			</div>
			<div class="me-1">
				<a class="btn btn-success btn-sm" id="search" onclick="rolesBody('<? print $rows;?>', '1', '<? print $sortby;?>', '<? print $sort_order;?>')" title="search">
					<i class="mdi mdi-magnify"></i>
				</a>
				<a class="btn btn-warning btn-sm" onclick="resetRolesBody()" title="Reset">
					<i class="mdi mdi-refresh"></i>
				</a>
			</div>
			<div class="me-1">
				<strong><? print '(' . $tRecords . ' ' . _("Records") .')';?></strong>
			</div>
		</div>
		<div class="float-end d-flex align-items-center">
			<div class="me-1">
		        <a class="btn btn-sm btn-success" href="javascript:addRole()">
		          	<span class="mdi mdi-plus"></span>&nbsp;<? print _("Add Role");?>
		        </a>
		    </div>
			<?
			if(isset($roles) && $roles) {
				?>
				<div id="pager-show" class="d-flex align-items-center">
					<div class="me-1">
						<select class="form-select form-select-sm" name="rows" onchange="rolesBody(this.value, '1', '<? print $sortby;?>', '<? print $sort_order;?>')" >
							<option value="10" <? if ($rows == 10) print 'selected="selected"';?> >10 Records</option>
							<option value="20" <? if ($rows == 20) print 'selected="selected"';?> >20 Records</option>
							<option value="50" <? if ($rows == 50) print 'selected="selected"';?> >50 Records</option>
							<option value="100" <? if ($rows == 100) print 'selected="selected"';?> >100 Records</option>
							<option value="1000" <? if ($rows == 1000) print 'selected="selected"';?> >1000 Records</option>
						</select>
					</div>
					<div class="me-0">
						<nav aria-label="Page navigation example">
                            <ul class="pagination pagination-sm mb-0">
                                <?
                                if ($pageno == 1) {
                                	?>
                                	<li class="page-item disabled"><a href="javascript:void(0);" class="page-link pagination-pad"><i class="mdi mdi-chevron-double-left"></i></a></li>
                                    <li class="page-item disabled"><a class="page-link pagination-pad" href="javascript:void(0);"><i class="mdi mdi-chevron-left"></i></a></li>
                                    <?
                                }
                                else {
                                    ?>
                                    <li class="page-item"><a class="page-link pagination-pad" href="javascript:void(0);"  onclick="rolesBody('<? print $rows;?>', '1', '<? print $sortby;?>', '<? print $sort_order;?>')"><i class="mdi mdi-chevron-double-left"></i></a></li>
                                    <li class="page-item"><a class="page-link pagination-pad" href="javascript:void(0);" onclick="rolesBody('<? print $rows;?>', '<? print $pageno-1;?>', '<? print $sortby;?>', '<? print $sort_order;?>')"><i class="mdi mdi-chevron-left"></i></a></li>
                                    <?
                                }
                                ?>
                                <li class="page-item active select-pagination" aria-current="page">
                                  <span class="page-link">
                                    <select class="form-select form-select-sm" name="rows" onchange="rolesBody('<? print $rows;?>', this.value, '<? print $sortby;?>', '<? print $sort_order;?>')">
                                        <?
                                        for ($pg = 1; $pg <= $total_pages; $pg++) {
                                        	?>
                                            <option value="<? print $pg?>" <? if ($pg == $pageno) print 'selected="selected"';?> >
                                                <?/*php print $pg . '/' . $total_pages;*/?>
                                                <? print $pageno . '/' . $total_pages;?>
                                            </option>
                                        	<?
                                        }
                                        ?>
                                    </select>
                                  </span>
                                </li>
                                <?
                                if ($pageno == $total_pages) {
                                    ?>
                                    <li class="page-item disabled"><a class="page-link pagination-pad disabled" href="javascript:void(0);"><i class="mdi mdi-chevron-right"></i></a></li>
                                    <li class="page-item disabled"><a class="page-link pagination-pad disabled" href="javascript:void(0);"><i class="mdi mdi-chevron-double-right"></i></a></li>
                                    <?
                                }
                                else {
                                	?>
                                	<li class="page-item"><a class="page-link pagination-pad" href="javascript:void(0);" onclick="rolesBody('<? print $rows;?>', '<? print $pageno+1;?>', '<? print $sortby;?>', '<? print $sort_order;?>')"><i class="mdi mdi-chevron-right"></i></a></li>
                                    <li class="page-item"><a class="page-link pagination-pad" href="javascript:void(0);" onclick="rolesBody('<? print $rows;?>', '<? print $total_pages;?>', '<? print $sortby;?>', '<? print $sort_order;?>')"><i class="mdi mdi-chevron-double-right" ></i></a></li>
                                    <?
                                }
                                ?>
                            </ul>
                        </nav>
					</div>
				</div>
				<?
			}
			?>
			</div>
	</div>
</form>
<div class="table-responsive">
	<table class="table table-bordered table-hover table-striped table-condensed">
		<thead>
			<tr class="table-secondary">
				<th width="1%" class="text-center">S.No.</th>
				<th nowrap>
					<? if ($sortby == 'name')  print $arrow; ?>
					<a href="javascript:void(0)" onclick="rolesBody('<? print $rows;?>', '1', 'name', '<? print $sort_order_alt;?>')">Name</a>
				</th>
				<th nowrap class="text-center">
					<? if ($sortby == 'status')  print $arrow; ?>
					<a href="javascript:void(0)" onclick="rolesBody('<? print $rows;?>', '1', 'status', '<? print $sort_order_alt;?>')">Status</a>
				</th>
				<th nowrap>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?
			if ($roles) {
				foreach ($roles as $id => $value) {
					?>
					<tr>
						<td width="1%" class="text-center"><? print $i++;?></td>
						<td><? print $value['name'];?></td>
						<td class="text-center">
							<?
							switch ($value['status']){
								case '0': print '<span class="status status-danger status-icon-close w-95">Disabled</span>'; break;
								case '1': print '<span class="status status-success status-icon-check w-95">Enabled</span>'; break;
								default: break;
							}
							?>
						</td>
						<td>
							<? if($value['id'] > 2){ ?>
								<button class="btn btn-sm btn-primary" onclick="editRole(<?php print $value['id'];?>)"><span class="mdi mdi-pencil">&nbsp;</span><?php print _("Edit");?>
	                			</button>
	                			<?php if($value['status'] == 1){ ?>
				                <button type="button" class="btn btn-sm btn-warning" id="status_btn<?php print $value['id'];?>" onclick="updateRoleStatus(<?php print $value['id'];?>,<?php print $value['status'];?>)"><span class="mdi mdi-close">&nbsp;</span><?php print _("Disable");?>
				                </button>
				                <?php }
				                else{ ?>
				                <button type="button" class="btn btn-sm btn-success" id="status_btn<?php print $value['id'];?>" onclick="updateRoleStatus(<?php print $value['id'];?>,<?php print $value['status'];?>)"><span class="mdi mdi-check">&nbsp;</span><?php print _("Enable");?>
				                </button>
				                <?php } ?>
	                			<button class="btn btn-sm btn-info" onclick="manageRights(<?php print $value['id'];?>)"><span class="mdi mdi-cog-outline">&nbsp;</span><?php print _("Manage Rights");?>
	                			</button>
	                		<? }
	                		else {
	                			print "All Rights";
	                		} 
	                		?>
						</td>
					</tr>
					<?
				}
			}
			else {
				?>
				<tr>
					<td colspan="3">
						<div class="alert alert-warning" role="alert">No records found</div>
					</td>
				</tr>
				<?
			}
			?>
		</tbody>
	</table>
</div>