<?php

$metaplate = get_option( $_GET['edit'] );

?>
<div class="wrap" id="metaplate-main-canvas">
	<span class="wp-baldrick spinner" style="float: none; display: block;" data-target="#metaplate-main-canvas" data-callback="mtpt_canvas_init" data-type="json" data-request="#metaplate-live-config" data-event="click" data-template="#main-ui-template" data-autoload="true"></span>
</div>

<div class="clear"></div>

<input type="hidden" class="clear" autocomplete="off" id="metaplate-live-config" style="width:100%;" value="<?php echo esc_attr( json_encode($metaplate) ); ?>">

<script type="text/html" id="main-ui-template">
	<?php
	// pull in the join table card template
	include MTPT_PATH . 'includes/templates/main-ui.php';
	?>	
</script>





