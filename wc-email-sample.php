<?php
/**
 * Plugin Name: WooCommerce Sample Email
 * Plugin URI:  https://github.com/helgatheviking/wc-sample-email
 * Description: Setup a custom WooCommerce Email.
 * Version:     1.0.0
 * Author:      Kathy Darling
 * Author URI:  http://www.kathyisawesome.com
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: wc-sample-email
 * Domain Path: /languages
 * Requires at least: 4.9.0
 * Tested up to: 5.0.0
 * WC requires at least: 3.4.0
 * WC tested up to: 3.5.0   
 */
 
class WC_Sample_Email_Plugin
{

	/**
	 * Setup plugin.
	 */
    public static function init()
    {
        define( 'WC_SAMPLE_EMAIL_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
        add_filter( 'woocommerce_email_classes', array( __CLASS__, 'sample_init_emails' ) );
        add_filter( 'woocommerce_order_actions', array( __CLASS__, 'sample_order_action' ) );
        add_action( 'woocommerce_order_action_send_sample_email', array( __CLASS__, 'resend_sample_email' ) );
    }

	/**
	 * Add our custom class.
	 *
	 * @param array    $emails The registerd emails.
	 * @return array
	 */
    public static function sample_init_emails( $emails ){
        $emails['WC_Sample_Email'] = include 'includes/class-wc-email-sample.php';
        return $emails;
    }

	/**
	 * Add our order action to metabox
	 *
	 * @param array    $actions The actions in the order metabox
	 * @return array
	 */    
    public static function sample_order_action( $actions ) {
        $actions['send_sample_email'] = __( 'Resend sample email', 'wc-sample-email' );
		return $actions;
    }

	/**
	 * Manually trigger the sending of this email.
	 *
	 * @param WC_Order $order Order object.
	 */
    public static function resend_sample_email( $order ) {

		do_action( 'woocommerce_before_resend_order_emails', $order, 'sample_email' );

		WC()->payment_gateways();
		WC()->shipping();
		WC()->mailer()->emails['WC_Sample_Email']->trigger( $order->get_id(), $order );

		do_action( 'woocommerce_after_resend_order_email', $order, 'sample_email' );

		// Change the post saved message.
		add_filter( 'redirect_post_location', array( 'WC_Meta_Box_Order_Actions', 'set_email_sent_message' ) );

	} 

}

add_action( 'woocommerce_loaded', array( 'WC_Sample_Email_Plugin', 'init' ) );
