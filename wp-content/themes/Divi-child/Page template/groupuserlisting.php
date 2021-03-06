<?php
/*
 *  Template Name: Group User listing
 */
get_header();
$current_user = wp_get_current_user();
if (!is_user_logged_in()):
    echo '<script>window.location.href="' . site_url() . '"</script>';
endif;
global $wpdb, $post, $pmpro_pages, $pmprorh_registration_fields;
//some page vars
if (!empty($pmpro_pages['directory']))
    $directory_url = get_permalink($pmpro_pages['directory']);
if (!empty($pmpro_pages['profile']))
    $profile_url = get_permalink($pmpro_pages['profile']);
//did they use level instead of levels?
if (empty($levels) && !empty($level))
    $levels = $level;
$_REQUEST['pugroupcode'];
if (isset($_REQUEST['pugroupcode']))
    $grpcode = intval($_REQUEST['pugroupcode']);
else
    $grpcode = "";
if (isset($_REQUEST['pugroupname']))
    $grpname = $_REQUEST['pugroupname'];
else
    $grpname = "";

if (isset($_REQUEST['pn']))
    $pn = intval($_REQUEST['pn']);
else
    $pn = 1;

if (isset($_REQUEST['limit']))
    $limit = intval($_REQUEST['limit']);
elseif (empty($limit))
    $limit = 15;

$end = $pn * $limit;
$start = $end - $limit;

$user_id = $current_user->ID;
$urole = get_user_meta($user_id, 'pruser_role', 'true');
if ($urole == "team member" || $urole == "group") {
    if ($grpcode != 0 && $grpcode != "" && $grpname != "") {

        $sqlQuery = "SELECT SQL_CALC_FOUND_ROWS u.ID, u.user_login, u.user_email, u.user_nicename, u.display_name, UNIX_TIMESTAMP(u.user_registered) as joindate,
umg.meta_value as m_groupcode,  
mu.membership_id, mu.initial_payment, mu.billing_amount, mu.cycle_period, mu.cycle_number, mu.billing_limit, mu.trial_amount, mu.trial_limit, UNIX_TIMESTAMP(mu.startdate) as startdate, UNIX_TIMESTAMP(mu.enddate) as enddate, m.name as membership, umf.meta_value as first_name, uml.meta_value as last_name FROM $wpdb->users u LEFT JOIN $wpdb->usermeta umh ON umh.meta_key = 'pmpromd_hide_directory' AND u.ID = umh.user_id LEFT JOIN $wpdb->usermeta umf ON umf.meta_key = 'first_name' AND u.ID = umf.user_id
LEFT JOIN wp_xoea_usermeta umg ON  umg.user_id = u.ID 
LEFT JOIN $wpdb->usermeta uml ON uml.meta_key = 'last_name' AND u.ID = uml.user_id LEFT JOIN $wpdb->pmpro_memberships_users mu ON u.ID = mu.user_id LEFT JOIN $wpdb->pmpro_membership_levels m ON mu.membership_id = m.id";
        $sqlQuery .= " WHERE mu.status = 'active' AND (umh.meta_value IS NULL OR umh.meta_value <> '1') AND mu.membership_id > 0 ";
        if ($levels)
            $sqlQuery .= "AND umg.meta_value = '$grpcode' AND mu.membership_id IN(" . esc_sql($levels) . ") ORDER BY  u.display_name ASC LIMIT";
        $sqlQuery .= "AND umg.meta_value = '$grpcode'  ORDER BY  u.display_name ASC";
        $sqlQuery .= " LIMIT $start, $limit";
        $sqlQuery = apply_filters("pmpro_member_directory_sql", $sqlQuery, $levels, $s, $pn, $limit, $start, $end, $order_by, $order);
    }
    else {

        $sqlQuery = "";
    }
    $theusers = $wpdb->get_results($sqlQuery);
    $totalrows = $wpdb->get_var("SELECT FOUND_ROWS() as found_rows");
} else {
    echo '<p> No records Found </p>';
}
//update end to match totalrows if total rows is small
if ($totalrows < $end)
    $end = $totalrows;
$layout_cols = preg_replace('/[^0-9]/', '', $layout);
if (!empty($layout_cols))
    $theusers_chunks = array_chunk($theusers, $layout_cols);
else
    $theusers_chunks = array_chunk($theusers, 1);
