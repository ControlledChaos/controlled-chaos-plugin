<?php

/**
 * Minify HTML source code.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

// namespace CCPlugin\Includes\Minify;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Minify HTML source code.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 * @author     Greg Sweet <greg@ccdzine.com>
 */
class Controlled_Chaos_Minify {

	// Variables.
	protected $html;

	public function __construct( $html ) {

		if ( ! empty( $html ) ) {
			$this->parse_html( $html ) ;
		}

	}

	public function __toString() {

		return $this->html;

	}

	protected function bottom_comment( $raw, $compressed ) {

		$raw        = strlen( $raw );
		$compressed = strlen( $compressed );
		$savings    = ( $raw-$compressed ) / $raw * 100;
		$savings    = round( $savings, 2 );

		return '<!--HTML compressed, size saved ' . $savings . '%. From ' . $raw . ' bytes, now ' . $compressed . ' bytes-->';

	}

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

						// Remove any empty attributes, except:
						// action, alt, content, src
						$content = preg_replace( '/(\s+)(\w++(?<!\baction|\balt|\bcontent|\bsrc)="")/', '$1', $content );

						// Remove any space before the end of self-closing XHTML tags
						// JavaScript excluded
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

	public function parse_html( $html ) {

		$this->html = $this->minify_html( $html );
		$this->html .= "\n" . $this->bottom_comment( $html, $this->html );

	}

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

function wp_html_compression_finish( $html ) {

	return new Controlled_Chaos_Minify( $html );

}

function wp_html_compression_start() {

	ob_start( 'wp_html_compression_finish' );

}
add_action( 'get_header', 'wp_html_compression_start' );