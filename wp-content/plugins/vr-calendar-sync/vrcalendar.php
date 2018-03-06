<?php
/**
 * @package   VR Calendar
 * @author    Innate Images, LLC <info@innateimagesllc.com>
 * @license   GPL-2.0+
 * @link      http://www.vrcalendarsync.com
 * @copyright 2015 Innate Images, LLC
 *
 * @wordpress-plugin
 * Plugin Name:		  VR Calendar Free Dual
 * Plugin URI:        http://www.vrcalendarsync.com/
 * Description:       VR Calendar Free plugin
 * Version:           2.0.0
 * Author:            Innate Images, LLC
 * Author URI:
 * Text Domain:       vr-calendar-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /Languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

define("VRCALENDAR_PLUGIN_DIR",addslashes(dirname(__FILE__)));
$pinfo = pathinfo(VRCALENDAR_PLUGIN_DIR);
define("VRCALENDAR_PLUGIN_FILE",addslashes(__FILE__));
define("VRCALENDAR_PLUGIN_URL",plugins_url().'/'.$pinfo['basename'].'/');

define("VRCALENDAR_PLUGIN_NAME",'VR Calendar');
define("VRCALENDAR_PLUGIN_SLUG",'vr-calendar');
define("VRCALENDAR_PLUGIN_TEXT_DOMAIN",'vr-calendar-locale');

require_once( VRCALENDAR_PLUGIN_DIR . '/Includes/Init.php' );