ob_start();
?>
<div class="group_user_listing container min_height">
    <div class="groupuser_sec">
        <?php
        if (!empty($theusers)) {
            if (!empty($fields)) {
                $fields_array = explode(";", $fields);
                if (!empty($fields_array)) {
                    for ($i = 0; $i < count($fields_array); $i++)
                        $fields_array[$i] = explode(",", trim($fields_array[$i]));
                }
            } else
                $fields_array = false;
// Get Register Helper field options
            $rh_fields = array();
            if (!empty($pmprorh_registration_fields)) {
                foreach ($pmprorh_registration_fields as $location) {
                    foreach ($location as $field) {
                        if (!empty($field->options))
                            $rh_fields[$field->name] = $field->options;
                    }
                }
            }
            ?>

            <div class="pmpro_member_directory">
                <hr class="clear" />
                <?php
                foreach ($theusers_chunks as $row):
                    ?>
                    <div class="user_list_detail">
                        <div class="row">
                            <?php
                            foreach ($row as $auser) {
                                $count++;
                                $auser = get_userdata($auser->ID);
                                $auser->membership_level = pmpro_getMembershipLevelForUser($auser->ID);
                                ?>
                                <div class="medium-<?php ?>
                                     columns">
                                    <div id="pmpro_member-<?php echo $auser->ID; ?>">
                                        <?php if (!empty($show_avatar)) { ?>
                                            <div class="pmpro_member_directory_avatar">
                                                <?php if (!empty($link) && !empty($profile_url)) { ?>
                                                    <a class="<?php echo $avatar_align; ?>" href="<?php echo add_query_arg('pu', $auser->user_nicename, $profile_url); ?>"><?php echo get_avatar($auser->ID, $avatar_size, NULL, $auser->display_name); ?></a>
                                                <?php } else { ?>
                                                    <span class="<?php echo $avatar_align; ?>"><?php echo get_avatar($auser->ID, $avatar_size, NULL, $auser->display_name); ?></span>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                        <h3 class="pmpro_member_directory_display-name">
                                            <?php if (!empty($link) && !empty($profile_url)) { ?>
                                                <a href="<?php echo add_query_arg('pu', $auser->user_nicename, $profile_url); ?>"><?php echo $auser->display_name; ?></a>
                                            <?php } else { ?>
                                                <?php echo $auser->display_name; ?>
                                            <?php } ?>
                                        </h3>
                                        <p class="pmpro_member_directory_email">
                                            <strong><?php _e('Email Address', 'pmpromd'); ?></strong>
                                            <?php echo $auser->user_email; ?>
                                        </p>
                                        <p class="pmpro_member_directory_level">
                                            <strong><?php _e('Level', 'pmpromd'); ?></strong>
                                            <?php echo $auser->membership_level->name; ?>
                                        </p>
                                        <p class="pmpro_member_directory_date">
                                            <strong><?php _e('Start Date', 'pmpromd'); ?></strong>
                                            <?php echo date(get_option("date_format"), $auser->membership_level->startdate); ?>
                                        </p>
                                        <?php
                                        if (!empty($fields_array)):
                                            foreach ($fields_array as $field) {
                                                $meta_field = $auser->{$field[1]};
                                                if (!empty($meta_field)) {
                                                    ?>
                                                    <p class="pmpro_member_directory_<?php echo $field[1]; ?>">
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
                                                        } elseif ($field[1] == 'user_url') {
                                                            ?>
                                                            <a href="<?php echo $auser->{$field[1]}; ?>" target="_blank"><?php echo $field[0]; ?></a>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <strong><?php echo $field[0]; ?>:</strong>
                                                            <?php echo make_clickable($auser->{$field[1]}); ?>
                                                            <?php
                                                        }
                                                        ?>
                                                    </p>
                                                    <?php
                                                }
                                            }
                                        endif;
                                    }
                                    ?>

                                    <p class="pmpro_member_directory_link">
                                        <a class="more-link" href="<?php echo add_query_arg('pu', $auser->user_nicename, get_permalink(28834)); ?>"><?php _e('View Profile', 'pmpromd'); ?></a>
                                    </p>

                                </div> <!-- end pmpro_addon_package-->
                            </div>
                            <?php ?>
                        </div> 
                    </div><!-- end row -->
                    <hr />
                    <?php
                endforeach;
            } else {
                ?>
                <p class="pmpro_member_directory_message pmpro_message pmpro_error">
                    <?php
                    _e('No matching profiles found', 'pmpromd');
                }
                ?>

            </p>

        </div> <!-- end pmpro_member_directory -->
    </div>
</div>
<?php
get_footer();
?>



