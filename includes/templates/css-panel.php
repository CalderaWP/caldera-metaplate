	<textarea id="css-code-editor" class="metaplate-code-editor" data-mode="text/css" name="css[code]">{{css/code}}</textarea>
	
	{{#is _current_tab value="#metaplate-panel-css"}}
		{{#script}}
		mtpt_init_editor('css-code-editor');
		{{/script}}
	{{/is}}