<?php
/**
 * Sample hello email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/sample-hello.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/

 * @package WC Sample Email/Templates/Emails
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer first name */ ?>
<p><?php printf( esc_html__( 'Hi %s,', 'wc-sample-email' ), esc_html( $order->get_billing_first_name() ) ); ?></p>

<blockquote><p><?php esc_html_e( 'Hello.', 'wc-sample-email' ); ?></p><p><?php esc_html_e( 'It\'s me.', 'wc-sample-email' ); ?></p></blockquote>

<?php

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
