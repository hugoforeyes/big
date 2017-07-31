<link rel="stylesheet" type="text/css" href="{URL_JS}file/file.css" media="screen" />
<script type="text/javascript" src="{URL_JS}file/upload.js"></script>
<script type="text/javascript" src="{URL_JS}file/swfobject.js"></script>
<script type="text/javascript" src="{URL_JS}file/file.js"></script>
<script type="text/javascript" src="{URL_JS}file/player/flowplayer-3.2.6.min.js"></script>

<!-- BLOCK plugin -->
<script type="text/javascript" src="{URL_JS}tinymce/tiny_mce_popup.js"></script>
<script type="text/javascript">
var FileBrowserDialogue = function () {
	var URL = $("#preview .img img").attr("src");
	var win = tinyMCEPopup.getWindowArg("window");
	// insert information now
	win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;

	// are we an image browser
	if (typeof(win.ImageDialog) != "undefined") {
		// we are, so update image dimensions...
		if (win.ImageDialog.getImageData) win.ImageDialog.getImageData();
		// ... and preview if necessary
		if (win.ImageDialog.showPreviewImage) win.ImageDialog.showPreviewImage(URL);
	}
	// close popup window
	tinyMCEPopup.close();
}
</script>
<!-- END plugin -->

<!-- BLOCK editor -->
<script type="text/javascript" src="{URL_JS}tinymce/tiny_mce_popup.js"></script>
<!-- END editor -->

<div id="uploader"></div>

<script type="text/javascript">
$(document).ready( function() {
	$('#uploader').pluploadQueue({
		url: '{U_FILEMAN}',
		upload: '{U_UPLOAD}',
		path: '{URL_JS}file/',
		option:{
			//runtimes : 'html5,flash',
			max_file_size : '{MAX_SIZE}',
			chunk_size : '{CHUNK_SIZE}',
			filters : [{title : "Uploadable files", extensions : "{LST_EXT}"}],
			unique_names : false
		}
	});
});
</script>