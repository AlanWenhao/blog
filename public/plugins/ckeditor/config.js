/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.extraPlugins = "youtube,jqueryspellchecker";
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config
	
	config.toolbar = [
	  	{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
	  	{ name: 'editing', groups: [ 'find', 'selection'], items: [ 'Find', 'Replace', '-', 'SelectAll' ] },
	  	
	  	{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
	  	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline'] },
	  	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
	  	{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
	  	{ name: 'insert', items: ['jqueryspellchecker', 'Youtube','Image', 'Flash', 'Iframe' ] },
	  	{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
	  	{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
	  	{ name: 'spellcheck', items: [ 'jQuerySpellChecker' ]},
	  	{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
	  	{ name: 'others', items: [ '-' ] },
	];

	config.contentsCss = '/public/plugins/ckeditor/plugins/jqueryspellchecker/dist/css/jquery.spellchecker.css';
	
	config.language = 'en';
	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	config.removeButtons = 'Subscript,Superscript,Table,SpecialChar,HorizontalRule,Maximize,Blockquote';

	// Se the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Make dialogs simpler.
	config.removeDialogTabs = 'image:advanced;link:advanced';
	
	config.height = '350px'; 
};
