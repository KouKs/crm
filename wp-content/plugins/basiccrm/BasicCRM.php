<?php
/**
 * @package BasicCRM
 */

/**
 * Plugin Name: Basic CRM
 * Description: Simple CROD system.
 * Version: 1.0
 * Author: Pavel Koch
 * Text Domain: basiccrm
 */

// Direct call restriction
defined('ABSPATH') or die('No script kiddies please!'); 

// Defining some useful constants
define('CRM_VERSION', '1.0');
define('CRM_PLUGIN_DIR', plugin_dir_path(__FILE__));

// Calling the class
require_once('class.basiccrm.php');

// Instantiating
new BasicCRM;