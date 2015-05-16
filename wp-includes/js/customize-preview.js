(function( exports, $ ){
	var api = wp.customize,
		debounce;

<<<<<<< HEAD
=======
	/**
	 * Returns a debounced version of the function.
	 *
	 * @todo Require Underscore.js for this file and retire this.
	 */
>>>>>>> WPHome/master
	debounce = function( fn, delay, context ) {
		var timeout;
		return function() {
			var args = arguments;

			context = context || this;

			clearTimeout( timeout );
			timeout = setTimeout( function() {
				timeout = null;
				fn.apply( context, args );
			}, delay );
		};
	};

<<<<<<< HEAD
=======
	/**
	 * @constructor
	 * @augments wp.customize.Messenger
	 * @augments wp.customize.Class
	 * @mixes wp.customize.Events
	 */
>>>>>>> WPHome/master
	api.Preview = api.Messenger.extend({
		/**
		 * Requires params:
		 *  - url    - the URL of preview frame
		 */
		initialize: function( params, options ) {
			var self = this;

			api.Messenger.prototype.initialize.call( this, params, options );

			this.body = $( document.body );
			this.body.on( 'click.preview', 'a', function( event ) {
				event.preventDefault();
				self.send( 'scroll', 0 );
				self.send( 'url', $(this).prop('href') );
			});

			// You cannot submit forms.
			// @todo: Allow form submissions by mixing $_POST data with the customize setting $_POST data.
			this.body.on( 'submit.preview', 'form', function( event ) {
				event.preventDefault();
			});

			this.window = $( window );
			this.window.on( 'scroll.preview', debounce( function() {
				self.send( 'scroll', self.window.scrollTop() );
			}, 200 ));

			this.bind( 'scroll', function( distance ) {
				self.window.scrollTop( distance );
			});
		}
	});

	$( function() {
		api.settings = window._wpCustomizeSettings;
		if ( ! api.settings )
			return;

<<<<<<< HEAD
		var preview, bg;

		preview = new api.Preview({
=======
		var bg;

		api.preview = new api.Preview({
>>>>>>> WPHome/master
			url: window.location.href,
			channel: api.settings.channel
		});

<<<<<<< HEAD
		preview.bind( 'settings', function( values ) {
=======
		api.preview.bind( 'settings', function( values ) {
>>>>>>> WPHome/master
			$.each( values, function( id, value ) {
				if ( api.has( id ) )
					api( id ).set( value );
				else
					api.create( id, value );
			});
		});

<<<<<<< HEAD
		preview.trigger( 'settings', api.settings.values );

		preview.bind( 'setting', function( args ) {
=======
		api.preview.trigger( 'settings', api.settings.values );

		api.preview.bind( 'setting', function( args ) {
>>>>>>> WPHome/master
			var value;

			args = args.slice();

			if ( value = api( args.shift() ) )
				value.set.apply( value, args );
		});

<<<<<<< HEAD
		preview.bind( 'sync', function( events ) {
			$.each( events, function( event, args ) {
				preview.trigger( event, args );
			});
			preview.send( 'synced' );
		});

	 	preview.bind( 'active', function() {
	 		if ( api.settings.nonce )
	 			preview.send( 'nonce', api.settings.nonce );
	 	});

		preview.send( 'ready' );
=======
		api.preview.bind( 'sync', function( events ) {
			$.each( events, function( event, args ) {
				api.preview.trigger( event, args );
			});
			api.preview.send( 'synced' );
		});

		api.preview.bind( 'active', function() {
			if ( api.settings.nonce ) {
				api.preview.send( 'nonce', api.settings.nonce );
			}

			api.preview.send( 'documentTitle', document.title );
		});

		api.preview.send( 'ready', {
			activePanels: api.settings.activePanels,
			activeSections: api.settings.activeSections,
			activeControls: api.settings.activeControls
		} );

		// Display a loading indicator when preview is reloading, and remove on failure.
		api.preview.bind( 'loading-initiated', function () {
			$( 'body' ).addClass( 'wp-customizer-unloading' );
			$( 'html' ).prop( 'title', api.settings.l10n.loading );
		});
		api.preview.bind( 'loading-failed', function () {
			$( 'body' ).removeClass( 'wp-customizer-unloading' );
			$( 'html' ).prop( 'title', '' );
		});
>>>>>>> WPHome/master

		/* Custom Backgrounds */
		bg = $.map(['color', 'image', 'position_x', 'repeat', 'attachment'], function( prop ) {
			return 'background_' + prop;
		});

		api.when.apply( api, bg ).done( function( color, image, position_x, repeat, attachment ) {
			var body = $(document.body),
				head = $('head'),
				style = $('#custom-background-css'),
				update;

<<<<<<< HEAD
			// If custom backgrounds are active and we can't find the
			// default output, bail.
			if ( body.hasClass('custom-background') && ! style.length )
				return;

=======
>>>>>>> WPHome/master
			update = function() {
				var css = '';

				// The body will support custom backgrounds if either
				// the color or image are set.
				//
				// See get_body_class() in /wp-includes/post-template.php
				body.toggleClass( 'custom-background', !! ( color() || image() ) );

				if ( color() )
					css += 'background-color: ' + color() + ';';

				if ( image() ) {
					css += 'background-image: url("' + image() + '");';
					css += 'background-position: top ' + position_x() + ';';
					css += 'background-repeat: ' + repeat() + ';';
					css += 'background-attachment: ' + attachment() + ';';
				}

				// Refresh the stylesheet by removing and recreating it.
				style.remove();
				style = $('<style type="text/css" id="custom-background-css">body.custom-background { ' + css + ' }</style>').appendTo( head );
			};

			$.each( arguments, function() {
				this.bind( update );
			});
		});
<<<<<<< HEAD
=======

		api.trigger( 'preview-ready' );
>>>>>>> WPHome/master
	});

})( wp, jQuery );
