<?php

/**
 * @package EstimatedShippingDate
 * @author Waqar Haider <waqarhaider783@yahoo.com>
 * @copyright 2021 Va8ive Digital
 * @license GPL-2.0-or-later
 * 
 * Plugin Name: Estimated Shipping Date
 * Description: This plugin displays the estimated shipping duration for any given product above the Add to Cart button on WooCommerce Single Product pages.
 * Version: 0.0.1
 * Author: Waqar Haider
 * Author URI: https://va8ivedigital.com/
 * Text Domain: estimated-shipping-date
 */

/*
Estimated Shipping Date is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Estimated Shipping Date is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
*/

/**
 * Security Measure
 */
if(!defined('ABSPATH')) exit;

/**
 * Custom field registration
 */
if( function_exists('acf_add_local_field_group') ):

  acf_add_local_field_group(
    array(
      'key' => 'group_607d1b8d6dfe5',
      'title' => 'Estimated Shipping Duration',
      'fields' => array(
        array(
          'key' => 'field_607d2258ba87b',
          'label' => 'Shipping Type',
          'name' => 'shipping_type',
          'type' => 'select',
          'instructions' => 'The type of shipping that applies to this product',
          'required' => 1,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'choices' => array(
            'normal' => 'Normal Shipping (45 - 50 Days)',
            'flash' => 'Flash Shipping (2 - 3 Days)',
          ),
          'default_value' => 'flash',
          'allow_null' => 0,
          'multiple' => 0,
          'ui' => 0,
          'return_format' => 'value',
          'ajax' => 0,
          'placeholder' => '',
        ),
      ),
      'location' => array(
        array(
          array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'product',
          ),
        ),
      ),
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => true,
      'description' => '',
    )
  );

endif;

/**
 * Function to render the shipping estimate component
 */
function display_shipping_estimate() {
  if (get_field('shipping_type')):
    if (get_field('shipping_type') === 'normal'):
      $earliest_shipping_date = date('d M Y', strtotime("+45 Days"));
      $latest_shipping_date   = date('d M Y', strtotime("+50 Days"));
    elseif (get_field('shipping_type') === 'flash'):
      $earliest_shipping_date = date('d M Y', strtotime("+2 Days"));
      $latest_shipping_date   = date('d M Y', strtotime("+5 Days"));
    endif;
    ?>
    <div class="woocommerce-shipping-estimate" style="margin-bottom: 1rem;">
      <p style="font-size: 1.2rem; color: var(--color-dark); margin: 0;">Estimated Delivery Date: <strong style="color: var(--color-theme);"><?php echo $earliest_shipping_date ?> - <?php echo $latest_shipping_date ?></strong></p>
    </div>
    <?php
  endif;
}

/**
 * Add shipping estimate renderer to the woocommerce loop
 */
add_action('woocommerce_before_add_to_cart_button', 'display_shipping_estimate', 10);