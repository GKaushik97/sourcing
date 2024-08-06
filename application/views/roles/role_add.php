<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?php print _("Add Role"); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form name="role_add_form" id="role_add_form" method="post" onsubmit="insertRole(event)">
            <div class="modal-body">
                <div class="row mb-2">
                    <label class="col-form-label col-sm-4 text-end" for="name">Role&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                    <div class="col-sm-6">
                        <input type="text" id="name" name="name" class="form-control form-control-sm" placeholder="Role" value="" />
                        <div id="add_name_alert"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-success"><span class="mdi mdi-plus"></span><?php print _("Add");?></button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><span class="mdi mdi-close"></span><?php print _("Close");?></button>
            </div>
        </form>
    </div>
</div>