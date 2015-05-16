<<<<<<< HEAD
window.wp = window.wp || {};

(function( exports, $ ) {
	var Uploader;

	if ( typeof _wpPluploadSettings === 'undefined' )
		return;

	/*
	 * An object that helps create a WordPress uploader using plupload.
	 *
	 * @param options - object - The options passed to the new plupload instance.
	 *    Accepts the following parameters:
	 *    - container - The id of uploader container.
	 *    - browser   - The id of button to trigger the file select.
	 *    - dropzone  - The id of file drop target.
	 *    - plupload  - An object of parameters to pass to the plupload instance.
	 *    - params    - An object of parameters to pass to $_POST when uploading the file.
	 *                  Extends this.plupload.multipart_params under the hood.
	 *
	 * @param attributes - object - Attributes and methods for this specific instance.
	 */
	Uploader = function( options ) {
		var self = this,
=======
/* global pluploadL10n, plupload, _wpPluploadSettings */

window.wp = window.wp || {};

( function( exports, $ ) {
	var Uploader;

	if ( typeof _wpPluploadSettings === 'undefined' ) {
		return;
	}

	/**
	 * A WordPress uploader.
	 *
	 * The Plupload library provides cross-browser uploader UI integration.
	 * This object bridges the Plupload API to integrate uploads into the
	 * WordPress back-end and the WordPress media experience.
	 *
	 * @param {object} options           The options passed to the new plupload instance.
	 * @param {object} options.container The id of uploader container.
	 * @param {object} options.browser   The id of button to trigger the file select.
	 * @param {object} options.dropzone  The id of file drop target.
	 * @param {object} options.plupload  An object of parameters to pass to the plupload instance.
	 * @param {object} options.params    An object of parameters to pass to $_POST when uploading the file.
	 *                                   Extends this.plupload.multipart_params under the hood.
	 */
	Uploader = function( options ) {
		var self = this,
			isIE = navigator.userAgent.indexOf('Trident/') != -1 || navigator.userAgent.indexOf('MSIE ') != -1,
>>>>>>> WPHome/master
			elements = {
				container: 'container',
				browser:   'browse_button',
				dropzone:  'drop_element'
			},
			key, error;

		this.supports = {
			upload: Uploader.browser.supported
		};

		this.supported = this.supports.upload;

<<<<<<< HEAD
		if ( ! this.supported )
			return;

=======
		if ( ! this.supported ) {
			return;
		}

		// Arguments to send to pluplad.Uploader().
>>>>>>> WPHome/master
		// Use deep extend to ensure that multipart_params and other objects are cloned.
		this.plupload = $.extend( true, { multipart_params: {} }, Uploader.defaults );
		this.container = document.body; // Set default container.

<<<<<<< HEAD
		// Extend the instance with options
=======
		// Extend the instance with options.
>>>>>>> WPHome/master
		//
		// Use deep extend to allow options.plupload to override individual
		// default plupload keys.
		$.extend( true, this, options );

		// Proxy all methods so this always refers to the current instance.
		for ( key in this ) {
<<<<<<< HEAD
			if ( $.isFunction( this[ key ] ) )
				this[ key ] = $.proxy( this[ key ], this );
		}

		// Ensure all elements are jQuery elements and have id attributes
		// Then set the proper plupload arguments to the ids.
		for ( key in elements ) {
			if ( ! this[ key ] )
				continue;
=======
			if ( $.isFunction( this[ key ] ) ) {
				this[ key ] = $.proxy( this[ key ], this );
			}
		}

		// Ensure all elements are jQuery elements and have id attributes,
		// then set the proper plupload arguments to the ids.
		for ( key in elements ) {
			if ( ! this[ key ] ) {
				continue;
			}
>>>>>>> WPHome/master

			this[ key ] = $( this[ key ] ).first();

			if ( ! this[ key ].length ) {
				delete this[ key ];
				continue;
			}

<<<<<<< HEAD
			if ( ! this[ key ].prop('id') )
				this[ key ].prop( 'id', '__wp-uploader-id-' + Uploader.uuid++ );
=======
			if ( ! this[ key ].prop('id') ) {
				this[ key ].prop( 'id', '__wp-uploader-id-' + Uploader.uuid++ );
			}

>>>>>>> WPHome/master
			this.plupload[ elements[ key ] ] = this[ key ].prop('id');
		}

		// If the uploader has neither a browse button nor a dropzone, bail.
<<<<<<< HEAD
		if ( ! ( this.browser && this.browser.length ) && ! ( this.dropzone && this.dropzone.length ) )
			return;

=======
		if ( ! ( this.browser && this.browser.length ) && ! ( this.dropzone && this.dropzone.length ) ) {
			return;
		}

		// Make sure flash sends cookies (seems in IE it does without switching to urlstream mode)
		if ( ! isIE && 'flash' === plupload.predictRuntime( this.plupload ) &&
			( ! this.plupload.required_features || ! this.plupload.required_features.hasOwnProperty( 'send_binary_string' ) ) ) {

			this.plupload.required_features = this.plupload.required_features || {};
			this.plupload.required_features.send_binary_string = true;
		}

		// Initialize the plupload instance.
>>>>>>> WPHome/master
		this.uploader = new plupload.Uploader( this.plupload );
		delete this.plupload;

		// Set default params and remove this.params alias.
		this.param( this.params || {} );
		delete this.params;

<<<<<<< HEAD
		error = function( message, data, file ) {
			if ( file.attachment )
				file.attachment.destroy();
=======
		/**
		 * Custom error callback.
		 *
		 * Add a new error to the errors collection, so other modules can track
		 * and display errors. @see wp.Uploader.errors.
		 *
		 * @param  {string}        message
		 * @param  {object}        data
		 * @param  {plupload.File} file     File that was uploaded.
		 */
		error = function( message, data, file ) {
			if ( file.attachment ) {
				file.attachment.destroy();
			}
>>>>>>> WPHome/master

			Uploader.errors.unshift({
				message: message || pluploadL10n.default_error,
				data:    data,
				file:    file
			});

			self.error( message, data, file );
		};

<<<<<<< HEAD
		this.uploader.init();

		this.supports.dragdrop = this.uploader.features.dragdrop && ! Uploader.browser.mobile;

		// Generate drag/drop helper classes.
		(function( dropzone, supported ) {
			var timer, active;

			if ( ! dropzone )
				return;

			dropzone.toggleClass( 'supports-drag-drop', !! supported );

			if ( ! supported )
				return dropzone.unbind('.wp-uploader');

			// 'dragenter' doesn't fire correctly,
			// simulate it with a limited 'dragover'
			dropzone.bind( 'dragover.wp-uploader', function(){
				if ( timer )
					clearTimeout( timer );

				if ( active )
					return;
=======
		/**
		 * After the Uploader has been initialized, initialize some behaviors for the dropzone.
		 *
		 * @param {plupload.Uploader} uploader Uploader instance.
		 */
		this.uploader.bind( 'init', function( uploader ) {
			var timer, active, dragdrop,
				dropzone = self.dropzone;

			dragdrop = self.supports.dragdrop = uploader.features.dragdrop && ! Uploader.browser.mobile;

			// Generate drag/drop helper classes.
			if ( ! dropzone ) {
				return;
			}

			dropzone.toggleClass( 'supports-drag-drop', !! dragdrop );

			if ( ! dragdrop ) {
				return dropzone.unbind('.wp-uploader');
			}

			// 'dragenter' doesn't fire correctly, simulate it with a limited 'dragover'.
			dropzone.bind( 'dragover.wp-uploader', function() {
				if ( timer ) {
					clearTimeout( timer );
				}

				if ( active ) {
					return;
				}
>>>>>>> WPHome/master

				dropzone.trigger('dropzone:enter').addClass('drag-over');
				active = true;
			});

<<<<<<< HEAD
			dropzone.bind('dragleave.wp-uploader, drop.wp-uploader', function(){
=======
			dropzone.bind('dragleave.wp-uploader, drop.wp-uploader', function() {
>>>>>>> WPHome/master
				// Using an instant timer prevents the drag-over class from
				// being quickly removed and re-added when elements inside the
				// dropzone are repositioned.
				//
<<<<<<< HEAD
				// See http://core.trac.wordpress.org/ticket/21705
=======
				// @see https://core.trac.wordpress.org/ticket/21705
>>>>>>> WPHome/master
				timer = setTimeout( function() {
					active = false;
					dropzone.trigger('dropzone:leave').removeClass('drag-over');
				}, 0 );
			});
<<<<<<< HEAD
		}( this.dropzone, this.supports.dragdrop ));
=======

			self.ready = true;
			$(self).trigger( 'uploader:ready' );
		});

		this.uploader.init();
>>>>>>> WPHome/master

		if ( this.browser ) {
			this.browser.on( 'mouseenter', this.refresh );
		} else {
			this.uploader.disableBrowse( true );
			// If HTML5 mode, hide the auto-created file container.
			$('#' + this.uploader.id + '_html5_container').hide();
		}

<<<<<<< HEAD
=======
		/**
		 * After files were filtered and added to the queue, create a model for each.
		 *
		 * @event FilesAdded
		 * @param {plupload.Uploader} uploader Uploader instance.
		 * @param {Array}             files    Array of file objects that were added to queue by the user.
		 */
>>>>>>> WPHome/master
		this.uploader.bind( 'FilesAdded', function( up, files ) {
			_.each( files, function( file ) {
				var attributes, image;

				// Ignore failed uploads.
<<<<<<< HEAD
				if ( plupload.FAILED === file.status )
					return;
=======
				if ( plupload.FAILED === file.status ) {
					return;
				}
>>>>>>> WPHome/master

				// Generate attributes for a new `Attachment` model.
				attributes = _.extend({
					file:      file,
					uploading: true,
					date:      new Date(),
					filename:  file.name,
					menuOrder: 0,
					uploadedTo: wp.media.model.settings.post.id
				}, _.pick( file, 'loaded', 'size', 'percent' ) );

				// Handle early mime type scanning for images.
				image = /(?:jpe?g|png|gif)$/i.exec( file.name );

<<<<<<< HEAD
				// Did we find an image?
=======
				// For images set the model's type and subtype attributes.
>>>>>>> WPHome/master
				if ( image ) {
					attributes.type = 'image';

					// `jpeg`, `png` and `gif` are valid subtypes.
					// `jpg` is not, so map it to `jpeg`.
					attributes.subtype = ( 'jpg' === image[0] ) ? 'jpeg' : image[0];
				}

<<<<<<< HEAD
				// Create the `Attachment`.
				file.attachment = wp.media.model.Attachment.create( attributes );

=======
				// Create a model for the attachment, and add it to the Upload queue collection
				// so listeners to the upload queue can track and display upload progress.
				file.attachment = wp.media.model.Attachment.create( attributes );
>>>>>>> WPHome/master
				Uploader.queue.add( file.attachment );

				self.added( file.attachment );
			});

			up.refresh();
			up.start();
		});

		this.uploader.bind( 'UploadProgress', function( up, file ) {
			file.attachment.set( _.pick( file, 'loaded', 'percent' ) );
			self.progress( file.attachment );
		});

<<<<<<< HEAD
=======
		/**
		 * After a file is successfully uploaded, update its model.
		 *
		 * @param {plupload.Uploader} uploader Uploader instance.
		 * @param {plupload.File}     file     File that was uploaded.
		 * @param {Object}            response Object with response properties.
		 * @return {mixed}
		 */
>>>>>>> WPHome/master
		this.uploader.bind( 'FileUploaded', function( up, file, response ) {
			var complete;

			try {
				response = JSON.parse( response.response );
			} catch ( e ) {
				return error( pluploadL10n.default_error, e, file );
			}

			if ( ! _.isObject( response ) || _.isUndefined( response.success ) )
				return error( pluploadL10n.default_error, null, file );
			else if ( ! response.success )
				return error( response.data && response.data.message, response.data, file );

			_.each(['file','loaded','size','percent'], function( key ) {
				file.attachment.unset( key );
			});

			file.attachment.set( _.extend( response.data, { uploading: false }) );
			wp.media.model.Attachment.get( response.data.id, file.attachment );

			complete = Uploader.queue.all( function( attachment ) {
				return ! attachment.get('uploading');
			});

			if ( complete )
				Uploader.queue.reset();

			self.success( file.attachment );
		});

<<<<<<< HEAD
=======
		/**
		 * When plupload surfaces an error, send it to the error handler.
		 *
		 * @param {plupload.Uploader} uploader Uploader instance.
		 * @param {Object}            error    Contains code, message and sometimes file and other details.
		 */
>>>>>>> WPHome/master
		this.uploader.bind( 'Error', function( up, pluploadError ) {
			var message = pluploadL10n.default_error,
				key;

			// Check for plupload errors.
			for ( key in Uploader.errorMap ) {
				if ( pluploadError.code === plupload[ key ] ) {
					message = Uploader.errorMap[ key ];
<<<<<<< HEAD
					if ( _.isFunction( message ) )
						message = message( pluploadError.file, pluploadError );
=======

					if ( _.isFunction( message ) ) {
						message = message( pluploadError.file, pluploadError );
					}

>>>>>>> WPHome/master
					break;
				}
			}

			error( message, pluploadError, pluploadError.file );
			up.refresh();
		});

<<<<<<< HEAD
		this.init();
=======
		this.uploader.bind( 'PostInit', function() {
			self.init();
		});
>>>>>>> WPHome/master
	};

	// Adds the 'defaults' and 'browser' properties.
	$.extend( Uploader, _wpPluploadSettings );

	Uploader.uuid = 0;

<<<<<<< HEAD
=======
	// Map Plupload error codes to user friendly error messages.
>>>>>>> WPHome/master
	Uploader.errorMap = {
		'FAILED':                 pluploadL10n.upload_failed,
		'FILE_EXTENSION_ERROR':   pluploadL10n.invalid_filetype,
		'IMAGE_FORMAT_ERROR':     pluploadL10n.not_an_image,
		'IMAGE_MEMORY_ERROR':     pluploadL10n.image_memory_exceeded,
		'IMAGE_DIMENSIONS_ERROR': pluploadL10n.image_dimensions_exceeded,
		'GENERIC_ERROR':          pluploadL10n.upload_failed,
		'IO_ERROR':               pluploadL10n.io_error,
		'HTTP_ERROR':             pluploadL10n.http_error,
		'SECURITY_ERROR':         pluploadL10n.security_error,

		'FILE_SIZE_ERROR': function( file ) {
			return pluploadL10n.file_exceeds_size_limit.replace('%s', file.name);
		}
	};

	$.extend( Uploader.prototype, {
		/**
		 * Acts as a shortcut to extending the uploader's multipart_params object.
		 *
		 * param( key )
		 *    Returns the value of the key.
		 *
		 * param( key, value )
		 *    Sets the value of a key.
		 *
		 * param( map )
		 *    Sets values for a map of data.
		 */
		param: function( key, value ) {
<<<<<<< HEAD
			if ( arguments.length === 1 && typeof key === 'string' )
				return this.uploader.settings.multipart_params[ key ];
=======
			if ( arguments.length === 1 && typeof key === 'string' ) {
				return this.uploader.settings.multipart_params[ key ];
			}
>>>>>>> WPHome/master

			if ( arguments.length > 1 ) {
				this.uploader.settings.multipart_params[ key ] = value;
			} else {
				$.extend( this.uploader.settings.multipart_params, key );
			}
		},

<<<<<<< HEAD
=======
		/**
		 * Make a few internal event callbacks available on the wp.Uploader object
		 * to change the Uploader internals if absolutely necessary.
		 */
>>>>>>> WPHome/master
		init:     function() {},
		error:    function() {},
		success:  function() {},
		added:    function() {},
		progress: function() {},
		complete: function() {},
		refresh:  function() {
			var node, attached, container, id;

			if ( this.browser ) {
				node = this.browser[0];

				// Check if the browser node is in the DOM.
				while ( node ) {
					if ( node === document.body ) {
						attached = true;
						break;
					}
					node = node.parentNode;
				}

				// If the browser node is not attached to the DOM, use a
				// temporary container to house it, as the browser button
				// shims require the button to exist in the DOM at all times.
				if ( ! attached ) {
					id = 'wp-uploader-browser-' + this.uploader.id;

					container = $( '#' + id );
					if ( ! container.length ) {
						container = $('<div class="wp-uploader-browser" />').css({
							position: 'fixed',
							top: '-1000px',
							left: '-1000px',
							height: 0,
							width: 0
						}).attr( 'id', 'wp-uploader-browser-' + this.uploader.id ).appendTo('body');
					}

					container.append( this.browser );
				}
			}

			this.uploader.refresh();
		}
	});

<<<<<<< HEAD
	Uploader.queue = new wp.media.model.Attachments( [], { query: false });
=======
	// Create a collection of attachments in the upload queue,
	// so that other modules can track and display upload progress.
	Uploader.queue = new wp.media.model.Attachments( [], { query: false });

	// Create a collection to collect errors incurred while attempting upload.
>>>>>>> WPHome/master
	Uploader.errors = new Backbone.Collection();

	exports.Uploader = Uploader;
})( wp, jQuery );
