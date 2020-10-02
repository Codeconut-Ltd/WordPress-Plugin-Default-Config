<?php
/**
 * Remove unused <head> links.
 *
 * @package CodeconutLtd_Global
 */

namespace CodeconutLtd_Global\Core\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Remove unused <head> links.
 */
final class HeaderLinks {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init__remove_header_links' ) );
	}

	/**
	 * Remove unused <head> links to enhance security and reduce clutter.
	 */
	public function init__remove_header_links() {
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'index_rel_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
		remove_action( 'wp_head', 'wp_shortlink_header', 10, 0 );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

		// Feeds
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );

		// Disable REST API link tag + HTTP headers for visitors (not logged in users)
		if ( ! is_user_logged_in() ) {
			remove_action( 'wp_head', 'rest_output_link_wp_head', 10, 0 );
			remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
		}
	}
}

