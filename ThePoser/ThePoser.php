<?php

class ThePoserPlugin extends MantisPlugin {
    function register() {
        $this->name = 'The Poser';    # Proper name of plugin
        $this->description = 'So you can explain to your boss why Mantis is better. (Look matters after all)';    # Short description of the plugin
        $this->page = 'config';           # Default plugin page

        $this->version = '1.0';     # Plugin version string
        $this->requires = array(    # Plugin dependencies, array of basename => version pairs
            'MantisCore' => '1.2.0',  #   Should always depend on an appropriate version of MantisBT
            );

        $this->author = 'Agave Storm Inc.';         # Author/team name
        $this->contact = 'agavestorm@gmail.com';        # Author/team e-mail address
        $this->url = 'http://agavestorm.com/the-poser-for-mantis/';            # Support webpage
    }
    
    function hooks() {
//        throw new Exception();
        return array(
            'EVENT_LAYOUT_RESOURCES' => 'initlook',
	    'EVENT_MENU_MAIN_FRONT' => 'beforeMenu',
	    'EVENT_LAYOUT_BODY_BEGIN' => 'bodyBegin',
	    'EVENT_LAYOUT_PAGE_HEADER' => 'afterMaintisLogo',
	    'EVENT_PLUGIN_INIT' => 'setupHeaders',
        );
    }
    
    function setupHeaders($p_event) {
	    global $g_bypass_headers;
	    if ( !$g_bypass_headers && !headers_sent() ) {
			http_content_headers();
			http_caching_headers();
			header( 'X-Frame-Options: DENY' );
		$t_avatar_img_allow = '';
		if ( config_get_global( 'show_avatar' ) ) {
			if ( http_is_protocol_https() ) {
				$t_avatar_img_allow = "; img-src 'self' https://secure.gravatar.com:443";
			} else {
				$t_avatar_img_allow = "; img-src 'self' http://www.gravatar.com:80";
			}
		}
		header( "X-Content-Security-Policy: allow 'self'; img-src *; options inline-script eval-script$t_avatar_img_allow; frame-ancestors 'none'" );
			http_custom_headers();
		}
	    $g_bypass_headers = true;
    }
    
    function bodyBegin($p_event) {
	if(plugin_config_get('headerHeight') != '2') {
	?>
	<div class="poserHeader">
		<a href="<?php echo plugin_config_get('companyUrl');?>" title="<?php echo plugin_config_get('companyName'); ?>" target="_blank">
			<?php 
			$imgdata = plugin_config_get('companyLogo');
			if(!empty($imgdata)) {
				?><img src="<?php echo $imgdata;?>" alt="<?php echo plugin_config_get('companyName'); ?>"/><?php
			} else {
				echo plugin_config_get('companyName'); 
			}
			?>
		</a>
	</div>
	<?php } ?>
	<div class="mantisLogo">
	<?php
    }
    
    function afterMaintisLogo($p_event) {
	    ?></div><?php
    }
    
    function beforeMenu($p_event) {
	    if(plugin_config_get('headerHeight') != '2') {
		    return;
	    }
	    $favicon = helper_mantis_url(config_get( 'favicon_image' ));
	    $companyName = plugin_config_get('companyName');
	    ?>
	    <span  class="tinyheader">
		<a href="<?php echo helper_mantis_url('my_view_page.php'); ?>">
			<img src="<?php echo $favicon; ?>"/>
			<?php
			if(!empty($companyName)) {
				?>
			<span>: <?php echo $companyName; ?></span>
				<?php
			}
			?></a>
		
	    </span>
	<?php
    }
    
    function initlook($p_event) {
	    $header = plugin_config_get('headerHeight');
        ?>
        <link rel="stylesheet" type="text/css" href="<?php echo plugin_file( 'main.css' ); ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo plugin_file( 'header-'.$header.'.css' ); ?>"/>
        <?php
    }
    
    function config() {
        return array(
            'customLogo' => '',
	    'headerHeight' => 0,// default=0, small=1, tiny=2
	    'companyName' => 'setup you company name and logo',
	    'companyUrl' => plugin_page('config'),
	    'companyLogo' => '',
        );
    }
}
