<style>
.et_pb_section.et_pb_section_2.et_pb_with_background.et_section_regular .et_pb_row.et_pb_row_7{padding-top: 75px;}
div.et_pb_section.et_pb_section_2{padding-bottom: 0px;}
</style>
<?php
/* Template Name: Reset user Password */
get_header();
if (is_user_logged_in()) {
    echo '<script>window.location.href="' . site_url() . '"</script>';
}

$string = $_REQUEST['string'];
$encrypt_method = "AES-256-CBC";
$secret_key = 'This is my secret key';
$secret_iv = 'This is my secret iv';
// hash
$key = hash('sha256', $secret_key);
// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
$iv = substr(hash('sha256', $secret_iv), 0, 16);
$decrypted_string = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
if (email_exists($decrypted_string)) {
    $user = get_user_by('email', $decrypted_string);
    $user_id = $user->ID;
    $email = $user->user_email;
    $username = $user->user_login;
    $pass = md5($user->user_pass);
    ?>
    <section class="reset_pw_section min_height">
        
         <div class="form_border">
        <div class="form_heading">   
            <div class="form_heading_img"> 
                <img src="<?php echo get_template_directory_uri()?>/images/L5_logo_final_2.png" alt="L5_logo" class="img-responsive">
            </div>
            <div class="form_heading_text">
                <h2><?php the_title(); ?></h2>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            </div>
        </div>            
        <div class=" signin_form form_contain">
            <form id="reset_pw" method="post" action="#">
                <input type="hidden" id="login_url" value="<?php echo the_permalink(28741); ?>" />
                <input type="hidden" name="email" id="email" value="<?php echo $email; ?>" />
                <input type="hidden" name="oldpass" id="oldpass" value="<?php echo $pass; ?>" />
                <input type="hidden" name="uname" id="uname" value="<?php echo $username; ?>" />
                <div class="load_overlay" id="loding" style="display: none;">
                    <img src="<?php echo get_template_directory_uri() . '/images/loader.gif'; ?>">
                </div>
                <label>Password</label>
                <input type="password" name="password"  id="password" placeholder="Password" />

                <label>Confirm Password</label>
                <input type="password" name="conf_password" id="conf_password" placeholder="Confirm Password" />

                <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />
                 <div class="signin_submit">
                <input type="submit" name="Submit" id="reset_pass" value="Submit" class="blue_btn" >
                 </div>
                <span id="result"></span>
                <input type="hidden" id="admin_url" value="<?php echo admin_url('admin-ajax.php'); ?>" />

            </form>     
        </div>

    </section>
    <?php
} else {
    echo '<p>Email id is not exists. Please check it.</p>';
}
?>
<?php get_footer(); ?>
