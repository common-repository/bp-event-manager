<?php /* * Attend event functionality*/
add_action('wp_ajax_bpem_persons_who_attend_event', 'bpem_persons_who_attend_event');
add_action('wp_ajax_nopriv_bpem_persons_who_attend_event', 'bpem_persons_who_attend_event');
function bpem_persons_who_attend_event() {
	$event_id = sanitize_text_field($_POST['event_id']);
	$user_id = get_current_user_id();
	add_post_meta($event_id, 'event_attend_id', $user_id, false);
	_e("Event Attend Success", "bp-event-manager");
	wp_die();
}