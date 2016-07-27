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

#Formulaire d'envoi des pièces jointes, appellé par la page get_emails.php en CURL

require_once( dirname(__FILE__) . '/../../../core.php' );
require_once( dirname(__FILE__) . '/../../../core/file_api.php' );

$f_bug_id = gpc_get_int('bug_id', -1);
$f_files = gpc_get_file('pic', -1);

if ($f_bug_id == -1 && $f_files == -1) {
# _POST/_FILES does not seem to get populated if you exceed size limit so check if bug_id is -1
    trigger_error(ERROR_FILE_TOO_BIG, ERROR);
}

#Envoi du fichier
file_add($f_bug_id, $f_files, 'bug', '', '', 1);

#Message de succès d'envoi
exit_status( plugin_lang_get('file_was_uploaded_successfuly') );

?>
