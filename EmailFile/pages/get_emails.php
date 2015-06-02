<?php

/*
  Plugin EmailFile pour Mantis BugTracker :

  - Rajouts de pièces jointes à un bug via email

  © Hennes Hervé - 2015
  http://www.h-hennes.fr
 */

require_once( dirname(__FILE__) . '/../../../core.php' );
require_once( dirname(__FILE__).'/../EmailFile.php');

#Attention pour que les données du plugin soient bien trouvée il faut appeller le module via l'url : plugin.php?page=EmailFile/get_emails.php
$t_email_user = plugin_config_get('email_address');
$t_email_pass = plugin_config_get('email_password');
$t_email_host = plugin_config_get('email_host');

#Affichage des informations de récupération des emails
echo plugin_lang_get('get_email_account') . $t_email_user. plugin_lang_get('get_email_host'). $t_email_host."<br />";

#Connexion à la boite email
$t_inbox = imap_open("{" . $t_email_host . "/pop3/novalidate-cert}INBOX", $t_email_user, $t_email_pass);
#Recupération des emails
$t_emails = imap_search($t_inbox, 'ALL');

if ($t_emails) {

    #Emails les + récents en 1er
    rsort($t_emails);

    foreach ($t_emails as $t_email_number) {

        #Recupération des informations de l'email
        $structure = imap_fetchstructure($t_inbox, $t_email_number);
        $header = imap_headerinfo ($t_inbox,$t_email_number);

        echo plugin_lang_get('get_email_treat_message'). $t_email_number . '<br />';
        
        #Récupération de l'identifiant du bug auquel il doit etre rattachée
        $t_email_subject = trim(str_replace('?iso-8859-1?Q?','',$header->subject));
        preg_match('/([0-9]{1,})/',$t_email_subject,$matches);
        $bug_id = $matches[1];
            
        if ( !$bug_id && $bug_id == '') {
            echo plugin_lang_get('get_email_error_bug_id_not_defined').'<br />';
            continue;
        }
        
        echo plugin_lang_get('get_email_attachment_add_to_bug').' '.$bug_id.'<br />';

        $attachments = array();

        if (isset($structure->parts) && count($structure->parts)) {

            $j = 100; #Identifiant pour les captures d'écran   
            for ($i = 0; $i < count($structure->parts); $i++) {


                #Fonctionnement standard : Pièces jointes   
                $attachments[$i] = array(
                    'is_attachment' => false,
                    'filename' => '',
                    'name' => '',
                    'attachment' => '');

                if ($structure->parts[$i]->ifdparameters) {
                    foreach ($structure->parts[$i]->dparameters as $object) {
                        if (strtolower($object->attribute) == 'filename') {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['filename'] = $object->value;
                        }
                    }
                }

                if ($structure->parts[$i]->ifparameters) {
                    foreach ($structure->parts[$i]->parameters as $object) {
                        if (strtolower($object->attribute) == 'name') {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['name'] = $object->value;
                        }
                    }
                }

                if ($attachments[$i]['is_attachment']) {
                    $attachments[$i]['attachment'] = imap_fetchbody($t_inbox, $t_email_number, $i + 1);
                    if ($structure->parts[$i]->encoding == 3) { // 3 = BASE64
                        $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                    } elseif ($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
                        $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                    }
                }

                #Fonctionnement captures d'écran @ToDO : Refactoriser
                #Pas encore Totalement Opérationnel ( à optimiser )
                if (count($structure->parts[$i]->parts)) {

                    $k = 2;
                    foreach ($structure->parts[$i]->parts as $part) {

                        $attachments[$j] = array(
                            'is_attachment' => false,
                            'filename' => '',
                            'name' => '',
                            'attachment' => '');
                        
                        
                        if ( $part->subtype == 'JPEG') {
                            echo 'Gestion capture écran <br />';
                            foreach ($part->dparameters as $object) {
                                if (strtolower($object->attribute) == 'filename') {
                                    $attachments[$j]['is_attachment'] = true;
                                    $attachments[$j]['filename'] = $object->value;
                                    $attachments[$j]['name'] = $object->value;
                                    $attachments[$j]['attachment'] = base64_decode(imap_fetchbody($t_inbox, $t_email_number, ($i + 1).'.'.$k));
                                    $k++;
                                    $j++;
                                }
                    }
                        }
                    }
                }
            } # for($i = 0; $i < count($structure->parts); $i++)
        } # if(isset($structure->parts) && count($structure->parts))

        if (count($attachments) != 0) {

            foreach ($attachments as $at) {

                if ($at['is_attachment'] == 1) {

                    #On dépose le fichier dans un dossier temporaire
                    $fileName = dirname(__FILE__) . '/tmpFiles/' .date('Ymd').'_email_'. $at['filename'];
                    file_put_contents($fileName, $at['attachment']);

                    $curl_posts = array(
                        'bug_id' => $bug_id,
                        'pic' => '@' . $fileName
                    );

                    #Une fois le fichier exécuté on va exécuter une requête curl pour procéder à l'envoi du fichier
                    $t_curl_url = $g_path . 'plugins/EmailFile/pages/upload_script.php';
                    echo plugin_lang_get('get_email_send_file').' '.$at['filename'].'<br />';
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $t_curl_url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_posts);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    echo $result;
                }
            }
        }
        
        #Supression des emails à la fin du traitement
        imap_delete($t_inbox, $t_email_number);
    }
}
else {
    echo plugin_lang_get('get_email_no_email ').'<br />';
}

#Suppression des messages
imap_expunge ( $t_inbox );

#Fermeture de la connexion
imap_close($t_inbox);
?>
