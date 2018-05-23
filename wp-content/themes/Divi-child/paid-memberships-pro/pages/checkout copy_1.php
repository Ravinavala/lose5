<?php
global $gateway, $pmpro_review, $skip_account_fields, $pmpro_paypal_token, $wpdb, $current_user, $pmpro_msg, $pmpro_msgt, $pmpro_requirebilling, $pmpro_level, $pmpro_levels, $tospage, $pmpro_show_discount_code, $pmpro_error_fields;
global $discount_code, $username, $password, $password2, $bfirstname, $groupcode, $preferedintake, $blastname, $baddress1, $baddress2, $bcity, $bstate, $bzipcode, $bcountry, $bphone, $bemail, $bconfirmemail, $CardType, $AccountNumber, $ExpirationMonth, $ExpirationYear;

/**
 * Filter to set if PMPro uses email or text as the type for email field inputs.
 *
 * @since 1.8.4.5
 *
 * @param bool $use_email_type, true to use email type, false to use text type
 */
$pmpro_email_field_type = apply_filters('pmpro_email_field_type', true);
?>
<?php if (!is_user_logged_in()) { ?>
    <div class="sign_up_sec min_height">
        <div class="form_heading">   
            <div class="form_heading_img"> 
                <img src="<?php echo get_template_directory_uri() ?>/images/L5_logo_final_2.png" alt="L5_logo" class="img-responsive">
            </div>
            <div class="form_heading_text">
                <h2><?php the_title(); ?></h2>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                <p>I am a </p>
            </div>

            <?php
            $pmpro_levels = pmpro_getAllLevels(false, true);
            $pmpro_level_order = pmpro_getOption('level_order');

            if (!empty($pmpro_level_order)) {
                $order = explode(',', $pmpro_level_order);

                //reorder array
                $reordered_levels = array();
                foreach ($order as $level_id) {
                    foreach ($pmpro_levels as $key => $level) {
                        if ($level_id == $level->id)
                            $reordered_levels[] = $pmpro_levels[$key];
                    }
                }

                $pmpro_levels = $reordered_levels;
            }
            $pmpro_levels = apply_filters("pmpro_levels_array", $pmpro_levels);
            $cnt = 0;
            foreach ($pmpro_levels as $level) {
                $cnt++;
                if (isset($current_user->membership_level->ID))
                    $current_level = ($current_user->membership_level->ID == $level->id);
                else
                    $current_level = false;
                ?>
                <div class="signup_heading_radio">     
                    <input type="radio" id="package<?php echo $cnt; ?>" name="selectedpkg" value="<?php echo $level->id; ?>" > <?php echo $level->name; ?>
                </div>

                <?php
            }
        }
        ?></div>
    <script>
        jQuery("#package1").attr('checked', 'checked');
        jQuery(document).on("click", "#package2, #package1, #package3", function () {

            var levelv = jQuery(this).val();
            if (levelv == 2) {
                jQuery('#displaygroupcode').show();


            } else {
                jQuery('#displaygroupcode').hide();

            }
            if (levelv == 1) {
                jQuery('#displaygroupname').show();
            } else {
                jQuery('#displaygroupname').hide();
            }
            if (levelv == 1) {
                jQuery('#userrole').val("group");

            } else if (levelv == 2) {
                jQuery('#userrole').val("team member");

            } else if (levelv == 3) {
                jQuery('#userrole').val("individual member");
            }

            jQuery('#level').val(levelv);

            if ($('#groupcode').is(":visible")) {

                $(document).on('click', '.pmpro_btn-submit-checkout', function (event) {

                    if ($('#groupcode').val() == '') {
                        $('#req_ms').html('Groupcode is Required');
                        return false;
                    } else {
                        return true;
                    }
                })


            }

        });
        $(document).ready(function () {
            if ($('#groupname').is(":visible")) {


                $(document).on('click', '.pmpro_btn-submit-checkout', function (event) {


                    if ($('#groupname').val() == '') {
                        $('#grpnameerr_msg').html('Group name is Required');
                        return false;
                    } else {
                        return true;
                    }
                })
            }
        });
    </script>


    <div id="pmpro_level-<?php echo $pmpro_level->id; ?>" class="signup_level2 min_height container">
        <form id="pmpro_form" class="pmpro_form" action="<?php if (!empty($_REQUEST['review'])) echo pmpro_url("checkout", "?level=" . $pmpro_level->id); ?>" method="post">
            <input type="hidden" name="userrole" id="userrole" value="group"/>
            <input type="hidden" name="captionid" id="captionid" value=""/>

            <input type="hidden" id="level" name="level" value="<?php echo esc_attr($pmpro_level->id) ?>" />
            <input type="hidden" id="checkjavascript" name="checkjavascript" value="1" />
            <?php if ($discount_code && $pmpro_review) { ?>
                <input class="input <?php echo pmpro_getClassForField("discount_code"); ?>" id="discount_code" name="discount_code" type="hidden" size="20" value="<?php echo esc_attr($discount_code) ?>" />
            <?php } ?>

            <?php
            if ($pmpro_msg) {
                ?>
                <div id="pmpro_message" class="pmpro_message <?php echo $pmpro_msgt ?>"><?php echo $pmpro_msg ?></div>
                <?php
            } else {
                ?>
                <div id="pmpro_message" class="pmpro_message" style="display: none;"></div>
                <?php
            }
            ?>

            <?php if ($pmpro_review) { ?>
                <p><?php _e('Almost done. Review the membership information and pricing below then <strong>click the "Complete Payment" button</strong> to finish your order.', 'paid-memberships-pro'); ?></p>
            <?php } ?>

      <!--  <table id="pmpro_pricing_fields" class="pmpro_checkout" width="100%" cellpadding="0" cellspacing="0" border="0">
            <thead>
                <tr>
                    <th>
                        <span class="pmpro_thead-name"><?php _e('Membership Level', 'paid-memberships-pro'); ?></span>
            <?php if (count($pmpro_levels) > 1) { ?><span class="pmpro_thead-msg"><a href="<?php echo pmpro_url("levels"); ?>"><?php _e('change', 'paid-memberships-pro'); ?></a></span><?php } ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <p>
            <?php printf(__('You have selected the <strong>%s</strong> membership level.', 'paid-memberships-pro'), $pmpro_level->name); ?>
                        </p>

            <?php
            /**
             * All devs to filter the level description at checkout.
             * We also have a function in includes/filters.php that applies the the_content filters to this description.
             * @param string $description The level description.
             * @param object $pmpro_level The PMPro Level object.
             */
            $level_description = apply_filters('pmpro_level_description', $pmpro_level->description, $pmpro_level);
            if (!empty($level_description))
                echo $level_description;
            ?>

                        <div id="pmpro_level_cost">
            <?php if ($discount_code && pmpro_checkDiscountCode($discount_code)) { ?>
                <?php printf(__('<p class="pmpro_level_discount_applied">The <strong>%s</strong> code has been applied to your order.</p>', 'paid-memberships-pro'), $discount_code); ?>
            <?php } ?>
            <?php echo wpautop(pmpro_getLevelCost($pmpro_level)); ?>
            <?php echo wpautop(pmpro_getLevelExpiration($pmpro_level)); ?>
                        </div>

            <?php do_action("pmpro_checkout_after_level_cost"); ?>

            <?php if ($pmpro_show_discount_code) { ?>

                <?php if ($discount_code && !$pmpro_review) { ?>
                                                <p id="other_discount_code_p" class="pmpro_small"><a id="other_discount_code_a" href="#discount_code"><?php _e('Click here to change your discount code', 'paid-memberships-pro'); ?></a>.</p>
                <?php } elseif (!$pmpro_review) { ?>
                                                <p id="other_discount_code_p" class="pmpro_small"><?php _e('Do you have a discount code?', 'paid-memberships-pro'); ?> <a id="other_discount_code_a" href="#discount_code"><?php _e('Click here to enter your discount code', 'paid-memberships-pro'); ?></a>.</p>
                <?php } elseif ($pmpro_review && $discount_code) { ?>
                                                <p><strong><?php _e('Discount Code', 'paid-memberships-pro'); ?>:</strong> <?php echo $discount_code ?></p>
                <?php } ?>

            <?php } ?>
                    </td>
                </tr>
            <?php if ($pmpro_show_discount_code) { ?>
                            <tr id="other_discount_code_tr" style="display: none;">
                                <td>
                                    <div>
                                        <label for="other_discount_code"><?php _e('Discount Code', 'paid-memberships-pro'); ?></label>
                                        <input id="other_discount_code" name="other_discount_code" type="text" class="input <?php echo pmpro_getClassForField("other_discount_code"); ?>" size="20" value="<?php echo esc_attr($discount_code) ?>" />
                                        <input type="button" name="other_discount_code_button" id="other_discount_code_button" value="<?php _e('Apply', 'paid-memberships-pro'); ?>" />
                                    </div>
                                </td>
                            </tr>
            <?php } ?>
            </tbody>
        </table>-->

            <?php if ($pmpro_show_discount_code) { ?>
                <script>
                    <!--
                    //update discount code link to show field at top of form
                    jQuery('#other_discount_code_a').attr('href', 'javascript:void(0);');
                    jQuery('#other_discount_code_a').click(function () {
                        jQuery('#other_discount_code_tr').show();
                        jQuery('#other_discount_code_p').hide();
                        jQuery('#other_discount_code').focus();
                    });

                    //update real discount code field as the other discount code field is updated
                    jQuery('#other_discount_code').keyup(function () {
                        jQuery('#discount_code').val(jQuery('#other_discount_code').val());
                    });
                    jQuery('#other_discount_code').blur(function () {
                        jQuery('#discount_code').val(jQuery('#other_discount_code').val());
                    });

                    //update other discount code field as the real discount code field is updated
                    jQuery('#discount_code').keyup(function () {
                        jQuery('#other_discount_code').val(jQuery('#discount_code').val());
                    });
                    jQuery('#discount_code').blur(function () {
                        jQuery('#other_discount_code').val(jQuery('#discount_code').val());
                    });

                    //applying a discount code
                    jQuery('#other_discount_code_button').click(function () {
                        var code = jQuery('#other_discount_code').val();
                        var level_id = jQuery('#level').val();

                        if (code)
                        {
                            //hide any previous message
                            jQuery('.pmpro_discount_code_msg').hide();

                            //disable the apply button
                            jQuery('#other_discount_code_button').attr('disabled', 'disabled');

                            jQuery.ajax({
                                url: '<?php echo admin_url('admin-ajax.php') ?>', type: 'GET', timeout:<?php echo apply_filters("pmpro_ajax_timeout", 5000, "applydiscountcode"); ?>,
                                dataType: 'html',
                                data: "action=applydiscountcode&code=" + code + "&level=" + level_id + "&msgfield=pmpro_message",
                                error: function (xml) {
                                    alert('Error applying discount code [1]');

                                    //enable apply button
                                    jQuery('#other_discount_code_button').removeAttr('disabled');
                                },
                                success: function (responseHTML) {
                                    if (responseHTML == 'error')
                                    {
                                        alert('Error applying discount code [2]');
                                    } else
                                    {
                                        jQuery('#pmpro_message').html(responseHTML);
                                    }

                                    //enable invite button
                                    jQuery('#other_discount_code_button').removeAttr('disabled');
                                }
                            });
                        }
                    });
    -->
                </script>
            <?php } ?>

            <?php
            do_action('pmpro_checkout_after_pricing_fields');
            ?>

            <?php if (!$skip_account_fields && !$pmpro_review) { ?>
                <div id="pmpro_user_fields" class="pmpro_checkout" width="100%" cellpadding="0" cellspacing="0" border="0">

                    <div class="signup_row">
                        <div>
                            <label for="firstname"><?php _e('First Name', 'paid-memberships-pro'); ?></label>
                            <input id="firstname" name="firstname" type="text" placeholder="Enter Your First Name"  class="input <?php echo pmpro_getClassForField("firstname"); ?>" size="30" value="<?php echo esc_attr($firstname) ?>" />
                        </div>
                        <?php
                        do_action('pmpro_checkout_after_firstname');
                        ?>
                        <div>
                            <label for="lastname"><?php _e('Last Name', 'paid-memberships-pro'); ?></label>
                            <input id="lastname" name="lastname" type="text" placeholder="Enter Your Last Name" class="input <?php echo pmpro_getClassForField("lastname"); ?>" size="30" value="<?php echo esc_attr($lastname) ?>" />
                        </div>

                        <?php
                        do_action('pmpro_checkout_after_lastname');
                        ?>      
                    </div>
                    <div class="signup_row">
                        <div id="signup_form_email">
                            <label for="bemail"><?php _e('E-mail Address', 'paid-memberships-pro'); ?></label>
                            <input id="bemail" name="bemail" type="<?php echo ($pmpro_email_field_type ? 'email' : 'text'); ?>" placeholder="Enter Your Email Address" class="input <?php echo pmpro_getClassForField("bemail"); ?>" size="30" value="<?php echo esc_attr($bemail) ?>" />
                        </div>

                        <?php
                        $pmpro_checkout_confirm_email = apply_filters("pmpro_checkout_confirm_email", true);
                        if ($pmpro_checkout_confirm_email) {
                            ?>  
                            <div>
                                <label for="bconfirmemail"><?php _e('Confirm E-mail Address', 'paid-memberships-pro'); ?></label>
                                <input id="bconfirmemail" name="bconfirmemail" type="<?php echo ($pmpro_email_field_type ? 'email' : 'text'); ?>" class="input <?php echo pmpro_getClassForField("bconfirmemail"); ?>" size="30" value="<?php echo esc_attr($bconfirmemail) ?>" />

                            </div>
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="bconfirmemail_copy" value="1" />
                            <?php
                        }
                        ?>
                    </div>
                    <div class="signup_row">
                        <div>
                            <label for="username"><?php _e('Username', 'paid-memberships-pro'); ?></label>
                            <input id="username" name="username" type="text" placeholder="Enter Your Username" class="input <?php echo pmpro_getClassForField("username"); ?>" size="30" value="<?php echo esc_attr($username) ?>" />
                        </div>


                        <?php
                        do_action('pmpro_checkout_after_username');
                        ?>     
                        <div id="displaygroupname">
                            <label for="groupname"><?php _e('Group Name', 'paid-memberships-pro'); ?></label>
                            <input id="groupname" name="groupname" type="text" placeholder="Enter Your Group Name" class="input <?php echo pmpro_getClassForField("groupname"); ?>" size="30" value="<?php echo esc_attr($groupcode) ?>" maxlength="25" " />
                            <div id="grpname_ms" style="color:red;"> </div>

                            <div id="grpnameerr_msg" style="color:red;"> </div>
                        </div>


                        <div id="displaygroupcode" style="display: none">
                            <label for="groupcode"><?php _e('Groupcode', 'paid-memberships-pro'); ?></label>
                            <input id="groupcode" name="groupcode" type="text"  class="input <?php echo pmpro_getClassForField("groupcode"); ?>" size="30" value="<?php echo esc_attr($groupcode) ?>" maxlength="6" onblur="checkGroupcode()" />
                                <div id="req_ms" style="color:red;"> </div>



     <div id="err_msg" style="color:red;"> </div>
                            </div>
                        </div>
                        <div class="signup_row">
                            <div>
                                <label for="password"><?php _e('Password', 'paid-memberships-pro'); ?></label>
                            <input id="password" name="password" type="password" placeholder="Enter Your Password" class="input <?php echo pmpro_getClassForField("password"); ?>" size="30" value="<?php echo esc_attr($password) ?>" />
                        </div>

                        <?php
                        $pmpro_checkout_confirm_password = apply_filters("pmpro_checkout_confirm_password", true);
                        if ($pmpro_checkout_confirm_password) {
                            ?>
                            <div>
                                <label for="password2"><?php _e('Confirm Password', 'paid-memberships-pro'); ?></label>
                                <input id="password2" name="password2" type="password" placeholder="Enter Your Confirm Password" class="input <?php echo pmpro_getClassForField("password2"); ?>" size="30" value="<?php echo esc_attr($password2) ?>" />
                            </div>

                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="password2_copy" value="1" />
                            <?php
                        }
                        ?>

                        <?php
                        do_action('pmpro_checkout_after_password');
                        ?>
                    </div>


                    <div id="prefered_intake">
                        <label for="prefered_intake"><?php _e('Select Your Prefered Intake', 'paid-memberships-pro'); ?></label>
                        <select id="preferedintake" name="preferedintake" class=" <?php echo pmpro_getClassForField("preferedintake"); ?>">
                            <?php
                            $args1 = array('post_type' => 'schedule', 'posts_per_page' => -1, 'order' => 'ASC',);
                            $loop1 = new WP_Query($args1);
                            while ($loop1->have_posts()) : $loop1->the_post();
                                $id = get_the_ID();
                                $ab = get_the_title();
                                $startdate = get_field('start_date');
                                $enddate = get_field('end_date');
                                ?>
                                <option value="<?php echo $id; ?>" <?php if ($id == $preferedintake) { ?>selected="selected"<?php } ?>><?php echo $ab; ?> 
                                    (<?php echo $startdate; ?>  - <?php echo $enddate; ?>)</option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <p>Signup fees <?php echo $pmpro_currency_symbol;
                            ?> <span id="levelprices"><?php
                        echo
                        $pmpro_level->initial_payment;
                        ?></span>
                        <?php
                        do_action('pmpro_checkout_after_email');
                        ?>
                        for 8 weeks
                    </p>
                    <p>(Membership fees are not renewable).</p>
                    <div class="pmpro_hidden">
                        <label for="fullname"><?php _e('Full Name', 'paid-memberships-pro'); ?></label>
                        <input id="fullname" name="fullname" type="text" class="input <?php echo pmpro_getClassForField("fullname"); ?>" size="30" value="" /> <strong><?php _e('LEAVE THIS BLANK', 'paid-memberships-pro'); ?></strong>
                    </div>

                    <div class="pmpro_captcha">
                        <?php
                        global $recaptcha, $recaptcha_publickey;
                        if ($recaptcha == 2 || ($recaptcha == 1 && pmpro_isLevelFree($pmpro_level))) {
                            echo pmpro_recaptcha_get_html($recaptcha_publickey, NULL, true);
                        }
                        ?>
                    </div>

                    <?php
                    do_action('pmpro_checkout_after_captcha');
                    ?>



                <?php } elseif ($current_user->ID && !$pmpro_review) { ?>

                    <p id="pmpro_account_loggedin">
                        <?php printf(__('You are logged in as <strong>%s</strong>. If you would like to use a different account for this membership, <a href="%s">log out now</a>.', 'paid-memberships-pro'), $current_user->user_login, wp_logout_url($_SERVER['REQUEST_URI'])); ?>
                    </p>
                <?php } ?>

                <?php
                do_action('pmpro_checkout_after_user_fields');
                ?>

                <?php
                do_action('pmpro_checkout_boxes');
                ?>

                <?php if (pmpro_getGateway() == "paypal" && empty($pmpro_review) && true == apply_filters('pmpro_include_payment_option_for_paypal', true)) { ?>
                    <table id="pmpro_payment_method" class="pmpro_checkout top1em" width="100%" cellpadding="0" cellspacing="0" border="0" <?php if (!$pmpro_requirebilling) { ?>style="display: none;"<?php } ?>>
                        <thead>
                            <tr>
                                <th><?php _e('Choose your Payment Method', 'paid-memberships-pro'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div>
                                        <span class="gateway_paypal">
                                            <input type="radio" name="gateway" value="paypal" <?php if (!$gateway || $gateway == "paypal") { ?>checked="checked"<?php } ?> />
                                            <a href="javascript:void(0);" class="pmpro_radio"><?php _e('Check Out with a Credit Card Here', 'paid-memberships-pro'); ?></a>
                                        </span>
                                        <span class="gateway_paypalexpress">
                                            <input type="radio" name="gateway" value="paypalexpress" <?php if ($gateway == "paypalexpress") { ?>checked="checked"<?php } ?> />
                                            <a href="javascript:void(0);" class="pmpro_radio"><?php _e('Check Out with PayPal', 'paid-memberships-pro'); ?></a>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php } ?>

                <?php
                $pmpro_include_billing_address_fields = apply_filters('pmpro_include_billing_address_fields', true);
                if ($pmpro_include_billing_address_fields) {
                    ?>
                    <table id="pmpro_billing_address_fields" class="pmpro_checkout top1em" width="100%" cellpadding="0" cellspacing="0" border="0" <?php if (!$pmpro_requirebilling || apply_filters("pmpro_hide_billing_address_fields", false)) { ?>style="display: none;"<?php } ?>>
                        <thead>
                            <tr>
                                <th><?php _e('Billing Address', 'paid-memberships-pro'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div>
                                        <label for="bfirstname"><?php _e('First Name', 'paid-memberships-pro'); ?></label>
                                        <input id="bfirstname" name="bfirstname" type="text" class="input <?php echo pmpro_getClassForField("bfirstname"); ?>" size="30" value="<?php echo esc_attr($bfirstname) ?>" />
                                    </div>
                                    <div>
                                        <label for="blastname"><?php _e('Last Name', 'paid-memberships-pro'); ?></label>
                                        <input id="blastname" name="blastname" type="text" class="input <?php echo pmpro_getClassForField("blastname"); ?>" size="30" value="<?php echo esc_attr($blastname) ?>" />
                                    </div>
                                    <div>
                                        <label for="baddress1"><?php _e('Address 1', 'paid-memberships-pro'); ?></label>
                                        <input id="baddress1" name="baddress1" type="text" class="input <?php echo pmpro_getClassForField("baddress1"); ?>" size="30" value="<?php echo esc_attr($baddress1) ?>" />
                                    </div>
                                    <div>
                                        <label for="baddress2"><?php _e('Address 2', 'paid-memberships-pro'); ?></label>
                                        <input id="baddress2" name="baddress2" type="text" class="input <?php echo pmpro_getClassForField("baddress2"); ?>" size="30" value="<?php echo esc_attr($baddress2) ?>" />
                                    </div>



                                    <?php
                                    $longform_address = apply_filters("pmpro_longform_address", true);
                                    if ($longform_address) {
                                        ?>
                                        <div>
                                            <label for="bcity"><?php _e('City', 'paid-memberships-pro'); ?></label>
                                            <input id="bcity" name="bcity" type="text" class="input <?php echo pmpro_getClassForField("bcity"); ?>" size="30" value="<?php echo esc_attr($bcity) ?>" />
                                        </div>
                                        <div>
                                            <label for="bstate"><?php _e('State', 'paid-memberships-pro'); ?></label>
                                            <input id="bstate" name="bstate" type="text" class="input <?php echo pmpro_getClassForField("bstate"); ?>" size="30" value="<?php echo esc_attr($bstate) ?>" />
                                        </div>
                                        <div>
                                            <label for="bzipcode"><?php _e('Postal Code', 'paid-memberships-pro'); ?></label>
                                            <input id="bzipcode" name="bzipcode" type="text" class="input <?php echo pmpro_getClassForField("bzipcode"); ?>" size="30" value="<?php echo esc_attr($bzipcode) ?>" />
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <div>
                                            <label for="bcity_state_zip"><?php _e('City, State Zip', 'paid-memberships-pro'); ?></label>
                                            <input id="bcity" name="bcity" type="text" class="input <?php echo pmpro_getClassForField("bcity"); ?>" size="14" value="<?php echo esc_attr($bcity) ?>" />,
                                            <?php
                                            $state_dropdowns = apply_filters("pmpro_state_dropdowns", false);
                                            if ($state_dropdowns === true || $state_dropdowns == "names") {
                                                global $pmpro_states;
                                                ?>
                                                <select name="bstate" class=" <?php echo pmpro_getClassForField("bstate"); ?>">
                                                    <option value="">--</option>
                                                    <?php
                                                    foreach ($pmpro_states as $ab => $st) {
                                                        ?>
                                                        <option value="<?php echo esc_attr($ab); ?>" <?php if ($ab == $bstate) { ?>selected="selected"<?php } ?>><?php echo $st; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <?php
                                            } elseif ($state_dropdowns == "abbreviations") {
                                                global $pmpro_states_abbreviations;
                                                ?>
                                                <select name="bstate" class=" <?php echo pmpro_getClassForField("bstate"); ?>">
                                                    <option value="">--</option>
                                                    <?php
                                                    foreach ($pmpro_states_abbreviations as $ab) {
                                                        ?>
                                                        <option value="<?php echo esc_attr($ab); ?>" <?php if ($ab == $bstate) { ?>selected="selected"<?php } ?>><?php echo $ab; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <?php
                                            } else {
                                                ?>
                                                <input id="bstate" name="bstate" type="text" class="input <?php echo pmpro_getClassForField("bstate"); ?>" size="2" value="<?php echo esc_attr($bstate) ?>" />
                                                <?php
                                            }
                                            ?>
                                            <input id="bzipcode" name="bzipcode" type="text" class="input <?php echo pmpro_getClassForField("bzipcode"); ?>" size="5" value="<?php echo esc_attr($bzipcode) ?>" />
                                        </div>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                    $show_country = apply_filters("pmpro_international_addresses", true);
                                    if ($show_country) {
                                        ?>
                                        <div>
                                            <label for="bcountry"><?php _e('Country', 'paid-memberships-pro'); ?></label>
                                            <select name="bcountry" id="bcountry" class=" <?php echo pmpro_getClassForField("bcountry"); ?>">
                                                <?php
                                                global $pmpro_countries, $pmpro_default_country;
                                                if (!$bcountry)
                                                    $bcountry = $pmpro_default_country;
                                                foreach ($pmpro_countries as $abbr => $country) {
                                                    ?>
                                                    <option value="<?php echo $abbr ?>" <?php if ($abbr == $bcountry) { ?>selected="selected"<?php } ?>><?php echo $country ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <input type="hidden" name="bcountry" value="US" />
                                        <?php
                                    }
                                    ?>
                                    <div>
                                        <label for="bphone"><?php _e('Phone', 'paid-memberships-pro'); ?></label>
                                        <input id="bphone" name="bphone" type="text" class="input <?php echo pmpro_getClassForField("bphone"); ?>" size="30" value="<?php echo esc_attr(formatPhone($bphone)) ?>" />
                                    </div>
                                    <?php if ($skip_account_fields) { ?>
                                        <?php
                                        if ($current_user->ID) {
                                            if (!$bemail && $current_user->user_email)
                                                $bemail = $current_user->user_email;
                                            if (!$bconfirmemail && $current_user->user_email)
                                                $bconfirmemail = $current_user->user_email;
                                        }
                                        ?>
                                        <div>
                                            <label for="bemail"><?php _e('E-mail Address', 'paid-memberships-pro'); ?></label>
                                            <input id="bemail" name="bemail" type="<?php echo ($pmpro_email_field_type ? 'email' : 'text'); ?>" class="input <?php echo pmpro_getClassForField("bemail"); ?>" size="30" value="<?php echo esc_attr($bemail) ?>" />
                                        </div>
                                        <?php
                                        $pmpro_checkout_confirm_email = apply_filters("pmpro_checkout_confirm_email", true);
                                        if ($pmpro_checkout_confirm_email) {
                                            ?>
                                            <div>
                                                <label for="bconfirmemail"><?php _e('Confirm E-mail', 'paid-memberships-pro'); ?></label>
                                                <input id="bconfirmemail" name="bconfirmemail" type="<?php echo ($pmpro_email_field_type ? 'email' : 'text'); ?>" class="input <?php echo pmpro_getClassForField("bconfirmemail"); ?>" size="30" value="<?php echo esc_attr($bconfirmemail) ?>" />

                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <input type="hidden" name="bconfirmemail_copy" value="1" />
                                            <?php
                                        }
                                        ?>
                                    <?php } ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php } ?>



                <?php do_action("pmpro_checkout_after_billing_fields"); ?>

                <?php
                $pmpro_accepted_credit_cards = pmpro_getOption("accepted_credit_cards");
                $pmpro_accepted_credit_cards = explode(",", $pmpro_accepted_credit_cards);
                $pmpro_accepted_credit_cards_string = pmpro_implodeToEnglish($pmpro_accepted_credit_cards);
                ?>

                <?php
                $pmpro_include_payment_information_fields = apply_filters("pmpro_include_payment_information_fields", true);
                if ($pmpro_include_payment_information_fields) {
                    ?>
                    <table id="pmpro_payment_information_fields" class="pmpro_checkout top1em" width="100%" cellpadding="0" cellspacing="0" border="0" <?php if (!$pmpro_requirebilling || apply_filters("pmpro_hide_payment_information_fields", false)) { ?>style="display: none;"<?php } ?>>
                        <thead>
                            <tr>
                                <th>
                                    <span class="pmpro_thead-name"><?php _e('Payment Information', 'paid-memberships-pro'); ?></span>
                                    <span class="pmpro_thead-msg"><?php printf(__('We Accept %s', 'paid-memberships-pro'), $pmpro_accepted_credit_cards_string); ?></span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr valign="top">
                                <td>
                                    <?php
                                    $sslseal = pmpro_getOption("sslseal");
                                    if ($sslseal) {
                                        ?>
                                        <div class="pmpro_sslseal"><?php echo stripslashes($sslseal) ?></div>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                    $pmpro_include_cardtype_field = apply_filters('pmpro_include_cardtype_field', false);
                                    if ($pmpro_include_cardtype_field) {
                                        ?>
                                        <div class="pmpro_payment-card-type">
                                            <label for="CardType"><?php _e('Card Type', 'paid-memberships-pro'); ?></label>
                                            <select id="CardType" name="CardType" class=" <?php echo pmpro_getClassForField("CardType"); ?>">
                                                <?php foreach ($pmpro_accepted_credit_cards as $cc) { ?>
                                                    <option value="<?php echo $cc ?>" <?php if ($CardType == $cc) { ?>selected="selected"<?php } ?>><?php echo $cc ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <input type="hidden" id="CardType" name="CardType" value="<?php echo esc_attr($CardType); ?>" />
                                        <script>
                                                    {
                                                    jQuery('#AccountNumber').validateCreditCard(function (result) {
                                                    var cardtypenames = {
                                                    "amex": "American Express",
                                                            "diners_club_carte_blanche": "Diners Club Carte Blanche",
                                                            "diners_club_international": "Diners Club International",
                                                            "discover": "Discover",
                                                            "jcb": "JCB",
                                                            "laser": "Laser",
                                                            "maestro": "Maestro",
                                                            "mastercard": "Mastercard",
                                                            "visa": "Visa",
                                                            " visa_electron": "Visa Electron"
                                                    };
                                                            if (result.card_type)
                                                            jQuery('#CardType').val(cardtypenames[result.card_type.name]);
                                                            else
                                                            jQuery('#CardType').val('Unknown Card Type');
                                                    });
                                                    }
                                                    );

                                                    </script>
                                        <?php
                                    }
                                    ?>

                                    <div class="pmpro_payment-account-number">
                                        <label for="AccountNumber"><?php _e('Card Number', 'paid-memberships-pro'); ?></label>
                                        <input id="AccountNumber" name="AccountNumber" class="input <?php echo pmpro_getClassForField("AccountNumber"); ?>" type="text" size="25" value="<?php echo esc_attr($AccountNumber) ?>" data-encrypted-name="number" autocomplete="off" />
                                    </div>

                                    <div class="pmpro_payment-expiration">
                                        <label for="ExpirationMonth"><?php _e('Expiration Date', 'paid-memberships-pro'); ?></label>
                                        <select id="ExpirationMonth" name="ExpirationMonth" class=" <?php echo pmpro_getClassForField("ExpirationMonth"); ?>">
                                            <option value="01" <?php if ($ExpirationMonth == "01") { ?>selected="selected"<?php } ?>>01</option>
                                            <option value="02" <?php if ($ExpirationMonth == "02") { ?>selected="selected"<?php } ?>>02</option>
                                            <option value="03" <?php if ($ExpirationMonth == "03") { ?>selected="selected"<?php } ?>>03</option>
                                            <option value="04" <?php if ($ExpirationMonth == "04") { ?>selected="selected"<?php } ?>>04</option>
                                            <option value="05" <?php if ($ExpirationMonth == "05") { ?>selected="selected"<?php } ?>>05</option>
                                            <option value="06" <?php if ($ExpirationMonth == "06") { ?>selected="selected"<?php } ?>>06</option>
                                            <option value="07" <?php if ($ExpirationMonth == "07") { ?>selected="selected"<?php } ?>>07</option>
                                            <option value="08" <?php if ($ExpirationMonth == "08") { ?>selected="selected"<?php } ?>>08</option>
                                            <option value="09" <?php if ($ExpirationMonth == "09") { ?>selected="selected"<?php } ?>>09</option>
                                            <option value="10" <?php if ($ExpirationMonth == "10") { ?>selected="selected"<?php } ?>>10</option>
                                            <option value="11" <?php if ($ExpirationMonth == "11") { ?>selected="selected"<?php } ?>>11</option>
                                            <option value="12" <?php if ($ExpirationMonth == "12") { ?>selected="selected"<?php } ?>>12</option>
                                        </select>/<select id="ExpirationYear" name="ExpirationYear" class=" <?php echo pmpro_getClassForField("ExpirationYear"); ?>">
                                            <?php
                                            for ($i = date_i18n("Y"); $i < intval(date_i18n("Y")) + 10; $i++) {
                                                ?>
                                                <option value="<?php echo $i ?>" <?php if ($ExpirationYear == $i) { ?>selected="selected"<?php } ?>><?php echo $i ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <?php
                                    $pmpro_show_cvv = apply_filters("pmpro_show_cvv", true);
                                    if ($pmpro_show_cvv) {
                                        ?>
                                        <div class="pmpro_payment-cvv">
                                            <label for="CVV"><?php _e('CVV', 'paid-memberships-pro'); ?></label>
                                            <input class="input" id="CVV" name="CVV" type="text" size="4" value="<?php
                                            if (!empty($_REQUEST['CVV'])) {
                                                echo esc_attr($_REQUEST['CVV']);
                                            }
                                            ?>" class="<?php echo pmpro_getClassForField("CVV"); ?>" />  <small>(<a href="javascript:void(0);" onclick="javascript:window.open('<?php echo pmpro_https_filter(PMPRO_URL) ?>/pages/popup-cvv.html', 'cvv', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=600, height=475');"><?php _e("what's this?", 'paid-memberships-pro'); ?></a>)</small>
                                        </div>
                                    <?php } ?>

                                    <?php if ($pmpro_show_discount_code) { ?>
                                        <div class="pmpro_payment-discount-code">
                                            <label for="discount_code"><?php _e('Discount Code', 'paid-memberships-pro'); ?></label>
                                            <input class="input <?php echo pmpro_getClassForField("discount_code"); ?>" id="discount_code" name="discount_code" type="text" size="20" value="<?php echo esc_attr($discount_code) ?>" />
                                            <input type="button" id="discount_code_button" name="discount_code_button" value="<?php _e('Apply', 'paid-memberships-pro'); ?>" />
                                            <p id="discount_code_message" class="pmpro_message" style="display: none;"></p>
                                        </div>
                                    <?php } ?>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php } ?>
                    <script>
                        <!--
                        //checking a discount code
                        jQuery('#discount_code_button').click(function () {
                        var code = jQuery('#discount_code').val();
                        var level_id = jQuery('#level').val();

                        if (code)
                        {
                            //hide any previous message
                            jQuery('.pmpro_discount_code_msg').hide();

                            //disable the apply button
                            jQuery('#discount_code_button').attr('disabled', 'disabled');

                            jQuery.ajax({
                                url: '<?php echo admin_url('admin-ajax.php') ?>', type: 'GET', timeout:<?php echo apply_filters("pmpro_ajax_timeout", 5000, "applydiscountcode"); ?>,
                                dataType: 'html',
                                data: "action=applydiscountcode&code=" + code + "&level=" + level_id + "&msgfield=discount_code_message",
                                error: function (xml) {
                                    alert('Error applying discount code [1]');

                                    //enable apply button
                                    jQuery('#discount_code_button').removeAttr('disabled');
                                },
                                success: function (responseHTML) {
                                    if (responseHTML == 'error')
                                    {
                                        alert('Error applying discount code [2]');
                                    } else
                                    {
                                        jQuery('#discount_code_message').html(responseHTML);
                                    }
    
                                    //enable invite button
                                    jQuery('#discount_code_button').removeAttr('disabled');
                                }
                            });
                        }
                        });
    
                    </    script>

                        <?php do_action('pmpro_checkout_after_payment_information_fields'); ?>

                        <?php
                        if ($tospage && !$pmpro_review) {
                            ?>
                            <table id="pmpro_tos_fields" class="pmpro_checkout top1em" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <thead>
                                    <tr>
                                        <th><?php echo $tospage->post_title ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd">
                                        <td>
                                            <div id="pmpro_license">
                                                <?php echo wpautop(do_shortcode($tospage->post_content)); ?>
                                            </div>
                                            <input type="checkbox" name="tos" value="1" id="tos" /> <label class="pmpro_normal pmpro_clickable" for="tos"><?php printf(__('I agree to the %s', 'paid-memberships-pro'), $tospage->post_title); ?></label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php
                        }
                        ?>

                        <?php do_action("pmpro_checkout_after_tos_fields"); ?>

                        <?php do_action("pmpro_checkout_before_submit_button"); ?>
                        <div class="pmpro_submit">
                            <?php if ($pmpro_review) { ?>

                                <span id="pmpro_submit_span">
                                    <input type="hidden" name="confirm" value="1" />
                                    <input type="hidden" name="token" value="<?php echo esc_attr($pmpro_paypal_token) ?>" />
                                    <input type="hidden" name="gateway" value="<?php echo esc_attr($gateway); ?>" />
                                    <input type="submit" class="pmpro_btn pmpro_custom pmpro_btn-submit-checkout" onClick="return validation()" value="<?php _e('Complete Payment', 'paid-memberships-pro'); ?> &raquo;" />
                                </span>

                            <?php } else { ?>

                                <?php
                                $pmpro_checkout_default_submit_button = apply_filters('pmpro_checkout_default_submit_button', true);
                                if ($pmpro_checkout_default_submit_button) {
                                    ?>
                                    <span id="pmpro_submit_span">
                                        <input type="hidden" name="submit-checkout" value="1" />
                                        <input type="submit" class="pmpro_btn pmpro_custom pmpro_btn-submit-checkout" onClick="return validation()" value="<?php
                                        if ($pmpro_requirebilling) {
                                            _e('Submit and Check Out', 'paid-memberships-pro');
                                        } else {
                                            _e('Submit and Confirm', 'paid-memberships-pro');
                                        }
                                        ?> &raquo;" />
                                    </span>
                                    <?php
                                }
                                ?>

                            <?php } ?>

                            <span id="pmpro_processing_message" style="visibility: hidden;">
                                <?php
                                $processing_message = apply_filters("pmpro_processing_message", __("Processing...", 'paid-memberships-pro'));
                                echo $processing_message;
                                ?>
                            </span>


                            </form>
                        </div>
                    </div>
            </div>
            <?php do_action('pmpro_checkout_after_form'); ?>
            <!-- end pmpro_level-ID -->
        </div>
        <script>

// Find ALL <form> tags on your page
                jQuery('form').submit(function () {
                    // On submit disable its submit button
                    jQuery('input[type=submit]', this).attr('disabled', 'disabled');
                    jQuery('input[type=image]', this).attr('disabled', 'disabled');
                    jQuery('#pmpro_processing_message').css('visibility', 'visible');
                });

                //iOS Safari fix (see: http://stackoverflow.com/questions/20210093/stop-safari-on-ios7-prompting-to-save-card-data)
                var userAgent = window.navigator.userAgent;
                if (userAgent.match(/iPad/i) || userAgent.match(/iPhone/i)) {
                    jQuery('input[type=submit]').click(function () {
                        try {
                            jQuery("input[type=password]").attr("type", "hidden");
                        } catch (ex) {
                            try {
                                jQuery("input[type=password]").prop("type", "hidden");
                            } catch (ex) {
                            }
                        }
                    });
                }

                //add required to required fields
                jQuery('.pmpro_required').after('<span class="pmpro_asterisk"> <abbr title="Required Field">*</abbr></span>');

                //unhighlight error fields when the user edits them
                jQuery('.pmpro_error').bind("change keyup input", function () {
                    jQuery(this).removeClass('pmpro_error');
                });

                //click apply button on enter in discount code box
                jQuery('#discount_code').keydown(function (e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        jQuery('#discount_code_button').click();
                    }
                });

                //hide apply button if a discount code was passed in
                <?php if (!empty($_REQUEST['discount_code'])) { ?>
                    jQuery('#discount_code_button').hide();
                    jQuery('#discount_code').bind('change keyup', function () {
                        jQuery('#discount_code_button').show();
                    });
                <?php } ?>

                //click apply button on enter in *other* discount code box
                jQuery('#other_discount_code').keydown(function (e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        jQuery('#other_discount_code_button').click();
                    }
                });

        </script>
                <script>

   //add javascriptok hidden field to checkout
                            jQuery("input[name=submit-checkout]").after('<input type="hidden" name="javascriptok" value="1" />');

            </script>

<script>

    $("#groupcode").onblur = function () {
        checkGroupcode()
    };

    function checkGroupcode() {
        debugger;
        var groupcode = $("#groupcode").val();
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php') ?>',
            type: "POST",
            data: {
                action: 'check_groupcode',
                groupcode: groupcode
            },
            success: function (data) {
                var data = JSON.parse(data);
                if (data.succ_msg == "success") {
                    preferintake = data.preferintake;
                    userid = data.userid;
                    groupnames = data.groupname;
                    $('#preferedintake').val(preferintake);
                    $('#groupname').val(groupnames);
                    $('#preferedintake').attr("disabled", true);
                    $('#displaygroupname').show();
                    $('#groupname').attr("readonly", true);
                    $('#captionid').val(userid);
                    $('#err_msg').hide();
                    $('.pmpro_btn-submit-checkout').attr("disabled", false);

                } else {
                    $('#err_msg').show();
                    $('#displaygroupname').hide();
                    $('#err_msg').html('Please Enter Valid Groupcode');
                    $('.pmpro_btn-submit-checkout').attr("disabled", true);

                    return false;
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    }
</script>
                                    <script>
                            <!--
                                             //add javascriptok hidden field to checkout
                            jQuery("input[name=submit-checkout]").after('<input type="hidden" name="javascriptok" value="1" />');
                                    -- >

                            $(document).on('click', '.pmpro_btn-submit-checkout', function (event) {

                                jQuery('.error').remove();
                                var username = jQuery('#username').val();
                                var password = jQuery('#password').val();
                                var password2 = jQuery('#password2').val();
                                var bemail = jQuery('#bemail').val();
                                var AccountNumber = jQuery('#AccountNumber').val();
                                var CVV = jQuery('#CVV').val();

                                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                                var error = 0;

                                if (username == '') {
                                    jQuery('#username').parent().find('span').after('<span class="error">Username is required.</span>');
                                    error = 1;
                                } else {
                                    jQuery('#username').parent().find('#error').remove();
                                }

                                if (password == '') {
                                    jQuery('#password').parent().find('span').after('<span class="error">Password is required.</span>');
                                    error = 1;
                                } else if (password.length < 8 || password.length > 15) {
                                    jQuery('#password').parent().find('span').after('<span class="error">Password should be between 8 to 15 characters.</span>');
                                    error = 1;
                                } else if (!password.match(/[A-z]/) || !password.match(/[A-Z]/) || !password.match(/\d/) || !password.match(/[\W]/)) {
                                    jQuery('#password').parent().find('span').after('<span class="error">Password must contain uppercase,lowercase,digit and special character.</span>');
                                    error = 1;
                                } else {
                                    jQuery('#password').parent().find('#error').remove();
                                }

                                if (password2 == '') {
                                    jQuery('#password2').parent().find('span').after('<span class="error">Confirom password is required.</span>');
                                    error = 1;
                                } else if (password2 != password) {
                                    jQuery('#password2').parent().find('span').after('<span class="error">Confirm password does not match.</span>');
                                    error = 1;
                                } else {
                                    jQuery('#password2').parent().find('#error').remove();
                                }

                                if (bemail == '') {
                                    jQuery('#bemail').parent().find('span').after('<span class="error">Email is required.</p>');
                                    error = 1;
                                } else if (!emailReg.test(bemail))
                                {
                                    jQuery('#bemail').parent().find('span').after('<span class="error">Please enter valid email.</p>');
                                    error = 1;
                                } else {
                                    jQuery('#bemail').parent().find('#error').remove();
                                }



                                if (error == 0) {
                                    jQuery('#pmpro_form').submit();
                                } else {
                                    return false;
                                }
                            });
                                </script>

