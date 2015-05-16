<<<<<<< HEAD
=======
/* global _wpCustomizeLoaderSettings, confirm */
>>>>>>> WPHome/master
window.wp = window.wp || {};

(function( exports, $ ){
	var api = wp.customize,
		Loader;

	$.extend( $.support, {
		history: !! ( window.history && history.pushState ),
		hashchange: ('onhashchange' in window) && (document.documentMode === undefined || document.documentMode > 7)
	});

<<<<<<< HEAD
	Loader = $.extend( {}, api.Events, {
=======
	/**
	 * Allows the Customizer to be overlayed on any page.
	 *
	 * By default, any element in the body with the load-customize class will open
	 * an iframe overlay with the URL specified.
	 *
	 *     e.g. <a class="load-customize" href="<?php echo wp_customize_url(); ?>">Open Customizer</a>
	 *
	 * @augments wp.customize.Events
	 */
	Loader = $.extend( {}, api.Events, {
		/**
		 * Setup the Loader; triggered on document#ready.
		 */
>>>>>>> WPHome/master
		initialize: function() {
			this.body = $( document.body );

			// Ensure the loader is supported.
			// Check for settings, postMessage support, and whether we require CORS support.
			if ( ! Loader.settings || ! $.support.postMessage || ( ! $.support.cors && Loader.settings.isCrossDomain ) ) {
				return;
			}

			this.window  = $( window );
			this.element = $( '<div id="customize-container" />' ).appendTo( this.body );

<<<<<<< HEAD
			this.bind( 'open', this.overlay.show );
			this.bind( 'close', this.overlay.hide );

			$('#wpbody').on( 'click', '.load-customize', function( event ) {
				event.preventDefault();

				// Store a reference to the link that opened the customizer.
=======
			// Bind events for opening and closing the overlay.
			this.bind( 'open', this.overlay.show );
			this.bind( 'close', this.overlay.hide );

			// Any element in the body with the `load-customize` class opens
			// the Customizer.
			$('#wpbody').on( 'click', '.load-customize', function( event ) {
				event.preventDefault();

				// Store a reference to the link that opened the Customizer.
>>>>>>> WPHome/master
				Loader.link = $(this);
				// Load the theme.
				Loader.open( Loader.link.attr('href') );
			});

			// Add navigation listeners.
<<<<<<< HEAD
			if ( $.support.history )
				this.window.on( 'popstate', Loader.popstate );
=======
			if ( $.support.history ) {
				this.window.on( 'popstate', Loader.popstate );
			}
>>>>>>> WPHome/master

			if ( $.support.hashchange ) {
				this.window.on( 'hashchange', Loader.hashchange );
				this.window.triggerHandler( 'hashchange' );
			}
		},

		popstate: function( e ) {
			var state = e.originalEvent.state;
<<<<<<< HEAD
			if ( state && state.customize )
				Loader.open( state.customize );
			else if ( Loader.active )
				Loader.close();
		},

		hashchange: function( e ) {
			var hash = window.location.toString().split('#')[1];

			if ( hash && 0 === hash.indexOf( 'wp_customize=on' ) )
				Loader.open( Loader.settings.url + '?' + hash );

			if ( ! hash && ! $.support.history )
				Loader.close();
		},

		open: function( src ) {
			var hash;

			if ( this.active )
				return;

			// Load the full page on mobile devices.
			if ( Loader.settings.browser.mobile )
				return window.location = src;
=======
			if ( state && state.customize ) {
				Loader.open( state.customize );
			} else if ( Loader.active ) {
				Loader.close();
			}
		},

		hashchange: function() {
			var hash = window.location.toString().split('#')[1];

			if ( hash && 0 === hash.indexOf( 'wp_customize=on' ) ) {
				Loader.open( Loader.settings.url + '?' + hash );
			}

			if ( ! hash && ! $.support.history ) {
				Loader.close();
			}
		},

		beforeunload: function () {
			if ( ! Loader.saved() ) {
				return Loader.settings.l10n.saveAlert;
			}
		},

		/**
		 * Open the Customizer overlay for a specific URL.
		 *
		 * @param  string src URL to load in the Customizer.
		 */
		open: function( src ) {

			if ( this.active ) {
				return;
			}

			// Load the full page on mobile devices.
			if ( Loader.settings.browser.mobile ) {
				return window.location = src;
			}

			// Store the document title prior to opening the Live Preview
			this.originalDocumentTitle = document.title;
>>>>>>> WPHome/master

			this.active = true;
			this.body.addClass('customize-loading');

<<<<<<< HEAD
			this.iframe = $( '<iframe />', { src: src }).appendTo( this.element );
=======
			// Dirty state of Customizer in iframe
			this.saved = new api.Value( true );

			this.iframe = $( '<iframe />', { 'src': src, 'title': Loader.settings.l10n.mainIframeTitle } ).appendTo( this.element );
>>>>>>> WPHome/master
			this.iframe.one( 'load', this.loaded );

			// Create a postMessage connection with the iframe.
			this.messenger = new api.Messenger({
				url: src,
				channel: 'loader',
				targetWindow: this.iframe[0].contentWindow
			});

			// Wait for the connection from the iframe before sending any postMessage events.
			this.messenger.bind( 'ready', function() {
				Loader.messenger.send( 'back' );
			});

			this.messenger.bind( 'close', function() {
<<<<<<< HEAD
				if ( $.support.history )
					history.back();
				else if ( $.support.hashchange )
					window.location.hash = '';
				else
					Loader.close();
			});

			this.messenger.bind( 'activated', function( location ) {
				if ( location )
					window.location = location;
			});

			hash = src.split('?')[1];

			// Ensure we don't call pushState if the user hit the forward button.
			if ( $.support.history && window.location.href !== src )
				history.pushState( { customize: src }, '', src );
			else if ( ! $.support.history && $.support.hashchange && hash )
				window.location.hash = 'wp_customize=on&' + hash;
=======
				if ( $.support.history ) {
					history.back();
				} else if ( $.support.hashchange ) {
					window.location.hash = '';
				} else {
					Loader.close();
				}
			});

			// Prompt AYS dialog when navigating away
			$( window ).on( 'beforeunload', this.beforeunload );

			this.messenger.bind( 'activated', function( location ) {
				if ( location ) {
					window.location = location;
				}
			});

			this.messenger.bind( 'saved', function () {
				Loader.saved( true );
			} );
			this.messenger.bind( 'change', function () {
				Loader.saved( false );
			} );

			this.messenger.bind( 'title', function( newTitle ){
				window.document.title = newTitle;
			});

			this.pushState( src );

			this.trigger( 'open' );
		},

		pushState: function ( src ) {
			var hash = src.split( '?' )[1];

			// Ensure we don't call pushState if the user hit the forward button.
			if ( $.support.history && window.location.href !== src ) {
				history.pushState( { customize: src }, '', src );
			} else if ( ! $.support.history && $.support.hashchange && hash ) {
				window.location.hash = 'wp_customize=on&' + hash;
			}
>>>>>>> WPHome/master

			this.trigger( 'open' );
		},

<<<<<<< HEAD
=======
		/**
		 * Callback after the Customizer has been opened.
		 */
>>>>>>> WPHome/master
		opened: function() {
			Loader.body.addClass( 'customize-active full-overlay-active' );
		},

<<<<<<< HEAD
		close: function() {
			if ( ! this.active )
				return;
=======
		/**
		 * Close the Customizer overlay and return focus to the link that opened it.
		 */
		close: function() {
			if ( ! this.active ) {
				return;
			}

			// Display AYS dialog if Customizer is dirty
			if ( ! this.saved() && ! confirm( Loader.settings.l10n.saveAlert ) ) {
				// Go forward since Customizer is exited by history.back()
				history.forward();
				return;
			}

>>>>>>> WPHome/master
			this.active = false;

			this.trigger( 'close' );

<<<<<<< HEAD
			// Return focus to link that was originally clicked.
			if ( this.link )
				this.link.focus();
		},

=======
			// Restore document title prior to opening the Live Preview
			if ( this.originalDocumentTitle ) {
				document.title = this.originalDocumentTitle;
			}

			// Return focus to link that was originally clicked.
			if ( this.link ) {
				this.link.focus();
			}
		},

		/**
		 * Callback after the Customizer has been closed.
		 */
>>>>>>> WPHome/master
		closed: function() {
			Loader.iframe.remove();
			Loader.messenger.destroy();
			Loader.iframe    = null;
			Loader.messenger = null;
<<<<<<< HEAD
			Loader.body.removeClass( 'customize-active full-overlay-active' ).removeClass( 'customize-loading' );
		},

=======
			Loader.saved     = null;
			Loader.body.removeClass( 'customize-active full-overlay-active' ).removeClass( 'customize-loading' );
			$( window ).off( 'beforeunload', Loader.beforeunload );
		},

		/**
		 * Callback for the `load` event on the Customizer iframe.
		 */
>>>>>>> WPHome/master
		loaded: function() {
			Loader.body.removeClass('customize-loading');
		},

<<<<<<< HEAD
=======
		/**
		 * Overlay hide/show utility methods.
		 */
>>>>>>> WPHome/master
		overlay: {
			show: function() {
				this.element.fadeIn( 200, Loader.opened );
			},

			hide: function() {
				this.element.fadeOut( 200, Loader.closed );
			}
		}
	});

<<<<<<< HEAD
=======
	// Bootstrap the Loader on document#ready.
>>>>>>> WPHome/master
	$( function() {
		Loader.settings = _wpCustomizeLoaderSettings;
		Loader.initialize();
	});

<<<<<<< HEAD
	// Expose the API to the world.
=======
	// Expose the API publicly on window.wp.customize.Loader
>>>>>>> WPHome/master
	api.Loader = Loader;
})( wp, jQuery );
