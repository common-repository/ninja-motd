<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
?>
<link rel='stylesheet' id='ninja-tools-main-style-css' href='<?php echo plugins_url('ninja-tools.css', __FILE__);?>' type='text/css' media='all'/>

<div class="wrap">
  <div class="icon32" id="icon-options-general"><br /></div>
  <h2><img src="<?php echo plugins_url('/images/icon.png', __FILE__);?>" />&nbsp;Ninja Tools</h2>

	<div class="metabox-holder has-right-sidebar">
<div class="inner-sidebar">
	
	<div class="NinjaToolsInfoBox">
		<h3><span>Developed by <a href='http://code-ninja.co.uk' target="_blank" style='text-decoration:none;'>Code-Ninja</a></span></h3>
		<div class="inside">
      <p><i>Why use a CodeMonkey, When you can use a CodeNinja</i></p>
      <a class="sm_button sm_pluginHome" href="http://code-ninja.co.uk/projects/ninja-tools/">Toolbox Homepage</a>
      <a class="sm_button sm_pluginHome" href="http://code-ninja.co.uk/projects/ninja-tools/suggest/">Suggest a Tool</a>
      <hr />
<?php
for($c=0;$c<count($NinjaToolsPlugins['Name']);$c++){
echo("<a class='sm_button sm_pluginHome' href='".$NinjaToolsPlugins['url'][$c]."'>".$NinjaToolsPlugins['Name'][$c]." HomePage</a>");
echo("<a class='sm_button sm_wordpress' href='".$NinjaToolsPlugins['WPurl'][$c]."'>".$NinjaToolsPlugins['Name'][$c]." Wordpress Page</a>");
}
?>
		</div>
	</div>
	
	<div class="NinjaToolsInfoBox">
		<h3><span>Donate</span></h3>
		<div class="inside">
      <p><b>If you like using any of the NinjaTools plugin's, please consider making a donation – particularly if you are using it for a commercial application.</b><br/><br />Your donations allow me to spend more time developing, maintaining and supporting these plugin's and adding more to the Toolbox. Any amount is appreciated. </p>
      <div style="text-align: center;">
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
          <p>Many thanks.</p>
          <input type="hidden" name="cmd" value="_s-xclick">
          <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
          <input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal <97> The safer, easier way to pay online.">
          <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
        </form>
      </div>
		</div>
	</div>
</div> <!-- .inner-sidebar -->

<div id="post-body">
	<div id="post-body-content">
		
		<div class="postbox">
			<h3><span>toolbox</span></h3>
			<div class="inside">
      <i>noun</i>
      <ol>
        <li>a box or case in which tools are kept.</li>
      </ol>
			</div>
		</div>
		
    <p>Ninja Tools are a collection of Plugin's or "Tools" that either work together or as standalone tools. </p>
    <p>For ease of use I have collected these tools into a Toolbox, or in this case a NinjaTools Menu item.  </p>
 
    <H2>Installed Tools</h2>
    <p>A List of Ninja Tools Installed on this Wordpress</p><br/>

<?php
for($c=0;$c<count($NinjaToolsPlugins['Name']);$c++){
echo("<div class='postbox'>");
echo("<h3><span>".$NinjaToolsPlugins['Name'][$c]."</span></h3>");
echo("<div class='inside'>");
  echo($NinjaToolsPlugins['Description'][$c]);
echo("</div>");
echo("</div>");
}
?>

	
	</div> <!-- #post-body-content -->
</div> <!-- #post-body -->
		<!-- ... main content ... -->
  </div> <!-- .metabox-holder -->
</div> <!-- .wrap -->

