<?php
(isset($msg)) ? '' : "Alert" ;
(isset($color)) ? '' : "info" ;

?>

<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>
    <div class="modal-body">
      <div class="alert alert-<?php print $color;?>">
        <?php print $msg;?>
      </div>
    </div>
  </div>
</div>