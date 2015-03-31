<?php
/*
  Plugin EmailFile pour Mantis BugTracker :

  - Rajouts de pièces jointes à un bug via email

  Version 0.1.0
  © Hennes Hervé - 2014
  http://www.h-hennes.fr
 */

auth_reauthenticate();
access_ensure_global_level(config_get('manage_plugin_threshold'));

html_page_top(plugin_lang_get('title'));

print_manage_menu();
?>
<br />
<p><?php echo plugin_lang_get('process_description'); ?></p>

<div style="border:1px solid #000;margin-top:20px;margin-bottom:20px;padding:10px;">
    <p><?php echo plugin_lang_get('launch_reception_script');?> : <a href="<?php echo plugin_page('get_emails'); ?>" target="_blank"><?php echo plugin_lang_get('script_name');?></a></p>
</div>

<form action="<?php echo plugin_page('config_edit') ?>" method="post">
    <table>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="category"><?php echo plugin_lang_get('config_email_host'); ?></td>
            <td><input type="text" name="email_host" size="50" value="<?php echo plugin_config_get('email_host'); ?>" /></td>
        </tr>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="category"><?php echo plugin_lang_get('config_email_address'); ?></td>
            <td><input type="text" name="email_address" size="50" value="<?php echo plugin_config_get('email_address'); ?>" /></td>
        </tr>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="category"><?php echo plugin_lang_get('config_email_password'); ?></td>
            <td><input type="password" name="email_password" size="50"value="<?php echo plugin_config_get('email_password'); ?>" /></td>
        </tr>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="category"><?php echo plugin_lang_get('config_email_fetch_mode'); ?>*</td>
            <td>
                <select name="email_fetch_mode">
                    <option value="manual" <?php if ( plugin_config_get('email_fetch_mode') == 'manual' ) :?> selected="selected"<?php endif; ?>><?php echo plugin_lang_get('config_email_fetch_mode_manual');?></option>
                    <option value="ajax" <?php if ( plugin_config_get('email_fetch_mode') == 'ajax' ) :?> selected="selected"<?php endif; ?>><?php echo plugin_lang_get('config_email_fetch_mode_ajax');?></option>
                    <option value="cron" <?php if ( plugin_config_get('email_fetch_mode') == 'cron' ) :?> selected="selected"<?php endif; ?>><?php echo plugin_lang_get('config_email_fetch_mode_cron');?></option>
                </select>
            </td>
        </tr>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="center" colspan="2"><input type="submit" value="<?php echo plugin_lang_get("config_action_update") ?>"/></td>
        </tr>
    </table>
</form>

<div class="hint" style="margin-top:20px;">
    *<?php echo plugin_lang_get('config_email_fetch_mode_description'); ?>
</div>
