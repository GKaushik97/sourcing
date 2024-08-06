<?php
(isset($msg)) ? '' : "Alert" ;
(isset($color)) ? '' : "info" ;
?>
<div class="modal-dialog">
	<div class="modal-content">

		<div class="modal-header">
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

		<div class="modal-body">
			<div class="alert alert-<?php print $color;?>">
				<?php print $msg;?>
			</div>
		</div>
		
	</div>
</div>