<?php
/*
  Plugin EmailFile pour Mantis BugTracker :

  - Rajouts de pièces jointes à un bug via email

  Version 0.1.0
  © Hennes Hervé - 2014
  http://www.h-hennes.fr
 */

#Page de mise à jour de la configuration du module

auth_reauthenticate( );
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

$f_email_host = gpc_get_string('email_host');
$f_email_address = gpc_get_string('email_address');
$f_email_password = gpc_get_string('email_password');
$f_email_fetch_mode = gpc_get_string('email_fetch_mode');


if( plugin_config_get( 'email_host' ) != $f_email_host ) {
	plugin_config_set( 'email_host', $f_email_host );
}
if( plugin_config_get( 'email_address' ) != $f_email_address ) {
	plugin_config_set( 'email_address', $f_email_address );
}
if( plugin_config_get( 'email_password' ) != $f_email_password ) {
	plugin_config_set( 'email_password', $f_email_password );
}
if( plugin_config_get( 'email_fetch_mode' ) != $f_email_fetch_mode ) {
	plugin_config_set( 'email_fetch_mode', $f_email_fetch_mode );
}

print_successful_redirect( plugin_page( 'config', true ) );

?>
