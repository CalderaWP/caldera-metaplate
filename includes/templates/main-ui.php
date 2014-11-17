<div class="metaplate-main-header">
		<h2>
		<span id="metaplate-name-title">{{name}}</span> <span class="metaplate-subline">{{slug}}</span>
		<span class="add-new-h2 wp-baldrick" data-action="mtpt_save_config" data-load-element="#metaplate-save-indicator" data-before="mtpt_get_config_object" ><?php _e('Save Changes', 'metaplate') ; ?></span>
	</h2>
	<ul class="metaplate-header-tabs metaplate-nav-tabs">
				
		

		<li id="metaplate-save-indicator"><span style="float: none; margin: 16px 0px -5px 10px;" class="spinner"></span></li>
	</ul>
	<span class="wp-baldrick" id="metaplate-field-sync" data-event="refresh" data-target="#metaplate-main-canvas" data-callback="mtpt_canvas_init" data-type="json" data-request="#metaplate-live-config" data-template="#main-ui-template"></span>
</div>
<div class="metaplate-sub-header">
	<ul class="metaplate-sub-tabs metaplate-nav-tabs">
			<li class="{{#is _current_tab value="#metaplate-panel-general"}}active {{/is}}metaplate-nav-tab"><a href="#metaplate-panel-general"><?php _e('Setup', 'metaplate') ; ?></a></li>
		<li class="{{#is _current_tab value="#metaplate-panel-html"}}active {{/is}}metaplate-nav-tab"><a href="#metaplate-panel-html"><?php _e('Template', 'metaplate') ; ?></a></li>
		<li class="{{#is _current_tab value="#metaplate-panel-css"}}active {{/is}}metaplate-nav-tab"><a href="#metaplate-panel-css"><?php _e('CSS', 'metaplate') ; ?></a></li>
		<li class="{{#is _current_tab value="#metaplate-panel-js"}}active {{/is}}metaplate-nav-tab"><a href="#metaplate-panel-js"><?php _e('Javascript', 'metaplate') ; ?></a></li>

	</ul>
</div>

<form id="metaplate-main-form" action="?page=metaplate" method="POST">
	<?php wp_nonce_field( 'metaplate', 'metaplate-setup' ); ?>
	<input type="hidden" value="{{id}}" name="id" id="metaplate-id">
	<input type="hidden" value="{{_current_tab}}" name="_current_tab" id="metaplate-active-tab">

		<div id="metaplate-panel-general" class="metaplate-editor-panel" {{#if _current_tab}}{{#is _current_tab value="#metaplate-panel-general"}}{{else}} style="display:none;" {{/is}}{{/if}}>
		<h4><?php _e( 'Metaplate Setup & Settings', 'metaplate' ); ?> <small class="description"><?php _e( 'Setup', 'metaplate' ); ?></small></h4>
		<?php
		// pull in the general settings template
		include MTPT_PATH . 'includes/templates/general-settings.php';
		?>
	</div>	<div id="metaplate-panel-html" class="metaplate-editor-panel" {{#is _current_tab value="#metaplate-panel-html"}}{{else}} style="display:none;" {{/is}}>		
		<h4><?php _e('Frontend HTML', 'metaplate') ; ?> <small class="description"><?php _e('Template', 'metaplate') ; ?></small></h4>
		<?php
		// pull in the general settings template
		include MTPT_PATH . 'includes/templates/html-panel.php';
		?>
	</div>	<div id="metaplate-panel-css" class="metaplate-editor-panel" {{#is _current_tab value="#metaplate-panel-css"}}{{else}} style="display:none;" {{/is}}>		
		<h4><?php _e('Custom Styles', 'metaplate') ; ?> <small class="description"><?php _e('CSS', 'metaplate') ; ?></small></h4>
		<?php
		// pull in the general settings template
		include MTPT_PATH . 'includes/templates/css-panel.php';
		?>
	</div>	<div id="metaplate-panel-js" class="metaplate-editor-panel" {{#is _current_tab value="#metaplate-panel-js"}}{{else}} style="display:none;" {{/is}}>		
		<h4><?php _e('Custom Scripts', 'metaplate') ; ?> <small class="description"><?php _e('Javascript', 'metaplate') ; ?></small></h4>
		<?php
		// pull in the general settings template
		include MTPT_PATH . 'includes/templates/js-panel.php';
		?>
	</div>

		

</form>

{{#unless _current_tab}}
	{{#script}}
		jQuery(function($){
			$('.metaplate-nav-tab').first().find('a').trigger('click');
		});
	{{/script}}
{{/unless}}