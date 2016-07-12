<?php
/**
 * @package CRM
 */

/**
 * Plugin Name: Basic CRM
 * Description: Simple CROD system.
 * Version: 1.0
 * Author: Pavel Koch
 * Text Domain: basiccrm
 */

// Make sure we don't expose any info if called directly
defined('ABSPATH') or die('No script kiddies please!'); 

// Defining some useful constants
define('CRM_VERSION', '1.0');
define('CRM_PLUGIN_DIR', plugin_dir_path(__FILE__));

require_once('BasicCRM-core.php');
require_once('BasicCRM-meta-boxes.php');
