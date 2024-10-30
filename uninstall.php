<?php
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();
$posts = get_posts('numberposts=-1&post_type=bpem_event&post_status=any' );
foreach ($posts as $post) {
	// deleting all posts
	wp_delete_post($post->ID, true);
	// Deleting all meta in posts
	delete_post_meta( $post->ID, 'evn_startDate');
	delete_post_meta( $post->ID, 'evn_startTime');
	delete_post_meta( $post->ID, 'evn_location');
	delete_post_meta( $post->ID, 'evn_endDate');
	delete_post_meta( $post->ID, 'event_attend_id');
	delete_post_meta( $post->ID, 'event_attend_avatar');
	delete_post_meta( $post->ID, 'event_attend_person');
	delete_post_meta( $post->ID, 'event_user_link');
	delete_post_meta( $post->ID, 'event_attend_status');
	delete_post_meta( $post->ID, 'evn_organizer');
	delete_post_meta( $post->ID, 'evn_organizer_url');
	delete_post_meta( $post->ID, 'evn_group');
	delete_post_meta( $post->ID, 'evn_group_slug');
}
?>