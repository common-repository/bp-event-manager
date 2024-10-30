<?php
if (get_option('bpem_user_shortcode_to_display_event') != 1) {
	function bpem_by_default_event_info($content) {

		if ('bpem_event' == get_post_type() && is_single()) {
			//$beforecontent = 'This goes before the content. Isn\'t that awesome!';
			// Event Day / Time
			$beforecontent = "";
			$start_date = get_post_meta(get_the_id(), 'evn_startDate');
			$start_time = get_post_meta(get_the_id(), 'evn_startTime');
			$location = get_post_meta(get_the_id(), 'evn_location');
			$organizer = get_post_meta(get_the_id(), 'evn_organizer');
			$organizerurl = get_post_meta(get_the_id(), 'evn_organizer_url');
			// End Date / Time
			$end_date = get_post_meta(get_the_id(), 'evn_endDate');
			$end_time = get_post_meta(get_the_id(), 'evn_endTime');
			$beforecontent .= '<div class="event_header">';
			$beforecontent .= '<p class="datetime"><i class="fa fa-clock-o" aria-hidden="true"></i> ' . $start_date[0] . ' ' . $start_time[0] . '<b class="styleto"> To </b> ' . $end_date[0] . ' ' . $end_time[0] . '</p>';

			$beforecontent .= '<div class="location"><span><p> <i class="fa fa-map-marker" aria-hidden="true"></i> ' . $location[0] . ' </p></span></div>';
			$beforecontent .= '<div class="organizerwrap"><span> <i class="fa fa-user" aria-hidden="true"></i>
		<a href="' . $organizerurl[0] . '">' . $organizer[0] . '</a></span></div>';

			// List of Attendees
			global $post;
			$aftercontent = '';
			$user_ids = get_post_meta($post->ID, 'event_attend_id');

			$count = count(array_filter($user_ids));

			$aftercontent .= "<div class='bpem_box'>";

			$aftercontent .= "<h1> Attandees(" . $count . ")</h1> ";

			$i = 0;

			foreach ($user_ids as $user_id) {

				$avatar = bp_core_fetch_avatar(array('item_id' => $user_id, 'width' => 100, 'height' => 100, 'class' => 'avatar', 'type' => 'full', 'html' => false));

				$aftercontent .= "<a href='" . bp_core_get_user_domain($user_id) . "'><div class='box'> ";

				$aftercontent .= "<img src='" . $avatar . "'>";

				$aftercontent .= "<p>" . bp_core_get_username($user_id) . " </p> ";

				$aftercontent .= "</div></a>";

				$i++;

			}

			$aftercontent .= "</div>";

			$aftercontent .= "<div class='return_link'><a href='" . $_SERVER['HTTP_REFERER'] . "'> Go Back to Previous Link </a></div>";

			$fullcontent = $beforecontent . $content . $aftercontent;
		} else {
			$fullcontent = $content;
		}

		return $fullcontent;

	}
	add_filter('the_content', 'bpem_by_default_event_info');

}

?>