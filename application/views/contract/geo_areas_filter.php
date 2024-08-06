<?php
$ga_val = isset($params['geo_area']) ? $params['geo_area'] : '';
?>
<select name="geo_area" id="ga" class="form-select form-select-sm">
	<option value="">GeoAreas</option>
	<?
	if(isset($geo_areas) and !empty($geo_areas)) {
		foreach($geo_areas as $key=>$value) {
		?>
		<option <? if($ga_val == $value['id']) { echo "selected"; }?> value="<? echo $value['id']; ?>"><? echo $value['name']; ?></option>
	<?}
	}?>
</select>