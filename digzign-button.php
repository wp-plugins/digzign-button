<?php
/*
Plugin Name: Digzign Button
Version: 1.0
Plugin URI: http://digzign.com/tools/buttons
Description: This plugin adds the Digzign's button to your WordPress posts and/or pages.
Author: Sergio Dinis Lopes
Author URI: http://sergiolopes.name/
*/

$message = "";

if (!function_exists('dzn_request_handler')) {
    function dzn_request_handler() {
        global $message;

        if ($_POST['dzn_action'] == "update options") {
            
			$dzn_align_v = $_POST['dzn_align_sl'];

			// Post Button Align
    		if(get_option("dzn_box_align")) {
    			update_option("dzn_box_align", $dzn_align_v);
    		} else {
    			add_option("dzn_box_align", $dzn_align_v);
    		}
			
			// Post Button Where?
            $dzn_where_v = $_POST['dzn_where_sl'];
			if(!empty($dzn_where_v)){$dzn_where_v = implode(',',$dzn_where_v);}
			else {$dzn_where_v = 'home,posts';}
    		
			if(get_option("dzn_box_where")) {
    			update_option("dzn_box_where", $dzn_where_v);
    		} else {
    			add_option("dzn_box_where", $dzn_where_v);
    		}
			
			// Post Button Background Color
            $dzn_bgcolor_v = $_POST['dzn_bgcolor_sl'];
    		
			if(get_option("dzn_box_bgcolor")) {
    			update_option("dzn_box_bgcolor", $dzn_bgcolor_v);
    		} else {
    			add_option("dzn_box_bgcolor", $dzn_bgcolor_v);
    		}
			
			// Post Button Window
            $dzn_window_v = $_POST['dzn_window_sl'];
    		
			if(get_option("dzn_box_window")) {
    			update_option("dzn_box_window", $dzn_window_v);
    		} else {
    			add_option("dzn_box_window", $dzn_window_v);
    		}
			
			// Post Button Skin
            $dzn_skin_v = $_POST['dzn_skin_sl'];
    		
			if(get_option("dzn_box_skin")) {
    			update_option("dzn_box_skin", $dzn_skin_v);
    		} else {
    			add_option("dzn_box_skin", $dzn_skin_v);
    		}


            $message = '<br clear="all" /> <div id="message" class="updated fade"><p><strong>Options Updated!</strong></p></div>';
        }
    }
}

if(!function_exists('dzn_add_menu')) {
    function dzn_add_menu () {
        add_options_page("Digzign Button", "Digzign Button", 8, basename(__FILE__), "dzn_displayOptions");
		
    }
}

if (!function_exists('dzn_displayOptions')) {
    function dzn_displayOptions() {
	
        global $message;
        echo $message;
		
		echo('<div class="wrap">');
		echo('<h2>Digzign Button</h2>');
        echo('<form name="dzn_form" action="'. get_bloginfo("wpurl") . '/wp-admin/options-general.php?page=digzign-button.php' .'" method="post">');
?>
        <p>Digzign Button allows for your readers to submit your content to <a target="_blank" href="http://digzign.com">Digzign</a></p>
        <table width="50%" border="0" class="form-table">
          <tr style="padding:10px;border-bottom:1px solid #d9d9d9;">
            <td width="300" align="left"><strong>Position where the button will appear:</strong></td>
            <td align="left">
        		<select name="dzn_align_sl" id="dzn_align_sl">
                    <option value="top_left"<?php if (get_option("dzn_box_align") == "top_left" || get_option("dzn_box_align") == "") echo(' selected="selected"'); ?> >Top Left (default)</option>
                    <option value="top_right"<?php if (get_option("dzn_box_align") == "top_right") echo(' selected="selected"'); ?> >Top Right</option>
                    <option value="bottom_left"<?php if (get_option("dzn_box_align") == "bottom_left") echo(' selected="selected"'); ?> >Bottom Left</option>
                    <option value="bottom_right"<?php if (get_option("dzn_box_align") == "bottom_right") echo(' selected="selected"'); ?> >Bottom Right</option>
                </select>
            </td>
          </tr>
          <tr style="padding:10px;border-bottom:1px solid #d9d9d9;">
            <td width="160"><strong>Background Color (CSS hexadecimal format)</strong></td>
            <td><input type="text" name="dzn_bgcolor_sl" id="dzn_bgcolor_sl" value="<?php if (!get_option("dzn_box_bgcolor")) { echo "none";} else {echo get_option("dzn_box_bgcolor");} ?>" /></td>
          </tr>
          <tr style="padding:10px;border-bottom:1px solid #d9d9d9;">
            <td><h3><strong>Type</strong></h3>
                <p>Type of button that you prefer:</p>
        
                <h3>standard</h3>
                <input type="radio" name="dzn_skin_sl" id="standard_button" value="standard"<?php if (get_option('dzn_box_skin') == '' || get_option('dzn_box_skin') == 'standard') echo(' checked="checked"'); ?>/>
                <label for="standard_button" style="background:url(http://digzign.com/design/images/standard_button.png) no-repeat center bottom;padding:21px 25px;">&nbsp;</label>
                <br/><br/>
                <h3>compact</h3>
                <input type="radio" name="dzn_skin_sl" id="compact_button" value="compact"<?php if (get_option('dzn_box_skin') == 'compact') echo(' checked="checked"'); ?> />
                <label for="compact_button" style="background:url(http://digzign.com/design/images/compact_button.png) no-repeat center top;padding:3px 36px;">&nbsp;</label>
	    	</td>
          </tr>
          <tr style="padding:10px;border-bottom:1px solid #d9d9d9;">
            <td><strong>Open link on...</strong></td>
            <td>
                <select name="dzn_window_sl" id="dzn_window_sl">
                    <option value="same"<?php if (get_option("dzn_box_window") == "same") echo(' selected="selected"'); ?> >Same Window</option>
                    <option value="new"<?php if (get_option("dzn_box_window") == "new") echo(' selected="selected"'); ?> >New Window</option>
                </select>
            </td>
          </tr>
          <tr style="padding:10px;border-bottom:1px solid #d9d9d9;">
            <td><strong>Button should appear on...</strong></td>
            <td>
            	<?php $dzn_box_where = get_option("dzn_box_where"); if(empty($dzn_box_where))$dzn_box_where = 'home,posts'; $dzn_box_where = explode(',',$dzn_box_where); ?>
                
                <input type="checkbox" name="dzn_where_sl[]" id="home" value="home"<?php if (in_array('home',$dzn_box_where)) echo(' checked="checked"'); ?> />
                <label for="home">Home</label>
                
                <input type="checkbox" name="dzn_where_sl[]" id="posts" value="posts"<?php if (in_array('posts',$dzn_box_where)) echo(' checked="checked"'); ?> />
                <label for="posts">Individual Posts</label>
            
                <input type="checkbox" name="dzn_where_sl[]" id="pages" value="pages"<?php if (in_array('pages',$dzn_box_where)) echo(' checked="checked"'); ?> />
                <label for="pages">Pages</label>
                
            </td>
          </tr>
        </table>

       <p>For more information about Digzign Button, please visit click <a target="_blank" href="http://digzign.com/tools/button">here</a>.</p>
<?php
		print ('<p class="submit"><input type="submit" value="Update Options" /></p>');
		print ('<input type="hidden" name="dzn_action" value="update options" />');
		print('</form></div>');

    }
}


