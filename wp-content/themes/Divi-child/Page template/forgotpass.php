<?php
/*
  Template Name: Forgot Password
 */
get_header();
if (is_user_logged_in()) {
    echo '<script>window.location.href="' . site_url() . '"</script>';
}
error_reporting(E_ALL);
ini_set('error_log', 'path_to_log_file');
ini_set('log_errors_max_len', 0);
ini_set('log_errors', true);
?>
<section class="forgotpass_section min_height">
    <div class="form_border">    
        <div class="form_heading">   
            <div class="form_heading_img"> 
                <img src="<?php echo get_template_directory_uri() ?>/images/L5_logo_final_2.png" alt="L5_logo" class="img-responsive">
            </div>
            <div class="form_heading_text">
                <h2><?php the_title(); ?></h2> 

            </div>
        </div>     
        <div class="forgotpass_form">             
            <div class="form_contain">
                <div class="load_overlay" id="loding" style="display: none;">
                    <img src="<?php echo get_template_directory_uri() . '/images/loader.gif'; ?>">
                </div>
                <form  id="forget_pw" method="post" action="#">
                    <label>Email Address</label>
                    <input type="email" name="email" id="email" placeholder="Enter Your Email Address" > 
                    <div class="forgotpass_submit">                              
                        <input type="submit" value="Submit" id="forgate_sub"  class="blue_btn" > 
                    </div>  
                    <!--                            <h3 id="forgate_sub" ></h3>-->
                    <?php if (!is_user_logged_in()) { ?>
                        <div class="forgot_password">
                            <p><a id="login_url" href="<?php echo the_permalink(28741); ?>" class="reg_now">Login Now</a></p>
                        </div>                   
                    <?php } ?>
                    <input type="hidden" id="admin_url" value="<?php echo admin_url('admin-ajax.php'); ?>" />
                </form>      
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>
