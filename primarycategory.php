<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              mehta.varun0125@gmail.com
 * @since             1.0.0
 * @package           Primarycategory
 *
 * @wordpress-plugin
 * Plugin Name:       Primary Category
 * Plugin URI:        PrimaryCategory
 * Description:       Offers the possibility to select the primary category for posts.
 * Version:           1.0.0
 * Author:            Varun Mehta
 * Author URI:        mehta.varun0125@gmail.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       primarycategory
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PRIMARYCATEGORY_VERSION', '1.1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-primarycategory-activator.php
 */
function activate_primarycategory() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-primarycategory-activator.php';
	Primarycategory_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-primarycategory-deactivator.php
 */
function deactivate_primarycategory() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-primarycategory-deactivator.php';
	Primarycategory_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_primarycategory' );
register_deactivation_hook( __FILE__, 'deactivate_primarycategory' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-primarycategory.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_primarycategory() {

	$plugin = new Primarycategory();
	$plugin->run();

}
run_primarycategory();







