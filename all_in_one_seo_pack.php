<?php
/*
Plugin Name: All In One SEO Pack
Plugin URI: http://semperfiwebdesign.com
Description: Out-of-the-box SEO for your WordPress blog. Features like XML Sitemaps, SEO for custom post types, SEO for blogs or business sites, SEO for ecommerce sites, and much more. Almost 30 million downloads since 2007.
Version: 2.3.3.2
Author: Michael Torbert
Author URI: http://michaeltorbert.com
Text Domain: all-in-one-seo-pack
Domain Path: /i18n/
*/

/*
Copyright (C) 2007-2016 Michael Torbert, semperfiwebdesign.com (michael AT semperfiwebdesign DOT com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * @package All-in-One-SEO-Pack
 * @version 2.3.3.2
 */

if ( ! defined( 'ABSPATH' ) ) return;

/**
 * @TODO: This might need more error handling for things like PHP safe_mode.
 */
if ( @file_exists( plugin_dir_path( __FILE__ ) . '/pro' ) && @is_dir( plugin_dir_path( __FILE__ ) . '/pro' ) ) {
	if ( ! defined( 'AIOSEOPPRO' ) ) {
		define( 'AIOSEOPPRO', true );
	} else {
		// Another copy of the plugin has already loaded.
		add_action( 'admin_init', 'disable_all_in_one_free', 1 );
		return;
	}
} else {
	if ( ! defined( 'AIOSEOPPRO' ) ) {
		define( 'AIOSEOPPRO', false );
	} else {
		// Another copy of the plugin has already loaded.
		return;
	}
}

if ( ! defined( 'AIOSEOP_PLUGIN_FILE' ) ) define( 'AIOSEOP_PLUGIN_FILE', __FILE__ );

if ( ! defined( 'AIOSEOP_PLUGIN_DIR' ) ) {
    define( 'AIOSEOP_PLUGIN_DIR', plugin_dir_path( AIOSEOP_PLUGIN_FILE ) );
} elseif ( AIOSEOP_PLUGIN_DIR != plugin_dir_path( __FILE__ ) ) {
	// Some other copy of the plugin has already loaded...
	return;
}

// Multiple active copies of the plugin should be resolved at this point.
if ( ! defined( 'AIOSEOP_VERSION' ) ) define( 'AIOSEOP_VERSION', '2.3.3.2' );

global $aioseop_plugin_name;
$aioseop_plugin_name = 'All in One SEO Pack';

if ( ! function_exists( 'disable_all_in_one_free' ) ) {
	/**
	 * Disable the free version of AIOSEOP if Free and Pro are both active
	 */
	function disable_all_in_one_free(){
		if ( AIOSEOPPRO && is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) ) {
			deactivate_plugins( 'all-in-one-seo-pack/all_in_one_seo_pack.php' );
		}
	}
}

/**
 * Main initialization code.
 */
require_once( AIOSEOP_PLUGIN_DIR . '/aioseop_init.php' );

if ( AIOSEOPPRO ) {
	/**
	 * Pro-specific initialization code.
	 */
	require_once( AIOSEOP_PLUGIN_DIR . '/pro/aioseop_pro_init.php' );
}

// eof
