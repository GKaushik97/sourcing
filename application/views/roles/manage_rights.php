<?
?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?php print _("Manage Rights"); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form name="manage_rights_form" id="manage_rights_form" method="post" onsubmit="manageRightsExt(event)">
            <input type="hidden" name="id" id="id" value="<?php print $role;?>">
            <div class="modal-body">                
                <?
                if(isset($results) && !empty($results)){
                    foreach ($results['modules'] as $mid => $actions) { ?>
                        <div class="recruit-sub-title"><h3><?php print $actions;?></h3></div>
                        <div class="row">  
                            <?
                            foreach ($results['actions'][$mid] as $key => $value) {
                                $check_class = "";
                                if(!empty($role_rights['rights'])){
                                    $rights = explode(',', $role_rights['rights']);
                                    if (in_array($value['id'], $rights)) {
                                        $check_class = "checked";
                                    }
                                }
                            
                            ?>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="rights[]" id="<?php print $value['id'];?>" value="<?php print $value['id'];?>" <?php print $check_class;?>>
                                    <label class="form-check-label" for="<?php print $value['id'];?>">
                                        <?php print $value['action_name'];?>
                                    </label>
                                </div>
                            </div>
                            <?
                            }?>
                        </div>
                    <?}
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-success"><span class="mdi mdi-check"></span><?php print _("Update");?></button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><span class="mdi mdi-close"></span><?php print _("Close");?></button>
            </div>
        </form>
    </div>
</div>
<style type="text/css">
    .recruit-sub-title h3 {
        color: #4466f2;
        font-size: 0.85rem;
    }
</style>