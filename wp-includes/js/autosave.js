<<<<<<< HEAD
var autosave, autosaveLast = '', autosavePeriodical, autosaveOldMessage = '', autosaveDelayPreview = false, notSaved = true, blockSave = false, fullscreen, autosaveLockRelease = true;

jQuery(document).ready( function($) {

	autosaveLast = ( $('#post #title').val() || '' ) + ( $('#post #content').val() || '' );
	autosavePeriodical = $.schedule({time: autosaveL10n.autosaveInterval * 1000, func: function() { autosave(); }, repeat: true, protect: true});

	//Disable autosave after the form has been submitted
	$("#post").submit(function() {
		$.cancel(autosavePeriodical);
		autosaveLockRelease = false;
	});

	$('input[type="submit"], a.submitdelete', '#submitpost').click(function(){
		blockSave = true;
		window.onbeforeunload = null;
		$(':button, :submit', '#submitpost').each(function(){
			var t = $(this);
			if ( t.hasClass('button-primary') )
				t.addClass('button-primary-disabled');
			else
				t.addClass('button-disabled');
		});
		if ( $(this).attr('id') == 'publish' )
			$('#major-publishing-actions .spinner').show();
		else
			$('#minor-publishing .spinner').show();
	});

	window.onbeforeunload = function(){
		var mce = typeof(tinymce) != 'undefined' ? tinymce.activeEditor : false, title, content;

		if ( mce && !mce.isHidden() ) {
			if ( mce.isDirty() )
				return autosaveL10n.saveAlert;
		} else {
			if ( fullscreen && fullscreen.settings.visible ) {
				title = $('#wp-fullscreen-title').val() || '';
				content = $("#wp_mce_fullscreen").val() || '';
			} else {
				title = $('#post #title').val() || '';
				content = $('#post #content').val() || '';
			}

			if ( ( title || content ) && title + content != autosaveLast )
				return autosaveL10n.saveAlert;
		}
	};

	$(window).unload( function(e) {
		if ( ! autosaveLockRelease )
			return;

		// unload fires (twice) on removing the Thickbox iframe. Make sure we process only the main document unload.
		if ( e.target && e.target.nodeName != '#document' )
			return;

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			async: false,
			data: {
				action: 'wp-remove-post-lock',
				_wpnonce: $('#_wpnonce').val(),
				post_ID: $('#post_ID').val(),
				active_post_lock: $('#active_post_lock').val()
			}
		});
	} );

	// preview
	$('#post-preview').click(function(){
		if ( $('#auto_draft').val() == '1' && notSaved ) {
			autosaveDelayPreview = true;
			autosave();
			return false;
		}
		doPreview();
		return false;
	});

	doPreview = function() {
		$('input#wp-preview').val('dopreview');
		$('form#post').attr('target', 'wp-preview').submit().attr('target', '');

		/*
		 * Workaround for WebKit bug preventing a form submitting twice to the same action.
		 * https://bugs.webkit.org/show_bug.cgi?id=28633
		 */
		if ( $.browser.safari ) {
			$('form#post').attr('action', function(index, value) {
				return value + '?t=' + new Date().getTime();
			});
		}

		$('input#wp-preview').val('');
	}

	// This code is meant to allow tabbing from Title to Post content.
	$('#title').on('keydown.editor-focus', function(e) {
		var ed;

		if ( e.which != 9 )
			return;

		if ( !e.ctrlKey && !e.altKey && !e.shiftKey ) {
			if ( typeof(tinymce) != 'undefined' )
				ed = tinymce.get('content');

			if ( ed && !ed.isHidden() ) {
				$(this).one('keyup', function(e){
					$('#content_tbl td.mceToolbar > a').focus();
				});
			} else {
				$('#content').focus();
			}

			e.preventDefault();
		}
	});

	// autosave new posts after a title is typed but not if Publish or Save Draft is clicked
	if ( '1' == $('#auto_draft').val() ) {
		$('#title').blur( function() {
			if ( !this.value || $('#auto_draft').val() != '1' )
				return;
			delayed_autosave();
		});
	}
});

