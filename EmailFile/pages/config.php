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

auth_reauthenticate();
access_ensure_global_level(config_get('manage_plugin_threshold'));

layout_page_header(plugin_lang_get('title'));

layout_page_begin('manage_overview_page.php');

print_manage_menu('manage_plugin_page.php');
?>
<br />
<p><?php echo plugin_lang_get('process_description'); ?></p>

<div class="alert alert-info">
    <p><?php echo plugin_lang_get('launch_reception_script'); ?> : <a href="<?php echo plugin_page('get_emails'); ?>" target="_blank"><?php echo plugin_lang_get('script_name'); ?></a></p>
</div>

<form action="<?php echo plugin_page('config_edit') ?>" method="post">
    <div class="widget-box widget-color-blue2">
        <div class="widget-header widget-header-small">
            <h4 class="widget-title lighter">
                <i class="ace-icon fa fa-edit"></i>
                <?php echo plugin_lang_get('edit_email'); ?>
            </h4>
        </div>
        <div class="widget-body">
            <div class="widget-main no-padding">
                <table class="table table-bordered table-condensed table-striped">
                    <tr <?php echo helper_alternate_class() ?>>
                        <th class="category">
                            <label for="email_host"><?php echo plugin_lang_get('config_email_host'); ?></label>
                        </th>
                        <td>
                            <input type="text" name="email_host" size="50" value="<?php echo plugin_config_get('email_host'); ?>" class="input-sm"/>
                        </td>
                    </tr>
                    <tr <?php echo helper_alternate_class() ?>>
                        <th class="category">
                            <label for="email_address"><?php echo plugin_lang_get('config_email_address'); ?></label>
                        </th>
                        <td>
                            <input type="text" name="email_address" size="50" value="<?php echo plugin_config_get('email_address'); ?>" class="input-sm"/>
                        </td>
                    </tr>
                    <tr <?php echo helper_alternate_class() ?>>
                        <th class="category">
                            <label for="email_password"><?php echo plugin_lang_get('config_email_password'); ?></label>
                        </th>
                        <td>
                            <input type="password" name="email_password" size="50"value="<?php echo plugin_config_get('email_password'); ?>" class="input-sm"/>
                        </td>
                    </tr>
                    <tr <?php echo helper_alternate_class() ?>>
                        <th class="category">
                            <label for="email_fetch_mode"><?php echo plugin_lang_get('config_email_fetch_mode'); ?>*</label>
                        </th>
                        <td>
                            <select name="email_fetch_mode" class="input-sm">
                                <option value="manual" <?php if (plugin_config_get('email_fetch_mode')
                    == 'manual') :
                    ?> selected="selected"<?php endif; ?>><?php echo plugin_lang_get('config_email_fetch_mode_manual'); ?></option>
                                <option value="ajax" <?php if (plugin_config_get('email_fetch_mode')
                                        == 'ajax') :
                                        ?> selected="selected"<?php endif; ?>><?php echo plugin_lang_get('config_email_fetch_mode_ajax'); ?></option>
                                <option value="cron" <?php if (plugin_config_get('email_fetch_mode')
                                            == 'cron') :
                                            ?> selected="selected"<?php endif; ?>><?php echo plugin_lang_get('config_email_fetch_mode_cron'); ?></option>
                            </select>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
        <div class="widget-toolbox padding-8 clearfix">
            <input type="submit" class="btn btn-primary btn-white btn-round" value="<?php echo plugin_lang_get("config_action_update") ?>"/>
        </div>
    </div>
</form>
<div class="hint" style="margin-top:20px;">
    *<?php echo plugin_lang_get('config_email_fetch_mode_description'); ?>
</div>
