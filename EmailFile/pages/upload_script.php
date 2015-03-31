<?php
/*
  Plugin EmailFile pour Mantis BugTracker :

  - Rajouts de pièces jointes à un bug via email
 
  => Formulaire d'envoi des pièces jointes, appellé par la page get_emails.php en CURL

  Version 0.1.0
  © Hennes Hervé - 2014
  http://www.h-hennes.fr
 */
require_once( dirname(__FILE__) . '/../../../core.php' );
require_once( dirname(__FILE__) . '/../../../core/file_api.php' );
ini_set('display_errors','on');
//
$f_bug_id = gpc_get_int('bug_id', -1);
$f_files = gpc_get_file('pic', -1);

if ($f_bug_id == -1 && $f_files == -1) {
# _POST/_FILES does not seem to get populated if you exceed size limit so check if bug_id is -1
    trigger_error(ERROR_FILE_TOO_BIG, ERROR);
}

#Envoi du fichier
file_add($f_bug_id, $f_files, 'bug', '', '', 1);

#Message de succès d'envoi
exit_status('File was uploaded successfuly!');

?>
