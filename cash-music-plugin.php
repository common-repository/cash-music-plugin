<?PHP
/*
Plugin Name: Cash Music Plugin
Plugin URI: http://www.BlogsEye.com/
Description: Integrates Cash Music with WordPress
Version: 1.0
Author: Keith P. Graham
Author URI: http://www.BlogsEye.com/

This software is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/


/************************************************************
* 	kpg_cash_music_fixup()
*	Shows the javascript in the footer so that the links can be adjusted
*
*************************************************************/
function kpg_cash_music_fixup() {
	echo "\r\n\r\n<!-- installing Cash Music framework\r\n\r\nAny Errors will appear here -->\r\n\r\n";
	$options=array();
	$options=get_option('kpg_cash_music_options');
	if (empty($options)||(!is_array($options))) $options=array();
	if (!array_key_exists('cashMusicPath',$options)) {
		echo "\r\n\r\n<!-- the music path option has not been set -->\r\n\r\n";
	} else {
		$cashMusicPath=$options['cashMusicPath'];
		if (!file_exists($cashMusicPath)) {
			echo "\r\n\r\n<!-- the path to cashmusic.php was not found: $cashMusicPath -->\r\n\r\n";
		} else {
			require($cashMusicPath);
		}
	}
	if (array_key_exists('cashMusicCSS',$options)) {
		$cashMusicCSS=$options['cashMusicCSS'];
		if (!empty($cashMusicCSS)) {
			echo "<style type=\"text/css\">\r\n$cashMusicCSS\r\n</style>";
		}
	}
	echo "\r\n\r\n<!-- Done installing Cash Music framework -->\r\n\r\n";
}
function kpg_cash_music_sc($atts, $content=null) {
	// call the guy
extract( shortcode_atts( array('title' => 'title','id' => '100'), $atts ) );
//extract( shortcode_atts( array('title' => 'title',), $atts ) );
	//$id=strip_tags($id);
	if (empty($id)) return '??<!-- no content found - id empty -->';
	// need to get $ansa using the simple include hack
	ob_start();
		CASHSystem::embedElement($id);
		$ansa = ob_get_contents();
	ob_end_clean();
	return "<!-- Loading shortcode $id -->\r\n$ansa;<!-- Loading shortcode -->";

}
function kpg_cash_music_control()  {

// check for update:
	if(!current_user_can('manage_options')) {
		die('Access Denied');
	}
	$options=array();
	$options=get_option('kpg_cash_music_options');
	if (empty($options)||(!is_array($options))) $options=array();
	if (array_key_exists('kpg_cash_music_nonce',$_POST)&&wp_verify_nonce($_POST['kpg_cash_music_nonce'],'kpgcashmusicnonce')) { 
		// here we update the input field
		if (array_key_exists('cashMusicPath',$_POST)) {
			$cashMusicPath=$_POST['cashMusicPath'];
			// check to see if it exists
			if (file_exists($cashMusicPath)) {
				$options['cashMusicPath']=$cashMusicPath;
				update_option('kpg_cash_music_options',$options);
				echo "<h3>Options updated</h3>";		
			} else {
				echo "<h3 style='color:red;'>path to cashmusic.php not found - not updated</h3>";		
			}
		}
		if (array_key_exists('cashMusicCSS',$_POST)) {
			$cashMusicCSS=$_POST['cashMusicCSS'];
			$options['cashMusicCSS']=$cashMusicCSS;
			update_option('kpg_cash_music_options',$options);
		}
	}	else {
		// no update
	}
	$nonce=wp_create_nonce('kpgcashmusicnonce');
    $cashMusicPath='';
	$cashMusicCSS=".cashmusic_social {position:relative;margin:10px 15px 20px 15px;padding:15px;background-color:#fff;border-top-left-radius:5px 5px;border-top-right-radius:5px 5px;border-bottom-right-radius:5px 5px;border-bottom-left-radius:5px 5px;}
.cashmusic_social a {color:#cdcdcd;font-weight:normal;}
.cashmusic_twitter {font:14.5px/1.75em georgia,'times new roman',times,serif;}
.cashmusic_twitter_avatar {float:left;margin:1px 8px 8px 0;}
.cashmusic_twitter_namespc {color:#ccc;font:11px/1.5em helvetica,\"helvetica neue\",arial,sans-serif;}
.cashmusic_twitter_namespc a {color:#007e3d;font:bold 15px/1.85em helvetica,\"helvetica neue\",arial,sans-serif;}
.cashmusic_twitter a {color:#007e3d;}
.cashmusic_tumblr h2, .cashmusic_tumblr h2 a, #topmenu * a, h2 {color:#111;font:28px/1em 'IM Fell English',georgia,'times new roman',times,serif;}
.cashmusic_social_date {margin-top:10px;color:#cdcdcd;font:11px/1.75em helvetica,\"helvetica neue\",arial,sans-serif;}
.cashmusic_social_date a {color:#ccc;}
.cashmusic_clearall {clear:both;height:1px;overflow:hidden;visibility:hidden;}
.clearall {height:1px;overflow:hidden;visibility:hidden;clear:both;}
.cash_tourdates_event {margin-bottom:18px;}
.cash_tourdates_date {font-weight:bold;}
.cash_tourdates_comments {display:block;color:#999;}
";
	extract($options);
	$cashMusicCSS=stripslashes($cashMusicCSS);
?>

<div class="wrap">
<h2>Cash Music Plugin</h2>
<h4>The Cash Music Plugin is installed and working correctly.</h4><div style="position:relative;float:right;width:35%;background-color:ivory;border:#333333 medium groove;padding:4px;margin-left:4px;">
    <p>This plugin is free and I expect nothing in return. If you would like to support my programming, you can buy my book of short stories.</p>
    <p>Some plugin authors ask for a donation. I ask you to spend a very small amount for something that you will enjoy. eBook versions for the Kindle and other book readers start at 99&cent;. The book is much better than you might think, and it has some very good science fiction writers saying some very nice things. <br/>
      <a target="_blank" href="http://www.blogseye.com/buy-the-book/">Error Message Eyes: A Programmer's Guide to the Digital Soul</a></p>
    <p>A link on your blog to one of my personal sites would also be appreciated.</p>
    <p><a target="_blank" href="http://www.WestNyackHoney.com">West Nyack Honey</a> (I keep bees and sell the honey)<br />
      <a target="_blank" href="http://www.cthreepo.com/blog">Wandering Blog</a> (My personal Blog) <br />
      <a target="_blank" href="http://www.cthreepo.com">Resources for Science Fiction</a> (Writing Science Fiction) <br />
      <a target="_blank" href="http://www.jt30.com">The JT30 Page</a> (Amplified Blues Harmonica) <br />
      <a target="_blank" href="http://www.harpamps.com">Harp Amps</a> (Vacuum Tube Amplifiers for Blues) <br />
      <a target="_blank" href="http://www.blogseye.com">Blog&apos;s Eye</a> (PHP coding) <br />
      <a target="_blank" href="http://www.cthreepo.com/bees">Bee Progress Beekeeping Blog</a> (My adventures as a new beekeeper) </p>
  </div>

<p>This is allows the use of the Cash Music System with Wordpress. The first thing to do is install the Cash Music System available at: 
<a href="http://www.cashmusic.org" target="_blank">www.cashmusic.org</a>.
</p> 
<p>Cash Music is supposed to be compatable with WordPress, but requires you to change the code. WordPress Short Codes will make this as easy as typing in a short code on a page.</p>
<p>In order for the plugin to work it needs the directory where Cash Music (cashmusic.php) is installed. You can find that by going to your Cash Music Administration page and clicking on <em>Help/Getting Started</em>. It shows the include link that looks like something like this:<br/>
&lt;?php include('<strong>/homepages/14/d89238444/htdocs/cashmusic/framework/cashmusic.php</strong>'); // CASH Music ?  &gt;<br/>
the path that you are interested in is inside the single quotes. In this case it would be:<br/>
 <strong>/homepages/14/d89238444/htdocs/cashmusic/framework/cashmusic.php</strong></p>
 <p>Copy the full path from the staring slash to the .php and put it in the box below and press "Save Changes".
<form method="post" action="">
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="kpg_cash_music_nonce" value="<?php echo $nonce;?>" />
<fieldset style="border:thin black solid;padding:2px;"><legend>cashmusic.php path</legend>    
<input size="72" name="cashMusicPath" type="text" value="<?php echo $cashMusicPath; ?>"/>
	</fieldset>
<p>The Cash Music elements don't look good unless styled. Below is the demo styling from the Cash Music installation. You can alter this to fit your site, or you can delete it and add styling to your WordPress installation directly. (You might want to take out the &quot;clear&quot; styles if they break your theme.) </p>	
<fieldset style="border:thin black solid;padding:2px;"><legend>Basic CSS</legend>    
<textarea name="cashMusicCSS" cols="80" rows="10"><?php echo $cashMusicCSS; ?></textarea>
	</fieldset>
	
	
	<p class="submit"><input class="button-primary" value="Save Changes" type="submit"></p>
</form>
</p>
<h4>How to use the Short Code</h4>
<p>
Once you have set the include path for the CashMusic framework, you can then put Cash Music Elements on a Page. Use the shortcode:<br/> 
<strong>[cashmusic id=xyz]</strong><br/>
Replace xyz with the element id. You find this by going to Elements in the Cash Music Administration page and clicking <em>Elements/Your Elements</em> and then clicking on details on the element that you want.</p>
There will be an embed code, but you are looking for the embed element. Look for the code:<br/> embedElement(102)<br/>
the element id is 102. You could add this element to any WordPress page by editing the page and using the shortcode:<br /> 
<strong>[cashmusic id=102]</strong>
<hr/>
<h4>Trouble Shooting</h4>
<p>1) Verify that the Cash Music system is installed and working. </p>
<p> 2) View the web page source. The plugin puts in comments in the header when it loads the plugin. It does this on every page. You should see html comments showing the progress of loading Cash Music. If the plugin settings have not been saved or the plugin can't find the path to cashmusic.php, there should be a comment explaining this. </p>
<p>
3) The shortcode also generates html comments so there might be some clues there.
</p>
<p>
4) Cash Music also generates some messages. If a message from Cash Music appears where you placed your shortcode, check the Cash Music docs.
</p>
<hr/>
<p>I am hoping to add more features to the plugin, including style sheets for the Cash Music elements. They don't look very nice unstyled. Perhaps this plugin would be a good place to add the cash music styles. <br/>
You feedback will be seriously considered. I hope that you, as a user, have some good ideas.<br/>
Thanks,
<br />
Keith P. Graham</p>
</div>

<?php
}
// no unistall because I have not created any meta data to delete.
function kpg_cash_music_init() {
   add_options_page('Cash Music', 'Cash Music', 'manage_options','cash-music','kpg_cash_music_control');
}
  // Plugin added to Wordpress plugin architecture
	add_action('admin_menu', 'kpg_cash_music_init');	
	add_action( 'wp_head', 'kpg_cash_music_fixup' );
  // add shortcode
  add_shortcode('cashmusic', 'kpg_cash_music_sc');

 	
?>