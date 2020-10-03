<?php
/**
 * Disable oEmbed feature for enhanced security.
 *
 * @link https://www.drweb.de/wordpress-snippets
 * @author Andreas Hecht
 * @package Codeconut_Global
 */

namespace Codeconut_Global\Core\Lib;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Disable oEmbed feature for enhanced security.
 */
final class Scripts {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'disable_embeds_init' ), 9999 );

		register_activation_hook( __FILE__, array( $this, 'disable_embeds_remove_rewrite_rules' ) );
		register_deactivation_hook( __FILE__, array( $this, 'disable_embeds_flush_rewrite_rules' ) );
	}

	/**
	 * Disable embeds on init.
	 * - Removes the needed query vars.
	 * - Disables oEmbed discovery.
	 * - Completely removes the related JavaScript.
	 */
	public function disable_embeds_init() {
		/* @var WP $wp */
		global $wp;

		// Remove embed query var
		$wp->public_query_vars = array_diff(
			$wp->public_query_vars,
			array(
				'embed',
			)
		);

		// Remove REST API endpoint
		remove_action( 'rest_api_init', 'wp_oembed_register_route' );

		// Turn off oEmbed auto discovery
		add_filter( 'embed_oembed_discover', '__return_false' );

		// Don't filter oEmbed results
		remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

		// Remove oEmbed discovery links
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

		// Remove oEmbed-specific JavaScript from front-end + back-end
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );
		add_filter( 'tiny_mce_plugins', array( $this, 'disable_embeds_tiny_mce_plugin' ) );

		// Remove all embeds rewrite rules
		add_filter( 'rewrite_rules_array', array( $this, 'disable_embeds_rewrites' ) );

		// Remove filter of oEmbed result before any HTTP requests
		remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );
	}

	/**
	 * Removes the 'wpembed' TinyMCE plugin.
	 *
	 * @param array $plugins List of TinyMCE plugins.
	 * @return array The modified list.
	 */
	public function disable_embeds_tiny_mce_plugin( $plugins ) {
		return array_diff( $plugins, array( 'wpembed' ) );
	}

	/**
	 * Remove all rewrite rules related to embeds.
	 *
	 * @param array $rules WordPress rewrite rules.
	 * @return array Rewrite rules without embeds rules.
	 */
	public function disable_embeds_rewrites( $rules ) {
		foreach ( $rules as $rule => $rewrite ) {
			if ( false !== strpos( $rewrite, 'embed=true' ) ) {
				unset( $rules[ $rule ] );
			}
		}

		return $rules;
	}

	/**
	 * Remove embeds rewrite rules on plugin activation.
	 */
	public function disable_embeds_remove_rewrite_rules() {
		add_filter( 'rewrite_rules_array', array( $this, 'disable_embeds_rewrites' ) );
		flush_rewrite_rules( false );
	}

	/**
	 * Flush rewrite rules on plugin deactivation.
	 */
	public function disable_embeds_flush_rewrite_rules() {
		remove_filter( 'rewrite_rules_array', array( $this, 'disable_embeds_rewrites' ) );
		flush_rewrite_rules( false );
	}
}
