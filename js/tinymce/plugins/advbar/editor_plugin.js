(function() {
	var DOM = tinymce.DOM;

	tinymce.create('tinymce.plugins.AdvBarPlugin', {
		mceTout : 0,

		init : function(ed, url) {
			var t = this, tbId = ed.getParam('adv_toolbar', 'toolbar2'), tbId2 = ed.getParam('adv_toolbar3', 'toolbar3');

			// ed.settings.adv_hidden = 0;

			// Hides the specified toolbar and resizes the iframe
			ed.onPostRender.add(function() {
				if (e = ed.controlManager.get(tbId)) DOM.hide(e.id);
				if (e = ed.controlManager.get(tbId2)) DOM.hide(e.id);
				t._resizeIframe(ed, 52);
			});

			// Register commands
			ed.addCommand('mceAdvBar', function() {
				var cm = ed.controlManager, id = cm.get(tbId).id, id2 = cm.get(tbId2).id;

				if ( 'undefined' == id )
					return;

				if ( DOM.isHidden(id) ) {
					cm.setActive('advbar', 1);
					DOM.show(id);
					DOM.show(id2);
					t._resizeIframe(ed, -52);
					// ed.settings.adv_hidden = 0;
					// setUserSetting('hidetb', '1');
				} else {
					cm.setActive('advbar', 0);
					DOM.hide(id);
					DOM.hide(id2);
					t._resizeIframe(ed, 52);
					// ed.settings.adv_hidden = 1;
					// setUserSetting('hidetb', '0');
				}
			});

			// Register buttons
			ed.addButton('advbar', {
				title : 'advbar.desc',
				image : url + '/toolbars.gif',
				cmd : 'mceAdvBar'
			});

			// Fullscreen
			ed.onBeforeExecCommand.add(function(ed, cmd, ui, val) {
				var DOM = tinymce.DOM;
				if ( 'mceFullScreen' != cmd ) return;
					ed.settings.theme_advanced_buttons1 = "bold,italic,underline,|,forecolor,backcolor,|,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,|,link,unlink,|,pastetext,pasteword,|,code,fullscreen,advbar";
					ed.settings.theme_advanced_buttons2 = "strikethrough,sub,sup,blockquote,outdent,indent,|,formatselect,styleselect,|,image,media,vfileman,charmap,anchor,advhr,pagebreak";
					ed.settings.theme_advanced_buttons3 = "tablecontrols,|,insertlayer,absolute,|,search,undo,redo,|,styleprops,attribs,removeformat";
			});
		},

		getInfo : function() {
			return {
				longname : 'Advanced Toolbar Plugin',
				author : 'advbar',
				authorurl : '',
				infourl : '',
				version : '1.0'
			};
		},

		// Resizes the iframe by a relative height value
		_resizeIframe : function(ed, dy) {
			var ifr = ed.getContentAreaContainer().firstChild;

			DOM.setStyle(ifr, 'height', ifr.clientHeight + dy); // Resize iframe
			ed.theme.deltaHeight += dy; // For resize cookie
		},

		_advbarHide : function(ed) {
			DOM.hide(ed.controlManager.get(tbId).id);
			DOM.hide(ed.controlManager.get(tbId2).id);
			t._resizeIframe(ed, 52);
		},

		_advbarShow : function(ed) {
			DOM.show(ed.controlManager.get(tbId).id);
			DOM.show(ed.controlManager.get(tbId2).id);
			t._resizeIframe(ed, -52);
		}
	});

	// Register plugin
	tinymce.PluginManager.add('advbar', tinymce.plugins.AdvBarPlugin);
})();
