<?php
/*
 * Plugin Name: ACF Gravity Forms Select

 * Plugin URI: http://Jamali.dev/ACF_Gravity_Forms_Select
 * Description: This custom plugin for Advanced Custom Fields (ACF) allows you to add a select field with Gravity Form.
 * Author: Armin Jamali
 * Version: 1.5.3
 * Author URI:  http://jamali.dev
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/


defined('ABSPATH') || exit('NO ACCESS');

// define constants for wrc
define('AGS_DIR', trailingslashit(plugin_dir_path(__FILE__)));
define('AGS_URL', trailingslashit(plugin_dir_url(__FILE__)));


// write activation && deactivation hook'callback
function AGS_activate()
{
}

function AGS_deactivate()
{
}


register_activation_hook(__FILE__, 'AGS_activate');
register_deactivation_hook(__FILE__, 'AGS_deactivate');


function custom_acf_field_type($field_types) {
    class ACF_Custom_Field_Type_Gravity_Forms extends acf_field {
        function __construct() {
            $this->name = 'gravity_forms_select';
            $this->label = __('Gravity Forms');
            $this->category = 'choice';
            $this->defaults = array(
                'default_value' => '',
            );
            parent::__construct();
        }

        function render_field($field) {

            if (is_plugin_active('gravityforms/gravityforms.php')) {
                // get Gravity Forms
                $forms = GFAPI::get_forms();


                // Display a select dropdown for Gravity Forms
                ?>
                <select name="<?php echo esc_attr($field['name']); ?>">
                    <option value="">Select a Gravity Form</option>
                    <?php foreach ($forms as $form) : ?>
                        <option value="<?php echo esc_attr($form['id']); ?>" <?php selected($field['value'], $form['id']); ?>>
                            <?php echo esc_html($form['title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php
            }

        }
    }

    acf_register_field_type(new ACF_Custom_Field_Type_Gravity_Forms());
}

add_action('acf/include_field_types', 'custom_acf_field_type');

