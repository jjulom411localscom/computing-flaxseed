<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WC_Zapier_Trigger_Subscription_New extends WC_Zapier_Trigger_Subscription {

	public function __construct() {
		$this->trigger_title = __( 'Subscription Created', 'wc_zapier' );

		$this->trigger_description = __( 'Triggers when a subscription is created, either via the Checkout or via the REST API.', 'wc_zapier' );

		// Prefix the trigger key with wc. to denote that this is a trigger that relates to a WooCommerce order
		$this->trigger_key = 'wc.new_subscription';

		$this->sort_order = 4;

		// Subscriptions created via the WooCommerce checkout process
		$this->actions['woocommerce_checkout_subscription_created'] = 3;

		// Subscriptions created via the WooCommerce REST API
		$this->actions['wcs_api_subscription_created'] = 2;

		parent::__construct();
	}

}