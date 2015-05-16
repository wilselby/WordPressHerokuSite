( function( $ ){
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
<<<<<<< HEAD
			$( '#site-title a' ).html( to );
=======
			$( '#site-title a' ).text( to );
>>>>>>> WPHome/master
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
<<<<<<< HEAD
			$( '#site-description' ).html( to );
=======
			$( '#site-description' ).text( to );
		} );
	} );

	// Header text color
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '#site-title, #site-title a, #site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '#site-title, #site-title a, #site-description' ).css( {
					'clip': 'auto',
					'color': to,
					'position': 'relative'
				} );
			}
>>>>>>> WPHome/master
		} );
	} );
} )( jQuery );