<div class="modal-dialog meghaModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?php print _("Edit Module Action"); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form name="module_action_edit_form" id="module_action_edit_form" method="post" onsubmit="updateModuleAction(event)">
            <input type="hidden" name="id" id="id" value="<?php print $module_action['id'];?>">
            <div class="modal-body">
                <div class="row mb-2">
                    <label class="col-form-label col-sm-4 text-end" for="name">Module&nbsp;:&nbsp;<span class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <select class="form-control form-control-sm" id="module_id" name="module_id">
                            <option value="">All</option>
                            <?
                            if(isset($modules) && !empty($modules)){
                                foreach ($modules as $key => $value) { ?>
                                    <option value="<?php print $value['id'];?>" <? if ($module_action['module_id'] == $value['id']) print 'selected="selected"';?>><?php print $value['name'];?></option>
                                    <?
                                }
                            }
                            ?>
                        </select>
                        <div id="module_alert"></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-form-label col-sm-4 text-end" for="name">Action Name&nbsp;:&nbsp;<span class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <input type="text" id="action_name" name="action_name" class="form-control form-control-sm" placeholder="Action Name" value="<?php print $module_action['action_name'];?>" />
                        <div id="name_alert"></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-form-label col-sm-4 text-end" for="name">Action Code&nbsp;:&nbsp;<span class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <input type="text" id="action_code" name="action_code" class="form-control form-control-sm" placeholder="Action Code" value="<?php print $module_action['action_code'];?>" />
                        <div id="code_alert"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-success"><span class="mdi mdi-check"></span>&nbsp;<?php print _("Update");?></button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><span class="mdi mdi-close"></span>&nbsp;<?php print _("Close");?></button>
            </div>
        </form>
    </div>
</div>