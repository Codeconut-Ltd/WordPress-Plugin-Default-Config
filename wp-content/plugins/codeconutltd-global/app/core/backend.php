<?php
/**
 * Backend features.
 *
 * @package Codeconut_Global
 */

namespace Codeconut_Global\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Backend features.
 * - Disable redundant self ping
 * - Delay post publication for QA/fixes
 */
final class Backend {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_filter( 'jpeg_quality', array( $this, 'jpeg_quality__maximum' ) );
		add_action( 'pre_ping', array( $this, 'pre_ping__disable_self_ping' ) );
		add_filter( 'posts_where', array( $this, 'posts_where__delay_post_publication' ) );
	}

	/**
	 * Set JPEG quality to max. to avoid compression.
	 * It's recommended to use plugins for better compression.
	 *
	 * @return int Quality percentage; default 75.
	 */
	public function jpeg_quality__maximum() {
		return 100;
	}

	/**
	 * Prevent redundant pingbacks from links within own domain.
	 *
	 * @param array $links Links.
	 */
	public function pre_ping__disable_self_ping( array &$links ) {
		$home = get_option( 'home' );

		foreach ( $links as $l => $link ) {
			if ( 0 === strpos( $link, $home ) ) {
				unset( $links[ $l ] );
			}
		}
	}

	/**
	 * Delay publishing posts via RSS feeds/emails immediately after publishing.
	 * Add an intentional delay for any last-minute QA and corrections.
	 *
	 * @example Affects any query:
	 *   $massageQuery = new WP_Query([
	 *     'post_type' => 'post',
	 *     'posts_per_page' => 10
	 *   ]);
	 *
	 * @link https://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file
	 * @param string $where Part of SQL query.
	 * @return string
	 */
	public function posts_where__delay_post_publication( string $where ) {
		global $wpdb;

		if ( is_feed() ) {
			$now    = gmdate( 'Y-m-d H:i:s' );
			$wait   = '10';
			$where .= " AND TIMESTAMPDIFF(MINUTE, $wpdb->posts.post_date_gmt, '$now') > $wait ";
		}

		return $where;
	}
}
