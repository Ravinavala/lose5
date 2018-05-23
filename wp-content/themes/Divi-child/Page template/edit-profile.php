<?php
/*
 *  Template Name: Edit User Profile
 */
?>
<?php
get_header();
$current_user = wp_get_current_user();
if ((!is_user_logged_in()) || !($current_user->membership_levels)):
    echo '<script>window.location.href="' . site_url() . '"</script>';
endif;
global $wpdb;
$user_email = "";
$current_user = wp_get_current_user();
$user_firstname = $current_user->first_name;
$user_lastname = $current_user->last_name;
$user_email = $current_user->user_email;
$user_name = $current_user->user_login;
$nickname = $current_user->nickname;
$user_id = $current_user->ID;

$profile_pic = get_user_meta($user_id, 'profile_pic_url', true);
$dummy_image = get_template_directory_uri() . '/images/d_user.png';
$phone = get_user_meta($user_id, 'pmpro_bphone', true);
$selecteddata = $wpdb->get_results("SELECT wp_xoea_pmpro_membership_orders.membership_id FROM wp_xoea_pmpro_membership_orders WHERE wp_xoea_pmpro_membership_orders.user_id=$user_id LIMIT 1
");
$mid = $selecteddata[0]->membership_id;
$levelname = $wpdb->get_results("SELECT wp_xoea_pmpro_membership_levels.name FROM wp_xoea_pmpro_membership_levels WHERE wp_xoea_pmpro_membership_levels.id = $mid LIMIT 1
");

$user_profilestaus = get_user_meta($user_id, 'user_profile_status', true);
?>
<div id="tabs-container">
    <div id="edit_user" class="tab-content">
        <section class="edit_user_profile min_height">
            <div class="lanloard_profile">
                <div class="container">
                    <div class="row">
                        <!-- <div class="col-sm-3"> -->
                        <aside class="upload_profile">
                            <div class="profile_photo">
                                <div class="profile_actions">
                                    <div class="change_photo manage_photo">
                                        <?php
                                        if ($profile_pic != "") {
                                            echo '<img src="' . $profile_pic . '" id="img_preview" class="image-responsive" alt="image" heigh="120px" width="130px">';
                                            echo '<img src="' . et_get_option('divi_logo', '') . '" id="img_preview1" class="image-responsive" heigh="120px" width="130px" alt="image" style="display:none">';
                                        } else {
                                            echo '<img src="" id="img_preview" class="image-responsive" alt="image" style="display:none;">';
                                            echo '<img src="' . et_get_option('divi_logo', '') . '" id="img_preview1" class="image-responsive" heigh="120px" width="130px" alt="image">';
                                        }
                                        ?>
                                    </div>

                                    <div class="select_img">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <span class="btn btn-file o_bold blue_btn pro_btn">
                                                <label>Choose File<input type="file" name="profile_pic" id="profile_pic" /></label>
                                            </span>
                                            <span class="fileinput-filename"></span><span class="fileinput-new"></span>
                                        </div>
                                    </div>

                                    <div class="content pic_msg"></div>
                                    <div class="profile_pic_remove">
                                        <p><a href="javascript:void(0);" id="remove_pic" class="color_black">remove</a></p>
                                    </div>
                                </div>
                                <div class="profile_photo_detail">
                                    <div class="u_fname">

                                        <p><?php echo $user_name; ?>  </p>
                                    </div>
                                    <div class="nick_name">

                                        <p><strong><?php _e('Nickname:'); ?></strong> <?php echo $nickname; ?>  </p>
                                    </div>

                                    <div class="u_email">

                                        <p><strong>Email Address: </strong><?php echo $user_email; ?> </p>
                                    </div>

                                    <div class="u_level">

                                        <p><strong>Level: </strong><?php echo $levelname[0]->name; ?> </p>
                                    </div>


                                </div>
                            </div>
                        </aside>
                        <!-- </div> -->
                        <div class="load_overlay" id="loding" style="display: none;">
                            <img src="<?php echo get_template_directory_uri() . '/images/loader.gif'; ?>">
                        </div>
                        <!-- <div class="col-md-offset-1 col-sm-8"> -->
                        <div class="landloard_cntct">
                            <form class="form_contain" id="prouser_profile" method="post" action="#">


                                <div class="edit_pro_status">
                                    <label class="heading">Profile Status:</label>
                                    <div class="user_radio">
                                        <input id="uppublic" name="uprofilestatus" type="radio" <?php echo ($user_profilestaus == "Public") ? 'checked="checked"' : '' ?>  value="Public">Public
                                        <input name="uprofilestatus" id="upprivate" type="radio" <?php echo ($user_profilestaus == "Private") ? 'checked="checked"' : '' ?>  value="Private">Private
                                    </div>
                                </div>
                                <div class="edit_user_detail">
                                    <label>User Name</label>
                                    <input type="text" value="<?php echo $user_name; ?>" name="cuname" id="cuname" required="" readonly="">
                                </div>
                                <div class="edit_user_detail">
                                    <div class="edit_user_name">
                                        <label>First Name</label>
                                        <input type="text" value="<?php echo $user_firstname; ?>" name="fname" id="fname" required="">
                                    </div>
                                    <div class="edit_user_name">
                                        <label>Last Name</label>
                                        <input type="text" value="<?php echo $user_lastname; ?>" name="lname" id="lname" required="">
                                    </div>
                                </div>
                                <div class="edit_user_detail">
                                    <label>Email Address</label>
                                    <input type="email" name="uemail" value="<?php echo $user_email; ?>"  readonly=""/>
                                </div>

                                <label>Current Password</label>
                                <input type="password"  name="old_password" id="old_password">
                                <label>New Password</label>
                                <input type="password" name="new_password" id="new_password" >
                                <input type="hidden" id="user_id" name="user_id" autocomplete="off" value="<?php echo $user_id; ?>"/>
                                <label>Confirm Password</label>
                                <input type="password" name="conf_password" id="conf_password">
                                <input type="hidden" id="login_url" value="<?php echo the_permalink(1101); ?>" />
                                <input type="hidden" id="profile_setting" value="<?php echo the_permalink(28834); ?>" />
                                <input type="hidden" id="location"  value="<?php echo admin_url('admin-ajax.php'); ?>"/>
                                <p id="signup_msg"></p>
                                <div class="col-sm-12 edit_user_save">

                                    <input type="hidden" name="remove_image" id="remove-image" value="" />
                                    <input type="submit" class="blue_btn" value="Save">
                                    <div class="message" id="signup_message" style="display:none;"></div>

                                </div>
                            </form>
                        </div>
                        <!-- </div> -->

                    </div>
                </div>
            </div>

        </section>
    </div>

</div>

<?php get_footer(); ?>
