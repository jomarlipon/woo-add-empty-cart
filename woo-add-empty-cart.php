<?php
/**
Plugin Name: Woo Add Empty Cart Button
Plugin URI: http://jomarph.com/
Description: Add empty cart button in cart page for Woocommece only. You can choose where to display the empty cart button in front-end.
Author: Jomar Lipon
Author URI: http://jomarph.com
Version: 1.1
**/
if(!class_exists('WC_Empty_Cart')) {
	
	class WC_Empty_Cart {
		
		public function __construct() 
		{
			if (get_option('display_empty_cart_button')=='before') {
				add_action('woocommerce_before_cart', array($this,'pt_wc_empty_cart_button'));
			} else {
				add_action('woocommerce_after_cart_contents', array($this,'pt_wc_empty_cart_button'));
			}
			add_action('init', array($this,'pt_wc_clear_cart_url'));
			add_filter( 'woocommerce_general_settings', array($this,'add_a_wc_setting') );	
		}
		
		
		public function pt_wc_empty_cart_button($cart) {
			/* $cart = calling the cart */
			global $woocommerce;
			$cart_url = $woocommerce->cart->get_cart_url();
			?>
						<tr>
						<td colspan="6" class="actions">
						<?php 
						
						if(empty($_GET)) {?>
						<a class="button emptycart" href="<?php echo $cart_url;?>?empty=empty-cart"><?php _e('Empty Cart','pt-emptycart'); ?></a>
						<?php } else {?>
						<a class="button emptycart" href="<?php echo $cart_url;?>&empty=empty-cart"><?php _e('Empty Cart','pt-emptycart'); ?></a>
						<?php } ?>
						
						
			</td></tr>


		<?php }

	
		public function pt_wc_clear_cart_url() {
						
			global $woocommerce;
			if( isset($_REQUEST['empty']) ) {
				$woocommerce->cart->empty_cart();
			}
			
		}
		
		public function add_a_wc_setting($settings) {
					
					$settings[] = 
						array(
							'name'		=> __( 'Empty Cart Option', 'woocommerce'),
							'desc' 		=> __( 'This controls where to display empty cart button', 'woocommerce' ),
							'id' 		=> 'display_empty_cart_button',
							'std' 		=> 'before',
							'default'	=> 'before',
							'type' 		=> 'select',
							'options'	=> array (
								'before' => __('Before Cart Table','woocommerce'),
								'after'	=> __('After Cart Table', 'woocommerce')
							)
						);
				
					$settings[] = array( 'type' => 'sectionend', 'id' => 'general_options');

					return $settings;
		}
		
	}
	$wchook = new WC_Empty_Cart();
	
}


?>
