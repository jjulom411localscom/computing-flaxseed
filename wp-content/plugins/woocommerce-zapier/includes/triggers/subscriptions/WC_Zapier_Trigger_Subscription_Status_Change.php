<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WC_Zapier_Trigger_Subscription_Status_Change extends WC_Zapier_Trigger_Subscription {

	public function __construct() {
		$this->trigger_title = __( 'Subscription Status Changed', 'wc_zapier' );

		$this->trigger_description = sprintf( __( 'Advanced: triggers every time a subscription changes status.<br />Consider using with a Filter.<br />See the <a href="%1$s" target="_blank">Advanced Zaps documentation</a> for more information.', 'wc_zapier' ), 'https://docs.woothemes.com/document/woocommerce-zapier/#advancedzaps' );

		// Prefix the trigger key with wc. to denote that this is a trigger that relates to a WooCommerce order
		$this->trigger_key = 'wc.subscription_status_change';

		$this->sort_order = 9;

		$this->actions['woocommerce_subscription_status_updated'] = 3;

		parent::__construct();
	}

}