	<textarea id="js-code-editor" class="metaplate-code-editor" data-mode="text/javascript" name="js[code]">{{js/code}}</textarea>
	
	{{#is _current_tab value="#metaplate-panel-js"}}
		{{#script}}
		mtpt_init_editor('js-code-editor');
		{{/script}}
	{{/is}}