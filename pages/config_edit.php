<?php
// authenticate
auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );
// Read results
$f_hierarchy 	= gpc_get_bool( 'clone_hierarchy', ON );
$f_sub			= gpc_get_bool( 'clone_subprojects', ON );
$f_cat			= gpc_get_bool( 'clone_categories', ON );
$f_versions		= gpc_get_bool( 'clone_versions', OFF );
$f_custom		= gpc_get_bool( 'clone_customfields', ON );
$f_users		= gpc_get_bool( 'clone_users', ON );

// update results
plugin_config_set( 'clone_hierarchy', $f_hierarchy );
plugin_config_set( 'clone_subprojects' , $f_sub );
plugin_config_set( 'clone_categories', $f_cat );
plugin_config_set( 'clone_versions', $f_versions );
plugin_config_set( 'clone_customfields', $f_custom );
plugin_config_set( 'clone_users', $f_users );
// redirect
print_header_redirect( plugin_page( 'config',TRUE ) );