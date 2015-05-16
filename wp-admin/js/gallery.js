<<<<<<< HEAD
jQuery(document).ready(function($) {
	var gallerySortable, gallerySortableInit, w, desc = false;
=======
/* global unescape, getUserSetting, setUserSetting */

jQuery(document).ready(function($) {
	var gallerySortable, gallerySortableInit, sortIt, clearAll, w, desc = false;
>>>>>>> WPHome/master

	gallerySortableInit = function() {
		gallerySortable = $('#media-items').sortable( {
			items: 'div.media-item',
			placeholder: 'sorthelper',
			axis: 'y',
			distance: 2,
			handle: 'div.filename',
<<<<<<< HEAD
			stop: function(e, ui) {
=======
			stop: function() {
>>>>>>> WPHome/master
				// When an update has occurred, adjust the order for each item
				var all = $('#media-items').sortable('toArray'), len = all.length;
				$.each(all, function(i, id) {
					var order = desc ? (len - i) : (1 + i);
					$('#' + id + ' .menu_order input').val(order);
				});
			}
		} );
<<<<<<< HEAD
	}
=======
	};
>>>>>>> WPHome/master

	sortIt = function() {
		var all = $('.menu_order_input'), len = all.length;
		all.each(function(i){
			var order = desc ? (len - i) : (1 + i);
			$(this).val(order);
		});
<<<<<<< HEAD
	}

	clearAll = function(c) {
		c = c || 0;
		$('.menu_order_input').each(function(){
			if ( this.value == '0' || c ) this.value = '';
		});
	}

	$('#asc').click(function(){desc = false; sortIt(); return false;});
	$('#desc').click(function(){desc = true; sortIt(); return false;});
	$('#clear').click(function(){clearAll(1); return false;});
	$('#showall').click(function(){
=======
	};

	clearAll = function(c) {
		c = c || 0;
		$('.menu_order_input').each( function() {
			if ( this.value === '0' || c ) {
				this.value = '';
			}
		});
	};

	$('#asc').click( function() {
		desc = false;
		sortIt();
		return false;
	});
	$('#desc').click( function() {
		desc = true;
		sortIt();
		return false;
	});
	$('#clear').click( function() {
		clearAll(1);
		return false;
	});
	$('#showall').click( function() {
>>>>>>> WPHome/master
		$('#sort-buttons span a').toggle();
		$('a.describe-toggle-on').hide();
		$('a.describe-toggle-off, table.slidetoggle').show();
		$('img.pinkynail').toggle(false);
		return false;
	});
<<<<<<< HEAD
	$('#hideall').click(function(){
=======
	$('#hideall').click( function() {
>>>>>>> WPHome/master
		$('#sort-buttons span a').toggle();
		$('a.describe-toggle-on').show();
		$('a.describe-toggle-off, table.slidetoggle').hide();
		$('img.pinkynail').toggle(true);
		return false;
	});

	// initialize sortable
	gallerySortableInit();
	clearAll();

	if ( $('#media-items>*').length > 1 ) {
		w = wpgallery.getWin();

		$('#save-all, #gallery-settings').show();
<<<<<<< HEAD
		if ( typeof w.tinyMCE != 'undefined' && w.tinyMCE.activeEditor && ! w.tinyMCE.activeEditor.isHidden() ) {
=======
		if ( typeof w.tinyMCE !== 'undefined' && w.tinyMCE.activeEditor && ! w.tinyMCE.activeEditor.isHidden() ) {
>>>>>>> WPHome/master
			wpgallery.mcemode = true;
			wpgallery.init();
		} else {
			$('#insert-gallery').show();
		}
	}
});

jQuery(window).unload( function () { tinymce = tinyMCE = wpgallery = null; } ); // Cleanup

/* gallery settings */
var tinymce = null, tinyMCE, wpgallery;

wpgallery = {
	mcemode : false,
	editor : {},
	dom : {},
	is_update : false,
	el : {},

	I : function(e) {
		return document.getElementById(e);
	},

	init: function() {
		var t = this, li, q, i, it, w = t.getWin();

<<<<<<< HEAD
		if ( ! t.mcemode ) return;
=======
		if ( ! t.mcemode ) {
			return;
		}
>>>>>>> WPHome/master

		li = ('' + document.location.search).replace(/^\?/, '').split('&');
		q = {};
		for (i=0; i<li.length; i++) {
			it = li[i].split('=');
			q[unescape(it[0])] = unescape(it[1]);
		}

<<<<<<< HEAD
		if (q.mce_rdomain)
			document.domain = q.mce_rdomain;
=======
		if ( q.mce_rdomain ) {
			document.domain = q.mce_rdomain;
		}
>>>>>>> WPHome/master

		// Find window & API
		tinymce = w.tinymce;
		tinyMCE = w.tinyMCE;
		t.editor = tinymce.EditorManager.activeEditor;

		t.setup();
	},

	getWin : function() {
		return window.dialogArguments || opener || parent || top;
	},

	setup : function() {
		var t = this, a, ed = t.editor, g, columns, link, order, orderby;
<<<<<<< HEAD
		if ( ! t.mcemode ) return;

		t.el = ed.selection.getNode();

		if ( t.el.nodeName != 'IMG' || ! ed.dom.hasClass(t.el, 'wpGallery') ) {
			if ( (g = ed.dom.select('img.wpGallery')) && g[0] ) {
				t.el = g[0];
			} else {
				if ( getUserSetting('galfile') == '1' ) t.I('linkto-file').checked = "checked";
				if ( getUserSetting('galdesc') == '1' ) t.I('order-desc').checked = "checked";
				if ( getUserSetting('galcols') ) t.I('columns').value = getUserSetting('galcols');
				if ( getUserSetting('galord') ) t.I('orderby').value = getUserSetting('galord');
=======
		if ( ! t.mcemode ) {
			return;
		}

		t.el = ed.selection.getNode();

		if ( t.el.nodeName !== 'IMG' || ! ed.dom.hasClass(t.el, 'wpGallery') ) {
			if ( ( g = ed.dom.select('img.wpGallery') ) && g[0] ) {
				t.el = g[0];
			} else {
				if ( getUserSetting('galfile') === '1' ) {
					t.I('linkto-file').checked = 'checked';
				}
				if ( getUserSetting('galdesc') === '1' ) {
					t.I('order-desc').checked = 'checked';
				}
				if ( getUserSetting('galcols') ) {
					t.I('columns').value = getUserSetting('galcols');
				}
				if ( getUserSetting('galord') ) {
					t.I('orderby').value = getUserSetting('galord');
				}
>>>>>>> WPHome/master
				jQuery('#insert-gallery').show();
				return;
			}
		}

		a = ed.dom.getAttrib(t.el, 'title');
		a = ed.dom.decode(a);

		if ( a ) {
			jQuery('#update-gallery').show();
			t.is_update = true;

			columns = a.match(/columns=['"]([0-9]+)['"]/);
			link = a.match(/link=['"]([^'"]+)['"]/i);
			order = a.match(/order=['"]([^'"]+)['"]/i);
			orderby = a.match(/orderby=['"]([^'"]+)['"]/i);

<<<<<<< HEAD
			if ( link && link[1] ) t.I('linkto-file').checked = "checked";
			if ( order && order[1] ) t.I('order-desc').checked = "checked";
			if ( columns && columns[1] ) t.I('columns').value = ''+columns[1];
			if ( orderby && orderby[1] ) t.I('orderby').value = orderby[1];
=======
			if ( link && link[1] ) {
				t.I('linkto-file').checked = 'checked';
			}
			if ( order && order[1] ) {
				t.I('order-desc').checked = 'checked';
			}
			if ( columns && columns[1] ) {
				t.I('columns').value = '' + columns[1];
			}
			if ( orderby && orderby[1] ) {
				t.I('orderby').value = orderby[1];
			}
>>>>>>> WPHome/master
		} else {
			jQuery('#insert-gallery').show();
		}
	},

	update : function() {
		var t = this, ed = t.editor, all = '', s;

		if ( ! t.mcemode || ! t.is_update ) {
<<<<<<< HEAD
			s = '[gallery'+t.getSettings()+']';
=======
			s = '[gallery' + t.getSettings() + ']';
>>>>>>> WPHome/master
			t.getWin().send_to_editor(s);
			return;
		}

<<<<<<< HEAD
		if (t.el.nodeName != 'IMG') return;

		all = ed.dom.decode(ed.dom.getAttrib(t.el, 'title'));
=======
		if ( t.el.nodeName !== 'IMG' ) {
			return;
		}

		all = ed.dom.decode( ed.dom.getAttrib( t.el, 'title' ) );
>>>>>>> WPHome/master
		all = all.replace(/\s*(order|link|columns|orderby)=['"]([^'"]+)['"]/gi, '');
		all += t.getSettings();

		ed.dom.setAttrib(t.el, 'title', all);
		t.getWin().tb_remove();
	},

	getSettings : function() {
		var I = this.I, s = '';

		if ( I('linkto-file').checked ) {
			s += ' link="file"';
			setUserSetting('galfile', '1');
		}

		if ( I('order-desc').checked ) {
			s += ' order="DESC"';
			setUserSetting('galdesc', '1');
		}

<<<<<<< HEAD
		if ( I('columns').value != 3 ) {
			s += ' columns="'+I('columns').value+'"';
			setUserSetting('galcols', I('columns').value);
		}

		if ( I('orderby').value != 'menu_order' ) {
			s += ' orderby="'+I('orderby').value+'"';
=======
		if ( I('columns').value !== 3 ) {
			s += ' columns="' + I('columns').value + '"';
			setUserSetting('galcols', I('columns').value);
		}

		if ( I('orderby').value !== 'menu_order' ) {
			s += ' orderby="' + I('orderby').value + '"';
>>>>>>> WPHome/master
			setUserSetting('galord', I('orderby').value);
		}

		return s;
	}
};
