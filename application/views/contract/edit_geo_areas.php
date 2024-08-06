<?php
$ga_val = isset($contract['ga']) ? $contract['ga'] : set_value('ga');
?> 
<div class="mb-3">
    <label class="form-label mb-0">Geo Area&nbsp;:</label>
    <select class="form-select form-select-sm" name="ga">
        <option value="">Select</option>
        <?
            foreach ($geo_areas as $key => $value2) {
            ?>
            <option <?if($ga_val == $value2['id']) {?> selected="selected"<?}?> value="<? echo $value2['id']; ?>"><? echo $value2['name']; ?></option>
        <?}
    ?>
    </select>
    <small class="text-danger"><? echo form_error('ga'); ?></small>
</div>