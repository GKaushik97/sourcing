<div class="mb-3">
    <label class="form-label mb-0">Geo Area&nbsp;:</label>
    <select class="form-select form-select-sm" name="ga" id="ga_ext" onchange="getContractPriority(this.value)">
        <option value="">Select</option>
        <?
        if(isset($geo_areas) and !empty($geo_areas)){
            foreach ($geo_areas as $key => $value2) {
            ?>
            <option <?if(set_value('ga') == $value2['id']) {?> selected="selected"<?}?> value="<? echo $value2['id']; ?>"><? echo $value2['name']; ?></option>
        <?}
    }?>
    </select>
    <small class="text-danger"><? echo form_error('ga'); ?></small>
</div>

 