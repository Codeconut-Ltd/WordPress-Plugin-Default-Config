<?php
/**
 * Script and styles handling.
 *
 * @package Codeconut_Global
 */

namespace Codeconut_Global\Core\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Script and styles handling.
 */
final class Scripts {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts__footer' ) );
	}

	/**
	 * Remove all scripts from header (which shifts them to be loaded in the footer).
	 * WARNING: This might break some features.
	 */
	public function wp_enqueue_scripts__footer() {
		remove_action( 'wp_head', 'wp_print_scripts' );
		remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
		remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );
	}
}
