
<div class="alert_data alert alert-<?php ($color) ? print $color : print "info";?> alert-autocloseable-<?php ($color) ? print $color : print "info";?> alert-position alert-dismissible" id="alert_data">
 	<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <?php
  if (isset($complaint_number) and !empty($complaint_number)) {
  	print $msg.$complaint_number;
  }
  else {
  	print $msg;
  }
  ?>
</div>

<script type="text/javascript">
  $('.alert_data').delay(10000).fadeOut( "slow", function() {
    // Animation complete.
    $('#alert_data-btn-success').prop("disabled", false);
  });
</script>