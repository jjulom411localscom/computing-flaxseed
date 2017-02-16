<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

abstract class WC_Zapier_Trigger_Subscription extends WC_Zapier_Trigger_Order {

	/**
	 * @var WC_Subscription instance
	 */
	protected $wc_subscription;

	/**
	 * The sample WooCommerce subscription data that is sent to Zapier as sample data.
	 *
	 * @return array
	 */
	public function get_sample_data() {
		$subscription = parent::get_sample_data();

		// Add additional subscription-specific fields to the standard Order fields
		$subscription['start_date']        = '2016-05-11T01:32:47+08:00';
		$subscription['trial_end_date']    = '2016-06-10T09:34:17+08:00';
		$subscription['next_payment_date'] = '2016-06-11T01:32:47+08:00';
		$subscription['end_date ']         = '2016-06-10T09:34:17+08:00';
		$subscription['last_payment_date'] = '2016-06-10T01:34:08+08:00';
		$subscription['billing_period']    = 'day';
		$subscription['billing_interval']  = '1';

		$subscription['completed_payment_count'] = '1';
		$subscription['failed_payment_count'] = '0';

		$subscription['view_url'] = 'http://yourdomain.com/my-account/view-subscription/123';

		return $subscription;
	}

	public function assemble_data( $args, $action_name ) {

		if ( $this->is_sample() ) {
			// The webhook/trigger is being tested
			return $this->get_sample_data();

		} else {
			// Using real live data

			if ( is_a( $args[0], 'WC_Subscription' ) ) {
				// The first argument is the subscription object
				$this->wc_subscription = $args[0];
			} else if ( is_numeric( $args[0] ) ) {
				// The first argument is a subscription ID
				$this->wc_subscription = wcs_get_subscription( absint( $args[0] ) );
			} else {
				WC_Zapier()->log( 'Unknown Subscription argument $args[0]: ' . var_dump( $args[0] ), null, 'Subscription' );
			}

			$new_status = '';
			$previous_status = '';

			if ( 'woocommerce_subscription_status_updated' == $action_name ) {
				$new_status      = $args[1];
				$previous_status = $args[2];
			}

			if ( empty( $new_status ) ) {
				$new_status = $this->wc_subscription->get_status();
			}

			// Compile the subscription details/data that will be sent to Zapier

			// WooCommerce Subscriptions are WooCommerce Orders, but with a few extra attributes.


			// Retrieve the basic "order" information first
			$orderargs    = array( $this->wc_subscription->id );
			$subscription = parent::assemble_data( $orderargs, $action_name );

			$subscription['status']          = $new_status;
			$subscription['status_previous'] = $previous_status;


			// Now add the Subscription-specific information
			$subscription['start_date']        = WC_Zapier::format_date( $this->wc_subscription->start_date );
			$subscription['trial_end_date']    = WC_Zapier::format_date( $this->wc_subscription->trial_end_date );
			$subscription['next_payment_date'] = WC_Zapier::format_date( $this->wc_subscription->next_payment_date );
			$subscription['end_date ']         = WC_Zapier::format_date( $this->wc_subscription->end_date );
			$subscription['last_payment_date'] = WC_Zapier::format_date( $this->wc_subscription->last_payment_date );
			$subscription['billing_period']    = $this->wc_subscription->billing_period;
			$subscription['billing_interval']  = $this->wc_subscription->billing_interval;

			$subscription['completed_payment_count'] = $this->wc_subscription->get_completed_payment_count();
			// TODO: Add completed payment total?
			$subscription['failed_payment_count'] = $this->wc_subscription->get_failed_payment_count();
			// TODO: Add failed payment total?

			$subscription['view_url'] = $this->wc_subscription->get_view_order_url();

			return $subscription;

		}

	}

	protected function data_sent_to_feed( WC_Zapier_Feed $feed, $result, $action_name, $arguments, $num_attempts = 0 ) {

		$note = '';

		if ( 1 == $num_attempts  ) {
			// Successful on the first attempt
			$note .= sprintf( __( 'Subscription sent to Zapier via the <a href="%1$s">%2$s</a> Zapier feed.', 'wc_zapier' ), $feed->edit_url(), $feed->title() );
		} else {
			// It took more than 1 attempt so add that to the note
			$note .= sprintf( __( 'Subscription sent to Zapier via the <a href="%1$s">%2$s</a> Zapier feed after %3$d attempts.', 'wc_zapier' ), $feed->edit_url(), $feed->title(), $num_attempts );
		}

		$note .= sprintf( __( '<br ><br />Trigger:<br />%1$s<br />%2$s', 'wc_zapier' ), $feed->trigger()->get_trigger_title(), "<small>{$action_name}</small>" );

		// Add a private note to this order
		$this->wc_subscription->add_order_note( $note );

		WC_Zapier()->log( $note, $this->wc_subscription->id, 'Subscription' );

	}

}