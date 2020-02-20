(function() {
	tinymce.create('tinymce.plugins.galleria', {
		init : function(ed, url) {
			var elem = url.split('/');
			var str = '';
			for (var i = 0; i < elem.length-1; i++) {
				str += elem[i] + '/';
			}
			ed.addCommand('frmgalleria', function() {
				ed.windowManager.open({
					title : 'Galleria ItaliaWP child',
					file : url + '/BottoneGallerie.php',
					width : 300,
					height : 100,
					inline : 1
				});
			});
			ed.addButton('ItaWPgalleria', {
				title : 'Galleria ItaliaWP child',
				image : str+'img/itwpgalleria.png',
				cmd   : 'frmgalleria'
			});
		},
		createControl : function() {
			return null;
		}
	});
	tinymce.PluginManager.add('ItaWPgalleria', tinymce.plugins.galleria);
})();