<?php
/**
 * Ooyala Admin settings page.
 *
 * Silver moon stands when the morning is rising
 * Chasing the wind to the crystal horizon
 * Hard to believe when the signs are uncertain
 * Courage be born, that our world will stop hurting
 *
 * @package WordPress
 * @author Anirudh K. Mahant
 * @link http://www.ravendevelopers.com
 * @subpackage Ooyala for WP
 * @since Ooyala for WP 1.0
 * @copyright Copyright 2006-2012, Raven Developers (http://www.ravendevelopers.com)
 */
?>
<div class="wrap">
  <?php screen_icon( 'options-general' ); ?>
  <?php if (isset( $_REQUEST['action'] ) && 'save' == $_REQUEST['action'] ) echo '<div id="message" class="updated fade"><p><strong>'.__('Ooyala for WP settings saved successfully!').'</strong></p></div>'; ?>
  <?php echo "<h2>" . __( 'Ooyala for WP Settings', 'ooyala-for-wp' ) . "</h2>"; ?>

  <?php
    if (isset( $_REQUEST['action'] ) && 'save' == $_REQUEST['action'] ):
      check_admin_referer(get_bloginfo('name'));
      extract($_POST);
      $save_def_height = ( empty( $default_ooyala_video_height ) ? "400" : $default_ooyala_video_height );
      $save_def_width = ( empty( $default_ooyala_video_width ) ? "640" : $default_ooyala_video_width );
      $save_center_video = ( isset( $ooyala_center_video ) ? 1 : 0 );

      $option_arry = array(
        'ooyala_def_width' => $save_def_width,
        'ooyala_def_height' => $save_def_height,
        'ooyala_center_video' => $save_center_video,
      );
  
      update_option('ooyala_for_wp_settings', serialize($option_arry));

    else:

      $options = unserialize(get_option('ooyala_for_wp_settings'));

      if (isset($options)):
        extract($options);
        $save_def_height = (isset($ooyala_def_height)) ? $ooyala_def_height : '400';
        $save_def_width = (isset($ooyala_def_width)) ? $ooyala_def_width : '640';
        $save_center_video = (isset($ooyala_center_video)) ? $ooyala_center_video : 0;
      endif;

    endif;
  ?>
  <form style="display:inline;" method="post" name="hicolor" id="hicolor" action="<?php echo esc_attr($_SERVER['REQUEST_URI']); ?>">
    <table class="form-table">
      <tr valign="top">
        <th scope="row"><label for="default_ooyala_video_height"><?php echo __('Default Video Height:','ooyala-for-wp'); ?></label></th>
        <td>
          <input type="text" id="default_ooyala_video_height" name="default_ooyala_video_height" class="regular-text" value="<?php echo $save_def_height; ?>" />
        </td>
      </tr>
      <tr valign="top">
        <th scope="row"><label for="default_ooyala_video_width"><?php echo __('Default Video Width:','ooyala-for-wp'); ?></label></th>
        <td>
          <input type="text" id="default_ooyala_video_width" name="default_ooyala_video_width" class="regular-text" value="<?php echo $save_def_width; ?>" />
        </td>
      </tr>
      <tr valign="top" align="left">
        <th scope="row"><label><?php echo __('Center align video ?','ooyala-for-wp'); ?></label></th>
        <td>
          <label><input id="ooyala_center_video" name="ooyala_center_video" class="regular-checkbox" type="checkbox" <?php checked( $save_center_video, true ); ?> /> Yes / No</label>
        </td>
      </tr>
    </table>
    <input type="hidden" name="action" value="save" />
    <?php wp_nonce_field(get_bloginfo('name')); ?>
    <p class="submit"><input type="submit" name="submitform" class="button-primary" value="<?php echo esc_html(__('Save Options')); ?>" onclick="cp.hidePopup('prettyplease')" /></p>
  </form>
<?php echo '<h4 style="color: #7F7F7F">' . __( "Developed by: Anirudh K. Mahant (<a href='http://www.ravendevelopers.com' target='_blank'>Raven Developers</a>)", "ooyala-for-wp" ) . '</h4>'; ?>
</div>