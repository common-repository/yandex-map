<?php
/*
Plugin Name: yandex map
Plugin URI: http://idehweb.com/yandex-map
Description: yandex map for woocommerce checkout
Version: 1.0.2
Author: Hamid Alinia - idehweb
Author URI: http://idehweb.com
Text Domain: yandex-map
Domain Path: /languages
*/

class idehwebYandexMap
{
    public $textdomain = 'yandex-map';

    function __construct()
    {
        add_action('init', array(&$this, 'idehweb_yandexmap_textdomain'));
        add_action('admin_init', array(&$this, 'admin_init'));
        add_action('admin_menu', array(&$this, 'admin_menu'));
        add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));
        add_action('activated_plugin', array(&$this, 'yandexmap_activation_redirect'));
        add_shortcode('idehweb_yandexmap', array(&$this, 'shortcode'));
        add_filter('woocommerce_checkout_fields', array(&$this, 'yandexmap_override_checkout_fields'));
        add_action('woocommerce_admin_order_data_after_billing_address', array(&$this, 'yandexmap_override_checkout_fields_admin'), 10, 1);
        add_action( 'woocommerce_checkout_update_order_meta', array(&$this,'yandexmap_override_checkout_update_meta' ));


    }


    function yandexmap_activation_redirect($plugin)
    {
        if ($plugin == plugin_basename(__FILE__)) {
            exit(wp_redirect(admin_url('admin.php?page=idehweb-yandexmap')));
        }
    }

    function idehweb_yandexmap_textdomain()
    {
        $idehweb_yandexmap_lang_dir = dirname(plugin_basename(__FILE__)) . '/languages/';
        $idehweb_yandexmap_lang_dir = apply_filters('idehweb_yandexmap_languages_directory', $idehweb_yandexmap_lang_dir);

        load_plugin_textdomain($this->textdomain, false, $idehweb_yandexmap_lang_dir);


    }

    function admin_init()
    {
        $options = get_option('idehweb_yandexmap_settings');


        register_setting('idehweb-yandexmap', 'idehweb_yandexmap_settings', array(&$this, 'settings_validate'));


        add_settings_section('idehweb-yandexmap', '', array(&$this, 'section_intro'), 'idehweb-yandexmap');

        add_settings_field('idehweb_yandexmap_api', __('Enter your map Api', $this->textdomain), array(&$this, 'setting_idehweb_yandexmap_api'), 'idehweb-yandexmap', 'idehweb-yandexmap', ['class' => 'idehweb_yandexmap']);
        add_settings_field('idehweb_yandexmap_language', __('Enter your language', $this->textdomain), array(&$this, 'setting_idehweb_yandexmap_lang'), 'idehweb-yandexmap', 'idehweb-yandexmap', ['class' => 'idehweb_yandexmap']);
        add_settings_field('idehweb_yandexmap_id_field', __('Enter id of where you need map button show', $this->textdomain), array(&$this, 'setting_idehweb_yandexmap_id_field'), 'idehweb-yandexmap', 'idehweb-yandexmap', ['class' => 'idehweb_yandexmap']);
        add_settings_field('idehweb_yandexmap_city_id_field', __('Enter id of city field you need to fill', $this->textdomain), array(&$this, 'setting_idehweb_yandexmap_city_id_field'), 'idehweb-yandexmap', 'idehweb-yandexmap', ['class' => 'idehweb_yandexmap']);

    }

    function admin_menu()
    {

        $icon_url = 'dashicons-smartphone';
        $page_hook = add_menu_page(
            __('Yandex map', $this->textdomain),
            __('Yandex map', $this->textdomain),
            'manage_options',
            'idehweb-yandexmap',
            array(&$this, 'settings_page'),
            $icon_url
        );
        $options = get_option('idehweb_yandexmap_settings');
        if (!isset($options['idehweb_yandexmap_api'])) $options['idehweb_yandexmap_api'] = '';
        if (!isset($options['idehweb_yandexmap_language'])) $options['idehweb_yandexmap_language'] = 'en_US';
        $lang = $options['idehweb_yandexmap_language'];
        $api = $options['idehweb_yandexmap_api'];

//        add_action('admin_print_styles-' . $page_hook, array(&$this, 'admin_custom_css'));
        wp_enqueue_style('idehweb-yandexmap-admin', plugins_url('/styles/yandexmap-admin.css', __FILE__));

        wp_enqueue_script('idehweb-yandexmap-external-admin', "https://api-maps.yandex.ru/2.1/?apikey=$api&lang=$lang", array('jquery'));
        wp_enqueue_script('idehweb-yandexmap-admin-js', plugins_url('/scripts/yandex-map-admin.js', __FILE__), array('jquery'), true, true);

    }

