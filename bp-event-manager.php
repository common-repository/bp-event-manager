<?php
/*
Plugin Name: BP Event Manager
Plugin URI: http://wordpresswithzaheer.blogspot.com/p/plugin.html
Description: Plug and Play Plugin Development. A person can create events for buddypress groups.
Version: 1.1.0
Author: Zaheer Abbas Aghani
Author URI: https://profiles.wordpress.org/zaheer01/
License: GPLv3 or later
Text Domain: bp-event-manager
Domain Path: /languages
*/



defined("ABSPATH") or die('You can\t access!');



class BPEventManager {



// check if buddypress is installed



function bpem_if_buddypress_not_active($message) {
	if (!is_plugin_active('buddypress/bp-loader.php')) {
	echo $message .= "<div class='notice notice-error is-dismissible'><h4> Buddypress Plugin Activation Required for BP Event Manager Plugin.</h4>
		<a href='".get_site_url().'/wp-admin/plugins.php'."'> Go Back</a>
	</div>";
	deactivate_plugins('/bp-event-manager/bp-event-manager.php');
	wp_die();
	}
}



	function __construct() {



		add_action('init', array($this, 'bpem_enqueue_script_front'));



		add_action('init', array($this, 'bpem_start_from_here'));



		add_action('init', array($this, 'bpem_register_dashboard_post_page'));



		add_action('admin_enqueue_scripts', array($this, 'bpem_admin_enqueue_scripts'));



		add_action('admin_menu', array($this, 'bpem_cpt_ui_for_admin_only'));



		add_action('add_meta_boxes', array($this, 'bpem_attendees_add_meta_boxes'));



		add_action('plugins_loaded', array($this, 'load_textdomain'));

		add_action( 'admin_init', array($this,'bpem_if_buddypress_not_active' ));

		add_action('admin_footer', array($this, 'bpem_deactivate_scripts'));



		add_action('widgets_init', array($this, 'bpem_all_events_in_calendar'));



		add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'bpem_plugin_action_links'));



		/*add_filter('bp_blogs_record_post_post_types', array($this, 'activity_publish_custom_post_types'), 1, 1);



		add_filter('bp_blogs_activity_new_post_action', array($this, 'record_cpt_activity_action'), 1, 3);*/



	}



// Activate plugin



	function bpem_activate() {



		flush_rewrite_rules();

		add_post_type_support('bpem_event', 'buddypress-activity');

	}



	public function load_textdomain() {



		load_plugin_textdomain('bpem-plugin', false, basename(dirname(__FILE__)) . '/languages/');



	}



//All Plugin files



	function bpem_start_from_here() {



		require_once plugin_dir_path(__FILE__) . 'bpem-front/bpem-event-form.php';

		require_once plugin_dir_path(__FILE__) . 'bpem-front/bpem-event-form-response.php';

		require_once plugin_dir_path(__FILE__) . 'bpem-front/bpem_persons_who_attend_event.php';

		require_once plugin_dir_path(__FILE__) . 'bpem-front/bpem-list-of-attendees.php';

		require_once plugin_dir_path(__FILE__) . 'bpem-front/bpem-event-calendar.php';

		require_once plugin_dir_path(__FILE__) . 'bpem-front/bpem-event-further-details.php';

		require_once plugin_dir_path(__FILE__) . 'bpem-front/bpem_leave_event.php';

		require_once plugin_dir_path(__FILE__) . 'bpem-front/bpem-list-events.php';

		require_once plugin_dir_path(__FILE__) . 'bpem-front/bpem_event_update_response.php';

		require_once plugin_dir_path(__FILE__) . 'bpem-front/bpem_event_delete_response.php';

		require_once plugin_dir_path(__FILE__) . 'bpem-front/bpem_event_info.php';



	}



