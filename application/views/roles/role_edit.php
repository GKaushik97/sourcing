<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?php print _("Edit Role"); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form name="role_edit_form" id="role_edit_form" method="post" onsubmit="updateRole(event)">
            <div class="modal-body">
                <div class="row mb-2">
                    <label class="col-form-label col-sm-4 text-end" for="id">Role&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-6">
                        <input type="hidden" name="id" id="id" value="<?php print $role['id'];?>">
                        <input type="text" id="name" name="name" class="form-control form-control-sm" placeholder="Role" value="<?php print $role['name'];?>" />
                        <div id="edit_name_alert"></div>                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-success"><span class="mdi mdi-check"></span><?php print _("Update");?></button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><span class="mdi mdi-close"></span><?php print _("Close");?></button>
            </div>
        </form>
    </div>
</div>