function autosave_parse_response(response) {
	var res = wpAjax.parseAjaxResponse(response, 'autosave'), message = '', postID, sup;

	if ( res && res.responses && res.responses.length ) {
		message = res.responses[0].data; // The saved message or error.
		// someone else is editing: disable autosave, set errors
		if ( res.responses[0].supplemental ) {
			sup = res.responses[0].supplemental;
			if ( 'disable' == sup['disable_autosave'] ) {
				autosave = function() {};
				autosaveLockRelease = false;
				res = { errors: true };
			}

			if ( sup['active-post-lock'] ) {
				jQuery('#active_post_lock').val( sup['active-post-lock'] );
			}

			if ( sup['alert'] ) {
				jQuery('#autosave-alert').remove();
				jQuery('#titlediv').after('<div id="autosave-alert" class="error below-h2"><p>' + sup['alert'] + '</p></div>');
			}

			jQuery.each(sup, function(selector, value) {
				if ( selector.match(/^replace-/) ) {
					jQuery('#'+selector.replace('replace-', '')).val(value);
				}
			});
		}

		// if no errors: add slug UI
		if ( !res.errors ) {
			postID = parseInt( res.responses[0].id, 10 );
			if ( !isNaN(postID) && postID > 0 ) {
				autosave_update_slug(postID);
			}
		}
	}
	if ( message ) { // update autosave message
		jQuery('.autosave-message').html(message);
	} else if ( autosaveOldMessage && res ) {
		jQuery('.autosave-message').html( autosaveOldMessage );
	}
	return res;
}

// called when autosaving pre-existing post
function autosave_saved(response) {
	blockSave = false;
	autosave_parse_response(response); // parse the ajax response
	autosave_enable_buttons(); // re-enable disabled form buttons
}

// called when autosaving new post
function autosave_saved_new(response) {
	blockSave = false;
	var res = autosave_parse_response(response), postID;
	if ( res && res.responses.length && !res.errors ) {
		// An ID is sent only for real auto-saves, not for autosave=0 "keepalive" saves
		postID = parseInt( res.responses[0].id, 10 );
		if ( !isNaN(postID) && postID > 0 ) {
			notSaved = false;
			jQuery('#auto_draft').val('0'); // No longer an auto-draft
		}
		autosave_enable_buttons();
		if ( autosaveDelayPreview ) {
			autosaveDelayPreview = false;
			doPreview();
		}
	} else {
		autosave_enable_buttons(); // re-enable disabled form buttons
	}
}

function autosave_update_slug(post_id) {
	// create slug area only if not already there
	if ( 'undefined' != makeSlugeditClickable && jQuery.isFunction(makeSlugeditClickable) && !jQuery('#edit-slug-box > *').size() ) {
		jQuery.post( ajaxurl, {
				action: 'sample-permalink',
				post_id: post_id,
				new_title: fullscreen && fullscreen.settings.visible ? jQuery('#wp-fullscreen-title').val() : jQuery('#title').val(),
				samplepermalinknonce: jQuery('#samplepermalinknonce').val()
			},
			function(data) {
				if ( data !== '-1' ) {
					jQuery('#edit-slug-box').html(data);
					makeSlugeditClickable();
				}
			}
		);
	}
}

function autosave_loading() {
	jQuery('.autosave-message').html(autosaveL10n.savingText);
}

function autosave_enable_buttons() {
	// delay that a bit to avoid some rare collisions while the DOM is being updated.
	setTimeout(function(){
		jQuery(':button, :submit', '#submitpost').removeAttr('disabled');
		jQuery('.spinner', '#submitpost').hide();
	}, 500);
}

function autosave_disable_buttons() {
	jQuery(':button, :submit', '#submitpost').prop('disabled', true);
	// Re-enable 5 sec later. Just gives autosave a head start to avoid collisions.
	setTimeout(autosave_enable_buttons, 5000);
}

function delayed_autosave() {
	setTimeout(function(){
		if ( blockSave )
			return;
		autosave();
	}, 200);
}

