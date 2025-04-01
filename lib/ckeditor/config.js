/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/
CKEDITOR.dtd.$removeEmpty.span = 0;
CKEDITOR.dtd.$removeEmpty['i'] = false;
CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	//config.extraPlugins='video';
	config.extraPlugins='video,jwplayer';
	
	config.toolbar = 'Full';
	config.toolbar_Full =
	[
		['Source','-','Save','NewPage','Preview','-','Templates'],['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'], ['Form','Checkbox','Radio','TextField','Textarea','Select','Button','ImageButton','HiddenField'],['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],['BidiLtr', 'BidiRtl'],['Anchor'],['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe','Video','jwplayer'],['Styles','Format','Font','FontSize'],['TextColor','BGColor'],['Link','Unlink'],['Maximize','ShowBlocks','-','About']
	];
	 
	config.toolbar_Basic =
	[
		['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink']
	];
};
