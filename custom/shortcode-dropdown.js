/**
 * Plugin Name: ShortCode DropDown
 * Description: ShortCode DropDown is an invaluable tool which enables authors to select the site's shortcodes from a dropdown box in WordPress's richtext editor.
 * Version: 0.0
 * Author: WPShowCase
 * Author URI: http://www.wpshowcase.net
 *
 * ShortCode DropDown is an invaluable tool that allows shortcodes to be selected from a dropdown menu
 * which means that authors can see the shortcodes that are available and that do not need to
 * memorize the names of shortcodes.
 *
 * @package ShortCodeDropDown
 * @version 0.0.0
 * @author WPShowCase <info@wpshowcase.net>
 * @copyright Copyright (c) 2013, WPShowCase
 * @license See license.txt
 */
(function() {
	tinymce.create('tinymce.plugins.ShortCodeDropDown', {
		
		init : function(ed, url) {
			var t = this;
			t.editor = ed;
		},
			
		//Creates the dropdown
		createControl : function(n, cm) {
            if(n=='shortcodedropdown'){
                var mlb = cm.createListBox('shortcode_dropdown', {
                     title : '[...]',
                     onselect : function(v) {
						if(tinyMCE.activeEditor.selection.getContent() == ''){//If nothing selected, just add the shortcode
                            tinyMCE.activeEditor.selection.setContent( '['+v+']' )
                        }
						else {//If text is selected, add the shortcode around the text
							tinyMCE.activeEditor.execCommand('mceReplaceContent', false, '['+v+']{$selection}[/'+v+']');
						}
						return false;
                     }
                });
	
				//Add the options to the dropdown
				for(var cnt=0; cnt<shortcode_options_for_dropdown.length; cnt++)
                	mlb.add('['+shortcode_options_for_dropdown[cnt]+']',shortcode_options_for_dropdown[cnt]);
 
                return mlb;
            }
            return null;
        }

	});

	tinymce.PluginManager.add('shortcodedropdown', tinymce.plugins.ShortCodeDropDown);
		
})();