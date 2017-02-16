<?php

abstract class Affiliate_WP_Recurring_Base {

	public $context;
	public $affiliate_id;


	/**
	 * Construct class
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Get things started
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function init() {

	}

	/**
	 * Determine if signup was referred
	 *
	 * @access public
	 * @since 1.0
	 * @return bool
	 */
	public function was_signup_referred() {
		return false;
	}

	/**
	 * Insert a pending referral for a subscription payment
	 *
	 * @access public
	 * @since 1.0
	 * @return int|bool
	 */
	public function insert_referral( $args = array() ) {

		if( function_exists( 'affwp_get_affiliate_meta' ) && affwp_get_affiliate_meta( $args['affiliate_id'], 'recurring_disabled', true ) ) {
			return false;
		}

		if( affiliate_wp()->referrals->get_by( 'reference', $args['reference'], $this->context ) ) {
			return false; // Referral already created for this reference
		}

		if( empty( $this->affiliate_id ) ) {
			$this->affiliate_id = $args['affiliate_id'];
		}

		$amount = $this->calc_referral_amount( $args['amount'] );

		if( 0 == $amount && affiliate_wp()->settings->get( 'ignore_zero_referrals' ) ) {
			return false; // Ignore a zero amount referral
		}

		return affiliate_wp()->referrals->add( array(
			'amount'       => $amount,
			'reference'    => $args['reference'],
			'description'  => $args['description'],
			'affiliate_id' => $args['affiliate_id'],
			'context'      => $this->context,
			'custom'       => ! empty( $args['custom'] ) ? $args['custom'] : ''
		) );

	}

	/**
	 * Mark a referral as complete
	 *
	 * @access public
	 * @since 1.0
	 * @return bool
	 */
	public function complete_referral( $referral_id = 0 ) {

		if ( empty( $referral_id ) ) {
			return false;
		}

		if ( affwp_set_referral_status( $referral_id, 'unpaid' ) ) {

			do_action( 'affwp_complete_recurring_referral', $referral_id );

			return true;
		}

		return false;

	}

	/**
	 * Calculate the referral amount for a subscription payment
	 *
	 * @access public
	 * @since 1.5.7
	 * @return float
	 */
	public function calc_referral_amount( $amount = '' ) {

		$rate     = $this->get_referral_rate();
		$type     = affwp_get_affiliate_rate_type( $this->affiliate_id );
		$decimals = affwp_get_decimal_count();

		$referral_amount = ( 'percentage' === $type ) ? round( $amount * $rate, $decimals ) : $rate;

		if ( $referral_amount < 0 ) {
			$referral_amount = 0;
		}

		return (string) apply_filters( 'affwp_recurring_calc_referral_amount', $referral_amount, $this->affiliate_id, $amount );

	}

	/**
	 * Retrieve the referral rate for a subscription payment
	 *
	 * @access public
	 * @since 1.5
	 * @return float
	 */
	public function get_referral_rate() {

		$rate = affwp_get_affiliate_meta( $this->affiliate_id, 'recurring_rate', true );

		if( empty( $rate ) ) {

			$rate = affiliate_wp()->settings->get( 'recurring_rate', 20 );

			if( empty( $rate ) ) {

				$rate = affwp_get_affiliate_rate( $this->affiliate_id, false, $rate );

			}
		}

		if( 'flat' !== affwp_get_affiliate_rate_type( $this->affiliate_id ) && $rate >= 1 ) {
			$rate /= 100;
		}

		return apply_filters( 'affwp_get_recurring_referral_rate', $rate, $this->affiliate_id, $this->context );

	}

}