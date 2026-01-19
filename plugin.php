<?php
/**
 * Plugin Name: Bishal Plugin
 * Description: A plugin to display a welcome message on the dashboard.
 * Version: 1.0.0
 * Author: Bishal
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


// Enqueue styles for the settings page and Google Fonts
function bishal_admin_styles($hook_suffix)
{
    // Enqueue Google Font based on setting
    $font_family = get_option('bishal_font_family', 'inherit');

    // Map font choices to Google Fonts URLs
    $google_fonts = array(
        'Roboto, sans-serif' => 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap',
        'Open Sans, sans-serif' => 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap',
        'Lato, sans-serif' => 'https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap',
        'Montserrat, sans-serif' => 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap',
        'Poppins, sans-serif' => 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap',
        'Roboto Slab, serif' => 'https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&display=swap',
        'Merriweather, serif' => 'https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap',
        'Nunito, sans-serif' => 'https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap',
        'Playfair Display, serif' => 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap',
        'Rubik, sans-serif' => 'https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap',
        'Ubuntu, sans-serif' => 'https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&display=swap',
        'Kanit, sans-serif' => 'https://fonts.googleapis.com/css2?family=Kanit:wght@400;700&display=swap',
        'Oswald, sans-serif' => 'https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&display=swap',
        'Raleway, sans-serif' => 'https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap',
        'Quicksand, sans-serif' => 'https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap',
    );

    if (array_key_exists($font_family, $google_fonts)) {
        wp_enqueue_style('bishal-google-font', $google_fonts[$font_family], array(), null);
    }

    if ('settings_page_bishal-settings' === $hook_suffix) {
        wp_enqueue_style('bishal-admin-css', plugin_dir_url(__FILE__) . 'admin-style.css', array(), '1.0.0');
    }
}
add_action('admin_enqueue_scripts', 'bishal_admin_styles');

// Register the settings menu
function bishal_add_admin_menu()
{
    add_options_page(
        'Bishal Settings',
        'Bishal Settings',
        'manage_options',
        'bishal-settings',
        'bishal_settings_page'
    );
}
add_action('admin_menu', 'bishal_add_admin_menu');

// Register settings
function bishal_settings_init()
{
    register_setting('bishalPlugin', 'bishal_message');
    register_setting('bishalPlugin', 'bishal_font_family');
    register_setting('bishalPlugin', 'bishal_font_size');
    register_setting('bishalPlugin', 'bishal_font_color');

    add_settings_section(
        'bishal_plugin_section',
        __('Dashboard Message settings', 'bishal'),
        'bishal_settings_section_callback',
        'bishalPlugin'
    );

    add_settings_field(
        'bishal_message',
        __('Welcome Message', 'bishal'),
        'bishal_message_render',
        'bishalPlugin',
        'bishal_plugin_section'
    );

    add_settings_field(
        'bishal_font_family',
        __('Font Family', 'bishal'),
        'bishal_font_family_render',
        'bishalPlugin',
        'bishal_plugin_section'
    );

    add_settings_field(
        'bishal_font_size',
        __('Font Size (px)', 'bishal'),
        'bishal_font_size_render',
        'bishalPlugin',
        'bishal_plugin_section'
    );

    add_settings_field(
        'bishal_font_color',
        __('Text Color', 'bishal'),
        'bishal_font_color_render',
        'bishalPlugin',
        'bishal_plugin_section'
    );
}
add_action('admin_init', 'bishal_settings_init');

// Renderers
function bishal_message_render()
{
    $value = get_option('bishal_message', 'welcome to bishals plugin');
    ?>
    <input type='text' name='bishal_message' value='<?php echo esc_attr($value); ?>'>
    <p class="description">Enter the text to display on the dashboard.</p>
    <?php
}

function bishal_font_family_render()
{
    $options = get_option('bishal_font_family', 'inherit');
    ?>
    <select name='bishal_font_family'>
        <optgroup label="System Fonts">
            <option value='inherit' <?php selected($options, 'inherit'); ?>>Default</option>
            <option value='Arial, sans-serif' <?php selected($options, 'Arial, sans-serif'); ?>>Arial</option>
            <option value='Times New Roman, serif' <?php selected($options, 'Times New Roman, serif'); ?>>Times New Roman
            </option>
            <option value='Courier New, monospace' <?php selected($options, 'Courier New, monospace'); ?>>Courier New
            </option>
            <option value='Georgia, serif' <?php selected($options, 'Georgia, serif'); ?>>Georgia</option>
            <option value='Verdana, sans-serif' <?php selected($options, 'Verdana, sans-serif'); ?>>Verdana</option>
            <option value='Impact, sans-serif' <?php selected($options, 'Impact, sans-serif'); ?>>Impact</option>
        </optgroup>
        <optgroup label="Google Fonts">
            <option value='Roboto, sans-serif' <?php selected($options, 'Roboto, sans-serif'); ?>>Roboto</option>
            <option value='Open Sans, sans-serif' <?php selected($options, 'Open Sans, sans-serif'); ?>>Open Sans</option>
            <option value='Lato, sans-serif' <?php selected($options, 'Lato, sans-serif'); ?>>Lato</option>
            <option value='Montserrat, sans-serif' <?php selected($options, 'Montserrat, sans-serif'); ?>>Montserrat
            </option>
            <option value='Poppins, sans-serif' <?php selected($options, 'Poppins, sans-serif'); ?>>Poppins</option>
            <option value='Roboto Slab, serif' <?php selected($options, 'Roboto Slab, serif'); ?>>Roboto Slab</option>
            <option value='Merriweather, serif' <?php selected($options, 'Merriweather, serif'); ?>>Merriweather</option>
            <option value='Nunito, sans-serif' <?php selected($options, 'Nunito, sans-serif'); ?>>Nunito</option>
            <option value='Playfair Display, serif' <?php selected($options, 'Playfair Display, serif'); ?>>Playfair
                Display
            </option>
            <option value='Rubik, sans-serif' <?php selected($options, 'Rubik, sans-serif'); ?>>Rubik</option>
            <option value='Ubuntu, sans-serif' <?php selected($options, 'Ubuntu, sans-serif'); ?>>Ubuntu</option>
            <option value='Kanit, sans-serif' <?php selected($options, 'Kanit, sans-serif'); ?>>Kanit</option>
            <option value='Oswald, sans-serif' <?php selected($options, 'Oswald, sans-serif'); ?>>Oswald</option>
            <option value='Raleway, sans-serif' <?php selected($options, 'Raleway, sans-serif'); ?>>Raleway</option>
            <option value='Quicksand, sans-serif' <?php selected($options, 'Quicksand, sans-serif'); ?>>Quicksand</option>
        </optgroup>
    </select>
    <?php
}

function bishal_font_size_render()
{
    $value = get_option('bishal_font_size', '');
    ?>
    <input type='number' name='bishal_font_size' value='<?php echo esc_attr($value); ?>' placeholder="e.g. 20">
    <p class="description">Leave empty for default size.</p>
    <?php
}

function bishal_font_color_render()
{
    $value = get_option('bishal_font_color', '#000000');
    ?>
    <input type='color' name='bishal_font_color' value='<?php echo esc_attr($value); ?>'>
    <?php
}

function bishal_settings_section_callback()
{
    echo __('how to make money online', 'bishal');
}

function bishal_settings_page()
{
    ?>
    <div class="bishal-settings-wrap">
        <h1>Bishal Plugin Settings</h1>
        <form action='options.php' method='post'>
            <?php
            settings_fields('bishalPlugin');
            do_settings_sections('bishalPlugin');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function bishal_welcome_message()
{
    $message = get_option('bishal_message', 'welcome to bishals plugin');
    $font_family = get_option('bishal_font_family', 'inherit');
    $font_size = get_option('bishal_font_size', '');
    $font_color = get_option('bishal_font_color', '#000000');

    $style = "color: " . esc_attr($font_color) . ";";
    $style .= "font-family: " . esc_attr($font_family) . ";";
    if (!empty($font_size)) {
        $style .= "font-size: " . esc_attr($font_size) . "px;";
    }
    ?>
    <div class="notice notice-success is-dismissible">
        <p style="<?php echo $style; ?>">
            <?php echo esc_html($message); ?>
        </p>
    </div>
    <?php
}
add_action('admin_notices', 'bishal_welcome_message');

ghjhgkjhkjgkjhgkjhkj