// Enqueue Style and Scripts



	function bpem_enqueue_script_front() {



//Style



		wp_enqueue_style('bpem-style', plugins_url('inc/css/bpem-style.css', __FILE__), '1.0.0', 'all');



		wp_enqueue_style('bpem-jquery-ui', plugins_url('inc/css/jquery-ui.css', __FILE__), false, "1.9.0", false);



		wp_enqueue_style('bpem-timepicker', plugins_url('inc/css/jquery.timepicker.min.css', __FILE__), '1.14.11', 'all');



		wp_enqueue_style('font-awesome', plugins_url('inc/css/font-awesome-4.7.0/css/font-awesome.min.css', __FILE__), '4.7.0', 'all');



		wp_enqueue_style('bpem-fc', plugins_url('inc/css/fullcalendar.min.css', __FILE__), '2.3.2', 'all');



		wp_enqueue_style('bpem-pagination', plugins_url('inc/css/simplePagination.min.css', __FILE__), '1.6', 'all');



// JS Scripts



		wp_enqueue_script('fd-validate', 'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.min.js', array('jquery'), '', true);



		wp_enqueue_script('bpem-timepicker', plugins_url('inc/js/jquery.timepicker.min.js', __FILE__), array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), '1.11.14', true);



		wp_enqueue_script('bpem-script', plugins_url('inc/js/bpem_script.js', __FILE__), array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), '1.0.0', true);



		wp_localize_script('bpem-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));



		wp_enqueue_style('jquery-ui-datepicker');



		wp_enqueue_style('wp-color-picker');



		wp_enqueue_script('wp-color-picker');



		wp_enqueue_media();



		wp_enqueue_script('moments', plugins_url('inc/js/moment.min.js', __FILE__), array('jquery'), '2.10.6', true);



		wp_enqueue_script('bpem-clndr', plugins_url('inc/js/fullcalendar.min.js', __FILE__), array('jquery'), '2.3.2', true);



		wp_enqueue_script('bpem-pagination', plugins_url('inc/js/jquery.simplePagination.js', __FILE__), array('jquery'), '1.6', true);



	}



//Enqueue style and script for admin



	function bpem_admin_enqueue_scripts() {



		wp_enqueue_style('bpem-admin', plugins_url('inc/css/admin-style.css', __FILE__), '1.0.0', 'all');



	}



// Register post type



	function bpem_register_dashboard_post_page() {



		require_once plugin_dir_path(__FILE__) . 'bpem-dash/bpem-post-type.php';



		require_once plugin_dir_path(__FILE__) . 'bpem-dash/bpem-admin-settings-page.php';



		require_once plugin_dir_path(__FILE__) . 'bpem-dash/bpem_remove_attendy.php';



	}



// Remove events tab if user is not admin



	function bpem_cpt_ui_for_admin_only() {



		if (!current_user_can('administrator')):



			remove_menu_page('edit.php?post_type=bpem_event');



		endif;



	}



//List of attendees in dashboard



	function bpem_attendees_add_meta_boxes() {



		add_meta_box('bpem_meta_box_attendees', 'Event Attendees', array($this, 'bpem_list_display_attendees'), 'bpem_event', 'side', 'low');



	} //bpem_attendees_add_meta_boxes



