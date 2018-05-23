<?php
/*
 *  Template Name: Manage Profile
 */
?>
<?php
get_header();

if (!is_user_logged_in()):
    echo '<script>window.location.href="' . site_url() . '"</script>';
endif;

global $wpdb, $post, $pmpro_pages, $current_user;
$post->ID = $pmpro_pages['profile'];
?>
<div id="tabs-container" class="profile container min_height">
    <h2><?php the_title(); ?></h2>
    <section class="profile_details">
        <div class="edit_profile">
            <?php if (!$_REQUEST['pu']): ?>
                <button type="button"><a href="<?php echo get_the_permalink(28848); ?>">Edit Profile</a></button>
            <?php endif; ?>
        </div>
        <?php
        $pmpro_pages['profile'];
        global $main_post_id;
        $main_post_id = $post->ID;
        //Get the profile user
        if (!empty($_REQUEST['pu']) && is_numeric($_REQUEST['pu']))
            $pu = get_user_by('id', $_REQUEST['pu']);
        elseif (!empty($_REQUEST['pu']))
            $pu = get_user_by('slug', $_REQUEST['pu']);
        elseif (!empty($current_user->ID))
            $pu = $current_user;
        else
            $pu = false;

        //If no profile user, go to directory or home
        if (empty($pu) || empty($pu->ID)) {
            if (!empty($pmpro_pages['directory']))
                wp_redirect(get_permalink($pmpro_pages['directory']));
            else
                wp_redirect(home_url());
            exit;
        }

        $user_profilestaus = get_user_meta($pu->ID, 'user_profile_status', true);

        if ($_REQUEST['pu'] && $user_profilestaus == 'Private') {
            echo 'NO records found';
        } else {

            function pmpromd_the_title($title, $post_id = NULL) {
                global $main_post_id, $current_user;
                if ($post_id == $main_post_id) {
                    if (!empty($_REQUEST['pu'])) {
                        global $wpdb;
                        $user_nicename = $_REQUEST['pu'];
                        $display_name = $wpdb->get_var("SELECT display_name FROM $wpdb->users WHERE user_nicename = '" . esc_sql($user_nicename) . "' LIMIT 1");
                    } elseif (!empty($current_user)) {
                        $display_name = $current_user->display_name;
                    }
                    if (!empty($display_name))
                        $title = $display_name;
                }
                return $title;
            }

            add_filter("the_title", "pmpromd_the_title", 10, 2);

            // the_title();
            // $atts    ::= array of attributes
            // $content ::= text within enclosing form of shortcode element
            // $code    ::= the shortcode found, when == callback name
            // examples: [pmpro_member_profile avatar="false" email="false"]



            global $current_user, $display_name, $wpdb, $pmpro_pages, $pmprorh_registration_fields;


            if (empty($user_id) && !empty($_REQUEST['pu'])) {
                //Get the profile user
                if (is_numeric($_REQUEST['pu']))
                    $pu = get_user_by('id', $_REQUEST['pu']);
                else
                    $pu = get_user_by('slug', $_REQUEST['pu']);
                $user_id = $pu->ID;
            }

            if (!empty($user_id))
                $pu = get_userdata($user_id);
            elseif (empty($_REQUEST['pu']))
                $pu = get_userdata($current_user->ID);
            if (!empty($pu))
                $pu->membership_level = pmpro_getMembershipLevelForUser($pu->ID);

            ob_start();
            ?>


            <div id="pmpro_member_profile-<?php echo $pu->ID; ?>" class="pmpro_member_profile new_profile_sec">
                <div class="left_side_profile">
                    <div class="profile_image">
                        <?php
                        $profile_pic = get_user_meta($pu->ID, 'profile_pic_url', true);

                        if ($profile_pic != "") {
                            echo '<img src="' . $profile_pic . '" id="img_preview" class="image-responsive" alt="image" heigh="120px" width="130px">';
                            echo '<img src="' . et_get_option('divi_logo', '') . '" id="img_preview1" class="image-responsive" heigh="120px" width="130px" alt="image" style="display:none">';
                        } else {
                            echo '<img src="" id="img_preview" class="image-responsive" alt="image" style="display:none;">';
                            echo '<img src="' . et_get_option('divi_logo', '') . '" id="img_preview1" class="image-responsive" heigh="120px" width="130px" alt="image">';
                        }
                        ?>
                    </div>
                    <div class="profile_info">
                        <?php if (!empty($pu->display_name)) { ?>
                            <h2 class="pmpro_member_directory_name">
                                <?php echo $pu->display_name; ?>
                            </h2>
                        <?php } ?>

                        <?php if (!empty($pu->nickname)) { ?>
                            <p class="pmpro_member_directory_level">
                                <strong><?php _e('Nickname', 'pmpromd'); ?></strong>
                                <?php echo $pu->nickname; ?>
                            </p>
                        <?php } ?>

                        <?php if (!empty($show_bio) && !empty($pu->description)) { ?>
                            <p class="pmpro_member_directory_bio">
                                <strong><?php _e('Biographical Info', 'pmpromd'); ?></strong>
                                <?php echo $pu->description; ?>
                            </p>
                        <?php } ?>
                        <?php if (!empty($pu->user_email)) { ?>
                            <p class="pmpro_member_directory_email">
                                <strong><?php _e('Email Address', 'pmpromd'); ?></strong>
                                <?php echo $pu->user_email; ?>
                            </p>

                        <?php } ?>

                        <?php if (!empty($pu->membership_level->name)) { ?>
                            <p class="pmpro_member_directory_level">
                                <strong><?php _e('Level', 'pmpromd'); ?></strong>
                                <?php echo $pu->membership_level->name; ?>
                            </p>
                        <?php } ?>




                        <?php if (!empty($pu->membership_level->startdate)) { ?>
                            <p class="pmpro_member_directory_date">
                                <strong><?php _e('Start Date', 'pmpromd'); ?></strong>
                                <?php echo date(get_option("date_format"), $pu->membership_level->startdate); ?>
                            </p>

                        <?php } ?>
                    </div>
                </div>
                <?php
//filter the fields
                $fields_array = apply_filters('pmpro_member_profile_fields', $fields_array, $pu);

                if (!empty($fields_array)) {
                    foreach ($fields_array as $field) {
                        if (empty($field[0]))
                            break;
                        $meta_field = $pu->{$field[1]};
                        if (!empty($meta_field)) {
                            ?>
                            <p class="pmpro_member_directory_<?php echo esc_attr($field[1]); ?>">
                                <?php
                                if (is_array($meta_field) && !empty($meta_field['filename'])) {
                                    //this is a file field
                                    ?>
                                    <strong><?php echo $field[0]; ?></strong>
                                    <?php echo pmpromd_display_file_field($meta_field); ?>
                                    <?php
                                } elseif (is_array($meta_field)) {
                                    //this is a general array, check for Register Helper options first
                                    if (!empty($rh_fields[$field[1]])) {
                                        foreach ($meta_field as $key => $value)
                                            $meta_field[$key] = $rh_fields[$field[1]][$value];
                                    }
                                    ?>
                                    <strong><?php echo $field[0]; ?></strong>
                                    <?php echo implode(", ", $meta_field); ?>
                                    <?php
                                } else {
                                    if ($field[1] == 'user_url') {
                                        ?>
                                        <a href="<?php echo esc_url($meta_field); ?>" target="_blank"><?php echo $field[0]; ?></a>
                                        <?php
                                    } else {
                                        ?>
                                        <strong><?php echo $field[0]; ?></strong>
                                        <?php
                                        $meta_field_embed = wp_oembed_get($meta_field);
                                        if (!empty($meta_field_embed))
                                            echo $meta_field_embed;
                                        else
                                            echo make_clickable($meta_field);
                                        ?>
                                        <?php
                                    }
                                }
                                ?>
                            </p>
                            <?php
                        }
                    }
                }
                ?>
                <div class="pmpro_clear"></div>

                <div class="weight_tracksec">
                    <?php
                    if (is_user_logged_in()) {
                        ws_ls_enqueue_files();
                        $chart_arguments = array('user-id' => $pu->ID,
                            'max-data-points' => WE_LS_CHART_MAX_POINTS);

                        if (is_numeric($instance['user-id']) && $instance['user-id'] != 0) {
                            $chart_arguments['user-id'] = $instance['user-id'];
                        }
                        if (is_numeric($instance['max-points'])) {
                            $chart_arguments['max-data-points'] = $instance['max-points'];
                        }
                        if (in_array($instance['type'], array('bar', 'line'))) {
                            $chart_arguments['type'] = $instance['type'];
                        }
                        if (isset($instance['exclude-measurements']) && 'yes' == $instance['exclude-measurements']) {
                            $chart_arguments['exclude-measurements'] = true;
                        }

                        $weight_data = ws_ls_get_weights($chart_arguments['user-id'], $chart_arguments['max-data-points'], -1, 'desc');

                        $chart_arguments['height'] = false;

                        if ($weight_data) {

                            // Reverse array so in cron order
                            $weight_data = array_reverse($weight_data);

                            echo $args['before_widget'];
                            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
                            if (count($weight_data) > 1) {
                                echo ws_ls_display_chart($weight_data, $chart_arguments);
                            } else {
                                echo '<p>' . __('A pretty graph shall appear once you have recorded several weights.', WE_LS_SLUG) . '</p>';
                            }
                            echo $args['after_widget'];
                        } else {
                            echo '<p>' . __('A pretty graph will appear once you have recorded several weights.', WE_LS_SLUG) . '</p>';
                        }
                    } elseif (isset($instance['not-logged-in-message']) && !empty($instance['not-logged-in-message'])) {
                        echo $args['before_widget'];
                        echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
                        echo '<p>' . $instance['not-logged-in-message'] . '</p>';
                        echo $args['after_widget'];
                    }

                    if ($weight_data && (count($weight_data) > 0 || $selected_week_number != -1)) {

                        if (WE_LS_ALLOW_TARGET_WEIGHTS && $use_tabs && false == $shortcode_arguments['hide-second-target-form']) {
                            $html_output .= ws_ls_display_weight_form(true, 'ws-ls-target-form', false, false);
                        }

                        // Display week filters and data tab
                        $html_output .= ws_ls_title(__('Weight History', WE_LS_SLUG));
                        if (count($week_ranges) <= WE_LS_TABLE_MAX_WEEK_FILTERS) {
                            $html_output .= ws_ls_display_week_filters($week_ranges, $selected_week_number);
                        }

                        if (WS_LS_IS_PRO && false === $shortcode_arguments['disable-advanced-tables']) {
                            $html_output .= ws_ls_data_table_placeholder($user_id, false, false, true);
                        } else {
                            $html_output .= ws_ls_display_table($weight_data);
                        }
                    } elseif ($use_tabs && $selected_week_number != -1) {
                        $html_output .= __('There is no data for this week, please try selecting another:', WE_LS_SLUG);
                        if (count($week_ranges) <= WE_LS_TABLE_MAX_WEEK_FILTERS) {
                            $html_output .= ws_ls_display_week_filters($week_ranges, $selected_week_number);
                        }
                    } elseif ($use_tabs) {
                        $html_output .= __('You haven\'t entered any weight data yet.', WE_LS_SLUG);
                    }
                    $html_output .= ws_ls_end_tab($use_tabs);
                    echo $html_output;
                    ?>
                </div>
            </div>
            <div align="center"><a class="more-link" href="<?php echo get_permalink(28850); ?>"><?php _e('View All Members', 'pmpromd'); ?></a></div>
    </div>
    <hr />


    <?php
// }
    ?>

    </section>

    <?php
}
?>

</div>

</div>

<?php get_footer(); ?>
