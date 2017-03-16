<?php
/**
 * Setup theme hooks
 */

/**
 * Hook after <head> tag
 * @since 1.1.1
 */
function vct_hook_after_head() {
    do_action( 'vct_hook_after_head' );
}

/**
 * Hook before theme header
 * @since 1.1.1
 */
function vct_hook_before_header() {
    do_action( 'vct_hook_before_header' );
}
/**
 * Hook after theme header
 * @since 1.1.1
 */
function vct_hook_after_header() {
    do_action( 'vct_hook_after_header' );
}

/**
 * Hook before theme footer
 * @since 1.1.1
 */
function vct_hook_before_footer() {
    do_action( 'vct_hook_before_footer' );
}
/**
 * Hook after theme footer
 * @since 1.1.1
 */
function vct_hook_after_footer() {
    do_action( 'vct_hook_after_footer' );
}