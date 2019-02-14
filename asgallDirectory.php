<?php
/*
 ***********************************************************/
/**
 * @name          : Apptha Slider Gallery.
 * @version	  : 1.0
 * @package       : apptha
 * @subpackage    : 
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license	      : GNU General Public License version 2 or later; see LICENSE.txt
 * @abstract      : The core file of calling Mac Photo Gallery.
 * @Creation Date : June 20 2011
 * @Modified Date : September 30 2011
 * */

/*
 ***********************************************************/

/*The Common load file for the plugin */
if ( !defined('WP_LOAD_PATH') )
{
    /** classic root path if wp-content and plugins is below wp-config.php */
    $classic_root = dirname(dirname(dirname(dirname(__FILE__)))) . '/' ;

    if (file_exists( $classic_root . 'wp-load.php') )
    define( 'WP_LOAD_PATH', $classic_root);
    else
    if (file_exists( $path . 'wp-load.php') )
    define( 'WP_LOAD_PATH', $path);
    else
    exit("Could not find wp-load.php");
}

// let's load WordPress
require_once( WP_LOAD_PATH . 'wp-load.php');
global $wpdb;
?>