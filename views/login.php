<!DOCTYPE html>
<html>
    <head>

        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <title><?php echo _("Datawrapper, a project by ABZV") ?></title>

        <!-- General styles -->
        <link rel="stylesheet" type="text/css" href="css/stylesheets/general.css" />

        <!-- JQuery library -->
        <script src="js/jquery-1.6.4.js" type="text/javascript"></script>

        <!-- JQueryUI library -->
        <script src="js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>       
        
        <!-- Fancybox assets -->
        <script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <link rel="stylesheet" href="js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

        <!-- The JS function that help navigate the app -->
        <script src="js/navigation.js" type="text/javascript"></script> 
        
        <!-- More general functions for the app -->
        <script src="js/functions.js" type="text/javascript"></script> 

        <!-- Loads Favicon -->
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

    </head>


    <body>
    
	    <script type="text/javascript">

	     $(document).ready(function() {
	        
            //Init all inputs fields so they react properly onBlur
            initInputs();

            //Init the buttons in the header
            initHeader();

            //Loads the fancybox
            $("a.fancybox").fancybox({
                'hideOnContentClick': false
            });

            //init the error box
            $('#error').click(function() {
                $(this).hide();
            });		

            //init the Sign in button
            $('#login_submit').click(function() {
                var email = $('#email').val();
                var pwd = $('#pwd').val();
                $.post('actions/user.php', {action:"connect", email: email, pwd: pwd}, function(data){
                    if (data != ""){
                        data = jQuery.parseJSON(data);
                        if (data.status == 200){
                            
                            //User is logged in, the page reloads with a valid SESSION[user_id]
                            location.reload();

                        }else{
                            error(data.error);
                        }
                    }else{
                        error();
                    }
                });
            }); 

            //init the back button
            $(".close_signup").click(function(){
                $("#login").hide();
                $("#show_signup").hide();
                $("#reminder").hide();
                $("#signup").show();

            });

            //init the password reminder screen
            $("#password_forgotten").click(function(){
                $("#login").hide();
                $("#reminder").show();
            });

            //init the reminder button that'll call the mail sender
            $("#reminder_submit").click(function(){

                var email = $('#email_reminder').val();

                if(test_email(email)) {
                    $.post('actions/user.php', {action:"pwd_reminder", email: email}, function(data){
                        if (data != ""){
                            data = jQuery.parseJSON(data);
                            if (data.status == 200){
                                
                                //Reminder e-mail sent, needs to choose a new pwd
                                $("#reset_confirmation").show()
                                            .html("<?php echo _("An e-mail has been sent. Please check your mailbox and follow instructions to reset your password.") ?>");

                            }else{
                                error(data.error);
                            }
                        }else{
                            error();
                        }
                    });

                }else{
                    
                    error("<?php echo _("Please enter a valid email address.") ?>");

                }

            });

            //init the show Sign up
            $('#show_signup').click(function() {
                $("#login").hide();
                $("#show_signup").hide();
                $("#signup").show();
            }); 

            //init the show Login
            $('#show_login').click(function() {
                $("#login").show();
                $("#show_signup").show();
                $("#signup").hide();
            }); 

            //init the Sign up
            $('#signup_submit').click(function() {
                var email = $('#email_signup').val();
                var pwd1 = $('#pwd1').val();
                var pwd2 = $('#pwd2').val();
                var tos = $(":checked").val();

                if(test_email(email)) {
                    
                    if (pwd1 == pwd2 && pwd1 != "<?php echo _("Password") ?>"){

                        if (tos == "agree"){

                            $.post('actions/user.php', {action:"signup", email: email, pwd: pwd1}, function(data){
                                if (data != ""){
                                    data = jQuery.parseJSON(data);
                                    if (data.status == 200){
                                        
                                        //User just signed up, needs to validate the e-mail address
                                        $("#verify").show()
                                                    .html("<?php echo _("Thanks for signing up! You just need to verify your e-mail address (be sure to check your spam filter). If you receive no confirmatory e-mail, please alert us at contact@Datawrapper.de") ?>");

                                    }else{
                                        error(data.error);
                                    }
                                }else{
                                    error();
                                }
                            });
                        }else{
                            error("<?php echo _("Please agree to the Terms of Use.") ?>");
                        }
                    }else{
                        error("<?php echo _("Passwords do not match.") ?>");
                    }
                }else{
                    
                    error("<?php echo _("Please enter a valid email address.") ?>");

                }
            }); 

            /* This section appears only if a password change was requested */

            <?php if (isset($_GET["new_pwd"])):?>
            
            //hides the normal signup box
            $("#signup").hide();

            //init the change pwd button that'll call the action
            $("#pwd_change_submit").click(function(){

                var email = "<?php echo $_GET["email"] ?>";
                var token = "<?php echo $_GET["new_pwd"] ?>";

                var reset_pwd1 = $('#reset_pwd1').val();
                var reset_pwd2 = $('#reset_pwd2').val();
                
                if (reset_pwd1 == reset_pwd2 && reset_pwd1 != "<?php echo _("Password") ?>"){

                    $.post('actions/user.php', {action: "pwd_change", email: email, token: token, pwd:reset_pwd1}, function(data){
                        if (data != ""){
                            data = jQuery.parseJSON(data);
                            if (data.status == 200){
                                
                                //Reminder e-mail sent, needs to choose a new pwd
                                $("#pwd_change_confirmation").show()
                                            .html("<a href='<?php echo BASE_DIR ?>'><?php echo _("Password changed. You can now login.") ?></a>");

                            }else{
                                error(data.error);
                            }
                        }else{
                            error();
                        }
                    });

                }else{
                        error("<?php echo _("Passwords do not match.") ?>");
                }

            });

            //init the confirmation message, so that it closes onlick
                $("#pwd_change_confirmation").click(function(){
                    $("#login").show();
                    $("#show_signup").show();
                    $("#new_pwd").hide();

                });
            <?php endif; ?>

            /* End password change request */

	     });
	    </script>

        <div id="container">
    	    <div id="error" style="display:none;"><?php echo _("Errors are displayed here") ?></div>

            <!-- Start header -->
        	<?php require_once "header.php" ?>
            <!-- End header -->

        	<div id="screen_container">
                <div class="divider"></div>
                <div class="login_bigtitle">Datawrapper</div>
                <p id="login_abzv"><?php printf(_("Datawrapper is a project by %sABZV%s%sa German training institution for newspaper journalists."), "<a href='http://www.abzv.de' target='_blank'>" , "</a>", "<br>") ?></p>
                <div class="beta_logo">Beta</div>
                <h1 class="login_title"><?php echo _("Open Source Data Visualization") ?></h1>
                
                <div id="about">
                    <p><?php echo _("Main features:") ?></p>
                    <ul>
                        <li><?php echo _("Simple: Create and embed charts in minutes") ?></li>
                        <li><?php echo _("Open Source: Download and install") ?></li>
                        <li><?php echo _("CSS: Change the CSS, add your logo") ?></li>
                        <li><?php echo _("Developers: Add new chart types") ?></li>
                        <li><?php echo _("Non-proﬁt: This is and will stay free to use") ?></li>
                    </ul>
                    <p><a href="#motivation" class="fancybox"><?php echo _("Why this approach? See our Motivations") ?></a></p>
                </div>


                <div id="login">
                    <div class="close_signup">[back]</div>
                    <h2><?php echo _("Login for registered users:") ?></h2>
                    <input class="login" id="email" value="<?php echo _("E-mail") ?>">
                    <input class="login" id="pwd" type="password" value="<?php echo _("Password") ?>">
                    <div id="password_forgotten"><?php echo _("Forgot your password?") ?></div>
                    <button id="login_submit" class="button"><?php echo _("Login") ?></button>

                    <input id="show_signup" type="submit" value="<?php echo _("First time user? Register here.") ?>" />
            
                </div>

                <div id="signup">
                    
                    <h2><?php echo _("Create an account on Datawrapper:") ?></h2>
                    <small><?php echo _("Enter your e-mail address") ?></small>
                    <input class="login" id="email_signup" value="<?php echo _("email@provider.tld") ?>">
                    
                    <div class="clear"></div>
                    
                    <small><?php echo _("Enter password twice") ?></small>
                    <input class="login" id="pwd1" type="password" value="<?php echo _("Password") ?>">
                    <input class="login" id="pwd2" type="password" value="<?php echo _("Password") ?>">
                    
                    <div class="clear"></div>
                    
                    <small><a href="#terms_of_use" class="fancybox"><?php echo _("I agree to the Terms of Use") ?></a></small><input type="checkbox" id="tos" value="agree">
                    
                    <div class="clear"></div>

                    <button id="signup_submit" class="button"><?php echo _("Sign up") ?></button> or <button id="show_login" class="button"><?php echo _("Log in") ?></button>
                    <div id="verify"></div>
                    
                </div>

                <div id="additional_ressources">
                        <p><?php echo _("Resources to get started:") ?></p>
                        <p><a href="#quickstart" class="fancybox"><?php echo _("Quickstart") ?></a> • <a href="#tutorial" class="fancybox"><?php echo _("Tutorial") ?></a> • <a href="#installation" class="fancybox"><?php echo _("Installation guide") ?></a>
                </div>

                <div id="reminder">
                    <div class="close_signup">[back]</div>
                    <p><?php echo _("Enter your e-mail address to reset your password.") ?></p>
                    <div class="clear"></div>
                    <input class="login" id="email_reminder" value="<?php echo _("E-mail") ?>">
                    
                    <div class="clear"></div>

                    <button id="reminder_submit" class="button"><?php echo _("Reset password") ?></button>
                    <div id="reset_confirmation"></div>
                </div>

                <!-- This section appears only if a password change was requested -->

                <?php if (isset($_GET["new_pwd"])):?>
                    
                    <div id="new_pwd">
                    
                    <div class="clear"></div>
                    
                    <small><?php echo _("Enter your new password twice") ?></small>
                    <input class="login" id="reset_pwd1" type="password" value="<?php echo _("Password") ?>">
                    <input class="login" id="reset_pwd2" type="password" value="<?php echo _("Password") ?>">
                    
                    <div class="clear"></div>

                    <button id="pwd_change_submit" class="button"><?php echo _("Change password") ?></button>
                    <div id="pwd_change_confirmation"></div>

                </div>
                <?php endif; ?>

                <!-- End password change request -->

        	</div>

            <!-- Start Footer -->
            <?php require_once "views/footer.php"; ?>