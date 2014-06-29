<?php
form_security_validate( 'plugin_Example_config_update' );

$f_header = gpc_get_string( 'headerHeight' );
$f_skin = gpc_get_string( 'skin' );
$f_reset = gpc_get_bool( 'reset', false );
$f_resetLogo = gpc_get_bool( 'reset_logo', false );
$f_resetTinyLogo = gpc_get_bool( 'reset_tiny_logo', false );

if($f_resetLogo) {
	plugin_config_delete('companyLogo');
}
if($f_resetTinyLogo) {
	plugin_config_delete('companyTinyLogo');
}
if ( $f_reset ) {
    plugin_config_delete( 'headerHeight' );
    plugin_config_delete( 'skin' );
    plugin_config_delete('companyName');
    plugin_config_delete('companyUrl');
    plugin_config_delete('companyLogo');
    plugin_config_delete('companyTinyLogo');
} else {
    if ( in_array($f_header,array(0,1,2))) {
        plugin_config_set( 'headerHeight', $f_header );
    }
    if ( in_array($f_skin,array(0,1,2))) {
        plugin_config_set( 'skin', $f_skin );
    }
    plugin_config_set('companyName', strip_tags(gpc_get_string('companyName')));
    plugin_config_set('companyUrl', strip_tags(gpc_get_string('companyUrl')));
    
//    $file = ;
    try {
    plugin_config_set('companyLogo',
	    ThePoserPlugin::getImageForSaving(gpc_get_file('customLogo'), 
		    array(null, 80)
		    )
	    );
    } catch(Exception $e) {}
    try {
	plugin_config_set('companyTinyLogo', 
		ThePoserPlugin::getImageForSaving(gpc_get_file('customTinyLogo'),
		    array(16, 16)
		    ));
    } catch(Exception $e) {}
   // exit;
//    if(!empty($file['tmp_name'])) {
////	    var_dump($file);
//	$uploaded = $file['tmp_name'];
//	$filecontent = 'data:'.$file['type'].';base64,'.base64_encode(file_get_contents($uploaded));
////	var_dump($filecontent); exit;
//	plugin_config_set('companyLogo', $filecontent);
//    }
//    
//    $file = gpc_get_file('customTinyLogo');
//    if(!empty($file['tmp_name'])) {
////	    var_dump($file);
//	$uploaded = $file['tmp_name'];
//	$filecontent = 'data:'.$file['type'].';base64,'.base64_encode(file_get_contents($uploaded));
////	var_dump($filecontent); exit;
//	plugin_config_set('companyTinyLogo', $filecontent);
//    }
}

form_security_purge( 'plugin_Example_config_update' );
print_successful_redirect( plugin_page( 'config', true ) );
