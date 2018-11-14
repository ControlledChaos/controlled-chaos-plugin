<?php
/**
 * Minify HTML source code.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Includes
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 *
 * @todo       Work out the errors thrown when the file is namespaced
 */

// namespace CC_Plugin\Includes\Minify;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Minify HTML source code.
 *
 * @since  1.0.0
 * @access public
 */
class Controlled_Chaos_Minify {

	/**
	 * HTML output variable.
	 *
	 * @var    string
	 * @access protected
	 */
	protected $html;

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct( $html ) {

		if ( ! empty( $html ) ) {
			$this->parse_html( $html ) ;
		}

	}

	/**
	 * Convert the HTML compressed by the class.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function __toString() {

		return $this->html;

	}

	/**
	 * Get the compression savings and return as a comment after the HTML.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @return string
	 */
	protected function bottom_comment( $raw, $compressed ) {

		$raw        = strlen( $raw );
		$compressed = strlen( $compressed );
		$savings    = ( $raw-$compressed ) / $raw * 100;
		$savings    = round( $savings, 2 );

		return '<!--HTML compressed, size saved ' . $savings . '%. From ' . $raw . ' bytes, now ' . $compressed . ' bytes-->';

	}

	/**
	 * Compress the HTML of the page.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @return string
	 */
	protected function minify_html( $html ) {

		// Settings
		$compress_css    = true;
		$compress_js     = false;
		$remove_comments = true;

		$pattern = '/<(?<script>script).*?<\/script\s*>|<(?<style>style).*?<\/style\s*>|<!(?<comment>--).*?-->|<(?<tag>[\/\w.:-]*)(?:".*?"|\'.*?\'|[^\'">]+)*>|(?<text>((<[^!\/\w.:-])?[^<]*)+)|/si';
		preg_match_all( $pattern, $html, $matches, PREG_SET_ORDER );

		$overriding = false;
		$raw_tag    = false;

		// Variable reused for output
		$html = '';

		foreach ( $matches as $token ) {

			$tag     = ( isset( $token['tag'] ) ) ? strtolower( $token['tag'] ) : null;
			$content = $token[0];

			if ( is_null( $tag ) ) {

				if ( ! empty( $token['script'] ) ) {
					$strip = $compress_js;
				} elseif ( ! empty( $token['style'] ) ) {
					$strip = $compress_css;
				} elseif ( '<!--wp-html-compression no compression-->' == $content ) {
					$overriding = !$overriding;

					// Don't print the comment
					continue;
				} elseif ( $remove_comments ) {

					if ( ! $overriding && $raw_tag != 'textarea' ) {
						// Remove any HTML comments, except MSIE conditional comments
						$content = preg_replace( '/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $content );
					}

				}

			} else {

				if ( $tag == 'pre' || $tag == 'textarea' ) {
					$raw_tag = $tag;
				} elseif ( $tag == '/pre' || $tag == '/textarea' ) {
					$raw_tag = false;
				} else {

					if ( $raw_tag || $overriding ) {
						$strip = false;
					} else {
						$strip = true;

						/**
						 * Remove any empty attributes, except action, alt, content, src.
						 */
						$content = preg_replace( '/(\s+)(\w++(?<!\baction|\balt|\bcontent|\bsrc)="")/', '$1', $content );

						/**
						 * Remove any space before the end of self-closing XHTML tags.
						 *
						 * JavaScript excluded.
						 */
						$content = str_replace( ' />', '/>', $content );
					}

				}

			}

			if ( $strip ) {
				$content = $this->remove_white_space( $content );
			}

			$html .= $content;

		}

		return $html;

	}

	/**
	 * Parse the HTML of the page.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function parse_html( $html ) {

		$this->html = $this->minify_html( $html );
		$this->html .= "\n" . $this->bottom_comment( $html, $this->html );

	}

	/**
	 * Remove the whitespace from the HTML of the page.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @return string
	 */
	protected function remove_white_space( $str ) {

		$str = str_replace( "\t", ' ', $str );
		$str = str_replace( "\n",  '', $str );
		$str = str_replace( "\r",  '', $str );

		while ( stristr( $str, '  ' ) ) {
			$str = str_replace( '  ', ' ', $str );
		}

		return $str;

	}

}

/**
 * Return the class as an output buffering callback.
 *
 * @since  1.0.0
 * @access public
 * @return object
 */
function wp_html_compression_finish( $html ) {

	return new Controlled_Chaos_Minify( $html );

}

/**
 * Return the HTML compressed by the class.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function wp_html_compression_start() {

	ob_start( 'wp_html_compression_finish' );

}
add_action( 'get_header', 'wp_html_compression_start' );