autosave = function() {
	// (bool) is rich editor enabled and active
	blockSave = true;
	var rich = (typeof tinymce != "undefined") && tinymce.activeEditor && !tinymce.activeEditor.isHidden(),
		post_data, doAutoSave, ed, origStatus, successCallback;

	autosave_disable_buttons();

	post_data = {
		action: "autosave",
		post_ID:  jQuery("#post_ID").val() || 0,
		autosavenonce: jQuery('#autosavenonce').val(),
		post_type: jQuery('#post_type').val() || "",
		autosave: 1
	};

	jQuery('.tags-input').each( function() {
		post_data[this.name] = this.value;
	} );

	// We always send the ajax request in order to keep the post lock fresh.
	// This (bool) tells whether or not to write the post to the DB during the ajax request.
	doAutoSave = true;

	// No autosave while thickbox is open (media buttons)
	if ( jQuery("#TB_window").css('display') == 'block' )
		doAutoSave = false;

	/* Gotta do this up here so we can check the length when tinymce is in use */
	if ( rich && doAutoSave ) {
		ed = tinymce.activeEditor;
		// Don't run while the tinymce spellcheck is on. It resets all found words.
		if ( ed.plugins.spellchecker && ed.plugins.spellchecker.active ) {
			doAutoSave = false;
		} else {
			if ( 'mce_fullscreen' == ed.id || 'wp_mce_fullscreen' == ed.id )
				tinymce.get('content').setContent(ed.getContent({format : 'raw'}), {format : 'raw'});
			tinymce.triggerSave();
		}
	}

	if ( fullscreen && fullscreen.settings.visible ) {
		post_data["post_title"] = jQuery('#wp-fullscreen-title').val() || '';
		post_data["content"] = jQuery("#wp_mce_fullscreen").val() || '';
	} else {
		post_data["post_title"] = jQuery("#title").val() || '';
		post_data["content"] = jQuery("#content").val() || '';
	}

	if ( jQuery('#post_name').val() )
		post_data["post_name"] = jQuery('#post_name').val();

	// Nothing to save or no change.
	if ( ( post_data["post_title"].length == 0 && post_data["content"].length == 0 ) || post_data["post_title"] + post_data["content"] == autosaveLast ) {
		doAutoSave = false;
	}

	origStatus = jQuery('#original_post_status').val();

	goodcats = ([]);
	jQuery("[name='post_category[]']:checked").each( function(i) {
		goodcats.push(this.value);
	} );
	post_data["catslist"] = goodcats.join(",");

	if ( jQuery("#comment_status").prop("checked") )
		post_data["comment_status"] = 'open';
	if ( jQuery("#ping_status").prop("checked") )
		post_data["ping_status"] = 'open';
	if ( jQuery("#excerpt").size() )
		post_data["excerpt"] = jQuery("#excerpt").val();
	if ( jQuery("#post_author").size() )
		post_data["post_author"] = jQuery("#post_author").val();
	if ( jQuery("#parent_id").val() )
		post_data["parent_id"] = jQuery("#parent_id").val();
	post_data["user_ID"] = jQuery("#user-id").val();
	if ( jQuery('#auto_draft').val() == '1' )
		post_data["auto_draft"] = '1';

	if ( doAutoSave ) {
		autosaveLast = post_data["post_title"] + post_data["content"];
		jQuery(document).triggerHandler('wpcountwords', [ post_data["content"] ]);
	} else {
		post_data['autosave'] = 0;
	}

	if ( post_data["auto_draft"] == '1' ) {
		successCallback = autosave_saved_new; // new post
	} else {
		successCallback = autosave_saved; // pre-existing post
	}

	autosaveOldMessage = jQuery('#autosave').html();
	jQuery.ajax({
		data: post_data,
		beforeSend: doAutoSave ? autosave_loading : null,
		type: "POST",
		url: ajaxurl,
		success: successCallback
	});
}
=======
/* global tinymce, wpCookies, autosaveL10n, switchEditors */
// Back-compat
window.autosave = function() {
	return true;
};

