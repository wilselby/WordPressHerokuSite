<<<<<<< HEAD
/**
 * PubSub
 *
 * A lightweight publish/subscribe implementation.
 * Private use only!
 */
var PubSub, fullscreen, wptitlehint;

PubSub = function() {
	this.topics = {};
};

PubSub.prototype.subscribe = function( topic, callback ) {
	if ( ! this.topics[ topic ] )
		this.topics[ topic ] = [];

	this.topics[ topic ].push( callback );
	return callback;
};

PubSub.prototype.unsubscribe = function( topic, callback ) {
	var i, l,
		topics = this.topics[ topic ];

	if ( ! topics )
		return callback || [];

	// Clear matching callbacks
	if ( callback ) {
		for ( i = 0, l = topics.length; i < l; i++ ) {
			if ( callback == topics[i] )
				topics.splice( i, 1 );
		}
		return callback;

	// Clear all callbacks
	} else {
		this.topics[ topic ] = [];
		return topics;
	}
};

PubSub.prototype.publish = function( topic, args ) {
	var i, l, broken,
		topics = this.topics[ topic ];

	if ( ! topics )
		return;

	args = args || [];

	for ( i = 0, l = topics.length; i < l; i++ ) {
		broken = ( topics[i].apply( null, args ) === false || broken );
	}
	return ! broken;
};

/**
 * Distraction Free Writing
 * (wp-fullscreen)
 *
 * Access the API globally using the fullscreen variable.
 */

