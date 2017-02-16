<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WC_Zapier_Trigger_Subscription_Renewal extends WC_Zapier_Trigger_Subscription {

	public function __construct() {
		$this->trigger_title = __( 'Subscription Renewed', 'wc_zapier' );

		$this->trigger_description = __( 'Triggers when a subscription renewal payment completes successfully.', 'wc_zapier' );

		// Prefix the trigger key with wc. to denote that this is a trigger that relates to a WooCommerce order
		$this->trigger_key = 'wc.subscription_renewal';

		$this->sort_order = 5;

		$this->actions['woocommerce_subscription_renewal_payment_complete'] = 1;

		parent::__construct();
	}

}