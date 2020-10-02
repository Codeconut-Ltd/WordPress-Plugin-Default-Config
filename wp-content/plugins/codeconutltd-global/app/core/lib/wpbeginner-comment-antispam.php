<?php
/**
 * Reduce spam potential in comments by stripping HTML and preventing clickable links.
 *
 * @link https://www.wpbeginner.com/beginners-guide/vital-tips-and-tools-to-combat-comment-spam-in-wordpress
 * @author WpBeginner
 * @package CodeconutLtd_Global
 */

namespace CodeconutLtd_Global\Core\Lib;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Reduce spam potential in comments by stripping HTML and preventing clickable links.
 */
final class WpBeginnerCommentAntispam {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_filter( 'comment_form_default_fields', array( $this, 'comment_form_default_fields_remove' ) );

		add_filter( 'preprocess_comment', array( $this, 'comment_post' ), '', 1 );

		add_filter( 'comment_text', array( $this, 'comment_display' ), '', 1 );
		add_filter( 'comment_text_rss', array( $this, 'comment_display' ), '', 1 );
		add_filter( 'comment_excerpt', array( $this, 'comment_display' ), '', 1 );

		remove_filter( 'comment_text', 'make_clickable', 9 );
	}

	/**
	 * Remove URL field from comment form as anti-spam measure.
	 *
	 * @param array $fields Form fields.
	 * @return array
	 */
	public function comment_form_default_fields_remove( $fields ) {
		unset( $fields['url'] );

		return $fields;
	}

	/**
	 * Remove HTML tags from comment.
	 *
	 * @param array $incoming_comment Comment.
	 * @return array
	 */
	public function comment_post( $incoming_comment ) {
		$incoming_comment['comment_content'] = htmlspecialchars( $incoming_comment['comment_content'] );
		$incoming_comment['comment_content'] = str_replace( "'", '&apos;', $incoming_comment['comment_content'] );

		return $incoming_comment;
	}

	/**
	 * Change comment apostroph character.
	 *
	 * @param string $comment_to_display Comment.
	 * @return string
	 */
	public function comment_display( $comment_to_display ) {
		$comment_to_display = str_replace( '&apos;', "'", $comment_to_display );

		return $comment_to_display;
	}
}
