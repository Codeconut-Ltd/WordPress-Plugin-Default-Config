<?php
/**
 * Security enhancements.
 *
 * @package Codeconut_Global
 */

namespace Codeconut_Global\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Security enhancements.
 */
final class Security {
	/**
	 * Constructor.
	 */
	public function __construct() {
		// Remove precise error message
		add_filter( 'login_errors', array( $this, 'login_errors__remove_messages' ) );

		// Disable XMLRPC API
		add_filter( 'xmlrpc_enabled', '__return_false' );
		add_filter( 'xmlrpc_methods', array( $this, 'xmlrpc_methods__remove' ) );

		// Remove version numbers
		add_filter( 'the_generator', array( $this, 'the_generator__remove_version_info' ) );
		add_filter( 'style_loader_src', array( $this, 'loader_src__remove_version_info' ), 9999 );
		add_filter( 'script_loader_src', array( $this, 'loader_src__remove_version_info' ), 9999 );

		// Remove generator tag
		remove_action( 'wp_head', 'wp_generator' );

		// Prevent logging in with email address
		remove_filter( 'authenticate', 'wp_authenticate_email_password', 20 );
	}

	/**
	 * Remove specific login errors from being displayed.
	 *
	 * @param string $errors Error messages.
	 * @return string
	 */
	public function login_errors__remove_messages( string $errors ) {
		return '';
	}

	/**
	 * Prevent leaking the WordPress version publicly.
	 *
	 * @return string
	 */
	public function the_generator__remove_version_info() {
		return '';
	}

	/**
	 * Remove version info from scripts and styles.
	 *
	 * @param string $src Source path.
	 * @return string
	 */
	public function loader_src__remove_version_info( string $src ) {
		if ( strpos( $src, 'ver=' ) ) {
			$src = remove_query_arg( 'ver', $src );
		}

		return $src;
	}

	/**
	 * Disable XML-RPC features.
	 *
	 * @link https://blog.cloudflare.com/wordpress-pingback-attacks-and-our-waf
	 * @link https://blog.cloudflare.com/a-look-at-the-new-wordpress-brute-force-amplification-attack
	 * @param array $methods Methods.
	 */
	public function xmlrpc_methods__remove( $methods ) {
		unset( $methods['pingback.ping'] );
		unset( $methods['system.multicall'] );

		return $methods;
	}
}