( function( $, window ) {
	function autosave() {
		var initialCompareString,
		lastTriggerSave = 0,
		$document = $(document);

		/**
		 * Returns the data saved in both local and remote autosave
		 *
		 * @return object Object containing the post data
		 */
		function getPostData( type ) {
			var post_name, parent_id, data,
				time = ( new Date() ).getTime(),
				cats = [],
				editor = typeof tinymce !== 'undefined' && tinymce.get('content');

			// Don't run editor.save() more often than every 3 sec.
			// It is resource intensive and might slow down typing in long posts on slow devices.
			if ( editor && ! editor.isHidden() && time - 3000 > lastTriggerSave ) {
				editor.save();
				lastTriggerSave = time;
			}

			data = {
				post_id: $( '#post_ID' ).val() || 0,
				post_type: $( '#post_type' ).val() || '',
				post_author: $( '#post_author' ).val() || '',
				post_title: $( '#title' ).val() || '',
				content: $( '#content' ).val() || '',
				excerpt: $( '#excerpt' ).val() || ''
			};

			if ( type === 'local' ) {
				return data;
			}

			$( 'input[id^="in-category-"]:checked' ).each( function() {
				cats.push( this.value );
			});
			data.catslist = cats.join(',');

			if ( post_name = $( '#post_name' ).val() ) {
				data.post_name = post_name;
			}

			if ( parent_id = $( '#parent_id' ).val() ) {
				data.parent_id = parent_id;
			}

			if ( $( '#comment_status' ).prop( 'checked' ) ) {
				data.comment_status = 'open';
			}

			if ( $( '#ping_status' ).prop( 'checked' ) ) {
				data.ping_status = 'open';
			}

			if ( $( '#auto_draft' ).val() === '1' ) {
				data.auto_draft = '1';
			}

			return data;
		}

		// Concatenate title, content and excerpt. Used to track changes when auto-saving.
		function getCompareString( postData ) {
			if ( typeof postData === 'object' ) {
				return ( postData.post_title || '' ) + '::' + ( postData.content || '' ) + '::' + ( postData.excerpt || '' );
			}

			return ( $('#title').val() || '' ) + '::' + ( $('#content').val() || '' ) + '::' + ( $('#excerpt').val() || '' );
		}

		function disableButtons() {
			$document.trigger('autosave-disable-buttons');
			// Re-enable 5 sec later. Just gives autosave a head start to avoid collisions.
			setTimeout( enableButtons, 5000 );
		}

		function enableButtons() {
			$document.trigger( 'autosave-enable-buttons' );
		}

		// Autosave in localStorage
		function autosaveLocal() {
			var restorePostData, undoPostData, blog_id, post_id, hasStorage, intervalTimer,
				lastCompareString,
				isSuspended = false;

			// Check if the browser supports sessionStorage and it's not disabled
			function checkStorage() {
				var test = Math.random().toString(),
					result = false;

				try {
					window.sessionStorage.setItem( 'wp-test', test );
					result = window.sessionStorage.getItem( 'wp-test' ) === test;
					window.sessionStorage.removeItem( 'wp-test' );
				} catch(e) {}

				hasStorage = result;
				return result;
			}

			/**
			 * Initialize the local storage
			 *
			 * @return mixed False if no sessionStorage in the browser or an Object containing all postData for this blog
			 */
			function getStorage() {
				var stored_obj = false;
				// Separate local storage containers for each blog_id
				if ( hasStorage && blog_id ) {
					stored_obj = sessionStorage.getItem( 'wp-autosave-' + blog_id );

					if ( stored_obj ) {
						stored_obj = JSON.parse( stored_obj );
					} else {
						stored_obj = {};
					}
				}

				return stored_obj;
			}

			/**
			 * Set the storage for this blog
			 *
			 * Confirms that the data was saved successfully.
			 *
			 * @return bool
			 */
			function setStorage( stored_obj ) {
				var key;

				if ( hasStorage && blog_id ) {
					key = 'wp-autosave-' + blog_id;
					sessionStorage.setItem( key, JSON.stringify( stored_obj ) );
					return sessionStorage.getItem( key ) !== null;
				}

				return false;
			}

			/**
			 * Get the saved post data for the current post
			 *
			 * @return mixed False if no storage or no data or the postData as an Object
			 */
			function getSavedPostData() {
				var stored = getStorage();

				if ( ! stored || ! post_id ) {
					return false;
				}

				return stored[ 'post_' + post_id ] || false;
			}

			/**
			 * Set (save or delete) post data in the storage.
			 *
			 * If stored_data evaluates to 'false' the storage key for the current post will be removed
			 *
			 * $param stored_data The post data to store or null/false/empty to delete the key
			 * @return bool
			 */
			function setData( stored_data ) {
				var stored = getStorage();

				if ( ! stored || ! post_id ) {
					return false;
				}

				if ( stored_data ) {
					stored[ 'post_' + post_id ] = stored_data;
				} else if ( stored.hasOwnProperty( 'post_' + post_id ) ) {
					delete stored[ 'post_' + post_id ];
				} else {
					return false;
				}

				return setStorage( stored );
			}

			function suspend() {
				isSuspended = true;
			}

			function resume() {
				isSuspended = false;
			}

			/**
			 * Save post data for the current post
			 *
			 * Runs on a 15 sec. interval, saves when there are differences in the post title or content.
			 * When the optional data is provided, updates the last saved post data.
			 *
			 * $param data optional Object The post data for saving, minimum 'post_title' and 'content'
			 * @return bool
			 */
			function save( data ) {
				var postData, compareString,
					result = false;

				if ( isSuspended || ! hasStorage ) {
					return false;
				}

				if ( data ) {
					postData = getSavedPostData() || {};
					$.extend( postData, data );
				} else {
					postData = getPostData('local');
				}

				compareString = getCompareString( postData );

				if ( typeof lastCompareString === 'undefined' ) {
					lastCompareString = initialCompareString;
				}

				// If the content, title and excerpt did not change since the last save, don't save again
				if ( compareString === lastCompareString ) {
					return false;
				}

				postData.save_time = ( new Date() ).getTime();
				postData.status = $( '#post_status' ).val() || '';
				result = setData( postData );

				if ( result ) {
					lastCompareString = compareString;
				}

				return result;
			}

			// Run on DOM ready
			function run() {
				post_id = $('#post_ID').val() || 0;

				// Check if the local post data is different than the loaded post data.
				if ( $( '#wp-content-wrap' ).hasClass( 'tmce-active' ) ) {
					// If TinyMCE loads first, check the post 1.5 sec. after it is ready.
					// By this time the content has been loaded in the editor and 'saved' to the textarea.
					// This prevents false positives.
					$document.on( 'tinymce-editor-init.autosave', function() {
						window.setTimeout( function() {
							checkPost();
						}, 1500 );
					});
				} else {
					checkPost();
				}

				// Save every 15 sec.
				intervalTimer = window.setInterval( save, 15000 );

				$( 'form#post' ).on( 'submit.autosave-local', function() {
					var editor = typeof tinymce !== 'undefined' && tinymce.get('content'),
						post_id = $('#post_ID').val() || 0;

					if ( editor && ! editor.isHidden() ) {
						// Last onSubmit event in the editor, needs to run after the content has been moved to the textarea.
						editor.on( 'submit', function() {
							save({
								post_title: $( '#title' ).val() || '',
								content: $( '#content' ).val() || '',
								excerpt: $( '#excerpt' ).val() || ''
							});
						});
					} else {
						save({
							post_title: $( '#title' ).val() || '',
							content: $( '#content' ).val() || '',
							excerpt: $( '#excerpt' ).val() || ''
						});
					}

					wpCookies.set( 'wp-saving-post', post_id + '-check', 24 * 60 * 60 );
				});
			}

			// Strip whitespace and compare two strings
			function compare( str1, str2 ) {
				function removeSpaces( string ) {
					return string.toString().replace(/[\x20\t\r\n\f]+/g, '');
				}

				return ( removeSpaces( str1 || '' ) === removeSpaces( str2 || '' ) );
			}

			/**
			 * Check if the saved data for the current post (if any) is different than the loaded post data on the screen
			 *
			 * Shows a standard message letting the user restore the post data if different.
			 *
			 * @return void
			 */
			function checkPost() {
				var content, post_title, excerpt, $notice,
					postData = getSavedPostData(),
					cookie = wpCookies.get( 'wp-saving-post' );

				if ( cookie === post_id + '-saved' ) {
					wpCookies.remove( 'wp-saving-post' );
					// The post was saved properly, remove old data and bail
					setData( false );
					return;
				}

				if ( ! postData ) {
					return;
				}

				// There is a newer autosave. Don't show two "restore" notices at the same time.
				if ( $( '#has-newer-autosave' ).length ) {
					return;
				}

				content = $( '#content' ).val() || '';
				post_title = $( '#title' ).val() || '';
				excerpt = $( '#excerpt' ).val() || '';

				if ( compare( content, postData.content ) && compare( post_title, postData.post_title ) &&
					compare( excerpt, postData.excerpt ) ) {

					return;
				}

				restorePostData = postData;
				undoPostData = {
					content: content,
					post_title: post_title,
					excerpt: excerpt
				};

				$notice = $( '#local-storage-notice' );
				$('.wrap h2').first().after( $notice.addClass( 'notice-warning' ).show() );

				$notice.on( 'click.autosave-local', function( event ) {
					var $target = $( event.target );

					if ( $target.hasClass( 'restore-backup' ) ) {
						restorePost( restorePostData );
						$target.parent().hide();
						$(this).find( 'p.undo-restore' ).show();
						$notice.removeClass( 'notice-warning' ).addClass( 'notice-success' );
					} else if ( $target.hasClass( 'undo-restore-backup' ) ) {
						restorePost( undoPostData );
						$target.parent().hide();
						$(this).find( 'p.local-restore' ).show();
						$notice.removeClass( 'notice-success' ).addClass( 'notice-warning' );
					}

					event.preventDefault();
				});
			}

			// Restore the current title, content and excerpt from postData.
			function restorePost( postData ) {
				var editor;

				if ( postData ) {
					// Set the last saved data
					lastCompareString = getCompareString( postData );

					if ( $( '#title' ).val() !== postData.post_title ) {
						$( '#title' ).focus().val( postData.post_title || '' );
					}

					$( '#excerpt' ).val( postData.excerpt || '' );
					editor = typeof tinymce !== 'undefined' && tinymce.get('content');

					if ( editor && ! editor.isHidden() && typeof switchEditors !== 'undefined' ) {
						// Make sure there's an undo level in the editor
						editor.undoManager.add();
						editor.setContent( postData.content ? switchEditors.wpautop( postData.content ) : '' );
					} else {
						// Make sure the Text editor is selected
						$( '#content-html' ).click();
						$( '#content' ).val( postData.content );
					}

					return true;
				}

				return false;
			}

			blog_id = typeof window.autosaveL10n !== 'undefined' && window.autosaveL10n.blog_id;

			// Check if the browser supports sessionStorage and it's not disabled,
			// then initialize and run checkPost().
			// Don't run if the post type supports neither 'editor' (textarea#content) nor 'excerpt'.
			if ( checkStorage() && blog_id && ( $('#content').length || $('#excerpt').length ) ) {
				$document.ready( run );
			}

			return {
				hasStorage: hasStorage,
				getSavedPostData: getSavedPostData,
				save: save,
				suspend: suspend,
				resume: resume
			};
		}

		// Autosave on the server
		function autosaveServer() {
			var _blockSave, _blockSaveTimer, previousCompareString, lastCompareString,
				nextRun = 0,
				isSuspended = false;

			// Block saving for the next 10 sec.
			function tempBlockSave() {
				_blockSave = true;
				window.clearTimeout( _blockSaveTimer );

				_blockSaveTimer = window.setTimeout( function() {
					_blockSave = false;
				}, 10000 );
			}

			function suspend() {
				isSuspended = true;
			}

			function resume() {
				isSuspended = false;
			}

			// Runs on heartbeat-response
			function response( data ) {
				_schedule();
				_blockSave = false;
				lastCompareString = previousCompareString;
				previousCompareString = '';

				$document.trigger( 'after-autosave', [data] );
				enableButtons();

				if ( data.success ) {
					// No longer an auto-draft
					$( '#auto_draft' ).val('');
				}
			}

			/**
			 * Save immediately
			 *
			 * Resets the timing and tells heartbeat to connect now
			 *
			 * @return void
			 */
			function triggerSave() {
				nextRun = 0;
				wp.heartbeat.connectNow();
			}

			/**
			 * Checks if the post content in the textarea has changed since page load.
			 *
			 * This also happens when TinyMCE is active and editor.save() is triggered by
			 * wp.autosave.getPostData().
			 *
			 * @return bool
			 */
			function postChanged() {
				return getCompareString() !== initialCompareString;
			}

			// Runs on 'heartbeat-send'
			function save() {
				var postData, compareString;

				// window.autosave() used for back-compat
				if ( isSuspended || _blockSave || ! window.autosave() ) {
					return false;
				}

				if ( ( new Date() ).getTime() < nextRun ) {
					return false;
				}

				postData = getPostData();
				compareString = getCompareString( postData );

				// First check
				if ( typeof lastCompareString === 'undefined' ) {
					lastCompareString = initialCompareString;
				}

				// No change
				if ( compareString === lastCompareString ) {
					return false;
				}

				previousCompareString = compareString;
				tempBlockSave();
				disableButtons();

				$document.trigger( 'wpcountwords', [ postData.content ] )
					.trigger( 'before-autosave', [ postData ] );

				postData._wpnonce = $( '#_wpnonce' ).val() || '';

				return postData;
			}

			function _schedule() {
				nextRun = ( new Date() ).getTime() + ( autosaveL10n.autosaveInterval * 1000 ) || 60000;
			}

			$document.on( 'heartbeat-send.autosave', function( event, data ) {
				var autosaveData = save();

				if ( autosaveData ) {
					data.wp_autosave = autosaveData;
				}
			}).on( 'heartbeat-tick.autosave', function( event, data ) {
				if ( data.wp_autosave ) {
					response( data.wp_autosave );
				}
			}).on( 'heartbeat-connection-lost.autosave', function( event, error, status ) {
				// When connection is lost, keep user from submitting changes.
				if ( 'timeout' === error || 603 === status ) {
					var $notice = $('#lost-connection-notice');

					if ( ! wp.autosave.local.hasStorage ) {
						$notice.find('.hide-if-no-sessionstorage').hide();
					}

					$notice.show();
					disableButtons();
				}
			}).on( 'heartbeat-connection-restored.autosave', function() {
				$('#lost-connection-notice').hide();
				enableButtons();
			}).ready( function() {
				_schedule();
			});

			return {
				tempBlockSave: tempBlockSave,
				triggerSave: triggerSave,
				postChanged: postChanged,
				suspend: suspend,
				resume: resume
			};
		}

		// Wait for TinyMCE to initialize plus 1 sec. for any external css to finish loading,
		// then 'save' to the textarea before setting initialCompareString.
		// This avoids any insignificant differences between the initial textarea content and the content
		// extracted from the editor.
		$document.on( 'tinymce-editor-init.autosave', function( event, editor ) {
			if ( editor.id === 'content' ) {
				window.setTimeout( function() {
					editor.save();
					initialCompareString = getCompareString();
				}, 1000 );
			}
		}).ready( function() {
			// Set the initial compare string in case TinyMCE is not used or not loaded first
			initialCompareString = getCompareString();
		});

		return {
			getPostData: getPostData,
			getCompareString: getCompareString,
			disableButtons: disableButtons,
			enableButtons: enableButtons,
			local: autosaveLocal(),
			server: autosaveServer()
		};
	}

	window.wp = window.wp || {};
	window.wp.autosave = autosave();

}( jQuery, window ));
>>>>>>> WPHome/master
