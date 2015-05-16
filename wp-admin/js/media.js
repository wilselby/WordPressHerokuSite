<<<<<<< HEAD

var findPosts;
(function($){
	findPosts = {
		open : function(af_name, af_val) {
			var st = document.documentElement.scrollTop || $(document).scrollTop(),
				overlay = $( '.ui-find-overlay' );

			if ( overlay.length == 0 ) {
=======
/* global ajaxurl, attachMediaBoxL10n, _wpMediaGridSettings */

var findPosts;
( function( $ ){
	findPosts = {
		open: function( af_name, af_val ) {
			var overlay = $( '.ui-find-overlay' );

			if ( overlay.length === 0 ) {
>>>>>>> WPHome/master
				$( 'body' ).append( '<div class="ui-find-overlay"></div>' );
				findPosts.overlay();
			}

			overlay.show();

			if ( af_name && af_val ) {
<<<<<<< HEAD
				$('#affected').attr('name', af_name).val(af_val);
			}
			$('#find-posts').show().draggable({
				handle: '#find-posts-head'
			}).css({'top':st + 50 + 'px','left':'50%','marginLeft':'-328px'});

			$('#find-posts-input').focus().keyup(function(e){
				if (e.which == 27) { findPosts.close(); } // close on Escape
=======
				$( '#affected' ).attr( 'name', af_name ).val( af_val );
			}

			$( '#find-posts' ).show();

			$('#find-posts-input').focus().keyup( function( event ){
				if ( event.which == 27 ) {
					findPosts.close();
				} // close on Escape
>>>>>>> WPHome/master
			});

			// Pull some results up by default
			findPosts.send();

			return false;
		},

<<<<<<< HEAD
		close : function() {
			$('#find-posts-response').html('');
			$('#find-posts').draggable('destroy').hide();
			$( '.ui-find-overlay' ).hide();
		},

		overlay : function() {
			$( '.ui-find-overlay' ).css(
				{ 'z-index': '999', 'width': $( document ).width() + 'px', 'height': $( document ).height() + 'px' }
			).on('click', function () {
=======
		close: function() {
			$('#find-posts-response').empty();
			$('#find-posts').hide();
			$( '.ui-find-overlay' ).hide();
		},

		overlay: function() {
			$( '.ui-find-overlay' ).on( 'click', function () {
>>>>>>> WPHome/master
				findPosts.close();
			});
		},

<<<<<<< HEAD
		send : function() {
			var post = {
					ps: $('#find-posts-input').val(),
=======
		send: function() {
			var post = {
					ps: $( '#find-posts-input' ).val(),
>>>>>>> WPHome/master
					action: 'find_posts',
					_ajax_nonce: $('#_ajax_nonce').val()
				},
				spinner = $( '.find-box-search .spinner' );

<<<<<<< HEAD
			spinner.show();

			$.ajax({
				type : 'POST',
				url : ajaxurl,
				data : post,
				success : function(x) { findPosts.show(x); spinner.hide(); },
				error : function(r) { findPosts.error(r); spinner.hide(); }
			});
		},

		show : function(x) {

			if ( typeof(x) == 'string' ) {
				this.error({'responseText': x});
				return;
			}

			var r = wpAjax.parseAjaxResponse(x);

			if ( r.errors ) {
				this.error({'responseText': wpAjax.broken});
			}
			r = r.responses[0];
			$('#find-posts-response').html(r.data);

			// Enable whole row to be clicked
			$( '.found-posts td' ).on( 'click', function () {
				$( this ).parent().find( '.found-radio input' ).prop( 'checked', true );
			});
		},

		error : function(r) {
			var er = r.statusText;

			if ( r.responseText ) {
				er = r.responseText.replace( /<.[^<>]*?>/g, '' );
			}
			if ( er ) {
				$('#find-posts-response').html(er);
			}
		}
	};

	$(document).ready(function() {
		$('#find-posts-submit').click(function(e) {
			if ( '' == $('#find-posts-response').html() )
				e.preventDefault();
=======
			spinner.addClass( 'is-active' );

			$.ajax( ajaxurl, {
				type: 'POST',
				data: post,
				dataType: 'json'
			}).always( function() {
				spinner.removeClass( 'is-active' );
			}).done( function( x ) {
				if ( ! x.success ) {
					$( '#find-posts-response' ).text( attachMediaBoxL10n.error );
				}

				$( '#find-posts-response' ).html( x.data );
			}).fail( function() {
				$( '#find-posts-response' ).text( attachMediaBoxL10n.error );
			});
		}
	};

	$( document ).ready( function() {
		var settings, $mediaGridWrap = $( '#wp-media-grid' );

		// Open up a manage media frame into the grid.
		if ( $mediaGridWrap.length && window.wp && window.wp.media ) {
			settings = _wpMediaGridSettings;

			window.wp.media({
				frame: 'manage',
				container: $mediaGridWrap,
				library: settings.queryVars
			}).open();
		}

		$( '#find-posts-submit' ).click( function( event ) {
			if ( ! $( '#find-posts-response input[type="radio"]:checked' ).length )
				event.preventDefault();
>>>>>>> WPHome/master
		});
		$( '#find-posts .find-box-search :input' ).keypress( function( event ) {
			if ( 13 == event.which ) {
				findPosts.send();
				return false;
			}
<<<<<<< HEAD
		} );
		$( '#find-posts-search' ).click( findPosts.send );
		$( '#find-posts-close' ).click( findPosts.close );
		$('#doaction, #doaction2').click(function(e){
			$('select[name^="action"]').each(function(){
				if ( $(this).val() == 'attach' ) {
					e.preventDefault();
=======
		});
		$( '#find-posts-search' ).click( findPosts.send );
		$( '#find-posts-close' ).click( findPosts.close );
		$( '#doaction, #doaction2' ).click( function( event ) {
			$( 'select[name^="action"]' ).each( function() {
				if ( $(this).val() === 'attach' ) {
					event.preventDefault();
>>>>>>> WPHome/master
					findPosts.open();
				}
			});
		});
<<<<<<< HEAD
	});
	$(window).resize(function() {
		findPosts.overlay();
	});
})(jQuery);
=======

		// Enable whole row to be clicked
		$( '.find-box-inside' ).on( 'click', 'tr', function() {
			$( this ).find( '.found-radio input' ).prop( 'checked', true );
		});
	});
})( jQuery );
>>>>>>> WPHome/master
