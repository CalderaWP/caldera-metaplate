<div class="wrap">
	<div class="metaplate-main-header">
		<h2>
			<?php _e( 'Metaplate', 'metaplate' ); ?> <span class="metaplate-version"><?php echo MTPT_VER; ?></span>
			<span class="add-new-h2 wp-baldrick" data-modal="new-metaplate" data-modal-height="192" data-modal-width="402" data-modal-buttons='<?php _e( 'Create Metaplate', 'metaplate' ); ?>|{"data-action":"mtpt_create_metaplate","data-before":"mtpt_create_new_metaplate", "data-callback": "bds_redirect_to_metaplate"}' data-modal-title="<?php _e('New Metaplate', 'metaplate') ; ?>" data-request="#new-metaplate-form"><?php _e('Add New', 'metaplate') ; ?></span>
		</h2>
	</div>

<?php

	$metaplates = get_option('_metaplates_registry');
	if( empty( $metaplates ) ){
		$metaplates = array();
	}
	global $wpdb;
	
	foreach( $metaplates as $metaplate_id => $metaplate ){
		$metaplate = get_option( $metaplate['id'] );
		if( !empty( $metaplate['post_type'] ) ){
			$post_types = implode(', ', array_keys( $metaplate['post_type'] ) );
		}else{
			$post_types = __( 'Disabled. (Not setup for any post types)', 'metaplate' );
		}
?>

	<div class="metaplate-card-item" id="metaplate-<?php echo $metaplate['id']; ?>">
		<span class="dashicons dashicons-media-code metaplate-card-icon"></span>
		<div class="metaplate-card-content">
			<h4><?php echo $metaplate['name']; ?></h4>
			<div class="description"><?php echo $post_types; ?></div>
			<br>
			<div class="metaplate-card-actions">
				<div class="row-actions">
					<span class="edit"><a href="?page=metaplate&amp;edit=<?php echo $metaplate['id']; ?>"><?php _e( 'Edit', 'metaplate' ); ?></a> | </span>
					<span class="trash confirm"><a href="?page=metaplate&amp;delete=<?php echo $metaplate['id']; ?>" data-block="<?php echo $metaplate['id']; ?>" class="submitdelete"><?php _e( 'Delete', 'metaplate' ); ?></a></span>
				</div>
				<div class="row-actions" style="display:none;">
					<span class="trash"><a class="wp-baldrick" style="cursor:pointer;" data-action="mtpt_delete_metaplate" data-callback="mtpt_remove_deleted" data-block="<?php echo $metaplate['id']; ?>" class="submitdelete"><?php _e( 'Confirm Delete', 'metaplate' ); ?></a> | </span>
					<span class="edit confirm"><a href="?page=metaplate&amp;edit=<?php echo $metaplate['id']; ?>"><?php _e( 'Cancel', 'metaplate' ); ?></a></span>
				</div>
			</div>
		</div>
	</div>

	<?php } ?>

</div>
<div class="clear"></div>
<script type="text/javascript">
	
	function mtpt_create_new_metaplate(el){
		var metaplate 	= jQuery(el),
			name 	= jQuery("#new-metaplate-name"),
			slug 	= jQuery('#new-metaplate-slug');

		if( slug.val().length === 0 ){
			name.focus();
			return false;
		}
		if( slug.val().length === 0 ){
			slug.focus();
			return false;
		}

		metaplate.data('name', name.val() ).data('slug', slug.val() ); 

	}

	function bds_redirect_to_metaplate(obj){
		
		if( obj.data.success ){

			obj.params.trigger.prop('disabled', true).html('<?php _e('Loading Metaplate', 'metaplate'); ?>');
			window.location = '?page=metaplate&edit=' + obj.data.data.id;

		}else{

			jQuery('#new-block-slug').focus().select();
			
		}
	}
	function mtpt_remove_deleted(obj){

		if( obj.data.success ){
			jQuery( '#metaplate-' + obj.data.data.block ).fadeOut(function(){
				jQuery(this).remove();
			});
		}else{
			alert('<?php echo __('Sorry, something went wrong. Try again.', 'metaplate'); ?>');
		}


	}
</script>
<script type="text/html" id="new-metaplate-form">
	<div class="metaplate-config-group">
		<label style="width: 90px;"><?php _e('Name', 'metaplate'); ?></label>
		<input type="text" name="name" id="new-metaplate-name" data-sync="#new-metaplate-slug" autocomplete="off" style="width: 280px;">
	</div>
	<div class="metaplate-config-group">
		<label style="width: 90px;"><?php _e('Slug', 'metaplate'); ?></label>
		<input type="text" name="slug" id="new-metaplate-slug" data-format="slug" autocomplete="off" style="width: 280px;">
	</div>

</script>