//List of attendees in dashboard



	function bpem_list_display_attendees() {



		global $post;



		$user_ids = get_post_meta($post->ID, 'event_attend_id');



		$count = count(array_filter($user_ids));



		echo "<h4 class='attandees'> Attandees(" . $count . ")</h4> ";



		sprintf(__('You can visit the page by clicking <a href="%s">here</a>.', 'bp-event-manager'), 'http://www.google.com');



		$i = 0;



		echo "<div class='wrap_bx'>";



		foreach ($user_ids as $user_id) {



			$avatar = bp_core_fetch_avatar(array('item_id' => $user_id, 'width' => 100, 'height' => 100, 'class' => 'avatar', 'html' => false));



			echo "<div class='box'><a href='#' class='remove_attendy' user-id='" . $user_id . "' event-id='" . $post->ID . "'>x</a > <a href='" . bp_core_get_user_domain($user_id) . "' class='box_attendee' target='_blank'>";



			echo "<img src='" . $avatar . "' alt=" . bp_core_get_username($user_id) . " title=" . bp_core_get_username($user_id) . ">";



			echo "</a></div>";



			$i++;



		}



		echo "</div>";



	}



	//bpem_list_display_attendees



	public function bpem_plugin_action_links($links) {



		$plugin_links = array(



			'<a href="' . admin_url('edit.php?post_type=bpem_event&page=bp_event_manager_settings') . '">' . __('Settings', 'bp-event-manager') . '</a>',



			'<a target="_blank" href="https://wordpress.org/support/plugin/bp-event-manager/">' . __('Support', 'bp-event-manager') . '</a>',



		);



		if (array_key_exists('deactivate', $links)) {



			$links['deactivate'] = str_replace('<a', '<a class="bpem-deactivate-link"', $links['deactivate']);



		}



		return array_merge($plugin_links, $links);



	}



	private function bepm_get_uninstall_comments() {



		$reasons = array(



			array(



				'id' => 'used-it',



				'text' => __('Can You Please Review ?  because  we want to improve our plugin.', 'bp-event-manager'),



				'type' => 'reviewhtml',



			),



		);



		return $reasons;



	}



	public function bpem_deactivate_scripts() {



		global $pagenow;



		if ('plugins.php' != $pagenow) {



			return;



		}



		$reasons = $this->bepm_get_uninstall_comments();



		?>







<div class="bpem-review-box" id="bpem-review-boxx">







    <div class="bpem-modal-wrap">







        <div class="bpem-modal-header">







            <h3><?php _e('Help Us:', 'bp-event-manager');?></h3>







        </div>







        <div class="bpem-modal-body">







            <ul class="reasons">







                <?php foreach ($reasons as $reason) {?>







                    <li data-type="<?php echo esc_attr($reason['type']); ?>" data-placeholder="<?php echo esc_attr($reason['placeholder']); ?>">







                        <label><input type="radio" name="selected-reason" value="<?php echo $reason['id']; ?>"> <?php echo $reason['text']; ?></label>







                    </li>







                <?php }?>







            </ul>







        </div>







        <div class="bpem-modal-footer">







            <button class="button-primary bpem-model-submit"><?php _e('No Deactivate', 'bp-event-manager');?></button>







            <button class="button-secondary bpem-model-cancel"><?php _e('Cancel', 'bp-event-manager');?></button>







        </div>







    </div>







</div>















<script type="text/javascript">







    (function ($) {

        $(function () {

        var modal = $('#bpem-review-boxx');

        var deactivateLink = '';



		$('#the-list').on('click', 'a.bpem-deactivate-link', function (e) {

			e.preventDefault();

            modal.addClass('modal-active');

            deactivateLink = $(this).attr('href');

            modal.find('a.dont-bother-me').attr('href', deactivateLink).css('float', 'left');

        });



	$('#bpem-review-boxx').on('click', 'a.review-and-deactivate', function (e) {

		e.preventDefault();

			window.open("https://wordpress.org/support/plugin/bp-event-manager/reviews/#new-post");

		window.location.href = deactivateLink;

	});







            modal.on('click', 'button.bpem-model-cancel', function (e) {







                e.preventDefault();







                modal.removeClass('modal-active');







            });







            modal.on('click', 'input[type="radio"]', function () {







                var parent = $(this).parents('li:first');







                modal.find('.reason-input').remove();







                var inputType = parent.data('type'),







                        inputPlaceholder = parent.data('placeholder');







                if ('reviewhtml' === inputType) {







                    var reasonInputHtml = '<div class="reviewlink"><a href="#" target="_blank" class="review-and-deactivate"><?php _e('Deactivate and leave a review', 'bp-event-manager');?> <span class="xa-bpem-rating-link"> &#9733;&#9733;&#9733;&#9733;&#9733; </span></a></div>';







                } else {







                    var reasonInputHtml = '<div class="reason-input">' + (('text' === inputType) ? '<input type="text" class="input-text" size="40" />' : '<textarea rows="5" cols="45"></textarea>') + '</div>';







                }







                if (inputType !== '') {







                    parent.append($(reasonInputHtml));







                    parent.find('input, textarea').attr('placeholder', inputPlaceholder).focus();







                }







            });















            modal.on('click', 'button.bpem-model-submit', function (e) {







                e.preventDefault();







                var button = $(this);







                if (button.hasClass('disabled')) {







                    return;







                }







                var $radio = $('input[type="radio"]:checked', modal);







                var $selected_reason = $radio.parents('li:first'),







                $input = $selected_reason.find('textarea, input[type="text"]');







                button.addClass('disabled');







                button.text('Processing...');







				window.location.href = deactivateLink;























            });







        });







    }(jQuery));







</script>







<?php



	}



// register All Events widget



	function bpem_all_events_in_calendar() {



		register_widget('ALLEVENTS');



	}



} // class ends



// CHECK WETHER CLASS EXISTS OR NOT.



if (class_exists('BPEventManager')) {



	$obj = new BPEventManager();



	require_once plugin_dir_path(__FILE__) . 'bpem-dash/bpem_showing_all_events.php';



}



//activate plugin hook



register_activation_hook(__FILE__, array($obj, 'bpem_activate'));