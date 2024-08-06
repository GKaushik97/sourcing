<?php
$priorities_val = isset($priorities) ? $priorities : 1;
$edit_priority = isset($contract['priority']) ? $contract['priority'] : set_value('priority');
?>
<label class="form-label mb-0">Priority&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
<select name="priority" id="priority" class="form-select form-select-sm" >
	<option value="">Select Priority</option>
	<?
	for($i = 1; $i <= $priorities_val; $i++) {
		?><option value="<? echo $i;?>" <? if($edit_priority == $i){ ?> selected="selected"<? }?>>Priority <? echo $i; ?></option><?
	}
	?>
</select>
<small class="text-danger"><? echo form_error('priority'); ?></small>