<?php
/**
 * Module Actions list
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
				<input type="text" class="form-control form-control-sm" id="keywords" name="keywords" placeholder="Action Name, Code" title="Name" value="<? print $keywords;?>" >
			</div>
			<div class="me-1">
				<a class="btn btn-success btn-sm" id="search" onclick="moduleActionsBody('<? print $rows;?>', '1', '<? print $sortby;?>', '<? print $sort_order;?>')" title="search">
					<i class="mdi mdi-magnify"></i>
				</a>
				<a class="btn btn-warning btn-sm" onclick="resetModuleActionsBody()" title="Reset">
					<i class="mdi mdi-refresh"></i>
				</a>
			</div>
			<div class="me-1">
				<strong><? print '(' . $tRecords . ' ' . _("Records") .')';?></strong>
			</div>
		</div>
		<div class="float-end d-flex align-items-center">
			<div class="me-1">
		        <a class="btn btn-sm btn-success" href="javascript:addModuleAction()">
		          	<span class="mdi mdi-plus"></span>&nbsp;<? print _("Add Module Action");?>
		        </a>
		    </div>
			<?
			if(isset($module_actions) && $module_actions) {
				?>
				<div id="pager-show" class="d-flex align-items-center">
					<div class="me-1">
						<select class="form-select form-select-sm" name="rows" onchange="moduleActionsBody(this.value, '1', '<? print $sortby;?>', '<? print $sort_order;?>')" >
							<option value="10" <? if ($rows == 10) print 'selected="selected"';?> >10 Records</option>
							<option value="20" <? if ($rows == 20) print 'selected="selected"';?> >20 Records</option>
							<option value="50" <? if ($rows == 50) print 'selected="selected"';?> >50 Records</option>
							<option value="100" <? if ($rows == 100) print 'selected="selected"';?> >100 Records</option>
							<option value="1000" <? if ($rows == 1000) print 'selected="selected"';?> >1000 Records</option>
						</select>
					</div>
					<div class="me-0">
						<nav aria-label="Page navigation">
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
                                    <li class="page-item"><a class="page-link pagination-pad" href="javascript:void(0);"  onclick="moduleActionsBody('<? print $rows;?>', '1', '<? print $sortby;?>', '<? print $sort_order;?>')"><i class="mdi mdi-chevron-double-left"></i></a></li>
                                    <li class="page-item"><a class="page-link pagination-pad" href="javascript:void(0);" onclick="moduleActionsBody('<? print $rows;?>', '<? print $pageno-1;?>', '<? print $sortby;?>', '<? print $sort_order;?>')"><i class="mdi mdi-chevron-left"></i></a></li>
                                    <?
                                }
                                ?>
                                <li class="page-item active select-pagination" aria-current="page">
                                  <span class="page-link">
                                    <select class="form-select form-select-sm" name="rows" onchange="moduleActionsBody('<? print $rows;?>', this.value, '<? print $sortby;?>', '<? print $sort_order;?>')">
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
                                    <li class="page-item disabled"><a class="page-link pagination-pad" href="javascript:void(0);"><i class="mdi mdi-chevron-right"></i></a></li>
                                    <li class="page-item disabled"><a class="page-link pagination-pad" href="javascript:void(0);"><i class="mdi mdi-chevron-double-right"></i></a></li>
                                    <?
                                }
                                else {
                                	?>
                                	<li class="page-item"><a class="page-link pagination-pad" href="javascript:void(0);" onclick="moduleActionsBody('<? print $rows;?>', '<? print $pageno+1;?>', '<? print $sortby;?>', '<? print $sort_order;?>')"><i class="mdi mdi-chevron-right"></i></a></li>
                                    <li class="page-item"><a class="page-link pagination-pad" href="javascript:void(0);" onclick="moduleActionsBody('<? print $rows;?>', '<? print $total_pages;?>', '<? print $sortby;?>', '<? print $sort_order;?>')"><i class="mdi mdi-chevron-double-right" ></i></a></li>
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
					<? if ($sortby == 'module_id')  print $arrow; ?>
					<a href="javascript:void(0)" onclick="moduleActionsBody('<? print $rows;?>', '1', 'module_id', '<? print $sort_order_alt;?>')">Module</a>
				</th>
				<th nowrap>
					<? if ($sortby == 'action_name')  print $arrow; ?>
					<a href="javascript:void(0)" onclick="moduleActionsBody('<? print $rows;?>', '1', 'action_name', '<? print $sort_order_alt;?>')">Action Name</a>
				</th>
				<th nowrap>
					<? if ($sortby == 'action_code')  print $arrow; ?>
					<a href="javascript:void(0)" onclick="moduleActionsBody('<? print $rows;?>', '1', 'action_code', '<? print $sort_order_alt;?>')">Action Code</a>
				</th>
				<th nowrap>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?
			if ($module_actions) {
				foreach ($module_actions as $id => $value) {
					?>
					<tr>
						<td width="1%" class="text-center"><? print $i++;?></td>
						<td><? print $value['module'];?></td>
						<td><? print $value['action_name'];?></td>
						<td><? print $value['action_code'];?></td>
						<td>
							<button class="btn btn-sm btn-primary" onclick="editModuleAction(<?php print $value['id'];?>)"><span class="mdi mdi-pencil">&nbsp;</span><?php print _("Edit");?>
                			</button>
						</td>
					</tr>
					<?
				}
			}
			else {
				?>
				<tr>
					<td colspan="5">
						<div class="alert alert-warning">No records found</div>
					</td>
				</tr>
				<?
			}
			?>
		</tbody>
	</table>
</div>