(function($){
	var api, ps, bounder, s;

	// Initialize the fullscreen/api object
	fullscreen = api = {};

	// Create the PubSub (publish/subscribe) interface.
	ps = api.pubsub = new PubSub();
	timer = 0;
	block = false;

	s = api.settings = { // Settings
		visible : false,
		mode : 'tinymce',
		editor_id : 'content',
		title_id : '',
		timer : 0,
		toolbar_shown : false
	}

	/**
	 * Bounder
	 *
	 * Creates a function that publishes start/stop topics.
	 * Used to throttle events.
	 */
	bounder = api.bounder = function( start, stop, delay, e ) {
		var y, top;

		delay = delay || 1250;

		if ( e ) {
			y = e.pageY || e.clientY || e.offsetY;
			top = $(document).scrollTop();

			if ( !e.isDefaultPrevented ) // test if e ic jQuery normalized
				y = 135 + y;

			if ( y - top > 120 )
				return;
		}

		if ( block )
			return;

		block = true;

		setTimeout( function() {
			block = false;
		}, 400 );

		if ( s.timer )
			clearTimeout( s.timer );
		else
			ps.publish( start );

		function timed() {
			ps.publish( stop );
			s.timer = 0;
		}

		s.timer = setTimeout( timed, delay );
	};
=======
/* global deleteUserSetting, setUserSetting, switchEditors, tinymce, tinyMCEPreInit */
/**
 * Distraction-Free Writing
 * (wp-fullscreen)
 *
 * Access the API globally using the window.wp.editor.fullscreen variable.
 */
( function( $, window ) {
	var api, ps, s, toggleUI, uiTimer, PubSub,
		uiScrollTop = 0,
		transitionend = 'transitionend webkitTransitionEnd',
		$body = $( document.body ),
		$document = $( document );

	/**
	 * PubSub
	 *
	 * A lightweight publish/subscribe implementation.
	 *
	 * @access private
	 */
	PubSub = function() {
		this.topics = {};

		this.subscribe = function( topic, callback ) {
			if ( ! this.topics[ topic ] )
				this.topics[ topic ] = [];

			this.topics[ topic ].push( callback );
			return callback;
		};

		this.unsubscribe = function( topic, callback ) {
			var i, l,
				topics = this.topics[ topic ];

			if ( ! topics )
				return callback || [];

			// Clear matching callbacks
			if ( callback ) {
				for ( i = 0, l = topics.length; i < l; i++ ) {
					if ( callback == topics[i] )
						topics.splice( i, 1 );
				}
				return callback;

			// Clear all callbacks
			} else {
				this.topics[ topic ] = [];
				return topics;
			}
		};

		this.publish = function( topic, args ) {
			var i, l, broken,
				topics = this.topics[ topic ];

			if ( ! topics )
				return;

			args = args || [];

			for ( i = 0, l = topics.length; i < l; i++ ) {
				broken = ( topics[i].apply( null, args ) === false || broken );
			}
			return ! broken;
		};
	};

	// Initialize the fullscreen/api object
	api = {};

	// Create the PubSub (publish/subscribe) interface.
	ps = api.pubsub = new PubSub();

	s = api.settings = { // Settings
		visible: false,
		mode: 'tinymce',
		id: '',
		title_id: '',
		timer: 0,
		toolbar_shown: false
	};

	function _hideUI() {
		$body.removeClass('wp-dfw-show-ui');
	}

	/**
	 * toggleUI
	 *
	 * Toggle the CSS class to show/hide the toolbar, borders and statusbar.
	 */
	toggleUI = api.toggleUI = function( show ) {
		clearTimeout( uiTimer );

		if ( ! $body.hasClass('wp-dfw-show-ui') || show === 'show' ) {
			$body.addClass('wp-dfw-show-ui');
		} else if ( show !== 'autohide' ) {
			$body.removeClass('wp-dfw-show-ui');
		}

		if ( show === 'autohide' ) {
			uiTimer = setTimeout( _hideUI, 2000 );
		}
	};

	function resetCssPosition( add ) {
		s.$dfwWrap.parents().each( function( i, parent ) {
			var cssPosition, $parent = $(parent);

			if ( add ) {
				if ( parent.style.position ) {
					$parent.data( 'wp-dfw-css-position', parent.style.position );
				}

				$parent.css( 'position', 'static' );
			} else {
				cssPosition = $parent.data( 'wp-dfw-css-position' );
				cssPosition = cssPosition || '';
				$parent.css( 'position', cssPosition );
			}

			if ( parent.nodeName === 'BODY' ) {
				return false;
			}
		});
	}
>>>>>>> WPHome/master

	/**
	 * on()
	 *
	 * Turns fullscreen on.
	 *
	 * @param string mode Optional. Switch to the given mode before opening.
	 */
	api.on = function() {
<<<<<<< HEAD
		if ( s.visible )
			return;

		// Settings can be added or changed by defining "wp_fullscreen_settings" JS object.
		if ( typeof(wp_fullscreen_settings) == 'object' )
			$.extend( s, wp_fullscreen_settings );

		s.editor_id = wpActiveEditor || 'content';

		if ( $('input#title').length && s.editor_id == 'content' )
			s.title_id = 'title';
		else if ( $('input#' + s.editor_id + '-title').length ) // the title input field should have [editor_id]-title HTML ID to be auto detected
			s.title_id = s.editor_id + '-title';
		else
			$('#wp-fullscreen-title, #wp-fullscreen-title-prompt-text').hide();

		s.mode = $('#' + s.editor_id).is(':hidden') ? 'tinymce' : 'html';
		s.qt_canvas = $('#' + s.editor_id).get(0);

		if ( ! s.element )
			api.ui.init();

		s.is_mce_on = s.has_tinymce && typeof( tinyMCE.get(s.editor_id) ) != 'undefined';
=======
		var id, $dfwWrap, titleId;

		if ( s.visible ) {
			return;
		}

		if ( ! s.$fullscreenFader ) {
			api.ui.init();
		}

		// Settings can be added or changed by defining "wp_fullscreen_settings" JS object.
		if ( typeof window.wp_fullscreen_settings === 'object' )
			$.extend( s, window.wp_fullscreen_settings );

		id = s.id || window.wpActiveEditor;

		if ( ! id ) {
			if ( s.hasTinymce ) {
				id = tinymce.activeEditor.id;
			} else {
				return;
			}
		}

		s.id = id;
		$dfwWrap = s.$dfwWrap = $( '#wp-' + id + '-wrap' );

		if ( ! $dfwWrap.length ) {
			return;
		}

		s.$dfwTextarea = $( '#' + id );
		s.$editorContainer = $dfwWrap.find( '.wp-editor-container' );
		uiScrollTop = $document.scrollTop();

		if ( s.hasTinymce ) {
			s.editor = tinymce.get( id );
		}

		if ( s.editor && ! s.editor.isHidden() ) {
			s.origHeight = $( '#' + id + '_ifr' ).height();
			s.mode = 'tinymce';
		} else {
			s.origHeight = s.$dfwTextarea.height();
			s.mode = 'html';
		}

		// Try to find title field
		if ( typeof window.adminpage !== 'undefined' &&
			( window.adminpage === 'post-php' || window.adminpage === 'post-new-php' ) ) {

			titleId = 'title';
		} else {
			titleId = id + '-title';
		}

		s.$dfwTitle = $( '#' + titleId );

		if ( ! s.$dfwTitle.length ) {
			s.$dfwTitle = null;
		}
>>>>>>> WPHome/master

		api.ui.fade( 'show', 'showing', 'shown' );
	};

	/**
	 * off()
	 *
	 * Turns fullscreen off.
	 */
	api.off = function() {
		if ( ! s.visible )
			return;

		api.ui.fade( 'hide', 'hiding', 'hidden' );
	};

	/**
	 * switchmode()
	 *
	 * @return string - The current mode.
	 *
	 * @param string to - The fullscreen mode to switch to.
	 * @event switchMode
	 * @eventparam string to   - The new mode.
	 * @eventparam string from - The old mode.
	 */
	api.switchmode = function( to ) {
		var from = s.mode;

<<<<<<< HEAD
		if ( ! to || ! s.visible || ! s.has_tinymce )
			return from;
=======
		if ( ! to || ! s.visible || ! s.hasTinymce || typeof switchEditors === 'undefined' ) {
			return from;
		}
>>>>>>> WPHome/master

		// Don't switch if the mode is the same.
		if ( from == to )
			return from;

<<<<<<< HEAD
		ps.publish( 'switchMode', [ from, to ] );
		s.mode = to;
		ps.publish( 'switchedMode', [ from, to ] );
=======
		if ( to === 'tinymce' && ! s.editor ) {
			s.editor = tinymce.get( s.id );

			if ( ! s.editor &&  typeof tinyMCEPreInit !== 'undefined' &&
				tinyMCEPreInit.mceInit && tinyMCEPreInit.mceInit[ s.id ] ) {

				// If the TinyMCE instance hasn't been created, set the "wp_fulscreen" flag on creating it
				tinyMCEPreInit.mceInit[ s.id ].wp_fullscreen = true;
			}
		}

		s.mode = to;
		switchEditors.go( s.id, to );
		api.refreshButtons( true );

		if ( to === 'html' ) {
			setTimeout( api.resizeTextarea, 200 );
		}
>>>>>>> WPHome/master

		return to;
	};

	/**
	 * General
	 */

	api.save = function() {
<<<<<<< HEAD
		var hidden = $('#hiddenaction'), old = hidden.val(), spinner = $('#wp-fullscreen-save .spinner'),
			message = $('#wp-fullscreen-save span');

		spinner.show();
		api.savecontent();

		hidden.val('wp-fullscreen-save-post');

		$.post( ajaxurl, $('form#post').serialize(), function(r){
			spinner.hide();
			message.show();

			setTimeout( function(){
				message.fadeOut(1000);
			}, 3000 );

			if ( r.last_edited )
				$('#wp-fullscreen-save input').attr( 'title',  r.last_edited );

		}, 'json');

		hidden.val(old);
	}

	api.savecontent = function() {
		var ed, content;

		if ( s.title_id )
			$('#' + s.title_id).val( $('#wp-fullscreen-title').val() );

		if ( s.mode === 'tinymce' && (ed = tinyMCE.get('wp_mce_fullscreen')) ) {
			content = ed.save();
		} else {
			content = $('#wp_mce_fullscreen').val();
		}

		$('#' + s.editor_id).val( content );
		$(document).triggerHandler('wpcountwords', [ content ]);
	}

	set_title_hint = function( title ) {
		if ( ! title.val().length )
			title.siblings('label').css( 'visibility', '' );
		else
			title.siblings('label').css( 'visibility', 'hidden' );
	}

	api.dfw_width = function(n) {
		var el = $('#wp-fullscreen-wrap'), w = el.width();

		if ( !n ) { // reset to theme width
			el.width( $('#wp-fullscreen-central-toolbar').width() );
=======
		var $hidden = $('#hiddenaction'),
			oldVal = $hidden.val(),
			$spinner = $('#wp-fullscreen-save .spinner'),
			$saveMessage = $('#wp-fullscreen-save .wp-fullscreen-saved-message'),
			$errorMessage = $('#wp-fullscreen-save .wp-fullscreen-error-message');

		$spinner.addClass( 'is-active' );
		$errorMessage.hide();
		$saveMessage.hide();
		$hidden.val('wp-fullscreen-save-post');

		if ( s.editor && ! s.editor.isHidden() ) {
			s.editor.save();
		}

		$.ajax({
			url: window.ajaxurl,
			type: 'post',
			data: $('form#post').serialize(),
			dataType: 'json'
		}).done( function( response ) {
			$spinner.removeClass( 'is-active' );

			if ( response && response.success ) {
				$saveMessage.show();

				setTimeout( function() {
					$saveMessage.fadeOut(300);
				}, 3000 );

				if ( response.data && response.data.last_edited ) {
					$('#wp-fullscreen-save input').attr( 'title',  response.data.last_edited );
				}
			} else {
				$errorMessage.show();
			}
		}).fail( function() {
			$spinner.removeClass( 'is-active' );
			$errorMessage.show();
		});

		$hidden.val( oldVal );
	};

	api.dfwWidth = function( pixels, total ) {
		var width;

		if ( pixels && pixels.toString().indexOf('%') !== -1 ) {
			s.$editorContainer.css( 'width', pixels );
			s.$statusbar.css( 'width', pixels );

			if ( s.$dfwTitle ) {
				s.$dfwTitle.css( 'width', pixels );
			}
			return;
		}

		if ( ! pixels ) {
			// Reset to theme width
			width = $('#wp-fullscreen-body').data('theme-width') || 800;
			s.$editorContainer.width( width );
			s.$statusbar.width( width );

			if ( s.$dfwTitle ) {
				s.$dfwTitle.width( width - 16 );
			}

>>>>>>> WPHome/master
			deleteUserSetting('dfw_width');
			return;
		}

<<<<<<< HEAD
		w = n + w;

		if ( w < 200 || w > 1200 ) // sanity check
			return;

		el.width( w );
		setUserSetting('dfw_width', w);
	}

	ps.subscribe( 'showToolbar', function() {
		s.toolbars.removeClass('fade-1000').addClass('fade-300');
		api.fade.In( s.toolbars, 300, function(){ ps.publish('toolbarShown'); }, true );
		$('#wp-fullscreen-body').addClass('wp-fullscreen-focus');
		s.toolbar_shown = true;
	});

	ps.subscribe( 'hideToolbar', function() {
		s.toolbars.removeClass('fade-300').addClass('fade-1000');
		api.fade.Out( s.toolbars, 1000, function(){ ps.publish('toolbarHidden'); }, true );
		$('#wp-fullscreen-body').removeClass('wp-fullscreen-focus');
	});

	ps.subscribe( 'toolbarShown', function() {
		s.toolbars.removeClass('fade-300');
	});

	ps.subscribe( 'toolbarHidden', function() {
		s.toolbars.removeClass('fade-1000');
		s.toolbar_shown = false;
	});

	ps.subscribe( 'show', function() { // This event occurs before the overlay blocks the UI.
		var title;

		if ( s.title_id ) {
			title = $('#wp-fullscreen-title').val( $('#' + s.title_id).val() );
			set_title_hint( title );
		}

		$('#wp-fullscreen-save input').attr( 'title',  $('#last-edit').text() );

		s.textarea_obj.value = s.qt_canvas.value;

		if ( s.has_tinymce && s.mode === 'tinymce' )
			tinyMCE.execCommand('wpFullScreenInit');

		s.orig_y = $(window).scrollTop();
	});

	ps.subscribe( 'showing', function() { // This event occurs while the DFW overlay blocks the UI.
		$( document.body ).addClass( 'fullscreen-active' );
		api.refresh_buttons();

		$( document ).bind( 'mousemove.fullscreen', function(e) { bounder( 'showToolbar', 'hideToolbar', 2000, e ); } );
		bounder( 'showToolbar', 'hideToolbar', 2000 );

		api.bind_resize();
		setTimeout( api.resize_textarea, 200 );

		// scroll to top so the user is not disoriented
		scrollTo(0, 0);

		// needed it for IE7 and compat mode
		$('#wpadminbar').hide();
	});

	ps.subscribe( 'shown', function() { // This event occurs after the DFW overlay is shown
		var interim_init;

		s.visible = true;

		// init the standard TinyMCE instance if missing
		if ( s.has_tinymce && ! s.is_mce_on ) {

			interim_init = function(mce, ed) {
				var el = ed.getElement(), old_val = el.value, settings = tinyMCEPreInit.mceInit[s.editor_id];

				if ( settings && settings.wpautop && typeof(switchEditors) != 'undefined' )
					el.value = switchEditors.wpautop( el.value );

				ed.onInit.add(function(ed) {
					ed.hide();
					ed.getElement().value = old_val;
					tinymce.onAddEditor.remove(interim_init);
				});
			};

			tinymce.onAddEditor.add(interim_init);
			tinyMCE.init(tinyMCEPreInit.mceInit[s.editor_id]);

			s.is_mce_on = true;
		}

		wpActiveEditor = 'wp_mce_fullscreen';
	});

	ps.subscribe( 'hide', function() { // This event occurs before the overlay blocks DFW.
		var htmled_is_hidden = $('#' + s.editor_id).is(':hidden');
		// Make sure the correct editor is displaying.
		if ( s.has_tinymce && s.mode === 'tinymce' && !htmled_is_hidden ) {
			switchEditors.go(s.editor_id, 'tmce');
		} else if ( s.mode === 'html' && htmled_is_hidden ) {
			switchEditors.go(s.editor_id, 'html');
		}

		// Save content must be after switchEditors or content will be overwritten. See #17229.
		api.savecontent();

		$( document ).unbind( '.fullscreen' );
		$(s.textarea_obj).unbind('.grow');

		if ( s.has_tinymce && s.mode === 'tinymce' )
			tinyMCE.execCommand('wpFullScreenSave');

		if ( s.title_id )
			set_title_hint( $('#' + s.title_id) );

		s.qt_canvas.value = s.textarea_obj.value;
	});

	ps.subscribe( 'hiding', function() { // This event occurs while the overlay blocks the DFW UI.

		$( document.body ).removeClass( 'fullscreen-active' );
		scrollTo(0, s.orig_y);
		$('#wpadminbar').show();
	});

	ps.subscribe( 'hidden', function() { // This event occurs after DFW is removed.
		s.visible = false;
		$('#wp_mce_fullscreen, #wp-fullscreen-title').removeAttr('style');

		if ( s.has_tinymce && s.is_mce_on )
			tinyMCE.execCommand('wpFullScreenClose');

		s.textarea_obj.value = '';
		api.oldheight = 0;
		wpActiveEditor = s.editor_id;
	});

	ps.subscribe( 'switchMode', function( from, to ) {
		var ed;

		if ( !s.has_tinymce || !s.is_mce_on )
			return;

		ed = tinyMCE.get('wp_mce_fullscreen');

		if ( from === 'html' && to === 'tinymce' ) {

			if ( tinyMCE.get(s.editor_id).getParam('wpautop') && typeof(switchEditors) != 'undefined' )
				s.textarea_obj.value = switchEditors.wpautop( s.textarea_obj.value );

			if ( 'undefined' == typeof(ed) )
				tinyMCE.execCommand('wpFullScreenInit');
			else
				ed.show();

		} else if ( from === 'tinymce' && to === 'html' ) {
			if ( ed )
				ed.hide();
		}
	});

	ps.subscribe( 'switchedMode', function( from, to ) {
		api.refresh_buttons(true);

		if ( to === 'html' )
			setTimeout( api.resize_textarea, 200 );
	});

	/**
	 * Buttons
	 */
	api.b = function() {
		if ( s.has_tinymce && 'tinymce' === s.mode )
			tinyMCE.execCommand('Bold');
	}

	api.i = function() {
		if ( s.has_tinymce && 'tinymce' === s.mode )
			tinyMCE.execCommand('Italic');
	}

	api.ul = function() {
		if ( s.has_tinymce && 'tinymce' === s.mode )
			tinyMCE.execCommand('InsertUnorderedList');
	}

	api.ol = function() {
		if ( s.has_tinymce && 'tinymce' === s.mode )
			tinyMCE.execCommand('InsertOrderedList');
	}

	api.link = function() {
		if ( s.has_tinymce && 'tinymce' === s.mode )
			tinyMCE.execCommand('WP_Link');
		else
			wpLink.open();
	}

	api.unlink = function() {
		if ( s.has_tinymce && 'tinymce' === s.mode )
			tinyMCE.execCommand('unlink');
	}

	api.atd = function() {
		if ( s.has_tinymce && 'tinymce' === s.mode )
			tinyMCE.execCommand('mceWritingImprovementTool');
	}

	api.help = function() {
		if ( s.has_tinymce && 'tinymce' === s.mode )
			tinyMCE.execCommand('WP_Help');
	}

	api.blockquote = function() {
		if ( s.has_tinymce && 'tinymce' === s.mode )
			tinyMCE.execCommand('mceBlockQuote');
	}

	api.medialib = function() {
		if ( typeof wp !== 'undefined' && wp.media && wp.media.editor )
			wp.media.editor.open(s.editor_id);
	}

	api.refresh_buttons = function( fade ) {
		fade = fade || false;

		if ( s.mode === 'html' ) {
			$('#wp-fullscreen-mode-bar').removeClass('wp-tmce-mode').addClass('wp-html-mode');

			if ( fade )
				$('#wp-fullscreen-button-bar').fadeOut( 150, function(){
					$(this).addClass('wp-html-mode').fadeIn( 150 );
				});
			else
				$('#wp-fullscreen-button-bar').addClass('wp-html-mode');

		} else if ( s.mode === 'tinymce' ) {
			$('#wp-fullscreen-mode-bar').removeClass('wp-html-mode').addClass('wp-tmce-mode');

			if ( fade )
				$('#wp-fullscreen-button-bar').fadeOut( 150, function(){
					$(this).removeClass('wp-html-mode').fadeIn( 150 );
				});
			else
				$('#wp-fullscreen-button-bar').removeClass('wp-html-mode');
		}
	}
=======
		if ( total ) {
			width = pixels;
		} else {
			width = s.$editorContainer.width();
			width += pixels;
		}

		if ( width < 200 || width > 1200 ) {
			// sanity check
			return;
		}

		s.$editorContainer.width( width );
		s.$statusbar.width( width );

		if ( s.$dfwTitle ) {
			s.$dfwTitle.width( width - 16 );
		}

		setUserSetting( 'dfw_width', width );
	};

	// This event occurs before the overlay blocks the UI.
	ps.subscribe( 'show', function() {
		var title = $('#last-edit').text();

		if ( title ) {
			$('#wp-fullscreen-save input').attr( 'title', title );
		}
	});

	// This event occurs while the overlay blocks the UI.
	ps.subscribe( 'showing', function() {
		$body.addClass( 'wp-fullscreen-active' );
		s.$dfwWrap.addClass( 'wp-fullscreen-wrap' );

		if ( s.$dfwTitle ) {
			s.$dfwTitle.after( '<span id="wp-fullscreen-title-placeholder">' );
			s.$dfwWrap.prepend( s.$dfwTitle.addClass('wp-fullscreen-title') );
		}

		api.refreshButtons();
		resetCssPosition( true );
		$('#wpadminbar').hide();

		// Show the UI for 2 sec. when opening
		toggleUI('autohide');

		api.bind_resize();

		if ( s.editor ) {
			s.editor.execCommand( 'wpFullScreenOn' );
		}

		if ( 'ontouchstart' in window ) {
			api.dfwWidth( '90%' );
		} else {
			api.dfwWidth( $( '#wp-fullscreen-body' ).data('dfw-width') || 800, true );
		}

		// scroll to top so the user is not disoriented
		scrollTo(0, 0);
	});

	// This event occurs after the overlay unblocks the UI
	ps.subscribe( 'shown', function() {
		s.visible = true;

		if ( s.editor && ! s.editor.isHidden() ) {
			s.editor.execCommand( 'wpAutoResize' );
		} else {
			api.resizeTextarea( 'force' );
		}
	});

	ps.subscribe( 'hide', function() { // This event occurs before the overlay blocks DFW.
		$document.unbind( '.fullscreen' );
		s.$dfwTextarea.unbind('.wp-dfw-resize');
	});

	ps.subscribe( 'hiding', function() { // This event occurs while the overlay blocks the DFW UI.
		$body.removeClass( 'wp-fullscreen-active' );

		if ( s.$dfwTitle ) {
			$( '#wp-fullscreen-title-placeholder' ).before( s.$dfwTitle.removeClass('wp-fullscreen-title').css( 'width', '' ) ).remove();
		}

		s.$dfwWrap.removeClass( 'wp-fullscreen-wrap' );
		s.$editorContainer.css( 'width', '' );
		s.$dfwTextarea.add( '#' + s.id + '_ifr' ).height( s.origHeight );

		if ( s.editor ) {
			s.editor.execCommand( 'wpFullScreenOff' );
		}

		resetCssPosition( false );

		window.scrollTo( 0, uiScrollTop );
		$('#wpadminbar').show();
	});

	// This event occurs after DFW is removed.
	ps.subscribe( 'hidden', function() {
		s.visible = false;
	});

	api.refreshButtons = function( fade ) {
		if ( s.mode === 'html' ) {
			$('#wp-fullscreen-mode-bar').removeClass('wp-tmce-mode').addClass('wp-html-mode')
				.find('a').removeClass( 'active' ).filter('.wp-fullscreen-mode-html').addClass( 'active' );

			if ( fade ) {
				$('#wp-fullscreen-button-bar').fadeOut( 150, function(){
					$(this).addClass('wp-html-mode').fadeIn( 150 );
				});
			} else {
				$('#wp-fullscreen-button-bar').addClass('wp-html-mode');
			}
		} else if ( s.mode === 'tinymce' ) {
			$('#wp-fullscreen-mode-bar').removeClass('wp-html-mode').addClass('wp-tmce-mode')
				.find('a').removeClass( 'active' ).filter('.wp-fullscreen-mode-tinymce').addClass( 'active' );

			if ( fade ) {
				$('#wp-fullscreen-button-bar').fadeOut( 150, function(){
					$(this).removeClass('wp-html-mode').fadeIn( 150 );
				});
			} else {
				$('#wp-fullscreen-button-bar').removeClass('wp-html-mode');
			}
		}
	};
>>>>>>> WPHome/master

	/**
	 * UI Elements
	 *
	 * Used for transitioning between states.
	 */
	api.ui = {
		init: function() {
<<<<<<< HEAD
			var topbar = $('#fullscreen-topbar'), txtarea = $('#wp_mce_fullscreen'), last = 0;

			s.toolbars = topbar.add( $('#wp-fullscreen-status') );
			s.element = $('#fullscreen-fader');
			s.textarea_obj = txtarea[0];
			s.has_tinymce = typeof(tinymce) != 'undefined';

			if ( !s.has_tinymce )
				$('#wp-fullscreen-mode-bar').hide();

			if ( wptitlehint && $('#wp-fullscreen-title').length )
				wptitlehint('wp-fullscreen-title');

			$(document).keyup(function(e){
				var c = e.keyCode || e.charCode, a, data;

				if ( !fullscreen.settings.visible )
					return true;

				if ( navigator.platform && navigator.platform.indexOf('Mac') != -1 )
					a = e.ctrlKey; // Ctrl key for Mac
				else
					a = e.altKey; // Alt key for Win & Linux

				if ( 27 == c ) { // Esc
					data = {
						event: e,
						what: 'dfw',
						cb: fullscreen.off,
						condition: function(){
							if ( $('#TB_window').is(':visible') || $('.wp-dialog').is(':visible') )
								return false;
							return true;
						}
					};

					if ( ! jQuery(document).triggerHandler( 'wp_CloseOnEscape', [data] ) )
						fullscreen.off();
				}

				if ( a && (61 == c || 107 == c || 187 == c) ) // +
					api.dfw_width(25);

				if ( a && (45 == c || 109 == c || 189 == c) ) // -
					api.dfw_width(-25);

				if ( a && 48 == c ) // 0
					api.dfw_width(0);

				return false;
			});

			// word count in Text mode
			if ( typeof(wpWordCount) != 'undefined' ) {

				txtarea.keyup( function(e) {
					var k = e.keyCode || e.charCode;

					if ( k == last )
						return true;

					if ( 13 == k || 8 == last || 46 == last )
						$(document).triggerHandler('wpcountwords', [ txtarea.val() ]);

					last = k;
					return true;
				});
			}

			topbar.mouseenter(function(e){
				s.toolbars.addClass('fullscreen-make-sticky');
				$( document ).unbind( '.fullscreen' );
				clearTimeout( s.timer );
				s.timer = 0;
			}).mouseleave(function(e){
				s.toolbars.removeClass('fullscreen-make-sticky');

				if ( s.visible )
					$( document ).bind( 'mousemove.fullscreen', function(e) { bounder( 'showToolbar', 'hideToolbar', 2000, e ); } );
=======
			var toolbar;

			s.toolbar = toolbar = $('#fullscreen-topbar');
			s.$fullscreenFader = $('#fullscreen-fader');
			s.$statusbar = $('#wp-fullscreen-status');
			s.hasTinymce = typeof tinymce !== 'undefined';

			if ( ! s.hasTinymce )
				$('#wp-fullscreen-mode-bar').hide();

			$document.keyup( function(e) {
				var c = e.keyCode || e.charCode, modKey;

				if ( ! s.visible ) {
					return;
				}

				if ( navigator.platform && navigator.platform.indexOf('Mac') !== -1 ) {
					modKey = e.ctrlKey; // Ctrl key for Mac
				} else {
					modKey = e.altKey; // Alt key for Win & Linux
				}

				if ( modKey && ( 61 === c || 107 === c || 187 === c ) ) { // +
					api.dfwWidth( 25 );
					e.preventDefault();
				}

				if ( modKey && ( 45 === c || 109 === c || 189 === c ) ) { // -
					api.dfwWidth( -25 );
					e.preventDefault();
				}

				if ( modKey && 48 === c ) { // 0
					api.dfwWidth( 0 );
					e.preventDefault();
				}
			});

			$( window ).on( 'keydown.wp-fullscreen', function( event ) {
				// Turn fullscreen off when Esc is pressed.
				if ( 27 === event.keyCode && s.visible ) {
					api.off();
					event.stopImmediatePropagation();
				}
			});

			if ( 'ontouchstart' in window ) {
				$body.addClass('wp-dfw-touch');
			}

			toolbar.on( 'mouseenter', function() {
				toggleUI('show');
			}).on( 'mouseleave', function() {
				toggleUI('autohide');
			});

			// Bind buttons
			$('#wp-fullscreen-buttons').on( 'click.wp-fullscreen', 'button', function( event ) {
				var command = event.currentTarget.id ? event.currentTarget.id.substr(6) : null;

				if ( s.editor && 'tinymce' === s.mode ) {
					switch( command ) {
						case 'bold':
							s.editor.execCommand('Bold');
							break;
						case 'italic':
							s.editor.execCommand('Italic');
							break;
						case 'bullist':
							s.editor.execCommand('InsertUnorderedList');
							break;
						case 'numlist':
							s.editor.execCommand('InsertOrderedList');
							break;
						case 'link':
							s.editor.execCommand('WP_Link');
							break;
						case 'unlink':
							s.editor.execCommand('unlink');
							break;
						case 'help':
							s.editor.execCommand('WP_Help');
							break;
						case 'blockquote':
							s.editor.execCommand('mceBlockQuote');
							break;
					}
				} else if ( command === 'link' && window.wpLink ) {
					window.wpLink.open();
				}

				if ( command === 'wp-media-library' && typeof wp !== 'undefined' && wp.media && wp.media.editor ) {
					wp.media.editor.open( s.id );
				}
>>>>>>> WPHome/master
			});
		},

		fade: function( before, during, after ) {
<<<<<<< HEAD
			if ( ! s.element )
				api.ui.init();

			// If any callback bound to before returns false, bail.
			if ( before && ! ps.publish( before ) )
				return;

			api.fade.In( s.element, 600, function() {
				if ( during )
					ps.publish( during );

				api.fade.Out( s.element, 600, function() {
					if ( after )
						ps.publish( after );
				})
=======
			if ( ! s.$fullscreenFader ) {
				api.ui.init();
			}

			// If any callback bound to before returns false, bail.
			if ( before && ! ps.publish( before ) ) {
				return;
			}

			api.fade.In( s.$fullscreenFader, 200, function() {
				if ( during ) {
					ps.publish( during );
				}

				api.fade.Out( s.$fullscreenFader, 200, function() {
					if ( after ) {
						ps.publish( after );
					}
				});
>>>>>>> WPHome/master
			});
		}
	};

	api.fade = {
<<<<<<< HEAD
		transitionend: 'transitionend webkitTransitionEnd oTransitionEnd',

=======
>>>>>>> WPHome/master
		// Sensitivity to allow browsers to render the blank element before animating.
		sensitivity: 100,

		In: function( element, speed, callback, stop ) {

			callback = callback || $.noop;
			speed = speed || 400;
			stop = stop || false;

			if ( api.fade.transitions ) {
				if ( element.is(':visible') ) {
					element.addClass( 'fade-trigger' );
					return element;
				}

				element.show();
<<<<<<< HEAD
				element.first().one( this.transitionend, function() {
					callback();
				});
				setTimeout( function() { element.addClass( 'fade-trigger' ); }, this.sensitivity );
			} else {
				if ( stop )
					element.stop();
=======
				element.first().one( transitionend, function() {
					callback();
				});

				setTimeout( function() { element.addClass( 'fade-trigger' ); }, this.sensitivity );
			} else {
				if ( stop ) {
					element.stop();
				}
>>>>>>> WPHome/master

				element.css( 'opacity', 1 );
				element.first().fadeIn( speed, callback );

<<<<<<< HEAD
				if ( element.length > 1 )
					element.not(':first').fadeIn( speed );
=======
				if ( element.length > 1 ) {
					element.not(':first').fadeIn( speed );
				}
>>>>>>> WPHome/master
			}

			return element;
		},

		Out: function( element, speed, callback, stop ) {

			callback = callback || $.noop;
			speed = speed || 400;
			stop = stop || false;

<<<<<<< HEAD
			if ( ! element.is(':visible') )
				return element;

			if ( api.fade.transitions ) {
				element.first().one( api.fade.transitionend, function() {
					if ( element.hasClass('fade-trigger') )
						return;
=======
			if ( ! element.is(':visible') ) {
				return element;
			}

			if ( api.fade.transitions ) {
				element.first().one( transitionend, function() {
					if ( element.hasClass('fade-trigger') ) {
						return;
					}
>>>>>>> WPHome/master

					element.hide();
					callback();
				});
				setTimeout( function() { element.removeClass( 'fade-trigger' ); }, this.sensitivity );
			} else {
<<<<<<< HEAD
				if ( stop )
					element.stop();

				element.first().fadeOut( speed, callback );

				if ( element.length > 1 )
					element.not(':first').fadeOut( speed );
=======
				if ( stop ) {
					element.stop();
				}

				element.first().fadeOut( speed, callback );

				if ( element.length > 1 ) {
					element.not(':first').fadeOut( speed );
				}
>>>>>>> WPHome/master
			}

			return element;
		},

<<<<<<< HEAD
		transitions: (function() { // Check if the browser supports CSS 3.0 transitions
			var s = document.documentElement.style;

			return ( typeof ( s.WebkitTransition ) == 'string' ||
				typeof ( s.MozTransition ) == 'string' ||
				typeof ( s.OTransition ) == 'string' ||
				typeof ( s.transition ) == 'string' );
=======
		// Check if the browser supports CSS 3.0 transitions
		transitions: ( function() {
			var style = document.documentElement.style;

			return ( typeof style.WebkitTransition === 'string' ||
				typeof style.MozTransition === 'string' ||
				typeof style.OTransition === 'string' ||
				typeof style.transition === 'string' );
>>>>>>> WPHome/master
		})()
	};

	/**
	 * Resize API
	 *
	 * Automatically updates textarea height.
	 */
<<<<<<< HEAD

	api.bind_resize = function() {
		$(s.textarea_obj).bind('keypress.grow click.grow paste.grow', function(){
			setTimeout( api.resize_textarea, 200 );
		});
	}

	api.oldheight = 0;
	api.resize_textarea = function() {
		var txt = s.textarea_obj, newheight;

		newheight = txt.scrollHeight > 300 ? txt.scrollHeight : 300;

		if ( newheight != api.oldheight ) {
			txt.style.height = newheight + 'px';
			api.oldheight = newheight;
		}
	};

})(jQuery);
=======
	api.bind_resize = function() {
		s.$dfwTextarea.on( 'keydown.wp-dfw-resize click.wp-dfw-resize paste.wp-dfw-resize', function() {
			api.resizeTextarea();
		});
	};

	api.resizeTextarea = function() {
		var node = s.$dfwTextarea[0];

		if ( node.scrollHeight > node.clientHeight ) {
			node.style.height = node.scrollHeight + 50 + 'px';
		}
	};

	// Export
	window.wp = window.wp || {};
	window.wp.editor = window.wp.editor || {};
	window.wp.editor.fullscreen = api;

})( jQuery, window );
>>>>>>> WPHome/master
