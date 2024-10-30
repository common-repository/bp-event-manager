<?php

// create custom plugin settings menu

add_action('admin_menu', 'my_cool_plugin_create_menu');

function my_cool_plugin_create_menu() {

	//create submenu page in cpt

	add_submenu_page('edit.php?post_type=bpem_event', 'Settings', 'BPEM Settings', 'manage_options', 'bp_event_manager_settings', 'bpem_plugin_settings_page');

	//call register settings function

	add_action('admin_init', 'bpem_register_plugin_settings_page');

}

function bpem_register_plugin_settings_page() {

	//register our settings

	register_setting('bpem-plugin-settings-group', 'bpem_allow_user_create_event');

	register_setting('bpem-plugin-settings-group', 'bpem_allow_user_join_event_after_join_group');

	register_setting('bpem-plugin-settings-group', 'bpem_join_event_label');

	register_setting('bpem-plugin-settings-group', 'bpem_not_join_event_label');

	register_setting('bpem-plugin-settings-group', 'bpem_number_avatar');

	register_setting('bpem-plugin-settings-group', 'bpem_event_status');

	register_setting('bpem-plugin-settings-group', 'bpem_user_shortcode_to_display_event');

}

function bpem_plugin_settings_page() {

	?>





<div class="bmep_wrap wrap">





<h1>BP Event Manager Settings</h1><hr>





<?php settings_errors();?>





<form method="post" action="options.php">





    <?php settings_fields('bpem-plugin-settings-group');?>





    <?php do_settings_sections('bpem-plugin-settings-group');?>





    <table class="form-table">











    <tr valign="top">





    <th scope="row">Join Event Label</th>





    <td><input type="text" name="bpem_join_event_label" value="<?php echo __(esc_attr(get_option('bpem_join_event_label')), 'bp-event-manager'); ?>" placeholder="Attend, Interested, Join Event,  etc" style="width:100%;"/></td>





    </tr>











    <tr valign="top">





    <th scope="row">Not Join Event Label</th>





    <td><input type="text" name="bpem_not_join_event_label" value="<?php echo __(esc_attr(get_option('bpem_not_join_event_label')), 'bp-event-manager'); ?>" placeholder="Not Attend, Not Interested, Not Join Event,Leave Event etc" style="width:100%;"/></td>





    </tr>











    <tr valign="top">





    <th scope="row"> No of Avatar to Display in Event Box</th>





    <td><input type="number" name="bpem_number_avatar" value="<?php echo __(esc_attr(get_option('bpem_number_avatar')), 'bp-event-manager'); ?>" placeholder="No of Avatar" style="width:100%;"/></td>





    </tr>











    <tr valign="top">





        <?php //$options = get_option( 'bpem_allow_user_create_event' ); ?>





        <th scope="row">Allow Group Members to Create Events</th>





        <td><input type="checkbox" name="bpem_allow_user_create_event" value="1" <?php checked(1, get_option('bpem_allow_user_create_event'), true);?>></td>





    </tr>











    <tr valign="top">
        <th scope="row">Allow Users to Join Event After Join Group</th>
        <td><input type="checkbox" name="bpem_allow_user_join_event_after_join_group" value="1" <?php checked(1, get_option('bpem_allow_user_join_event_after_join_group'), true);?>></td>
    </tr>

    <tr valign="top">
        <th scope="row">Use Shortcode to display event info</th>
        <td><input type="checkbox" name="bpem_user_shortcode_to_display_event" value="1" <?php checked(1, get_option('bpem_user_shortcode_to_display_event'), true);?>></td>
    </tr>












    <?php $options = get_option('bpem_event_status');?>





    <tr valign="top">





        <th scope="row">Frontend Event Create Status</th>





        <td><select name='bpem_event_status[bpem_status]' style="width: 100%;">





            <?php

	$post_status = array('publish', 'pending', 'draft', 'future', 'private', 'inherit');

	foreach ($post_status as $status) {?>





                <option value='<?php echo __($status, 'bp-event-manager'); ?>' <?php selected($options['bpem_status'], $status);?>>





                    <?php echo __(ucfirst($status), 'bp-event-manager'); ?>





                </option>





            <?php }?>





        </select></td>





    </tr>

















    </table>











    <?php submit_button();?>











</form>





</div>





<?php }?>
