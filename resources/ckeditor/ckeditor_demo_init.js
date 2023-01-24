	//CKEDITOR.config.removeButtons = 'Underline,Subscript,Superscript';
	CKEDITOR.config.allowedContent = true;
	CKEDITOR.config.extraAllowedContent = 'i[*]';
	CKEDITOR.config.protectedSource.push(/<i[^>]*><\/i>/g);
	CKEDITOR.env.isCompatible = true;
CKEDITOR.replaceAll('editor-instance'); // important