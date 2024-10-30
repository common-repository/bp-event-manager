<?php

// creating shortcode for list of attendees

function bpem_list_of_attendees($attendees) {
	global $post;
	$user_ids = get_post_meta($post->ID, 'event_attend_id');
	$count = count(array_filter($user_ids));
	$attendees .= "<div class='bpem_box'>";
	$attendees .= "<h1> Attandees(" . $count . ")</h1> ";
	$i = 0;

	foreach ($user_ids as $user_id) {
		$avatar = bp_core_fetch_avatar(array('item_id' => $user_id, 'width' => 100, 'height' => 100, 'class' => 'avatar', 'type' => 'full', 'html' => false));
		$attendees .= "<a href='" . bp_core_get_user_domain($user_id) . "'><div class='box'> ";
		$attendees .= "<img src='" . $avatar . "'>";
		$attendees .= "<p>" . bp_core_get_username($user_id) . " </p> ";
		$attendees .= "</div></a>";
		$i++;
	}
	$attendees .= "</div>";

	$attendees .= "<div class='return_link'><a href='" . $_SERVER['HTTP_REFERER'] . "'> Go Back to Previous Link </a></div>";

	if (is_singular('bpem_event')) {
		return $attendees;
	} //endif
}
add_shortcode('attendees', 'bpem_list_of_attendees');
?>