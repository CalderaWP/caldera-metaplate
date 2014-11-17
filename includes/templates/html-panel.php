	<textarea id="html-code-editor" class="metaplate-code-editor" data-mode="text/html" name="html[code]">{{html/code}}</textarea>
	
	{{#is _current_tab value="#metaplate-panel-html"}}
		{{#script}}
		mtpt_init_editor('html-code-editor');
		{{/script}}
	{{/is}}