if (!function_exists('dzn_dcpvragehtml')) {
	function dzn_dcpvragehtml($float) {
		global $wp_query;
		$post = $wp_query->post;
		$permalink = get_permalink($post->ID);
        $title = urlencode($post->post_title);
		$pvrskin = get_option("dzn_box_skin");
		$pvrbgcolor = get_option("dzn_box_bgcolor");
		$pvrwindow = get_option("dzn_box_window");
		$dcpvragehtml = <<<CODE

    <span style="padding:5px; margin:0; float:$float;">
		<script type="text/javascript">
			dzn_url = "$permalink";
			dzn_skin = "$pvrskin";
			dzn_title = "$title";
			dzn_window = "$pvrwindow";
			dzn_bgcolor = "$pvrbgcolor";
		</script>
		<script type="text/javascript" src="http://digzign.com/button/button.js"></script>
    </span>
CODE;
	return  $dcpvragehtml;
	}
}


if (!function_exists('dzn_addbutton')) {
	function dzn_addbutton($content) {
    
		$dzn_box_where = get_option("dzn_box_where");
        if(empty($dzn_box_where))$dzn_box_where = 'home,posts';
		$dzn_box_where = explode(',', $dzn_box_where);
        
        if(is_home() && !in_array('home',$dzn_box_where)) return $content;
        if(is_single() && !in_array('posts',$dzn_box_where)) return $content;
        if(is_page() && !in_array('pages',$dzn_box_where)) return $content;
        
		if ( !is_feed() && !is_archive() && !is_search() && !is_404() ) {
    		if(! preg_match('|<!--sphinnit-->|', $content)) {
    		    $dzn_align = get_option("dzn_box_align");
    		    if ($dzn_align) {
                    switch ($dzn_align) {
                        case "top_left":
        		              return dzn_dcpvragehtml("left").$content;
                              break;
                        case "top_right":
        		              return dzn_dcpvragehtml("right").$content;
                              break;
                        case "bottom_left":
        		              return $content.dzn_dcpvragehtml("left");
                              break;
                        case "bottom_right":
        		              return $content.dzn_dcpvragehtml("right");
                              break;
                        default:
        		              return dzn_dcpvragehtml("left").$content;
                              break;
                    }
                } else {
        		      return dzn_dcpvragehtml("left").$content;
                }

    		} else {
                  return str_replace('<!--dcpvrage-->', dzn_dcpvragehtml(""), $content);
            }
        } else {
			return $content;
        }
	}
}

add_filter('the_content', 'dzn_addbutton', 999);
add_action('admin_menu', 'dzn_add_menu');
add_action('init', 'dzn_request_handler');

?>