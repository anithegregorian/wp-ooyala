<?php
/*
Plugin Name: Ooyala For Wordpress
Plugin URI: http://www.ravendevelopers.com/blog/2012/11/ooyala-wordpress-plugin
Description: Plugin for embedding Ooyala videos in your blog
Author: Anirudh K. Mahant, inquiry@ravendevelopers.com
Version: 1.1
Author URI: http://www.ravendevelopers.com
*/

//-- Constants
if (!defined('OOYALA_FOR_WP_PLUGIN_DIR'))
	define ('OOYALA_FOR_WP_PLUGIN_DIR', '/ooyala-for-wp');

if (!defined('OOYALA_FOR_WP_PLUGIN_LANG_DIR'))
	define ('OOYALA_FOR_WP_PLUGIN_LANG_DIR', WP_PLUGIN_DIR . OOYALA_FOR_WP_PLUGIN_DIR . '/languages');

if (!defined('OOYALA_FOR_WP_SETTINGS_DIR'))
	define ('OOYALA_FOR_WP_SETTINGS_DIR', '/admin');

if (!defined('OOYALA_FOR_WP_SETTINGS_PAGE'))
	define ('OOYALA_FOR_WP_SETTINGS_PAGE', WP_PLUGIN_DIR . OOYALA_FOR_WP_PLUGIN_DIR . OOYALA_FOR_WP_SETTINGS_DIR . '/ooyala_settings.php');

if (!defined('OOYALA_FOR_WP_MCE_PLUGIN_DIR'))
	define ('OOYALA_FOR_WP_MCE_PLUGIN_DIR', '/mce');

if (!defined('OOYALA_FOR_WP_PLAYER_JS'))
	define ('OOYALA_FOR_WP_PLAYER_JS', 'http://player.ooyala.com/player.js?');

//-- Ooyala video shortcode handler
add_shortcode('ooyala_video_embed', 'ooyala_video_embed_shortcode_handler');

function ooyala_video_embed_shortcode_handler($atts, $content = null){

	extract( shortcode_atts( array(
		'ec' => 's2ZjV0NTrH2qT7OOAL6NuiwnXHxVIzJP'
	), $atts ) );

  //-- Get options for video defaults
  $options = unserialize(get_option('ooyala_for_wp_settings'));

  if (isset($options)):
    extract($options);
    $save_def_height = (isset($ooyala_def_height)) ? $ooyala_def_height : '400';
    $save_def_width = (isset($ooyala_def_width)) ? $ooyala_def_width : '640';
    $save_center_video = (isset($ooyala_center_video)) ? $ooyala_center_video : 0;
  endif;

  $args = array(
		'playerId' => 'player',
		'embedCode' => $atts['ec'],
    'height' => $save_def_height,
    'width' => $save_def_width,
		'verison' => '2',
  );

  $query = http_build_query($args, '', '&amp;');

  if ($save_center_video):
    $output = '<div class="ooyala_for_wp_video" style="height:'.$save_def_height.'px; width:'.$save_def_width.'px; margin: 0 auto; text-align: center; overflow: hidden;">';
    $output .= '<script type="text/javascript" src="' . OOYALA_FOR_WP_PLAYER_JS . $query . '"></script>';
    $output .= '</div>';
  else:
    $output = '<script type="text/javascript" src="' . OOYALA_FOR_WP_PLAYER_JS . $query . '"></script>';
  endif;

  return $output . $content;
}

load_plugin_textdomain('ooyala_for_wp', false, OOYALA_FOR_WP_PLUGIN_LANG_DIR);

add_action('admin_menu', 'wp_ooyala_settings');

function wp_ooyala_settings() {
    add_options_page("Ooyala Video", "Ooyala Video", 1, "ooyala_for_wp", "wp_ooyala_admin_screen");
}

function wp_ooyala_admin_screen() {
	include_once(OOYALA_FOR_WP_SETTINGS_PAGE);
}

class RD_Ooyala_For_WP {

	function RD_Ooyala_For_WP(){
		if(is_admin()){
			if ( current_user_can('edit_posts') && current_user_can('edit_pages') && get_user_option('rich_editing') == 'true'){
				add_filter('tiny_mce_version', array(&$this, 'tiny_mce_version') );
				add_filter("mce_external_plugins", array(&$this, "mce_external_plugins"));
				add_filter('mce_buttons_2', array(&$this, 'mce_buttons'));
			}
		}
	}
	function mce_buttons($buttons) {
		array_push($buttons, "separator", "OoyalaForWP" );
		return $buttons;
	}
	function mce_external_plugins($plugin_array) {
		$plugin_array['ooyalaforwp']  =  plugins_url('/ooyala-for-wp/mce/ooyala_mce.js');
		return $plugin_array;
	}
	function tiny_mce_version($version) {
		return ++$version;
	}
}
add_action('init', 'RD_Ooyala_For_WP');

function RD_Ooyala_For_WP(){
	global $RD_Ooyala_For_WP;
	$RD_Ooyala_For_WP = new RD_Ooyala_For_WP();
}
