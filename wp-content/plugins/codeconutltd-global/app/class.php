<?php
/**
 * Main entry point.
 *
 * @package Codeconut_Global
 */

require_once 'includes.php';

use Codeconut_Global\Core;
use Codeconut_Global\Utilities\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main entry point.
 * Includes plugin config and features.
 */
final class Codeconut_Global_Plugin extends Singleton {
	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Instanciate plugin features.
	 */
	private function init() {
		new Core\Lib\Scripts();
		new Core\Lib\WpBeginnerCommentAntispam();
		new Core\Theme\Emojis();
		new Core\Theme\HeaderLinks();
		new Core\Theme\Scripts();
		new Core\Backend();
		new Core\Security();
	}
}
