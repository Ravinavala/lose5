/* Validation for register tenants */
jQuery(document).ready(function () {
    /*add custom validate start*/
    $.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
    }, "Letters only please");
    /*add custom validate end*/
    /*Password strength validation*/
    $.validator.addMethod("pwcheck", function (value) {
        return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value)
                && /[A-Z]/.test(value)// consists of only these
                && /[a-z]/.test(value) // has a lowercase letter
                && /\d/.test(value) // has a digit
    });

    /* Validation for login */

    jQuery("#signin").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            pw: "required",
        },
        messages: {
            email: {
                required: "Email is required.",
                email: "Please enter valid email address.",
            },
            pw: {
                required: "Password is required.",
            },
        },
        submitHandler: function (form) {

            jQuery('#signin_msg').hide();
            jQuery('#loding').show();
            var url = jQuery('#location').val();
            var alldata = jQuery('#signin').serialize();
            jQuery.ajax({
                url: url,
                type: "POST",
                data: alldata + '&action=user_signin',
                dataType: "html",
                success: function (data) {
                    jQuery('#loding').hide();
                    if (data == "1") {
                        jQuery(".signin_msg").css({"color": ""});
                        jQuery(".signin_msg").css({"color": "green"});
                        jQuery('#signin_msg').show();
                        jQuery('#signin_msg').html('Login Successful.');
                        setTimeout(function () {
                            jQuery('#signin_msg').fadeOut('fast');
                        }, 2000);
                        window.location.href = 'manage-profile';
                    } else {
                        jQuery('#signin_msg').show();
                        jQuery('#signin_msg').html('Invalid Email Or Password.');
                        setTimeout(function () {
                            jQuery('#signin_msg').fadeOut('fast');
                        }, 2000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    jQuery('#loding').hide();
                    $loader.html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
            return false;
        }
    });

    /* End Validation for login */

    /* Validation for forget password */
    $("#forget_pw").validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: {
                required: "Email is required.",
                email: "Please enter valid email address.",
            }
        },
        submitHandler: function (form) {
            debugger;
            $('#loding').show();
            var url = $('#admin_url').val();
            var alldata = $('#forget_pw').serialize();
            $.ajax({
                url: url,
                type: "POST",
                data: alldata + '&action=forgot_pass',
                dataType: "html",
                success: function (data) {

                    $('#loding').hide();
                    if (data == "1") {

                        $('#forgate_sub').after('<label class="text-success forgot_err" style="color: #3c763d">A password reset email is send to your email, Please check it.</label>');
                        $('#forgate_sub').prop('disabled', true);
                        setTimeout(function () {
                            $('.text-success').fadeOut('fast');
                            window.location.href = $('#login_url').attr('href');
                        }, 5000);
                    } else if (data == "0") {

                        $('#forgate_sub').after('<label class="text-danger forgot_err">Email does not exists.</label>');
                        setTimeout(function () {
                            $('.text-danger').fadeOut('fast');
                        }, 2000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                    $('#loding').hide();
                    $loader.html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
            return false;
        }
    });
    /* End Validation for forget password */

    //Reset password

    $("#reset_pw").validate({
        rules: {
            password: {
                required: true,
                minlength: 8,
                pwcheck: true
            },
            conf_password: {
                required: true,
                equalTo: "#password",
                pwcheck: true
            }
        },
        messages: {
            password: {
                required: "This field is required.",
                minlength: "Minimum 8 charecters are Required.",
                pwcheck: "Password should be special charactor, numeric value, capital letter and small letter."
            },
            conf_password: {
                equalTo: "Password did not match.",
                pwcheck: "Please use one special charector, numeric value capital letter and small letter."
            }
        },
        submitHandler: function (form) {
            debugger;
            $('#loding').show();
            $('#reset_pass').html();
            $('#reset_pass').hide();
            var password = $('#password').val();
            var conf_password = $('#conf_password').val();
            var user_id = $('#user_id').val();
            var email = $('#email').val();
            var uname = $('#uname').val();
            var oldpass = $('#oldpass').val();

            var url = $('#admin_url').val();
            var password_count = password.length;

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    action: 'reset_pass',
                    password: password,
                    user_id: user_id,
                    email: email,
                    uname: uname,
                    oldpass: oldpass
                },
                dataType: "html",
                success: function (data) {

                    if (data == "1")
                    {
                        window.location.href = $('#login_url').val();
                    } else if (data == "0")
                    {
                        $('#reset_pass').after('<label class="text-danger reset_err">Password does not updated successfully. Please try again.</label>');
                        $('#loding').hide();
                        window.setTimeout(function () {
                            $('#reset_pass').hide();
                        }, 1000);
                    }
                }
            });
        }
    });


    //Email Validation
    function validateEmail(email) {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(email)) {
            return true;
        } else {
            return false;
        }
    }

    /* Validation for change profile password */


    $("#prouser_profile").validate({
        rules: {
            fname: {
                required: true,
                lettersonly: true,

            },
            lname: {
                required: true,
                lettersonly: true,
            },
            uemail: {
                required: true,
                email: true,
                maxlength: 50,
            },

        },
        messages: {
            uemail: {
                required: "This field is required.",
            },

        },
        submitHandler: function (form) {

            var flage = true;
            var oldpass = $('#old_password').val();
            var newpass = $('#new_password').val();
            var confpass = $('#conf_password').val();
            if (confpass && (newpass == "")) {
                $('#new_password').after('<label class="error">New Password is required</label>');
                flage = false;

            }
            if (confpass && (oldpass == "")) {
                $('#old_password').after('<label class="error">Old Password is required</label>');
                flage = false;

            }
            if (oldpass && newpass == "") {
                $('#new_password').after('<label class="error">New Password is required</label>');
                flage = false;
            }
            if (newpass && newpass.length < 8) {
                $('#new_password').after('<label class="error">Minimum 8 charecters are Required</label>');
                flage = false;
            }
            if (newpass && confpass && oldpass == "") {
                $('#old_password').after('<label class="error">Current Password is required</label>');
                flage = false;

            } else if (newpass && newpass != confpass) {
                $('#conf_password').after("<label class='error'>password didn't match</label>");
                flage = false;
            }

            if (flage == true) {
                debugger;
                
                $('#loding').show();
                $('#signup_message').html();
                $('#signup_message').show();
                var location = $('#location').val();
                var alldata = $('#prouser_profile').serialize();
                if ($("#profile_pic").val().length != 0) {

                    var profile_pic = $("#profile_pic").prop('files')[0];
                }
                var form = $("#prouser_profile")[0];
                var formdata = new FormData(form);
                formdata.append('alldata', alldata);
                formdata.append('action', 'edit_user');
                if ($("#profile_pic").val().length != 0) {
                    formdata.append('profile_pic', profile_pic);
                }
                redirectsetiing = $('#profile_setting').val();

                $.ajax({
                    url: location,
                    type: "POST",
                    data: formdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        
                        $('#loding').hide();
                        if (data == '2') {
                            $('#signup_message').html('<p>Your password has been changed.</p>');

                            setTimeout(function () {
                                $('#signup_message').fadeOut('fast');
                               
                            }, 2000);
                             window.location.href = redirectsetiing;
                        } else if (data == '3') {
                            $('#signup_message').html('<p>Your old password does not match</p>');
                            setTimeout(function () {
                                $('#signup_message').fadeOut('fast');

                            }, 2000);
                        } else if (data == '1') {
                            $('#signup_message').html('<p>Your profile has been saved</p>');
                            setTimeout(function () {
                                $('#signup_message').fadeOut('fast');

                            }, 2000);
                            window.location.href = redirectsetiing;
                        } else if (data.profile_suc == 'profile saved') {
                            $('#signup_message').html('<p>Your profile has been saved!</p>');
                            setTimeout(function () {
                                $('#signup_message').fadeOut('fast');
                            }, 2000);
                            window.location.href = redirectsetiing;
                        } else {

                            $('#signup_message').html('<p>Profile saved successfully!</p>');
                            setTimeout(function () {
                                $('#signup_message').fadeOut('fast');
                            }, 2000);
                            window.location.href = redirectsetiing;
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('#loding').hide();
                        $loader.html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                    }
                });
                return false;
            } else {
                alert('no');

                return false;
            }
        }

    });

    $('#remove_pic').click(function () {
        $('#img_preview').attr('src', $('#img_preview1').attr('src'));
        $('#remove-image').val('true');
         var url = $('#location').val();
         debugger;
            jQuery.ajax({
                url: url,
                type: "POST",
                data: {
                    action: 'remove_u_pic',
                   remove_pic: 1
                },
                success: function (data) {
                    
                    var data = JSON.parse(data);
                    
                    if (data.succ_msg == "success") {
                        
                    } else {
                       
                        return false;
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
    });

    $(document).on("change", "#profile_pic", function () {
        showMyImage(this);

    });


    function showMyImage(fileInput) {
        debugger;
        var files = fileInput.files;

        var ext = $('#profile_pic').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
            alert('invalid extension!');
            $('#profile_pic').val("");

        } else {
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var imageType = /image.*/;
                if (!file.type.match(imageType)) {
                    continue;
                }
                var img = document.getElementById("img_preview");
                img.file = file;
                var reader = new FileReader();
                reader.onload = (function (aImg) {
                    return function (e) {
                        aImg.src = e.target.result;
                    };
                })(img);
                reader.readAsDataURL(file);
            }
        }
        $('#img_preview').show();
        $('#img_preview1').hide();
    }

    $(".tabs-menu a").click(function (event) {
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
        $(".tab-content").not(tab).css("display", "none");
        $(tab).fadeIn();
    });


    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img_preview').attr('src', e.target.result).width(165)
                        .height(188);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#profile_pic").change(function () {
        readURL(this);
    });


    /* Validation Add new weight */
    $("#add_new_weight").validate({
        rules: {
            noofweight: {
                required: true,
                number: true,
                maxlength: 3
            }
        },
        messages: {
            noofweight: {
                required: "weight is required.",
                number: "Please enter number only.",
                maxlength: "maximun 3 number is allowed"
            }
        },
        submitHandler: function (form) {
            debugger;
            $('#loding').show();
            var url = $('#admin_url').val();
            var noofweight = $('#noofweight').val();

            jQuery.ajax({
                url: url,
                type: "POST",
                data: {
                    action: 'add_current_weight',
                    noofweight: noofweight
                },
                success: function (data) {
                     $('#loding').hide();
                    var data = JSON.parse(data);
                    
                    if (data.succ_msg == "success") {
                        alert(data.test);
                    } else {
                        alert('no');
                        return false;
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });

        }
    });
    /* End Validation weight */
    /** start section min height **/
    var header_height = $("header").outerHeight();
    var footer_height = $("footer").outerHeight();
    var top_header_height = $("#top-header").outerHeight();
    var header_footer = header_height + footer_height + top_header_height;
    var window_height = $(window).outerHeight();
    var total_height = window_height - header_footer;
    $('.min_height').css('min-height', total_height);
    $(window).resize(function () {
        var header_height = $("header").outerHeight();
        var footer_height = $("footer").outerHeight();
        var top_header_height = $("#top-header").outerHeight();
        var header_footer = header_height + footer_height + top_header_height;
        var window_height = $(window).outerHeight();
        var total_height = window_height - header_footer;
        $('.min_height').css('min-height', total_height);
    });
    /** end section min height **/
});


   