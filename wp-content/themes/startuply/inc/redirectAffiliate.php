<?php
/*
Redirect Affiliate To account Page
*/
function affwp_wc_redirect_affiliates( $redirect, $user ) {
	$user_id = $user->ID;

	if ( function_exists( 'affwp_is_affiliate' ) && affwp_is_affiliate( $user_id ) ) {
		$redirect = apply_filters( 'affwp_wc_redirect', get_permalink( affiliate_wp()->settings->get( 'affiliates_page' ) ) );
	}
     
    return $redirect;
}
add_filter( 'woocommerce_login_redirect', 'affwp_wc_redirect_affiliates', 10, 2 );