<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       mehta.varun0125@gmail.com
 * @since      1.0.0
 *
 * @package    Primarycategory
 * @subpackage Primarycategory/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Primarycategory
 * @subpackage Primarycategory/admin
 * @author     Varun Mehta <mehta.varun0125@gmail.com>
 */
class Primarycategory_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the JavaScript for Gutenberg.
     *
     * @since    1.0.0
     */
    function enqueue_block_editor_assets()
    {
        wp_enqueue_script('block_editor_js', plugin_dir_url(__FILE__) . 'js/primarycategory-gutenberg.js', array('wp-plugins', 'wp-edit-post', 'wp-element'), $this->version, false);
    }

    /**
     * Check if is used  classic editor.
     *
     * @since    1.0.0
     */
    public function maybe_is_classic_editor(){
        if(!get_current_screen()->is_block_editor()){
            require_once plugin_dir_path( dirname( __FILE__ ) ) . '/admin/class-primarycategory-classic-eitor.php';
        }

    }


}
