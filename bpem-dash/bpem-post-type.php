<?php 









    $labels = array(




    'name'               => _x( 'Events', 'events', 'bp-event-manager' ),




    'singular_name'      => _x( 'Event', 'event', 'bp-event-manager' ),




    'menu_name'          => _x( 'Events', 'admin menu', 'bp-event-manager' ),




    'name_admin_bar'     => _x( 'Event', 'add new on admin bar', 'bp-event-manager' ),




    'add_new'            => _x( 'Add New', 'event', 'bp-event-manager' ),




    'add_new_item'       => __( 'Add New Event', 'bp-event-manager' ),




    'new_item'           => __( 'New Event', 'bp-event-manager' ),




    'edit_item'          => __( 'Edit Event', 'bp-event-manager' ),




    'view_item'          => __( 'View Event', 'bp-event-manager' ),




    'all_items'          => __( 'All Events', 'bp-event-manager' ),




    'search_items'       => __( 'Search Events', 'bp-event-manager' ),




    'parent_item_colon'  => __( 'Parent Events:', 'bp-event-manager' ),




    'not_found'          => __( 'No Events found.', 'bp-event-manager' ),




    'not_found_in_trash' => __( 'No Events found in Trash.', 'bp-event-manager' )




);



















$args = array(




    'labels'             => $labels,




    'description'        => __( 'Description.', 'bp-event-manager' ),




    'public'             => true,




    'publicly_queryable' => true,




    'show_ui'            => true,




    'show_in_menu'       => true,




    'query_var'          => true,




    'rewrite'            => array( 'slug' => 'events' ),




    'capability_type'    => 'post',




    'has_archive'        => true,




    'hierarchical'       => false,




    'menu_position'      => null,




    'menu_icon'           => 'dashicons-megaphone',




    'supports'           => array( 'title', 'editor', 'thumbnail', 'comments' )




);



















register_post_type( 'bpem_event', $args );





























// Add meta Boxes














function bpem_add_meta_box() {









    $screens = array( 'bpem_event' );




    foreach ( $screens as $screen ) {




        add_meta_box(




        'EventInformation',




        'Event Information',




        'bpem_show_custom_meta_box',




        $screen,




        'normal',




        'high'




        );




    }




}









add_action( 'add_meta_boxes', 'bpem_add_meta_box' );









function bpem_show_custom_meta_box( $post ) {









    echo "<div class='evn_meta'>";









    wp_nonce_field( 'evn_location', 'evn_location_nonce' );









    $evn_location = get_post_meta( $post->ID, 'evn_location', true );









    echo '<label for="evn_location"><span> '; _e( 'Event Location', 'bp-event-manager' );









    echo '</span><input type="text" id="evn_location" name="evn_location" value="'.esc_attr( $evn_location ) . '" size="100" /> </label>';



















    wp_nonce_field( 'evn_startDate', 'evn_startDate_nonce' );









    $evn_startDate = get_post_meta( $post->ID, 'evn_startDate', true );









    echo '<label for="evn_startDate"><span>'; _e( 'Start Date', 'bp-event-manager' );









    echo '</span><input type="text" id="evn_startDate" name="evn_startDate" value="' . esc_attr( $evn_startDate ) . '" size="100" /></label> ';



















    wp_nonce_field( 'evn_startTime', 'evn_startTime_nonce' );









    $evn_startTime = get_post_meta( $post->ID, 'evn_startTime', true );









    echo '<label for="evn_startTime"><span>'; _e( 'Start Time', 'bp-event-manager' );









    echo '</span><input type="text" id="evn_startTime" name="evn_startTime" value="'.esc_attr( $evn_startTime ) . '" size="100" /></label>';



















    wp_nonce_field( 'evn_endDate', 'evn_endDate_nonce' );









    $evn_endDate = get_post_meta( $post->ID, 'evn_endDate', true );









    echo '<label for="evn_endDate"><span>'; _e( 'End Date', 'bp-event-manager' );









    echo '</span><input type="text" id="evn_endDate" name="evn_endDate" value="' . esc_attr( $evn_endDate ) . '" size="100" /></label>';



















    wp_nonce_field( 'evn_endTime', 'evn_endTime_nonce' );









    $evn_endTime = get_post_meta( $post->ID, 'evn_endTime', true );









    echo '<label for="evn_endTime"><span>'; _e( 'End time', 'bp-event-manager' ); 









    echo '</span><input type="text" id="evn_endTime" name="evn_endTime" value="' . esc_attr( $evn_endTime ) . '" size="100" /></label>';





























    wp_nonce_field( 'evn_organizer', 'evn_organizer_nonce' );









    $evn_organizer = get_post_meta( $post->ID, 'evn_organizer', true );









    echo '<label for="evn_organizer"><span>'; _e( 'Event Organiser', 'bp-event-manager' );









    echo '</span><input type="text" id="evn_organizer" name="evn_organizer" value="' . esc_attr( $evn_organizer ) . '" size="100" /></label>';









    



















    wp_nonce_field( 'evn_organizer_url', 'evn_organizer_url_nonce' );




    $evn_organizer_url = get_post_meta( $post->ID, 'evn_organizer_url', true );




    echo '<label for="evn_organizer_url"><span>'; _e( 'Organiser URL', 'bp-event-manager' );




    echo '</span><input type="text" id="evn_organizer_url" name="evn_organizer_url" value="' . esc_attr( $evn_organizer_url ) . '" size="100" /></label>';



















    wp_nonce_field( 'evn_group', 'evn_group_nonce' );









    $evn_group = get_post_meta( $post->ID, 'evn_group', true );









    //echo '<label for="evn_group"><span>'; _e( 'Group Name', 'bp-event-manager' );




    echo '</span><input type="hidden" id="evn_group" name="evn_group" value="' . esc_attr( $evn_group ) . '" size="100" /></label>';









    echo '<p> Event Belong to <b>'.bp_get_group_name(groups_get_group($evn_group)).'</b> Group</p>';


    echo '<p> GDPR Agreement <b style="text-transform:capitalize">'.   $evn_group = get_post_meta( $post->ID, 'gdpr_compliant', true ).'</b> </p>';









    echo "</div>";









}









