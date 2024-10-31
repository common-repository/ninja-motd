<?php
/*
Plugin Name: Ninja MOTD
version: 1.1.5
Plugin URI: http://code-ninja.co.uk/projects/ninja-tools/ninja-motd/
Description: Basic MOTD/Random Quote plugin,
Author: Code Ninja
Author URI: http://www.code-ninja.co.uk/
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//Variables
global $nm_db_version;
$nm_db_version = "1.0";
//Plugin Information.
$NinjaToolsPlugins['url'][]="http://code-ninja.co.uk/projects/ninja-tools/ninja-motd/";
$NinjaToolsPlugins['WPurl'][]="https://en-gb.wordpress.org/plugins/ninja-motd/";
$NinjaToolsPlugins['Name'][]="Ninja-MOTD";
$NinjaToolsPlugins['Description'][]="<b>Ninja MOTD</b> is a A Basic MOTD/Random Quote plugin.
<p>A very simple random quote plugin, for MOTD. TOTD, or just random Film/book/etc quotes on your site.</p>
<p>Add/Edit/Delete from your collection of messages, then display them in any post or page by use of a shortcode, A Widget, Or add a call to the function in your theme.</p>";

//Install
function NinjaMOTD_install() {
  global $wpdb;
  global $nm_db_version;
  $table_name = $wpdb->prefix . "ninjamotd";
  $sql = "CREATE TABLE $table_name (
          id mediumint(9) NOT NULL AUTO_INCREMENT,
          motd text NOT NULL,
          UNIQUE KEY id (id)
  );";
  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql);
}

function NinjaMOTD_install_data() {
  global $wpdb;
  global $nm_db_version;
  $nm_db_old_version = get_option("nm_db_version");
  if($nm_db_old_version != $nm_db_version){
    $nm_motd="I ate what?";
    $addMOTD = $wpdb->insert( $wpdb->prefix."ninjamotd",array('motd' => $nm_motd));
    update_option("nm_db_version", $nm_db_version);
  }
  add_option("nm_db_version", $nm_db_version);
}

//Tags & hooks
register_activation_hook(__FILE__,'NinjaMOTD_install');
register_activation_hook(__FILE__,'NinjaMOTD_install_data');
add_action('admin_menu', 'NinjaTools_Admin_Menu');
add_action('admin_menu', 'NinjaMOTD_menu');

//Menu
if (!function_exists('NinjaTools_Admin_Menu')) {
  function NinjaTools_Admin_Menu(){
    if(empty($GLOBALS['admin_page_hooks']['NinjaTools_admin_menu'])){
      add_menu_page('NinjaTools','NinjaTools','manage_options','NinjaTools_admin_menu','NinjaTools_InfoPage',plugins_url('/images/icon.png', __FILE__),40);
    }
  }
}

function NinjaMOTD_menu() {
  add_submenu_page( 'NinjaTools_admin_menu','Ninja-MOTD', 'Ninja-MOTD', 'manage_options', 'NinjaMOTD-notepage', 'NinjaMOTD_motd_callback');
}

//Page
if (!function_exists('NinjaTools_InfoPage')) {
  function NinjaTools_InfoPage(){
    global $NinjaToolsPlugins;
    include('ninja-tools-information.php');
  }
}

function NinjaMOTD_motd_callback() {
global $wpdb;
//Add
if(isset($_POST['update_motds_nonce']) 
 && wp_verify_nonce($_POST['update_motds_nonce'], 'update_motds') 
 && current_user_can('administrator')){
  $allowed   = array(
            'a' => array(
                'href' => true,
                'title' => true,
                'target' => true,
            ),
            'b' => array(),
            'code' => array(),
            'del' => array(
                'datetime' => true,
            ),
            'em' => array(),
            'i' => array(),
            'q' => array(
                'cite' => true,
            ),
            'strike' => array(),
            'strong' => array(),
  );
  if ( isset($_POST['Add'])) {
    $motd = stripslashes(wp_kses( $_POST['motd_0'], $allowed ));
    $addMOTD = $wpdb->insert( $wpdb->prefix."ninjamotd",array('motd' => $motd));
  }
  if ( isset($_POST['Delete'])) {
    $ids=array_keys($_POST['Delete']);
    $id=intval($ids[0]);
    $wpdb->query("delete from ".$wpdb->prefix."ninjamotd where `id`='".$id."'");
  }
  if ( isset($_POST['Edit'])) {
    $ids=array_keys($_POST['Edit']);
    $id=intval($ids[0]);
    $motd = stripslashes(wp_kses( $_POST['motd_'.$id], $allowed ));    
    $wpdb->update($wpdb->prefix."ninjamotd", array('motd' => $motd), array('id' => $id),array('%s'));
  }
}
?>
<div class="wrap">
  <div class="icon32" id="icon-options-general"><br /></div>
  <h2><img src="<?php echo plugins_url('/images/icon.png', __FILE__);?>" />&nbsp;Ninja MOTD</h2>
<hr/>
<p>
To use as a shortcode add [motd] to yout post or page.
To use as part of your theme add the following to the php in yout theme
<pre>
if (function_exists('NinjaMOTD_motd')) {
   NinjaMOTD_motd();
}
</pre>
</p>
<div id="motds" class="col-md-8">
<?php NinjaMOTD_show_motds(); ?>    
</div>
<?php
}

//Function
function NinjaMOTD_motd() {
  global $wpdb;
  $NumRows = $wpdb->get_var("SELECT COUNT(*) FROM `".$wpdb->prefix."ninjamotd`");
  if($NumRows >=1){
    $RandNum = rand(0, $NumRows-1);
    $randomMOTD = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ninjamotd order by `id`",ARRAY_A);
    return nl2br($randomMOTD[$RandNum]['motd']);
  }else{
    return " ";
  }
}

function NinjaMOTD_show_motds() {
  global $wpdb;
  $res = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ninjamotd order by `id`");
  echo("<form action='' method='post' id='motds'>");
  wp_nonce_field('update_motds', 'update_motds_nonce');
  echo("<table>");
  foreach($res as $row){
    echo("<tr><td><textarea rows=2 cols=40 name='motd_".$row->id."' id='motd_".$row->id."'>".esc_textarea($row->motd)."</textarea></td>");
    echo("<td><input type='submit' name='Edit[".$row->id."]' value='Update'> &nbsp;");
    echo("<input type='submit' name='Delete[".$row->id."]' value='Delete'></tr>");
  }
  echo("<tr><td><textarea rows=2 cols=40 name='motd_0' id='motd_0'></textarea></td>");
  echo("<td><input type='submit' name='Add' value='Add'></td></tr>");
  echo("</table>");
  echo("</form>");
  return;
}

//Shortcode
function NinjaMOTD_shortcode($atts) {
  $NinjaMOTDstr="<div id='motds'><p>".NinjaMOTD_motd()."</p></div>";
  return $NinjaMOTDstr;
}
add_shortcode('motd', 'NinjaMOTD_shortcode');

//Widget
class NinjaMOTD_Widget extends WP_Widget {
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'Ninja MOTD ',
			'description' => 'Random MOTD Quote',
		);
		parent::__construct( 'NinjaMOTD_widget', 'Ninja MOTD', $widget_ops );
	}

	public function widget( $args, $instance ) {
    extract( $args );
    $title = apply_filters('widget_title', $instance['title']);
    echo $before_widget;
    echo '<div class="widget-text wp_widget_plugin_box">';
    if ( $title ) {
      echo $before_title . $title . $after_title;
    }
    echo("<p class='wp_widget_plugin_textarea'>");
    echo(NinjaMOTD_motd());
  	echo("</p>");
    echo '</div>';
    echo $after_widget;
	}

	public function form( $instance ) {
    if( $instance) {
      $title = esc_attr($instance['title']);
    } else {
      $title = 'MOTD';
  }
?>
<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>
<?php
	}

	public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
	}
}
add_action('widgets_init',create_function('', 'return register_widget("NinjaMOTD_Widget");'));
?>
