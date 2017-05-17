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

require_once( config_get('class_path') . 'MantisPlugin.class.php' );

class EmailFilePlugin extends MantisPlugin {

    /**
     * Enregistrement du module
     */
    function register() {
        $this->name = lang_get('plugin_emailfile_title');
        $this->description = lang_get('plugin_emailfile_description');
        $this->page = 'config.php';
        $this->version = '0.1.4';
        $this->requires = array(
            'MantisCore' => '2.2',
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