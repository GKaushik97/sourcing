<?php
$ga_val = isset($params['ga']) ? $params['ga'] : '';
?>
<label class="form-label mb-0">Geo Area&nbsp;<span class="text-danger">*</span>:</label>
<select name="ga" id="ga" class="form-select form-select-sm" aria-label="All Geo Areas" data-live-search="true">
	<option value="">All Geo Areas</option>
	<?
	if(isset($geo_areas) and !empty($geo_areas)) {
		foreach($geo_areas as $key => $value) {
			?>
			<option <? if($ga_val == $value['id']) { echo "selected"; }?> value="<? echo $value['id']; ?>"><? echo $value['name']; ?></option>
			<?
		}
	}
	?>
</select>
<div id="ga_alert"></div>
