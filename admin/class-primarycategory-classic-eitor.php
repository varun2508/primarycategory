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
class Primarycategory_Admin_Classic_Editor
{


    /**
     * Constructor.
     * Register hooks and filters, etc.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'primary_category_box'));
        add_action('save_post', array($this, 'save_post'), 10, 2);
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'), 10, 2);


    }


    /**
     * Register the JavaScript for the clasic editor.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        wp_enqueue_script('classic-editor', plugin_dir_url(__FILE__) . 'js/primarycategory-classic-editor.js', array('jquery'), 1.1, false);

    }

    /**
     * @param $post_id
     * @param $post
     */
    public function save_post($post_id, $post)
    {

        if (isset($post->post_status) && 'auto-draft' == $post->post_status) {
            return;
        }

        // Autosave, do nothing
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        // AJAX? Not used here
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }

        // Return if it's a post revision
        if (false !== wp_is_post_revision($post_id)) {
            return;
        }

        update_post_meta($post_id, 'primary_category', $_POST['primary_category']);

    }

    /**
     *
     */
    public function primary_category_box()
    {

        add_meta_box(
            'message_categories_custom_box',
            __( 'Primary category', 'primarycategory' ),
            array($this, 'primary_category_metabox'),
            'post'
        );


    }

    /**
     * @param $post
     */
    public function primary_category_metabox($post)
    {

        $categories = get_the_terms($post->ID, 'category');
        $selected_value = get_post_meta($post->ID, 'primary_category', true);
        $this->html_select('primary_category', $categories, $selected_value);

    }


    /**
     * @param $name
     * @param $options
     * @param $selected_value
     */
    public function html_select($name, $options, $selected_value)
    {
        print '<select name="' . $name . '"  id="primary_category_select" >';
        print '<option value>'. __( 'Select', 'primarycategory' ).'</option>';
        foreach ($options as $option) {
            printf(
                '<option value= "%d" %s >%s</option>',
                $option->term_id,
                ($selected_value == $option->term_id) ? 'selected' : '',
                $option->name
            );
        }
        print '</select>';
    }


}


new Primarycategory_Admin_Classic_Editor();