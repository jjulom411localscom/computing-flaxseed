<?php

class AffiliateWP_Recurring_Affiliates_Edit {

	public function __construct() {

		if( ! function_exists( 'affwp_get_affiliate_meta' ) ) {
			return;
		}

		add_action( 'affwp_edit_affiliate_end', array( $this, 'settings' ) );
		add_action( 'affwp_insert_affiliate', array( $this, 'add_affiliate' ), -1 );
		add_action( 'affwp_update_affiliate', array( $this, 'update_affiliate' ), -1 );
	}

	public function settings( $affiliate ) {

		$rate     = affwp_get_affiliate_meta( $affiliate->affiliate_id, 'recurring_rate', true );
		$disabled = affwp_get_affiliate_meta( $affiliate->affiliate_id, 'recurring_disabled', true );
?>

		<tr class="form-row">

			<th scope="row">
				<label for="recurring_rate"><?php _e( 'Recurring Referral Rate', 'affiliate-wp-recurring' ); ?></label>
			</th>

			<td>
				<input type="number" class="small-text" name="recurring_rate" id="recurring_rate" value="<?php echo esc_attr( affwp_abs_number_round( $rate ) ); ?>" step="0.01" min="0" max="999999" placeholder="<?php echo esc_attr( affwp_abs_number_round( affiliate_wp()->settings->get( 'referral_rate', 20 ) ) ); ?>"/>
				<p class="description"><?php _e( 'The affiliate\'s recurring referral rate, such as 20 for 20%. If left blank, the default recurring rate will be used.', 'affiliate-wp-recurring' ); ?></p>
			</td>

		</tr>

		<tr class="form-row">

			<th scope="row">
				<label for="recurring_disabled"><?php _e( 'Recurring Referrals', 'affiliate-wp-recurring' ); ?></label>
			</th>

			<td>
				<input type="checkbox" name="recurring_disabled" id="recurring_disabled" value="1"<?php checked( 1, $disabled ); ?>/>
				<p class="description"><?php _e( 'Disable recurring referrals for this affiliate?', 'affiliate-wp-recurring' ); ?></p>
			</td>

		</tr>
<?php
	}

	public function add_affiliate( $affiliate_id = 0 ) {

		if( isset( $_POST['recurring_disabled'] ) ) {
			affwp_update_affiliate_meta( $affiliate_id, 'recurring_disabled', 1 );
		} else {
			affwp_delete_affiliate_meta( $affiliate_id, 'recurring_disabled' );
		}

		if( isset( $_POST['recurring_rate'] ) ) {
			affwp_update_affiliate_meta( $affiliate_id, 'recurring_rate', sanitize_text_field( $_POST['recurring_rate'] ) );
		} else {
			affwp_delete_affiliate_meta( $affiliate_id, 'recurring_rate' );
		}

	}

	public function update_affiliate( $data ) {

		if ( empty( $data['affiliate_id'] ) ) {
			return false;
		}

		if ( ! is_admin() ) {
			return false;
		}

		if ( ! current_user_can( 'manage_affiliates' ) ) {
			wp_die( __( 'You do not have permission to manage affiliates', 'affiliate-wp-recurring' ), __( 'Error', 'affiliate-wp-recurring' ), array( 'response' => 403 ) );
		}

		if( isset( $_POST['recurring_disabled'] ) ) {
			affwp_update_affiliate_meta( $data['affiliate_id'], 'recurring_disabled', 1 );
		} else {
			affwp_delete_affiliate_meta( $data['affiliate_id'], 'recurring_disabled' );
		}

		if( isset( $_POST['recurring_rate'] ) ) {
			affwp_update_affiliate_meta( $data['affiliate_id'], 'recurring_rate', sanitize_text_field( $_POST['recurring_rate'] ) );
		} else {
			affwp_delete_affiliate_meta( $data['affiliate_id'], 'recurring_rate' );
		}

	}

}
new AffiliateWP_Recurring_Affiliates_Edit;