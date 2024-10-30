<?php

//Create Events

add_action('wp_ajax_bpem_event_form_response', 'bpem_event_form_response');
add_action('wp_ajax_nopriv_bpem_event_form_response', 'bpem_event_form_response');
function bpem_event_form_response() {


	$title = sanitize_text_field($_POST['event_title']);
	$content = sanitize_textarea_field($_POST['event_desc']);
	$image_url = sanitize_text_field($_FILES['ev_image']);
	$location = sanitize_text_field($_POST['event_location']);
	$start_date = sanitize_text_field($_POST['start_date']);
	$start_time = sanitize_text_field($_POST['start_time']);
	$end_date = sanitize_text_field($_POST['end_date']);
	$end_time = sanitize_text_field($_POST['end_time']);
	$ev_organizer = sanitize_text_field($_POST['event_organizer']);
	$ev_organizer_url = sanitize_text_field($_POST['event_organizer_url']);
	$group = sanitize_text_field($_POST['evn_group']);
	$gdpr_compliant = sanitize_text_field($_POST['gdpr_compliant']);
	$status_all = get_option('bpem_event_status');
	foreach ($status_all as $st) {
		$status = $st;
	}
	$post_id = wp_insert_post(array(
		'post_type' => 'bpem_event',
		'post_title' => $title,
		'post_content' => $content,
		'post_status' => $status,
	));



	add_post_meta($post_id, 'evn_location', $location);
	add_post_meta($post_id, 'evn_startDate', $start_date);
	add_post_meta($post_id, 'evn_startTime', $start_time);
	add_post_meta($post_id, 'evn_endDate', $end_date);
	add_post_meta($post_id, 'evn_endTime', $end_time);
	add_post_meta($post_id, 'evn_organizer', $ev_organizer);
	add_post_meta($post_id, 'evn_organizer_url', $ev_organizer_url);
	add_post_meta($post_id, 'evn_group', $group);
	add_post_meta($post_id, 'gdpr_compliant', $gdpr_compliant);
	add_post_meta($post_id, 'evn_group_slug', sanitize_title($group));

	//require the needed files

	require_once ABSPATH . "wp-admin" . '/includes/image.php';
	require_once ABSPATH . "wp-admin" . '/includes/file.php';
	require_once ABSPATH . "wp-admin" . '/includes/media.php';



	//then loop over the files that were sent and store them using  media_handle_upload();

	if ($_FILES) {

		foreach ($_FILES as $file => $array) {
			if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
				echo "upload error : " . $_FILES[$file]['error'];
			die();
	}

		$attach_id = media_handle_upload($file, $post_id);
	}
	}



	//and if you want to set that image as Post  then use:



	update_post_meta($post_id, '_thumbnail_id', $attach_id);
	bp_activity_add(array(

		'action' => apply_filters('groups_activity_new_update_action', sprintf(__('%1$s created an event in  %2$s', 'buddypress'), bp_core_get_userlink(get_current_user_id()), '<a href="' . bp_get_group_permalink(groups_get_group($group)) . '">' . esc_attr(bp_get_group_name(groups_get_group($group))) . '</a>')),

		'content' => "Event Name: <a href='" . get_the_permalink($post_id) . "' target='_blank'> " . get_the_title($post_id) . "</a>",

		'component' => 'groups',

		'type' => 'created_event',

		'item_id' => $group,

		'user_id' => get_current_user_id(),

	));

	_e('Event Created Successfully', 'bp-event-manager');
	wp_die();
}