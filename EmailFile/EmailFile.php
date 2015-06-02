<?php

/*
  Plugin EmailFile pour Mantis BugTracker :

  - Rajouts de pièces jointes à un bug via email

  © Hennes Hervé - 2015
  http://www.h-hennes.fr
 */
require_once( config_get('class_path') . 'MantisPlugin.class.php' );

class EmailFilePlugin extends MantisPlugin {

    /**
     * Enregistrement du module
     */
    function register() {
        $this->name = lang_get('plugin_emailfile_title');
        $this->description = lang_get('plugin_emailfile_description');
        $this->page = 'config.php';
        $this->version = '0.1.1';
        $this->requires = array(
            'MantisCore' => '1.2.0',
            'jQuery' => '1.11'
        );
        $this->author = 'Hennes Hervé';
        $this->url = 'http://www.h-hennes.fr';
    }

    /**
     * Initialisation du module
     */
    function init() {
        plugin_event_hook('EVENT_VIEW_BUG_EXTRA', 'fetchEmailFiles');
    }

    /**
     * Configuration par défaut du module
     */
    function config() {

        return array(
            'email_host' => 'mail.example.com',
            'email_address' => 'test@example.fr',
            'email_password' => 'password',
            'email_fetch_mode' => 'manual',
        );
    }

    /**
     * Fonction qui va récupérer les emails des pièces jointes
     */
    function fetchEmailFiles() {

        //Mode manuel ou ajax affichage d'un block
        if (plugin_config_get('email_fetch_mode') == 'manual' || plugin_config_get('email_fetch_mode') == 'ajax') {
            echo '<a id="email_file_block">
                <br />
                <table class="width100" cellspacing="0" border="0">
                   <tr><td class="form-title" colspan="2">' . plugin_lang_get('bugpage_title') . '</td></tr>
                   <tr class="row-2">
                    <td>&nbsp;</td>
                    <td id="ajax_results">';
            if (plugin_config_get('email_fetch_mode') == 'manual')
                echo '<a href="' . plugin_page('get_emails.php') . '" target="_blank">' . plugin_lang_get('click_to_launch_script') . '</a>';
            echo '</td> </tr>
                </table>
                </a>';
        }

        //En ajax on lance la récupération des emails
        if (plugin_config_get('email_fetch_mode') == 'ajax') {
            echo '<script type="text/javascript">
                $(function() {
                 $("#ajax_results").load("' . plugin_page('get_emails.php') . '");
                });
            </script>';
        }
    }

}

?>