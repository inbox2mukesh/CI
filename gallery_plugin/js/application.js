
	var datafile = new plupload.Uploader({
		runtimes : 'html5,flash,silverlight,html4',
		
		browse_button : 'image', // you can pass in id...
		container: document.getElementById('container'), // ... or DOM Element itself
		chunk_size: '1mb', 
		url : WOSA_ADMIN_URL+'uploadfile/uploadtoserver',
		
		max_file_count: 1,
	
		//ADD FILE FILTERS HERE
		filters : {
			 mime_types: [
					{title : "Image files", extensions : "jpg,jpeg,gif,png,webp,svg,ico"},					
					{title : "Movie files", extensions : "mp4"},
					{title : "Audio files", extensions : "mp3"},
				]
			
		}, 
	
		// Flash settings
	flash_swf_url : WOSA_BASE_URL + 'public/js/plupload/Moxie.swf',
	
		// Silverlight settings
		silverlight_xap_url : WOSA_BASE_URL + 'public/js/plupload/Moxie.xap',
		 
	
		init: {
			PostInit: function() {
			 	document.getElementById('filelist').innerHTML = '';	
				
				document.getElementById('upload').onclick = function() {
				datafile.start();
					return false;
				};
			},
	
			FilesAdded: function(up, files) {
				plupload.each(files, function(file) {
					$('#submit_btn').prop('disabled', true);
					document.getElementById('image_err').innerHTML = "";
					document.getElementById('filelist').innerHTML = '<div class="text-bold" id="' + file.id + '">'+ file.name+'<span></span></div>';
				});
			},
	
			UploadProgress: function(up, file) {
				document.getElementById(file.id).getElementsByTagName('span')[0].innerHTML = '<span class="text-blue"> is Uploading...' + file.percent + "%</span>";
				if(file.percent == 100)
				{
					$('#submit_btn').prop('disabled', false);
					$('#file_hidden').val(file.name);
				}
				
			},
	
			Error: function(up, err) {
				document.getElementById('image_err').innerHTML += "\nError #: " + err.message;
			}
		}
	});
	
	datafile.init();
