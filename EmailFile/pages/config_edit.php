<?php
# MantisBT - A PHP based bugtracking system
# MantisBT is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 2 of the License, or
# (at your option) any later version.
#
# MantisBT is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.

#
#  EmailFile Plugin for Mantis BugTracker :
#  - Add attachments to bug with an email
#  © Hennes Hervé <contact@h-hennes.fr>
#    2015-2016
#  http://www.h-hennes.fr/blog/

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
