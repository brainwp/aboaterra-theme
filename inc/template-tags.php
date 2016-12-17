<?php
/**
 * Custom template tags for Odin.
 *
 * @package Odin
 * @since 2.2.0
 */

if ( ! function_exists( 'odin_classes_page_full' ) ) {

	/**
	 * Classes page full.
	 *
	 * @since 2.2.0
	 *
	 * @return string Classes name.
	 */
	function odin_classes_page_full() {
		return 'col-md-12';
	}
}

if ( ! function_exists( 'odin_classes_page_sidebar' ) ) {

	/**
	 * Classes page with sidebar.
	 *
	 * @since 2.2.0
	 *
	 * @return string Classes name.
	 */
	function odin_classes_page_sidebar() {
		return 'col-md-9';
	}
}

if ( ! function_exists( 'odin_classes_page_sidebar_aside' ) ) {

	/**
	 * Classes aside of page with sidebar.
	 *
	 * @since 2.2.0
	 *
	 * @return string Classes name.
	 */
	function odin_classes_page_sidebar_aside() {
		return 'col-md-3 hidden-xs hidden-print widget-area';
	}
}

if ( ! function_exists( 'odin_posted_on' ) ) {

	/**
	 * Print HTML with meta information for the current post-date/time and author.
	 *
	 * @since 2.2.0
	 */
	function odin_posted_on() {
		if ( is_sticky() && is_home() && ! is_paged() ) {
			echo '<span class="featured-post">' . __( 'Sticky', 'odin' ) . ' </span>';
		}

		// Set up and print post meta information.
		printf( '<span class="entry-date">%s <time class="entry-date" datetime="%s">%s</time></span> <span class="byline">%s <span class="author vcard"><a class="url fn n" href="%s" rel="author">%s</a></span>.</span>',
			__( 'Posted in', 'odin' ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			__( 'by', 'odin' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			get_the_author()
		);
	}
}

if ( ! function_exists( 'odin_paging_nav' ) ) {

	/**
	 * Print HTML with meta information for the current post-date/time and author.
	 *
	 * @since 2.2.0
	 */
	function odin_paging_nav() {
		$mid  = 2;     // Total of items that will show along with the current page.
		$end  = 1;     // Total of items displayed for the last few pages.
		$show = false; // Show all items.

		echo odin_pagination( $mid, $end, false );
	}
}
/**
 * Get user city
 * @return string
 */
function get_the_city() {
	if ( is_user_logged_in() && $field = get_user_meta( get_current_user_id(), 'user_city', true ) ) {
		return apply_filters( 'woocommerce_get_the_city', $field );
	}
	return apply_filters( 'woocommerce_get_the_city', 'São Paulo' );
}
/**
 * Show menu ou hidden by page
 * @return boolean
 */
function aboaterra_show_menu() {
	if ( is_page_template( 'page-regioes.php' ) ) {
		return false;
	}
	if ( ! is_user_logged_in() && is_account_page() ) {
		return false;
	}
	if ( is_cart() ) {
		return false;
	}
	if ( is_checkout() ) {
		return false;
	}
	return true;
}
/**
 * Add body class on pages without header menu
 * @param array $classes
 * @return array
 */
function add_body_class_on_no_menu_pages( $classes ) {
	if ( ! aboaterra_show_menu() ) {
		$classes[] = 'no-menu';
	}
	return $classes;
}
add_filter( 'body_class', 'add_body_class_on_no_menu_pages', 9999 );
