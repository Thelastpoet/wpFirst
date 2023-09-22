<?php
/**
 * Plugin Name: wpFirst
 * Plugin URI: https://tunedai.com/wpFirst
 * Description: Automate common setup tasks for new WordPress installations.
 * Version: 1.0
 * Author: Ammanulah
 * Author URI: https://www.yourwebsite.com
*/

// activate wpFirst
register_activation_hook(__FILE__, 'wp_first_activation');

function wp_first_activation() {
    // Delete Default Post and page
    wp_delete_post(1, TRUE); // Delete 'Hello World!' post
    wp_delete_post(2, TRUE); // Delete 'Sample Page' page
    wp_delete_comment(1);   // Delete default comment
    
    // Setup Permalinks to 'Post name'
    update_option('permalink_structure', '/%postname%/');
    
    // Flush rewrite rules to apply the changes
    global $wp_rewrite;
    $wp_rewrite->flush_rules(true);
    
    // Remove Unnecessary Dashboard Widgets
    remove_action('welcome_panel', 'wp_welcome_panel');
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); // Quick Draft widget
    remove_meta_box('dashboard_primary', 'dashboard', 'side');    // WordPress Events and News
    
    // Delete default plugins - Hello Dolly and Akismet
    require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    delete_plugins(array('hello.php', 'akismet/akismet.php'));
}

// Let's remove widgets without waiting plugin activation
add_action('wp_dashboard_setup', 'remove_dashboard_meta');
function remove_dashboard_meta() {
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');       
    remove_meta_box('dashboard_primary', 'dashboard', 'side');        
    remove_meta_box('dashboard_secondary', 'dashboard', 'normal'); 
}