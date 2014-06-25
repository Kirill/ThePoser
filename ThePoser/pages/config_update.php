<?php
form_security_validate( 'plugin_Example_config_update' );

$f_foo_or_bar = gpc_get_string( 'headerHeight' );
$f_reset = gpc_get_bool( 'reset', false );
$f_resetLogo = gpc_get_bool( 'reset_logo', false );

if($f_resetLogo) {
	//var_dump($f_resetLogo); exit;
	plugin_config_delete('companyLogo');
}
if ( $f_reset ) {
    plugin_config_delete( 'headerHeight' );
    plugin_config_delete('companyName');
    plugin_config_delete('companyUrl');
    plugin_config_delete('companyLogo');
} else {
    if ( in_array($f_foo_or_bar,array(0,1,2))) {
        plugin_config_set( 'headerHeight', $f_foo_or_bar );
    }
    plugin_config_set('companyName', strip_tags(gpc_get_string('companyName')));
    plugin_config_set('companyUrl', strip_tags(gpc_get_string('companyUrl')));
    
    $file = gpc_get_file('customLogo');
    if(!empty($file['tmp_name'])) {
//	    var_dump($file);
	$uploaded = $file['tmp_name'];
	$filecontent = 'data:'.$file['type'].';base64,'.base64_encode(file_get_contents($uploaded));
//	var_dump($filecontent); exit;
	plugin_config_set('companyLogo', $filecontent);
    }
}

form_security_purge( 'plugin_Example_config_update' );
print_successful_redirect( plugin_page( 'config', true ) );
