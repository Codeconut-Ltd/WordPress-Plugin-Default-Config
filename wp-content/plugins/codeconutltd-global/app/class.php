<?php
/**
 * Main entry point.
 *
 * @package CodeconutLtd_Global
 */

require_once 'includes.php';

use CodeconutLtd_Global\Core;
use CodeconutLtd_Global\Utilities\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main entry point.
 * Includes plugin config and features.
 */
final class CodeconutLtd_Global_Plugin extends Singleton {
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

