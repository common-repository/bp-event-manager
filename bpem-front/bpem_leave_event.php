<?php //Create Events
add_action('wp_ajax_bpem_leave_event', 'bpem_leave_event');
add_action('wp_ajax_nopriv_bpem_leave_event', 'bpem_leave_event');
function bpem_leave_event() {
	$image_url = sanitize_text_field($_POST['ev_image']);
	$event_id = sanitize_text_field($_POST['event_id']);
	$user_id = get_current_user_id();

	delete_post_meta($event_id, 'event_attend_id', $user_id, false);
	_e("Event Leave Success", 'bp-event-manager');
	wp_die();
}