function bpem_save_meta_box_data( $post_id ) {









    if ( ! isset( $_POST['evn_location_nonce'] ) && 




        ! isset( $_POST['evn_startDate_nonce'] )  &&  




        ! isset( $_POST['evn_startTime_nonce'] ) && 




        ! isset( $_POST['evn_endDate_nonce'] )  &&  




        ! isset( $_POST['evn_endTime_nonce'] ) &&




        ! isset( $_POST['evn_group'] ) 









    )  



















    {









        return;









    }









    if (! wp_verify_nonce( $_POST['evn_location_nonce'], 'evn_location' ) && 




        ! wp_verify_nonce( $_POST['evn_startDate_nonce'], 'evn_startDate' ) && 




        ! wp_verify_nonce( $_POST['evn_startTime_nonce'], 'evn_startTime' ) && 




        ! wp_verify_nonce( $_POST['evn_endDate_nonce'], 'evn_endDate' ) && 




        ! wp_verify_nonce( $_POST['evn_endTime_nonce'], 'evn_endTime' ) &&




        ! wp_verify_nonce( $_POST['evn_group_nonce'], 'evn_group' ) 









         ) {









        return;









    }









    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {









        return;









    }









    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {









        if ( ! current_user_can( 'edit_page', $post_id ) ) {









            return;









        }









    } else {









        if ( ! current_user_can( 'edit_post', $post_id ) ) {









            return;









        }









    }









    if ( ! isset( $_POST['evn_location'] ) && 




         ! isset( $_POST['evn_startDate'] ) && 




         ! isset( $_POST['evn_startTime'] ) && 




         ! isset( $_POST['evn_endDate'] ) &&




         ! isset( $_POST['evn_endTime'] ) &&




         ! isset( $_POST['evn_group'] )




        ) {









        return;









    }









    









    $evn_location = sanitize_text_field( $_POST['evn_location'] );




    update_post_meta( $post_id, 'evn_location', $evn_location );









    $evn_startDate = sanitize_text_field( $_POST['evn_startDate'] );




    update_post_meta( $post_id, 'evn_startDate', $evn_startDate );









    $evn_startTime = sanitize_text_field( $_POST['evn_startTime'] );




    update_post_meta( $post_id, 'evn_startTime', $evn_startTime );









    $evn_endDate = sanitize_text_field( $_POST['evn_endDate'] );




    update_post_meta( $post_id, 'evn_endDate', $evn_endDate );









    $evn_endTime = sanitize_text_field( $_POST['evn_endTime'] );




    update_post_meta( $post_id, 'evn_endTime', $evn_endTime );









    $evn_group = sanitize_text_field( $_POST['evn_group'] );




    update_post_meta( $post_id, 'evn_group', $evn_group );



















}









add_action( 'save_post', 'bpem_save_meta_box_data' );














// Add the custom columns to the book post type:




add_filter( 'manage_bpem_event_posts_columns', 'set_custom_edit_book_columns' );




function set_custom_edit_book_columns($columns) {




    //unset( $columns['author'] );




    // $columns['book_author'] = __( 'Author', 'your_text_domain' );




    // $columns['publisher'] = __( 'Publisher', 'your_text_domain' );









    // return $columns;









    $columns = array(




        'cb' => '&lt;input type="checkbox" />',




        'title' => __( 'Event' ),




        'groupname' => __( 'Group Name' ),




        'startdate' => __( 'Start Date' ),




        'enddate'  => __( 'End Date' ),




        'date' => __( 'Publish' )




    );









    return $columns;









}









// Add the data to the custom columns for the book post type:




add_action( 'manage_bpem_event_posts_custom_column' , 'custom_book_column', 10, 2 );




function custom_book_column( $column, $post_id ) {




    switch ( $column ) {




    









        case 'groupname' :




        $evn_group = get_post_meta( $post_id, 'evn_group', true );




        $GN = bp_get_group_name(groups_get_group($evn_group));




        echo '<p>'.__($GN).'</p>';




        break;









        case 'startdate' :




        $startdate = get_post_meta( $post_id, 'evn_startDate', true );




        echo '<p>'.__( $startdate).'</p>';




        break;









        case 'enddate' :




        $enddate = get_post_meta( $post_id, 'evn_endDate', true );




        echo '<p>'.__($enddate).'</p>';




        break;









    }




}









?>