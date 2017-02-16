<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WC_Zapier_Trigger_Subscription_Renewal_Failed extends WC_Zapier_Trigger_Subscription {

	public function __construct() {
		$this->trigger_title = __( 'Subscription Renewal Failed', 'wc_zapier' );

		$this->trigger_description = __( 'Triggers when a subscription renewal payment fails.', 'wc_zapier' );

		// Prefix the trigger key with wc. to denote that this is a trigger that relates to a WooCommerce order
		$this->trigger_key = 'wc.subscription_renewal_failed';

		$this->sort_order = 6;

		$this->actions['woocommerce_subscription_renewal_payment_failed'] = 1;

		parent::__construct();
	}

}