<?php

function pre($t) {

    echo htmlentities($t);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>OAuth 2.0 CodeIgniter Library</title>
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <script  src="http://code.jquery.com/jquery-1.7.min.js" ></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/prettify/prettify.js"></script>

        <!-- Le styles -->
        <link href="<?php echo base_url(); ?>assets/js/prettify/prettify.css" type="text/css" rel="stylesheet" />
        <link rel="stylesheet" href="http://twitter.github.com/bootstrap/1.4.0/bootstrap.min.css">
        <style type="text/css">
            /* Override some defaults */
            html, body {
                background-color: #eee;
            }
            body {
                padding-top: 40px; /* 40px to make the container go all the way to the bottom of the topbar */
            }
            .container > footer p {
                text-align: center; /* center align it with the container */
            }
            .container {
                width: 820px; /* downsize our container to make the content feel a bit tighter and more cohesive. NOTE: this removes two full columns from the grid, meaning you only go to 14 columns and not 16. */
            }

            /* The white background content wrapper */
            .content {
                background-color: #fff;
                padding: 20px;
                margin: 0 -20px; /* negative indent the amount of the padding to maintain the grid system */
                -webkit-border-radius: 0 0 6px 6px;
                -moz-border-radius: 0 0 6px 6px;
                border-radius: 0 0 6px 6px;
                -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
            }

            /* Page header tweaks */
            .page-header {
                background-color: #f5f5f5;
                padding: 20px 20px 10px;
                margin: -20px -20px 20px;
            }

            /* Styles you shouldn't keep as they are for displaying this base example only */
            .content .span10,
            .content .span4 {
                min-height: 500px;
            }
            /* Give a quick and non-cross-browser friendly divider */
            .content .span4 {
                margin-left: 0;
                padding-left: 19px;
                border-left: 1px solid #eee;
            }

            .topbar .btn {
                border: 0;
            }



        </style>


    </head>

    <body onload="prettyPrint()">

        <div class="topbar">
            <div class="fill">
                <div class="container">
                    <a class="brand" href="auth.php">OAuth 2.0 CodeIgniter</a>

                    <ul class="nav">

                        <li class="active"><a href="http://codeigniter.com/user_guide/" target="_blank">CodeIgniter Docs</a></li>
                    </ul>

                </div>
            </div>
        </div>

        <div class="container">

            <div class="content">
                <div class="page-header">
                    <h1>  <img  src="<?php echo base_url() . "assets/img/oauth-2-sm.png" ?>" width="80px" alt="logo" /><img  src="<?php echo base_url() . "assets/img/ci.png" ?>"  alt="logo" /> <small>by <a href="http://perrot-julien.fr">Perrot julien</a></small></h1>
                </div>
                <div class="row">
                    <div class="span14">

                        <ul>
                            <li>1- Create in config folder : Twitter & facebook file with api and secret keys</li>
                            <li>2 - Change The autoload file : <pre class="prettyprint lang-php"> <?php pre(' <?php $autoload["config"] = array("facebook", "twitter"); ?>'); ?></pre></li>
                            <li>3 - Create twitter and facebook folder in librairies and download the php sdk resources</li>
                            <li>4 - Create fb_connect and twitter_connect class in librairies folder</li>
                            <li>5 - Load in the autoload fb & twitter librairies</li>
                            <li>6 - Create a crontroller Login, this file can call fb/twitter or normal connection</li>
                            <li>7 - Set the init fb/twitter in the main page</li>
                            <li>8 - Set the form connection</li>
                        </ul>

                        <?php
                        if ($logged_user) {

                            echo '<div id="user-connect" class="grid_12">

    <div id="user-connect-choice" ><a href="#" id="see-user-profil">Name</a> | <a href="' . base_url() . 'login/logout" id="logoff">Logout</a></div>

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
                             echo $twitter_user->screen_name . ", vous êtes identifié avec votre compte twitter.";
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

                        <br />
                    </div>
                </div>
            </div>

            <footer>
                <p>&copy; Perrot Julien 2012</p>

            </footer>

        </div> <!-- /container -->

    </body>
</html>
