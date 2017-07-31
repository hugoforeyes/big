(function() {
	tinymce.create('tinymce.plugins.vFileManPlugin', {

		init : function(ed, url) {
			// Register commands
			ed.addCommand('mceFileMan', function() {
				ed.execCallback('vfileman_callback');
			});

			// Register buttons
			ed.addButton('vfileman', {
				title : 'vfileman.desc',
				image : url + '/fileman.gif',
				cmd : 'mceFileMan'
			});
		},

		getInfo : function() {
			return {
				longname : 'Files/Images Manager',
				author : 'Vipcom',
				authorurl : 'http://www.vipcom.vn',
				infourl : 'http://www.vfileman.com',
				version : '1.0'
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('vfileman', tinymce.plugins.vFileManPlugin);
})();
