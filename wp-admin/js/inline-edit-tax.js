<<<<<<< HEAD

=======
/* global inlineEditL10n, ajaxurl */

var inlineEditTax;
>>>>>>> WPHome/master
(function($) {
inlineEditTax = {

	init : function() {
		var t = this, row = $('#inline-edit');

		t.type = $('#the-list').attr('data-wp-lists').substr(5);
		t.what = '#'+t.type+'-';

<<<<<<< HEAD
		$('.editinline').live('click', function(){
=======
		$('#the-list').on('click', 'a.editinline', function(){
>>>>>>> WPHome/master
			inlineEditTax.edit(this);
			return false;
		});

		// prepare the edit row
<<<<<<< HEAD
		row.keyup(function(e) { if(e.which == 27) return inlineEditTax.revert(); });

		$('a.cancel', row).click(function() { return inlineEditTax.revert(); });
		$('a.save', row).click(function() { return inlineEditTax.save(this); });
		$('input, select', row).keydown(function(e) { if(e.which == 13) return inlineEditTax.save(this); });

		$('#posts-filter input[type="submit"]').mousedown(function(e){
=======
		row.keyup( function( e ) {
			if ( e.which === 27 ) {
				return inlineEditTax.revert();
			}
		});

		$( 'a.cancel', row ).click( function() {
			return inlineEditTax.revert();
		});
		$( 'a.save', row ).click( function() {
			return inlineEditTax.save(this);
		});
		$( 'input, select', row ).keydown( function( e ) {
			if ( e.which === 13 ) {
				return inlineEditTax.save( this );
			}
		});

		$( '#posts-filter input[type="submit"]' ).mousedown( function() {
>>>>>>> WPHome/master
			t.revert();
		});
	},

	toggle : function(el) {
		var t = this;
<<<<<<< HEAD
		$(t.what+t.getId(el)).css('display') == 'none' ? t.revert() : t.edit(el);
	},

	edit : function(id) {
		var t = this, editRow;
		t.revert();

		if ( typeof(id) == 'object' )
			id = t.getId(id);
=======
		$(t.what+t.getId(el)).css('display') === 'none' ? t.revert() : t.edit(el);
	},

	edit : function(id) {
		var editRow, rowData, val,
			t = this;
		t.revert();

		if ( typeof(id) === 'object' ) {
			id = t.getId(id);
		}
>>>>>>> WPHome/master

		editRow = $('#inline-edit').clone(true), rowData = $('#inline_'+id);
		$('td', editRow).attr('colspan', $('.widefat:first thead th:visible').length);

<<<<<<< HEAD
		if ( $(t.what+id).hasClass('alternate') )
			$(editRow).addClass('alternate');

		$(t.what+id).hide().after(editRow);

		$(':input[name="name"]', editRow).val( $('.name', rowData).text() );
		$(':input[name="slug"]', editRow).val( $('.slug', rowData).text() );
=======
		$(t.what+id).hide().after(editRow).after('<tr class="hidden"></tr>');

		val = $('.name', rowData);
		val.find( 'img' ).replaceWith( function() { return this.alt; } );
		val = val.text();
		$(':input[name="name"]', editRow).val( val );

		val = $('.slug', rowData);
		val.find( 'img' ).replaceWith( function() { return this.alt; } );
		val = val.text();
		$(':input[name="slug"]', editRow).val( val );
>>>>>>> WPHome/master

		$(editRow).attr('id', 'edit-'+id).addClass('inline-editor').show();
		$('.ptitle', editRow).eq(0).focus();

		return false;
	},

	save : function(id) {
		var params, fields, tax = $('input[name="taxonomy"]').val() || '';

<<<<<<< HEAD
		if( typeof(id) == 'object' )
			id = this.getId(id);

		$('table.widefat .spinner').show();
=======
		if( typeof(id) === 'object' ) {
			id = this.getId(id);
		}

		$( 'table.widefat .spinner' ).addClass( 'is-active' );
>>>>>>> WPHome/master

		params = {
			action: 'inline-save-tax',
			tax_type: this.type,
			tax_ID: id,
			taxonomy: tax
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
				var row, new_id;
				$('table.widefat .spinner').hide();

				if (r) {
					if ( -1 != r.indexOf('<tr') ) {
						$(inlineEditTax.what+id).remove();
						new_id = $(r).attr('id');

						$('#edit-'+id).before(r).remove();
						row = new_id ? $('#'+new_id) : $(inlineEditTax.what+id);
						row.hide().fadeIn();
					} else
						$('#edit-'+id+' .inline-edit-save .error').html(r).show();
				} else
					$('#edit-'+id+' .inline-edit-save .error').html(inlineEditL10n.error).show();
=======
				var row, new_id, option_value;
				$( 'table.widefat .spinner' ).removeClass( 'is-active' );

				if (r) {
					if ( -1 !== r.indexOf( '<tr' ) ) {
						$(inlineEditTax.what+id).siblings('tr.hidden').addBack().remove();
						new_id = $(r).attr('id');

						$('#edit-'+id).before(r).remove();

						if ( new_id ) {
							option_value = new_id.replace( inlineEditTax.type + '-', '' );
							row = $( '#' + new_id );
						} else {
							option_value = id;
							row = $( inlineEditTax.what + id );
						}

						// Update the value in the Parent dropdown.
						$( '#parent' ).find( 'option[value=' + option_value + ']' ).text( row.find( '.row-title' ).text() );

						row.hide().fadeIn();
					} else {
						$('#edit-'+id+' .inline-edit-save .error').html(r).show();
					}
				} else {
					$('#edit-'+id+' .inline-edit-save .error').html(inlineEditL10n.error).show();
				}
>>>>>>> WPHome/master
			}
		);
		return false;
	},

	revert : function() {
		var id = $('table.widefat tr.inline-editor').attr('id');

		if ( id ) {
<<<<<<< HEAD
			$('table.widefat .spinner').hide();
			$('#'+id).remove();
=======
			$( 'table.widefat .spinner' ).removeClass( 'is-active' );
			$('#'+id).siblings('tr.hidden').addBack().remove();
>>>>>>> WPHome/master
			id = id.substr( id.lastIndexOf('-') + 1 );
			$(this.what+id).show();
		}

		return false;
	},

	getId : function(o) {
<<<<<<< HEAD
		var id = o.tagName == 'TR' ? o.id : $(o).parents('tr').attr('id'), parts = id.split('-');
=======
		var id = o.tagName === 'TR' ? o.id : $(o).parents('tr').attr('id'), parts = id.split('-');
>>>>>>> WPHome/master
		return parts[parts.length - 1];
	}
};

$(document).ready(function(){inlineEditTax.init();});
})(jQuery);
