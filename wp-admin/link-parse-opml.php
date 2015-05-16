<?php
/**
 * Parse OPML XML files and store in globals.
 *
 * @package WordPress
 * @subpackage Administration
 */

if ( ! defined('ABSPATH') )
	die();

<<<<<<< HEAD
global $opml, $map;

// columns we wish to find are: link_url, link_name, link_target, link_description
// we need to map XML attribute names to our columns
$opml_map = array('URL'         => 'link_url',
	'HTMLURL'     => 'link_url',
	'TEXT'        => 'link_name',
	'TITLE'       => 'link_name',
	'TARGET'      => 'link_target',
	'DESCRIPTION' => 'link_description',
	'XMLURL'      => 'link_rss'
);

$map = $opml_map;
=======
global $opml;
>>>>>>> WPHome/master

/**
 * XML callback function for the start of a new XML tag.
 *
 * @since 0.71
 * @access private
 *
<<<<<<< HEAD
 * @uses $updated_timestamp Not used inside function.
 * @uses $all_links Not used inside function.
 * @uses $map Stores names of attributes to use.
=======
>>>>>>> WPHome/master
 * @global array $names
 * @global array $urls
 * @global array $targets
 * @global array $descriptions
 * @global array $feeds
 *
 * @param mixed $parser XML Parser resource.
 * @param string $tagName XML element name.
 * @param array $attrs XML element attributes.
 */
function startElement($parser, $tagName, $attrs) {
<<<<<<< HEAD
	global $updated_timestamp, $all_links, $map;
	global $names, $urls, $targets, $descriptions, $feeds;

	if ($tagName == 'OUTLINE') {
		foreach (array_keys($map) as $key) {
			if (isset($attrs[$key])) {
				$$map[$key] = $attrs[$key];
			}
		}

		//echo("got data: link_url = [$link_url], link_name = [$link_name], link_target = [$link_target], link_description = [$link_description]<br />\n");

		// save the data away.
		$names[] = $link_name;
		$urls[] = $link_url;
		$targets[] = $link_target;
		$feeds[] = $link_rss;
		$descriptions[] = $link_description;
	} // end if outline
=======
	global $names, $urls, $targets, $descriptions, $feeds;

	if ( 'OUTLINE' === $tagName ) {
		$name = '';
		if ( isset( $attrs['TEXT'] ) ) {
			$name = $attrs['TEXT'];
		}
		if ( isset( $attrs['TITLE'] ) ) {
			$name = $attrs['TITLE'];
		}
		$url = '';
		if ( isset( $attrs['URL'] ) ) {
			$url = $attrs['URL'];
		}
		if ( isset( $attrs['HTMLURL'] ) ) {
			$url = $attrs['HTMLURL'];
		}

		// Save the data away.
		$names[] = $name;
		$urls[] = $url;
		$targets[] = isset( $attrs['TARGET'] ) ? $attrs['TARGET'] :  '';
		$feeds[] = isset( $attrs['XMLURL'] ) ? $attrs['XMLURL'] :  '';
		$descriptions[] = isset( $attrs['DESCRIPTION'] ) ? $attrs['DESCRIPTION'] :  '';
	} // End if outline.
>>>>>>> WPHome/master
}

/**
 * XML callback function that is called at the end of a XML tag.
 *
 * @since 0.71
 * @access private
<<<<<<< HEAD
 * @package WordPress
 * @subpackage Dummy
=======
>>>>>>> WPHome/master
 *
 * @param mixed $parser XML Parser resource.
 * @param string $tagName XML tag name.
 */
function endElement($parser, $tagName) {
<<<<<<< HEAD
	// nothing to do.
=======
	// Nothing to do.
>>>>>>> WPHome/master
}

// Create an XML parser
$xml_parser = xml_parser_create();

// Set the functions to handle opening and closing tags
xml_set_element_handler($xml_parser, "startElement", "endElement");

<<<<<<< HEAD
if (!xml_parse($xml_parser, $opml, true)) {
	echo(sprintf(__('XML error: %1$s at line %2$s'),
	xml_error_string(xml_get_error_code($xml_parser)),
	xml_get_current_line_number($xml_parser)));
=======
if ( ! xml_parse( $xml_parser, $opml, true ) ) {
	printf(
		/* translators: 1: error message, 2: line number */
		__( 'XML Error: %1$s at line %2$s' ),
		xml_error_string( xml_get_error_code( $xml_parser ) ),
		xml_get_current_line_number( $xml_parser )
	);
>>>>>>> WPHome/master
}

// Free up memory used by the XML parser
xml_parser_free($xml_parser);
