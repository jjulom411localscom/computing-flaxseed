<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class AffiliateWP_PayPal_MassPay extends AffiliateWP_PayPal_API {

	/**
	 * Process a single referral payment
	 *
	 * @access public
	 * @since 1.1
	 * @return bool|WP_Error
	 */
	public function send_payment( $args = array() ) {

		$body = array(
			'USER'         => $this->credentials['username'],
			'PWD'          => $this->credentials['password'],
			'SIGNATURE'    => $this->credentials['signature'],
			'METHOD'       => 'MassPay',
			'VERSION'      => '124',
			'RECEIVERTYPE' => 'EmailAddress',
			'CURRENCYCODE' => affwp_get_currency(),
			'EMAILSUBJECT' => __( 'Affiliate Earnings Payout', 'affswp-paypal-payouts' ),
			'L_EMAIL0'     => $args['email'],
			'L_AMT0'       => $args['amount'],
			'L_NOTE0'      => $args['description']
		);

		$mode     = affiliate_wp_paypal()->is_test_mode() ? 'sandbox.' : '';
		$request  = wp_remote_post( 'https://api-3t.' . $mode . 'paypal.com/nvp', array( 'timeout' => 45, 'sslverify' => false, 'body' => $body, 'httpversion' => '1.1' ) );
		$body     = wp_remote_retrieve_body( $request );
		$code     = wp_remote_retrieve_response_code( $request );
		$message  = wp_remote_retrieve_response_message( $request );

		if( 200 === $code && 'ok' === strtolower( $message ) ) {
						
			if( is_string( $body ) ) {
				wp_parse_str( $body, $body );
			}

			if( 'failure' === strtolower( $body['ACK'] ) ) {

				return new WP_Error( 'api_error', $body['L_ERRORCODE0'] . ': ' . $body['L_LONGMESSAGE0'] ); 

			} else {

				if ( function_exists( 'affwp_add_payout' ) ) {
					if ( $referral = affwp_get_referral( $args['referral_id' ] ) ) {
						affwp_add_payout( array(
							'affiliate_id'  => $referral->affiliate_id,
							'referrals'     => $referral->ID,
							'amount'        => $referral->amount,
							'payout_method' => 'PayPal'
						) );
					}
				} else {
					affwp_set_referral_status( $args['referral_id'], 'paid' );
				}

			}

		} else {

			return new WP_Error( 'api_error', $code . ': ' . $message ); 

		}

		return true;

	}

	/**
	 * Process a referral payment for a bulk payout
	 *
	 * @access public
	 * @since 1.1
	 * @return bool|WP_Error
	 */
	public function send_bulk_payment( $payouts = array() ) {

		$body = array(
			'USER'         => $this->credentials['username'],
			'PWD'          => $this->credentials['password'],
			'SIGNATURE'    => $this->credentials['signature'],
			'METHOD'       => 'MassPay',
			'VERSION'      => '124',
			'RECEIVERTYPE' => 'EmailAddress',
			'CURRENCYCODE' => affwp_get_currency(),
			'EMAILSUBJECT' => __( 'Affiliate Earnings Payout', 'affwp-paypal-payouts' )
		);

		$i = 0;
		foreach( $payouts as $payout ) {

			$body[ 'L_EMAIL' . $i ] = $payout['email'];
			$body[ 'L_AMT' . $i ]   = $payout['amount'];
			$body[ 'L_NOTE' . $i ]  = $payout['description'];

			$i++;
		}

		$mode     = affiliate_wp_paypal()->is_test_mode() ? 'sandbox.' : '';
		$request  = wp_remote_post( 'https://api-3t.' . $mode . 'paypal.com/nvp', array( 'timeout' => 45, 'sslverify' => false, 'body' => $body, 'httpversion' => '1.1' ) );
		$body     = wp_remote_retrieve_body( $request );
		$code     = wp_remote_retrieve_response_code( $request );
		$message  = wp_remote_retrieve_response_message( $request );

		if ( is_wp_error( $request ) ) {

			return $request;

		} else if( 200 === $code && 'ok' === strtolower( $message ) ) {

			if( is_string( $body ) ) {
				wp_parse_str( $body, $body );
			}
		
			if( 'failure' === strtolower( $body['ACK'] ) ) {

				return new WP_Error( $body['L_ERRORCODE0'], $body['L_LONGMESSAGE0'] ); 

			}

		} else {

			return new WP_Error( $code, $message ); 

		}

		return true;

	}

}