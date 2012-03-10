<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>OAuth 2.0 CodeIgniter Library</title>
        <meta name="description" content="">
        <meta name="author" content="">
    </head>

    <body >
<?php
        if ($logged_user) {

             echo '<div id="user-connect" class="grid_12">

    <div id="user-connect-choice" ><a href="#" id="see-user-profil">Name</a> | <a href="' . base_url() . 'login/logout" id="logout">Logout</a></div>

</div>';
                        } else {


                            if (!$logged_fb && !$twitter_islogged && !$logged_user) {

                                echo '<div id="user-connect" class="grid_12">
    
    <div id="user-connect-choice" ><a href="#" id="register">Register</a> | <a href="#" id="connect">Login</a></div>
    
</div>';
                            }
                        }
                        ?>

                        <?php
                        //TWITTER INFO PROFIL/ERROR
                        
                        if($twitter_islogged){
                             echo $twitter_user->screen_name . ", you are logged with your twitter account";
                        }
                        
                        if ($twitter_error != null) {

                            echo $twitter_error;
                        }
                        
                        
                        ?>






                        <?php if ($logged_fb) {
                            ?>
                            <div id="user-connect" class="grid_12">
                                <div id="user-connect-choice" >

                                    <?php
                                    //FB INFO PROFIL
                                    print print_r($fb_user);
                                    echo '<img src="https://graph.facebook.com/'
                                    . $user . '/picture" alt="profil image">';
                                    ?>
                                    
                                    
                                    <a href='<?php echo $base_url_logout; ?>'>Logout Facebook</a>

                                </div>
                            </div>

                            <?php
                        } elseif (!$twitter_islogged) {
                            ?>

                            
                            <div id="user-connect-dialog"  title="Connexion" style="overflow:hidden;">

                                <div id="user-connect-left"  >

                                    <form action="<?php echo base_url() . 'login/validate_user'; ?>" method="post">

                                        <div class="control-group">
                                            <label class="control-label" for="form-co-pseudo">Pseudo : </label>
                                            <div class="controls">
                                                <input id="form-co-pseudo" class="input-xlarge focused" name="pseudo" type="text"  >
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="form-co-mdp">Mot de passe : </label>
                                            <div class="controls">
                                                <input id="form-co-mdp" class="input-xlarge focused" name="pwd" type="password" >
                                            </div>
                                        </div>



                                        <input type="submit" class="btn btn-primary" name="user_co" value="Login"  >

                                    </form>

                                </div>

                                <div id="user-connect-right" >
                                        OR <br />
                                   <div id="fb-auth" class="fb-login-button">Login with Facebook</div>


                                    <!-- FB CODE -->
                                    <div id="fb-root"></div>
                                    <script>
                                        window.fbAsyncInit = function() {

                                            FB.init({
                                                appId: '<?= $appkey ?>',
                                                cookie: true,
                                                xfbml: true,
                                                oauth: true,
                                                status: true

                                            });

                                            function updateButton(response) {

                                                var button = document.getElementById('fb-auth');

                                                if (response.authResponse) {
                                                    /*user is already logged in and connected
                                                var userInfo = document.getElementById('user-info');
                                                FB.api('/me', function(response) {
                                                    userInfo.innerHTML = '<img src="https://graph.facebook.com/'
                                                        + response.id + '/picture">' + response.name;
                                                    button.innerHTML = 'Logout';
                                                });*/

                                                    button.onclick = function() {
                                                        /*FB.logout(function(response) {
                                                        var userInfo = document.getElementById('user-info');
                                                        userInfo.innerHTML="";
                                                    });*/
                                                        window.location = "<?= $base_url_login ?>";
                                                    };
                                                }
                                                else {
                                                    //user is not connected to your app or logged out

                                                    button.onclick = function() {
                                                        FB.login(function(response) {
                                                            if (response.authResponse) {

                                                                window.location = "<?= $base_url_login ?>";
                                                            } else {
                                                                //user cancelled login or did not grant authorization
                                                            }
                                                        }, {scope:'email,user_about_me,publish_stream'});
                                                    }
                                                }
                                            }

                                            // run once with current status and whenever the status changes
                                            FB.getLoginStatus(updateButton);
                                            FB.Event.subscribe('auth.statusChange', updateButton);

                                        };

                                        (function() {
                                            var e = document.createElement('script'); e.async = true;
                                            e.src = document.location.protocol
                                                + '//connect.facebook.net/en_US/all.js';
                                            document.getElementById('fb-root').appendChild(e);
                                        }());


                                    </script>

                                    <!-- END OF FB CODE   -->
                                    <br /><br />

                                    <div id="twitter-signin-box">
                                        <a href="<?php echo base_url() . 'login/twitter'; ?>" id="twitter-signin"><span>Login with Twitter</span></a>


                                    </div>

                                </div>
                            </div>

                        <?php } ?>

        
    </body>
</html>
