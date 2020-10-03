<?php
/**
 * Singleton pattern.
 *
 * @package Codeconut_Global
 */

namespace Codeconut_Global\Utilities;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Singleton pattern.
 *
 * @package Codeconut_Global
 */
abstract class Singleton {
	/**
	 * Single instance.
	 *
	 * @var array
	 */
	protected static $instances = array();

	/**
	 * Singleton pattern: Only one instance can be loaded.
	 *
	 * @return object
	 */
	public static function get_instance() {
		$class = get_called_class();

		if ( ! isset( self::$instances[ $class ] ) ) {
			self::$instances[ $class ] = new static();
		}

		return self::$instances[ $class ];
	}

	/**
	 * Forbidden access.
	 */
	protected function __construct() { }

	/**
	 * Forbidden access.
	 */
	protected function __clone() { }

	/**
	 * Forbidden access.
	 */
	protected function __wakeup() { }
}
