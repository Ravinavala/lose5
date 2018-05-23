<?php
/*
 *  Template Name: Change Password
 */
?>
<?php
get_header();
if (!is_user_logged_in()):
    echo '<script>window.location.href="' . get_the_permalink(119) . '"</script>';
endif;
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
?>
<div class="inner_section">

    <section class="contact_section change_passowrd_section">
        <div class="container">
            <div class="load_overlay" id="loding" style="display: none;">
                <img src="<?php echo get_template_directory_uri() . '/images/loader.gif'; ?>">
            </div>
            <form class="form_contain" id="chnge_pass" method="post" action="#">
                <label>Current Password</label>
                <input type="password"  name="old_password" id="old_password" required="">
                <label>New Password</label>
                <input type="password" name="new_password" id="new_password" required="">
                <input type="hidden" id="user_id" name="user_id" autocomplete="off" value="<?php echo $user_id; ?>"/>
                <label>Confirm Password</label>
                <input type="password" name="conf_password" id="conf_password" required="">
                <input type="hidden" id="login_url" value="<?php echo the_permalink(1101); ?>" />
                <input type="hidden" id="location"  value="<?php echo admin_url('admin-ajax.php'); ?>"/>
                <input type="submit" class="blue_btn" value="confirm">

                <p id="signup_msg"></p>
            </form>
        </div>

    </section>
</div>

<?php get_footer(); ?>


<script>
//$("#chnge_pass").validate({
//	rules: {
//		old_password: "required",
//		new_password: "required",
//                conf_password: "required",
//                
//		conf_password: {
//			required: true,
//			equalTo: "#new_password"
//		}
//	},
//	messages: {
//		
//		con_pass: {
//			required: "This field is required.",
//			equalTo: "Password does not match"
//		}
//	},
//	submitHandler: function (form) {
//		//$('#loding').show();
//		var alldata = $('#chnge_pass').serialize();
//		$.ajax({
//			url: '<?php //echo admin_url('admin-ajax.php');      ?>',
//			type: "POST",
//			data: alldata + '&action=change_password',
//			dataType: "html",
//			success: function (data) {
//				//$('#loding').hide();
//				alert(data);
//				if (data == 1) {
//					$('#signup_msg').html('Your password is succesfully set.');
//					setTimeout(function () {
//						$('#signup_msg').fadeOut('fast');
//					}, 5000);
//				}
//				
//				else {
//					$('#signup_msg').html(' password is not set.');
//					setTimeout(function () {
//						$('#signup_msg').fadeOut('fast');
//					}, 5000);
//				} 
//			},
//			error: function (jqXHR, textStatus, errorThrown) {
//				//$('#loding').hide();
//				$loader.html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
//			}
//		});
//		return false;
//	}
//});
</script>
