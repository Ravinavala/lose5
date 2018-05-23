<?php
/*
  Template Name: login page
 */
get_header();
if (is_user_logged_in()):
    echo '<script>window.location.href="' . site_url() . '"</script>';
endif;
?>
<section class="login_section min_height">
    <div class="form_border">
        <div class="form_heading">   
            <div class="form_heading_img"> 
                <img src="<?php echo get_template_directory_uri() ?>/images/L5_logo_final_2.png" alt="L5_logo" class="img-responsive">
            </div>
            <div class="form_heading_text">
                <h2><?php the_title(); ?></h2>

            </div>
        </div>        
        <div class="signin_form">
            <form name="signin" class="form_contain" id="signin" method="post" action="#">
                <label>Email Address</label>
                <input type="email" name="email" required="" placeholder="Enter Your Email Address">
                <label>Password</label>
                <input type="password" name="pw" required="" placeholder="Enter Your Password">
                <div class="forgot_password">
                    <a  href="<?php the_permalink(28826); ?>" id="test">Forgot Password?</a>
                </div>
                <input type="hidden" id="location" value="<?php echo admin_url('admin-ajax.php'); ?>" />
                <div class="signin_submit">
                    <input type="submit" value="Sign In" class="blue_btn"/>
                </div>
                <span id="signin_msg" class="signin_msg" ></span>
                <p>Don’t have an account ? <a href="<?php the_permalink(28745) ?>?level=1">Sign Up</a></p>
            </form>
        </div>
    </div>
</section>
<?php get_footer(); ?>
