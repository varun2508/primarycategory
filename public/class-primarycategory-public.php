<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       mehta.varun0125@gmail.com
 * @since      1.0.0
 *
 * @package    Primarycategory
 * @subpackage Primarycategory/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Primarycategory
 * @subpackage Primarycategory/public
 * @author     Varun Mehta <mehta.varun0125@gmail.com>
 */
class Primarycategory_Public
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
     * @param string $plugin_name The name of the plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the Rest Api Route for gutenberg request.
     *
     * @since    1.0.0
     */
    public function register_rest_route()
    {
        register_rest_route('primarycategory/v1', '/terms/(?P<ids>\S+)', [
            'method' => WP_REST_Server::ALLMETHODS,
            'callback' => array($this, 'get_terms_route_callback')
        ]);
    }


    /**
     *  Rest Api Route callback.
     *
     * @since    1.0.0
     */
    public function get_terms_route_callback($request)
    {
        $terms_ids = explode(",", $request->get_param('ids'));

        $terms = get_terms(array(
            'taxonomy' => 'category',
            'include' => $terms_ids,
            'hide_empty' => false,
            'orderby' => 'include',
        ));

        $data = array_map(
            function ($term) {
                return ['value' => $term->term_id, 'name' => $term->name];
            },
            $terms);

        return rest_ensure_response($data);

    }


    /**
     *  Rest Api Route callback.
     *
     * @since    1.0.0
     */
    public function register_category_post_meta()
    {
        register_post_meta(
            '',
            'primary_category',
            [
                'single' => true,
                'show_in_rest' => true,
                'type' => 'integer',
                'sanitize_callback' => 'sanitize_register_meta_callback',

            ]
        );

    }


}
