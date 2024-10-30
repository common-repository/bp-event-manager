<?php

// Creating shortcode to display details

function bpem_extra_info($extrainfo) {

	$start_date = get_post_meta(get_the_id(), 'evn_startDate');

	$start_time = get_post_meta(get_the_id(), 'evn_startTime');

	$location = get_post_meta(get_the_id(), 'evn_location');

	$organizer = get_post_meta(get_the_id(), 'evn_organizer');

	$organizerurl = get_post_meta(get_the_id(), 'evn_organizer_url');

// End Date / Time

	$end_date = get_post_meta(get_the_id(), 'evn_endDate');

	$end_time = get_post_meta(get_the_id(), 'evn_endTime');

	$extrainfo .= '<div class="event_header">';

	$extrainfo .= '<p class="datetime"><i class="fa fa-clock-o" aria-hidden="true"></i> ' . $start_date[0] . ' ' . $start_time[0] . '<b class="styleto"> To </b> ' . $end_date[0] . ' ' . $end_time[0] . '</p>';

	$extrainfo .= '<div class="location"><span><p> <i class="fa fa-map-marker" aria-hidden="true"></i> ' . $location[0] . ' </p></span></div>';

	$extrainfo .= '<div class="organizerwrap"><span> <i class="fa fa-user" aria-hidden="true"></i>





<a href="' . $organizerurl[0] . '">' . $organizer[0] . '</a></span></div>';

	if (is_singular('bpem_event')) {

		return $extrainfo;

	} //endif

}

add_shortcode('eventdetail', 'bpem_extra_info');

?>