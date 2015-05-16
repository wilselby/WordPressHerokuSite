<<<<<<< HEAD
=======
/* global inlineEditL10n, ajaxurl, typenow */

var inlineEditPost;
>>>>>>> WPHome/master
(function($) {
inlineEditPost = {

	init : function(){
		var t = this, qeRow = $('#inline-edit'), bulkRow = $('#bulk-edit');

		t.type = $('table.widefat').hasClass('pages') ? 'page' : 'post';
		t.what = '#post-';

		// prepare the edit rows
		qeRow.keyup(function(e){
<<<<<<< HEAD
			if (e.which == 27)
				return inlineEditPost.revert();
		});
		bulkRow.keyup(function(e){
			if (e.which == 27)
				return inlineEditPost.revert();
=======
			if ( e.which === 27 ) {
				return inlineEditPost.revert();
			}
		});
		bulkRow.keyup(function(e){
			if ( e.which === 27 ) {
				return inlineEditPost.revert();
			}
>>>>>>> WPHome/master
		});

		$('a.cancel', qeRow).click(function(){
			return inlineEditPost.revert();
		});
		$('a.save', qeRow).click(function(){
			return inlineEditPost.save(this);
		});
		$('td', qeRow).keydown(function(e){
<<<<<<< HEAD
			if ( e.which == 13 )
				return inlineEditPost.save(this);
=======
			if ( e.which === 13 && ! $( e.target ).hasClass( 'cancel' ) ) {
				return inlineEditPost.save(this);
			}
>>>>>>> WPHome/master
		});

		$('a.cancel', bulkRow).click(function(){
			return inlineEditPost.revert();
		});

		$('#inline-edit .inline-edit-private input[value="private"]').click( function(){
			var pw = $('input.inline-edit-password-input');
			if ( $(this).prop('checked') ) {
				pw.val('').prop('disabled', true);
			} else {
				pw.prop('disabled', false);
			}
		});

		// add events
<<<<<<< HEAD
		$('a.editinline').live('click', function(){
=======
		$('#the-list').on('click', 'a.editinline', function(){
>>>>>>> WPHome/master
			inlineEditPost.edit(this);
			return false;
		});

<<<<<<< HEAD
		$('#bulk-title-div').parents('fieldset').after(
=======
		$('#bulk-edit').find('fieldset:first').after(
>>>>>>> WPHome/master
			$('#inline-edit fieldset.inline-edit-categories').clone()
		).siblings( 'fieldset:last' ).prepend(
			$('#inline-edit label.inline-edit-tags').clone()
		);

<<<<<<< HEAD
		// hiearchical taxonomies expandable?
		$('span.catshow').click(function(){
			$(this).hide().next().show().parent().next().addClass("cat-hover");
		});

		$('span.cathide').click(function(){
			$(this).hide().prev().show().parent().next().removeClass("cat-hover");
		});

=======
>>>>>>> WPHome/master
		$('select[name="_status"] option[value="future"]', bulkRow).remove();

		$('#doaction, #doaction2').click(function(e){
			var n = $(this).attr('id').substr(2);
<<<<<<< HEAD
			if ( $('select[name="'+n+'"]').val() == 'edit' ) {
=======
			if ( 'edit' === $( 'select[name="' + n + '"]' ).val() ) {
>>>>>>> WPHome/master
				e.preventDefault();
				t.setBulk();
			} else if ( $('form#posts-filter tr.inline-editor').length > 0 ) {
				t.revert();
			}
		});
<<<<<<< HEAD

		$('#post-query-submit').mousedown(function(e){
			t.revert();
			$('select[name^="action"]').val('-1');
		});
=======
>>>>>>> WPHome/master
	},

	toggle : function(el){
		var t = this;
<<<<<<< HEAD
		$(t.what+t.getId(el)).css('display') == 'none' ? t.revert() : t.edit(el);
=======
		$( t.what + t.getId( el ) ).css( 'display' ) === 'none' ? t.revert() : t.edit( el );
>>>>>>> WPHome/master
	},

	setBulk : function(){
		var te = '', type = this.type, tax, c = true;
		this.revert();

		$('#bulk-edit td').attr('colspan', $('.widefat:first thead th:visible').length);
<<<<<<< HEAD
		$('table.widefat tbody').prepend( $('#bulk-edit') );
		$('#bulk-edit').addClass('inline-editor').show();

		$('tbody th.check-column input[type="checkbox"]').each(function(i){
=======
		// Insert the editor at the top of the table with an empty row above to maintain zebra striping.
		$('table.widefat tbody').prepend( $('#bulk-edit') ).prepend('<tr class="hidden"></tr>');
		$('#bulk-edit').addClass('inline-editor').show();

		$( 'tbody th.check-column input[type="checkbox"]' ).each( function() {
>>>>>>> WPHome/master
			if ( $(this).prop('checked') ) {
				c = false;
				var id = $(this).val(), theTitle;
				theTitle = $('#inline_'+id+' .post_title').html() || inlineEditL10n.notitle;
				te += '<div id="ttle'+id+'"><a id="_'+id+'" class="ntdelbutton" title="'+inlineEditL10n.ntdeltitle+'">X</a>'+theTitle+'</div>';
			}
		});

<<<<<<< HEAD
		if ( c )
			return this.revert();
=======
		if ( c ) {
			return this.revert();
		}
>>>>>>> WPHome/master

		$('#bulk-titles').html(te);
		$('#bulk-titles a').click(function(){
			var id = $(this).attr('id').substr(1);

			$('table.widefat input[value="' + id + '"]').prop('checked', false);
			$('#ttle'+id).remove();
		});

		// enable autocomplete for tags
<<<<<<< HEAD
		if ( 'post' == type ) {
			// support multi taxonomies?
			tax = 'post_tag';
			$('tr.inline-editor textarea[name="tax_input['+tax+']"]').suggest( ajaxurl + '?action=ajax-tag-search&tax=' + tax, { delay: 500, minchars: 2, multiple: true, multipleSep: inlineEditL10n.comma + ' ' } );
=======
		if ( 'post' === type ) {
			// support multi taxonomies?
			tax = 'post_tag';
			$('tr.inline-editor textarea[name="tax_input['+tax+']"]').suggest( ajaxurl + '?action=ajax-tag-search&tax=' + tax, { delay: 500, minchars: 2, multiple: true, multipleSep: inlineEditL10n.comma } );
>>>>>>> WPHome/master
		}
		$('html, body').animate( { scrollTop: 0 }, 'fast' );
	},

	edit : function(id) {
<<<<<<< HEAD
		var t = this, fields, editRow, rowData, status, pageOpt, pageLevel, nextPage, pageLoop = true, nextLevel, cur_format, f;
		t.revert();

		if ( typeof(id) == 'object' )
			id = t.getId(id);

		fields = ['post_title', 'post_name', 'post_author', '_status', 'jj', 'mm', 'aa', 'hh', 'mn', 'ss', 'post_password', 'post_format', 'menu_order'];
		if ( t.type == 'page' )
			fields.push('post_parent', 'page_template');

		// add the new blank row
		editRow = $('#inline-edit').clone(true);
		$('td', editRow).attr('colspan', $('.widefat:first thead th:visible').length);

		if ( $(t.what+id).hasClass('alternate') )
			$(editRow).addClass('alternate');
		$(t.what+id).hide().after(editRow);
=======
		var t = this, fields, editRow, rowData, status, pageOpt, pageLevel, nextPage, pageLoop = true, nextLevel, cur_format, f, val;
		t.revert();

		if ( typeof(id) === 'object' ) {
			id = t.getId(id);
		}

		fields = ['post_title', 'post_name', 'post_author', '_status', 'jj', 'mm', 'aa', 'hh', 'mn', 'ss', 'post_password', 'post_format', 'menu_order'];
		if ( t.type === 'page' ) {
			fields.push('post_parent', 'page_template');
		}

		// add the new edit row with an extra blank row underneath to maintain zebra striping.
		editRow = $('#inline-edit').clone(true);
		$('td', editRow).attr('colspan', $('.widefat:first thead th:visible').length);

		$(t.what+id).hide().after(editRow).after('<tr class="hidden"></tr>');
>>>>>>> WPHome/master

		// populate the data
		rowData = $('#inline_'+id);
		if ( !$(':input[name="post_author"] option[value="' + $('.post_author', rowData).text() + '"]', editRow).val() ) {
			// author no longer has edit caps, so we need to add them to the list of authors
			$(':input[name="post_author"]', editRow).prepend('<option value="' + $('.post_author', rowData).text() + '">' + $('#' + t.type + '-' + id + ' .author').text() + '</option>');
		}
<<<<<<< HEAD
		if ( $(':input[name="post_author"] option', editRow).length == 1 ) {
=======
		if ( $( ':input[name="post_author"] option', editRow ).length === 1 ) {
>>>>>>> WPHome/master
			$('label.inline-edit-author', editRow).hide();
		}

		// hide unsupported formats, but leave the current format alone
		cur_format = $('.post_format', rowData).text();
		$('option.unsupported', editRow).each(function() {
			var $this = $(this);
<<<<<<< HEAD
			if ( $this.val() != cur_format )
				$this.remove();
		});

		for ( f = 0; f < fields.length; f++ ) {
			$(':input[name="' + fields[f] + '"]', editRow).val( $('.'+fields[f], rowData).text() );
		}

		if ( $('.comment_status', rowData).text() == 'open' )
			$('input[name="comment_status"]', editRow).prop("checked", true);
		if ( $('.ping_status', rowData).text() == 'open' )
			$('input[name="ping_status"]', editRow).prop("checked", true);
		if ( $('.sticky', rowData).text() == 'sticky' )
			$('input[name="sticky"]', editRow).prop("checked", true);

		// hierarchical taxonomies
		$('.post_category', rowData).each(function(){
			var term_ids = $(this).text();
=======
			if ( $this.val() !== cur_format ) {
				$this.remove();
			}
		});

		for ( f = 0; f < fields.length; f++ ) {
			val = $('.'+fields[f], rowData);
			// Deal with Twemoji
			val.find( 'img' ).replaceWith( function() { return this.alt; } );
			val = val.text();
			$(':input[name="' + fields[f] + '"]', editRow).val( val );
		}

		if ( $( '.comment_status', rowData ).text() === 'open' ) {
			$( 'input[name="comment_status"]', editRow ).prop( 'checked', true );
		}
		if ( $( '.ping_status', rowData ).text() === 'open' ) {
			$( 'input[name="ping_status"]', editRow ).prop( 'checked', true );
		}
		if ( $( '.sticky', rowData ).text() === 'sticky' ) {
			$( 'input[name="sticky"]', editRow ).prop( 'checked', true );
		}

		// hierarchical taxonomies
		$('.post_category', rowData).each(function(){
			var taxname,
				term_ids = $(this).text();
>>>>>>> WPHome/master

			if ( term_ids ) {
				taxname = $(this).attr('id').replace('_'+id, '');
				$('ul.'+taxname+'-checklist :checkbox', editRow).val(term_ids.split(','));
			}
		});

		//flat taxonomies
		$('.tags_input', rowData).each(function(){
<<<<<<< HEAD
			var terms = $(this).text(),
=======
			var terms = $(this),
>>>>>>> WPHome/master
				taxname = $(this).attr('id').replace('_' + id, ''),
				textarea = $('textarea.tax_input_' + taxname, editRow),
				comma = inlineEditL10n.comma;

<<<<<<< HEAD
			if ( terms ) {
				if ( ',' !== comma )
					terms = terms.replace(/,/g, comma);
				textarea.val(terms);
			}

			textarea.suggest( ajaxurl + '?action=ajax-tag-search&tax=' + taxname, { delay: 500, minchars: 2, multiple: true, multipleSep: inlineEditL10n.comma + ' ' } );
=======
			terms.find( 'img' ).replaceWith( function() { return this.alt; } );
			terms = terms.text();

			if ( terms ) {
				if ( ',' !== comma ) {
					terms = terms.replace(/,/g, comma);
				}
				textarea.val(terms);
			}

			textarea.suggest( ajaxurl + '?action=ajax-tag-search&tax=' + taxname, { delay: 500, minchars: 2, multiple: true, multipleSep: inlineEditL10n.comma } );
>>>>>>> WPHome/master
		});

		// handle the post status
		status = $('._status', rowData).text();
<<<<<<< HEAD
		if ( 'future' != status )
			$('select[name="_status"] option[value="future"]', editRow).remove();

		if ( 'private' == status ) {
			$('input[name="keep_private"]', editRow).prop("checked", true);
=======
		if ( 'future' !== status ) {
			$('select[name="_status"] option[value="future"]', editRow).remove();
		}

		if ( 'private' === status ) {
			$('input[name="keep_private"]', editRow).prop('checked', true);
>>>>>>> WPHome/master
			$('input.inline-edit-password-input').val('').prop('disabled', true);
		}

		// remove the current page and children from the parent dropdown
		pageOpt = $('select[name="post_parent"] option[value="' + id + '"]', editRow);
		if ( pageOpt.length > 0 ) {
			pageLevel = pageOpt[0].className.split('-')[1];
			nextPage = pageOpt;
			while ( pageLoop ) {
				nextPage = nextPage.next('option');
<<<<<<< HEAD
				if (nextPage.length == 0) break;
				nextLevel = nextPage[0].className.split('-')[1];
=======
				if ( nextPage.length === 0 ) {
					break;
				}

				nextLevel = nextPage[0].className.split('-')[1];

>>>>>>> WPHome/master
				if ( nextLevel <= pageLevel ) {
					pageLoop = false;
				} else {
					nextPage.remove();
					nextPage = pageOpt;
				}
			}
			pageOpt.remove();
		}

		$(editRow).attr('id', 'edit-'+id).addClass('inline-editor').show();
		$('.ptitle', editRow).focus();

		return false;
	},

	save : function(id) {
		var params, fields, page = $('.post_status_page').val() || '';

<<<<<<< HEAD
		if ( typeof(id) == 'object' )
			id = this.getId(id);

		$('table.widefat .spinner').show();
=======
		if ( typeof(id) === 'object' ) {
			id = this.getId(id);
		}

		$( 'table.widefat .spinner' ).addClass( 'is-active' );
>>>>>>> WPHome/master

		params = {
			action: 'inline-save',
			post_type: typenow,
			post_ID: id,
			edit_date: 'true',
			post_status: page
		};

<<<<<<< HEAD
		fields = $('#edit-'+id+' :input').serialize();
=======
		fields = $('#edit-'+id).find(':input').serialize();
>>>>>>> WPHome/master
		params = fields + '&' + $.param(params);

		// make ajax request
		$.post( ajaxurl, params,
			function(r) {
<<<<<<< HEAD
				$('table.widefat .spinner').hide();

				if (r) {
					if ( -1 != r.indexOf('<tr') ) {
						$(inlineEditPost.what+id).remove();
=======
				$( 'table.widefat .spinner' ).removeClass( 'is-active' );

				if (r) {
					if ( -1 !== r.indexOf( '<tr' ) ) {
						$(inlineEditPost.what+id).siblings('tr.hidden').addBack().remove();
>>>>>>> WPHome/master
						$('#edit-'+id).before(r).remove();
						$(inlineEditPost.what+id).hide().fadeIn();
					} else {
						r = r.replace( /<.[^<>]*?>/g, '' );
						$('#edit-'+id+' .inline-edit-save .error').html(r).show();
					}
				} else {
					$('#edit-'+id+' .inline-edit-save .error').html(inlineEditL10n.error).show();
				}
<<<<<<< HEAD
			}
		, 'html');
=======
			},
		'html');
>>>>>>> WPHome/master
		return false;
	},

	revert : function(){
		var id = $('table.widefat tr.inline-editor').attr('id');

		if ( id ) {
<<<<<<< HEAD
			$('table.widefat .spinner').hide();

			if ( 'bulk-edit' == id ) {
				$('table.widefat #bulk-edit').removeClass('inline-editor').hide();
				$('#bulk-titles').html('');
				$('#inlineedit').append( $('#bulk-edit') );
			} else {
				$('#'+id).remove();
=======
			$( 'table.widefat .spinner' ).removeClass( 'is-active' );

			if ( 'bulk-edit' === id ) {
				$('table.widefat #bulk-edit').removeClass('inline-editor').hide().siblings('tr.hidden').remove();
				$('#bulk-titles').empty();
				$('#inlineedit').append( $('#bulk-edit') );
			} else {
				$('#'+id).siblings('tr.hidden').addBack().remove();
>>>>>>> WPHome/master
				id = id.substr( id.lastIndexOf('-') + 1 );
				$(this.what+id).show();
			}
		}

		return false;
	},

	getId : function(o) {
		var id = $(o).closest('tr').attr('id'),
			parts = id.split('-');
		return parts[parts.length - 1];
	}
};

<<<<<<< HEAD
$(document).ready(function(){inlineEditPost.init();});
})(jQuery);
=======
$( document ).ready( function(){ inlineEditPost.init(); } );

// Show/hide locks on posts
$( document ).on( 'heartbeat-tick.wp-check-locked-posts', function( e, data ) {
	var locked = data['wp-check-locked-posts'] || {};

	$('#the-list tr').each( function(i, el) {
		var key = el.id, row = $(el), lock_data, avatar;

		if ( locked.hasOwnProperty( key ) ) {
			if ( ! row.hasClass('wp-locked') ) {
				lock_data = locked[key];
				row.find('.column-title .locked-text').text( lock_data.text );
				row.find('.check-column checkbox').prop('checked', false);

				if ( lock_data.avatar_src ) {
					avatar = $('<img class="avatar avatar-18 photo" width="18" height="18" />').attr( 'src', lock_data.avatar_src.replace(/&amp;/g, '&') );
					row.find('.column-title .locked-avatar').empty().append( avatar );
				}
				row.addClass('wp-locked');
			}
		} else if ( row.hasClass('wp-locked') ) {
			// Make room for the CSS animation
			row.removeClass('wp-locked').delay(1000).find('.locked-info span').empty();
		}
	});
}).on( 'heartbeat-send.wp-check-locked-posts', function( e, data ) {
	var check = [];

	$('#the-list tr').each( function(i, el) {
		if ( el.id ) {
			check.push( el.id );
		}
	});

	if ( check.length ) {
		data['wp-check-locked-posts'] = check;
	}
}).ready( function() {
	// Set the heartbeat interval to 15 sec.
	if ( typeof wp !== 'undefined' && wp.heartbeat ) {
		wp.heartbeat.interval( 15 );
	}
});

}(jQuery));
>>>>>>> WPHome/master
