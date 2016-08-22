/**
 * Ooyala for WP TinyMCE plugin.
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
(function() {

  function getParameterByName(paramName, queryString) {
    var results = new RegExp('[\\?&]' + paramName + '=([^&#]*)').exec(queryString);
    if (!results) {
      return 0;
    }
    return results[1] || 0;
  }

  tinymce.PluginManager.requireLangPack('ooyalaforwp');

  tinymce.create('tinymce.plugins.OoyalaForWP', {

    init : function(ed, url) {

      ed.addCommand('mceOoyalaVideo', function() {
        
        var videoEmbedCode = prompt("Paste embed code of Ooyala Video below:", "");

        if (videoEmbedCode != null){
					// Gets source of url
					var escapedVideoEmbedCode = jQuery(videoEmbedCode).attr('src');
					// Replace # query string with ?
					//var escapedVideoEmbedCode = escapedVideoEmbedCode.replace('#', '?');
          //var owp_pbid = getParameterByName("pbid", escapedVideoEmbedCode);
          var owp_ec = getParameterByName("ec", escapedVideoEmbedCode);
          //tinyMCE.activeEditor.selection.setContent('[ooyala_video_embed]pbid=' + owp_pbid + '&amp;ec=' + owp_ec + '[/ooyala_video_embed]');
					tinyMCE.activeEditor.selection.setContent('[ooyala_video_embed ec=' + owp_ec + '][/ooyala_video_embed]');

        }
      });
      ed.addButton('OoyalaForWP', {
        title: 'Embed Ooyala Video',
        image: url + '/ooyala.png',
        cmd: 'mceOoyalaVideo'
      });
      ed.addShortcut('alt+ctrl+shift+o', ed.getLang('ooyalaforwp.php'), 'mceOoyalaVideo');
    },
    createControl : function(n, cm) {
      return null;
    },
    getInfo : function() {
      return {
        longname: 'Ooyala For Wordpress Buttons',
        author: '@anithegregorian',
        authorurl: 'http://www.ravendevelopers.com',
        infourl: 'http://www.ravendevelopers.com',
        version: "1.0"
      };
    }
  });
  tinymce.PluginManager.add('ooyalaforwp', tinymce.plugins.OoyalaForWP);
})();