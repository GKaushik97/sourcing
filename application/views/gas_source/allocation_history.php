<?php
$date1 = date('d-m-Y');
$date2 = date('d-m-Y',strtotime('-15 days'));
$begin = new DateTime($date1);
$end = new DateTime($date2);
if (isset($allocation_history)) {
	$contracts = $details = $dates = array();
	if (!empty($allocation_history)) {
		foreach ($allocation_history as $result) {
			$contracts[$result['id']] = $result['name'];
			$dates[date('d-m-Y',strtotime($result['source_date']))] = $result['source_date'];
			$details[date('d-m-Y',strtotime($result['source_date']))][$result['id']] = $result;
		}
		?>
		<div>
			<h4>Nomination & Allocation History</h4>
		</div>
		<div class="mt-2">
			<div class="table-responsive th-virticle-middle">
				<table class="table table-bordered table-hover table-striped table-condensed">
					<thead>
						<tr class="table-secondary">
							<th class="text-center" rowspan="3" width="1%">S.No</th>
							<th rowspan="3">Date</th>
							<? if(isset($contracts) && !empty($contracts)){
								foreach ($contracts as $cid => $value) {
									?><th colspan="4" class="text-center"><?php print $value;?></th><?
								}
							}
							?>
						</tr>
						<tr class="table-secondary">
							<? if(isset($contracts) && !empty($contracts)){
								foreach ($contracts as $cid => $value) {
									?><th colspan="2" class="text-center">Nomination</th><th colspan="2" class="text-center">Allocation</th><?
								}
							}
							?>
						</tr>
						<tr class="table-secondary">
							<? if(isset($contracts) && !empty($contracts)){
								foreach ($contracts as $cid => $value) {
									?><th class="text-end">SCM</th><th class="text-end">MMBTU</th><?
									?><th class="text-end">SCM</th><th class="text-end">MMBTU</th><?
								}
							}
							?>
						</tr>
					</thead>
					<tbody>
						<?
						$i=1;
						for($j = $begin; $j > $end; $j->modify('-1 day')){
							$date = $j->format("d-m-Y");
							?>
							<tr>
								<td class="text-center"><?php print $i++;?></td>
								<td><?php print $date;?></td>
								<? if(isset($contracts) && !empty($contracts)){
									foreach ($contracts as $cid => $value) { 
										$gcv = isset($details[$date][$cid]['gcv']) ? $details[$date][$cid]['gcv'] : 0 ;
										$nom_scm = $nom_mmbtu = $allo_scm = $allo_mmbtu = '0';
										if(isset($details[$date][$cid]['nomination_unit'])){
											if(($details[$date][$cid]['nomination_unit']) == 1){
												$nom_scm = $details[$date][$cid]['nomination_qty'];
												$nom_mmbtu = round(convertToMmbtu($details[$date][$cid]['nomination_qty'],$gcv),2);
											}
											else if($details[$date][$cid]['nomination_unit'] == 2){
												$nom_mmbtu = $details[$date][$cid]['nomination_qty'];
												$nom_scm = round(convertToScm($details[$date][$cid]['nomination_qty'],$gcv),2);
											}
										}
										//
										if(isset($details[$date][$cid]['allocation_unit'])){
											if(($details[$date][$cid]['allocation_unit']) == 1){
												$allo_scm = $details[$date][$cid]['allocation_qty'];
												$allo_mmbtu = round(convertToMmbtu($details[$date][$cid]['allocation_qty'],$gcv),2);
											}
											else if($details[$date][$cid]['allocation_unit'] == 2){
												$allo_mmbtu = $details[$date][$cid]['allocation_qty'];
												$allo_scm = round(convertToScm($details[$date][$cid]['allocation_qty'],$gcv),2);
											}
										}

										?>
										<td class="text-end"><?php print displayNumber($nom_scm,2);?></td>
										<td class="text-end"><?php print displayNumber($nom_mmbtu,2);?></td>
										<td class="text-end"><?php print displayNumber($allo_scm,2);?></td>
										<td class="text-end"><?php print displayNumber($allo_mmbtu,2);?></td>
										<?
									}
								}
								?>
							</tr>
							<?
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	<? }else {
		?>
		<tr>
			<td colspan="9">
			    <div class="alert alert-warning">No History Found</div>
			</td>
		</tr>
	<?}
}
?>