//    function admin_custom_css()
//    {
//        wp_enqueue_style('idehweb-yandexmap-admin', plugins_url('/styles/yandexmap-admin.css', __FILE__));
//
//
//    }

    function settings_page()
    {
        $options = get_option('idehweb_yandexmap_settings');
        if (!isset($options['idehweb_phone_number'])) $options['idehweb_phone_number'] = '';

        ?>
        <div class="wrap">
            <div id="icon-themes" class="icon32"></div>
            <h2><?php _e('Yandex map Settings', $this->textdomain); ?></h2>
            <?php if (isset($_GET['settings-updated']) && $_GET['settings-updated']) {

                ?>
                <div id="setting-error-settings_updated" class="updated settings-error">
                    <p><strong><?php _e('Settings saved.', $this->textdomain); ?></strong></p>
                </div>
            <?php } ?>
            <form action="options.php" method="post" id="iuytfrdghj">
                <?php settings_fields('idehweb-yandexmap'); ?>
                <?php do_settings_sections('idehweb-yandexmap'); ?>

                <p class="submit">
                    <span id="wkdugchgwfchevg3r4r"></span>
                </p>
                <p class="submit">
                    <span id="oihdfvygehv"></span>
                </p>
                <p class="submit">
                    <input type="submit" class="button-primary"
                           value="<?php _e('Save Changes', $this->textdomain); ?>"/></p>

            </form>


            <script>
                <?php

                ?>
                jQuery(function ($) {
                });
            </script>
        </div>
        <?php
    }


    function section_intro()
    {
        ?>

        <?php

    }

    function section_title()
    {
        ?>
        <!--        jhgjk-->

        <?php

    }

    function settings_validate($input)
    {

        return $input;
    }

    function enqueue_scripts()
    {
        $options = get_option('idehweb_yandexmap_settings');
        if (!isset($options['idehweb_yandexmap_api'])) $options['idehweb_yandexmap_api'] = '';
        if (!isset($options['idehweb_yandexmap_language'])) $options['idehweb_yandexmap_language'] = 'en_US';
        if (!isset($options['idehweb_yandexmap_id_field'])) $options['idehweb_yandexmap_id_field'] = '';
        if (!isset($options['idehweb_yandexmap_city_id_field'])) $options['idehweb_yandexmap_city_id_field'] = 'billing_city';
        $lang = $options['idehweb_yandexmap_language'];
        $localize = array(
//            'ajaxurl' => admin_url('admin-ajax.php'),
//            'redirecturl' => $options['idehweb_redirect_url'],
//            'UserId' => 0,
            'IamHere' => __('I am here', $this->textdomain),
            'yandexidfiled' => $options['idehweb_yandexmap_id_field'],
            'yandex_billing_city' => $options['idehweb_yandexmap_city_id_field'],
        );

        $api = $options['idehweb_yandexmap_api'];
        if ($api) {
            wp_enqueue_style('idehweb-yandexmap-css', plugins_url('/styles/yandex-map.css', __FILE__));

            wp_enqueue_script('idehweb-yandexmap-external', "https://api-maps.yandex.ru/2.1/?apikey=$api&lang=$lang", array('jquery'));
            wp_enqueue_script('idehweb-yandexmap-js', plugins_url('/scripts/yandex-map.js', __FILE__), array('jquery'));
        }
        wp_localize_script('idehweb-yandexmap-js', 'idehweb_yandexmap', $localize);
//        if ($options['idehweb_use_custom_gateway'] == '1' && $options['idehweb_default_gateways'] === 'firebase') {
//
//            wp_add_inline_script('idehweb-yandexmap', '' . htmlspecialchars_decode($options['idehweb_firebase_config']));
//        }

    }


    function shortcode($atts)
    {

        extract(shortcode_atts(array(
            'redirect_url' => ''
        ), $atts));
        ob_start();
        $options = get_option('idehweb_yandexmap_settings');

        ?>
        <div id="map" style="width: 600px; height: 400px"></div
        <?php
        return ob_get_clean();
    }


    function setting_idehweb_yandexmap_api()
    {
        $options = get_option('idehweb_yandexmap_settings');
        if (!isset($options['idehweb_yandexmap_api'])) $options['idehweb_yandexmap_api'] = '';

        echo '<input id="yandexmap_token" type="text" name="idehweb_yandexmap_settings[idehweb_yandexmap_api]" class="regular-text" value="' . esc_attr($options['idehweb_yandexmap_api']) . '" />
		<p class="description">' . __('enter yandex map api', $this->textdomain) . '</p>';

    }
    function setting_idehweb_yandexmap_lang()
    {
        $options = get_option('idehweb_yandexmap_settings');
        if (!isset($options['idehweb_yandexmap_language'])) $options['idehweb_yandexmap_language'] = 'en_US';

        echo '<input id="yandexmap_lang" type="text" name="idehweb_yandexmap_settings[idehweb_yandexmap_language]" class="regular-text" value="' . esc_attr($options['idehweb_yandexmap_language']) . '" />
		<p class="description">' . __('enter yandex map language', $this->textdomain) . '</p>';

    }

    function setting_idehweb_yandexmap_id_field()
    {
        $options = get_option('idehweb_yandexmap_settings');
        if (!isset($options['idehweb_yandexmap_id_field'])) $options['idehweb_yandexmap_id_field'] = '';

        echo '<input id="yandexmap_token" type="text" name="idehweb_yandexmap_settings[idehweb_yandexmap_id_field]" class="regular-text" value="' . esc_attr($options['idehweb_yandexmap_id_field']) . '" />
		<p class="description">' . __('enter id of element you need map button show', $this->textdomain) . '</p>';

    }
    function setting_idehweb_yandexmap_city_id_field()
    {
        $options = get_option('idehweb_yandexmap_settings');
        if (!isset($options['idehweb_yandexmap_city_id_field'])) $options['idehweb_yandexmap_city_id_field'] = 'billing_city';

        echo '<input id="idehweb_yandexmap_city_id_field_input" type="text" name="idehweb_yandexmap_settings[idehweb_yandexmap_city_id_field]" class="regular-text" value="' . esc_attr($options['idehweb_yandexmap_city_id_field']) . '" />
		<p class="description">' . __('enter id of city field you need map fill that', $this->textdomain) . '</p>';

    }

    function yandexmap_override_checkout_fields($fields)
    {
        $fields['billing']['billing_yandex_location'] = array(
            'label' => __('Yandex Location', $this->textdomain),
            'placeholder' => _x('Yandex Location', 'placeholder', $this->textdomain),
            'required' => false,
            'class' => array('form-row-wide'),
            'clear' => true
        );

        return $fields;
    }

    function yandexmap_override_checkout_fields_admin($order)
    {
        $_billing_yandex_location =esc_html(get_post_meta($order->get_id(), '_billing_yandex_location', true));
        echo '<p><strong>' . esc_html(__('Yandex Location', $this->textdomain)) . ':</strong><div id="bgvvgcvfrcr"></div> <a target="_blank" href="'.esc_attr__("#").'" id="htgfrdfgvrfe">' . $_billing_yandex_location . '</a></p>';
    }

    function yandexmap_override_checkout_update_meta( $order_id ) {
        if ( ! empty( $_POST['billing_yandex_location'] ) ) {
            update_post_meta( $order_id, '_billing_yandex_location', sanitize_text_field( $_POST['billing_yandex_location'] ) );
        }
    }
}

global $idehwebYandexMap;
$idehwebYandexMap = new idehwebYandexMap();

/**
 * Template Tag
 */
function idehweb_yandexmap()
{

}



