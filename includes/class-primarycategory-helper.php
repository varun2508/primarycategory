<?php

/**
 * The helper class.
 *
 *
 * @since      1.0.0
 * @package    Primarycategory
 * @subpackage Primarycategory/includes
 * @author     Varun Mehta <mehta.varun0125@gmail.com>
 */
class PrimaryCategoryHelper
{

    /**
     * Define the function for this plugin for internationalization.
     *
     *
     * @since    1.0.0
     * @access   private
     */
    public static function get_primary_term_id($post_id = null)
    {
        if (!$post_id) {
            global $post;
            $post_id = $post->ID;
        }

        return get_post_meta($post_id, 'primary_category', true) ?? false;

    }

}
