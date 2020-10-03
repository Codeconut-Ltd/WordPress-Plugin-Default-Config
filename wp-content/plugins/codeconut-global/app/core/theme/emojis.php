<?php
/**
 * Remove emojis for performance.
 *
 * @package Codeconut_Global
 */

namespace Codeconut_Global\Core\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Remove emojis for performance.
 */
final class Emojis {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init__disable_emojis' ) );
	}

	/**
	 * Disable emojis by removing their hooks.
	 */
	public function init__disable_emojis() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

		// Tiny MCE
		add_filter( 'tiny_mce_plugins', array( $this, 'tiny_mce_plugins__disable_emojis' ) );
		add_filter( 'wp_resource_hints', array( $this, 'wp_resource_hints__disable_emojis_remove_dns_prefetch' ), 10, 2 );
	}

	/**
	 * Filter funcion to remove the emoji plugin from TinyMCE.
	 *
	 * @param array $plugins Plugins.
	 * @return array Difference betwen the two arrays.
	 */
	public function tiny_mce_plugins__disable_emojis( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}

	/**
	 * Removing emoji CDN hostname from DNS prefetching hints.
	 * Filter is documented in: wp-includes/formatting.php
	 *
	 * @param array  $urls URLs to print for resource hints.
	 * @param string $relation_type The relation type the URLs are printed for.
	 * @return array Difference betwen the two arrays.
	 */
	public function wp_resource_hints__disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
		if ( 'dns-prefetch' === $relation_type ) {
			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals
			$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
			$urls          = array_diff( $urls, array( $emoji_svg_url ) );
		}

		return $urls;
	}
}
