<?php 
require 'vendor/autoload.php'; 

use CornpunchCore\Session;
use CornpunchCore\Database;
?>
<html>
<head>
    <!--Meta-->
    <meta charset="UTF-8">
    <title>CornPunch</title>
    <!-- Written by Haskell with love! This is a beta so please don't be angry-->
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <!--CSS and shit-->
    <link rel="stylesheet" href="css/main.css">
    <?php
        //include("php/includes.php");
        if($session->checkSession()){
            header("Location: movies.php");
        }
    ?>
</head>
<body>
<section class="logo">
</section>
<section class="form">
    <div class="form-wrap">
        <div class="form-logo"></div>
        <!-- Login -->
        <div class="form-default" id="form-one">
            <div class="form-elements">
                <input type="text" id="fpuid" class="form-textbox" placeholder="Facepunch Profile">
            </div>
            <!-- Accept Button! -->
            <div class="form-button">
                <a href="javascript:login.requestLogin()" id="formbutton" class="form-button-placeholder">Login</a>
            </div>
        </div>
        <!--Step 2-->
        <div class="form-default big hidden" id="form-two">
            <div class="form-elements">
                <div class="form-padding">
                    <p> Hello <b><span id="fpusername">Undefined</span>!</b></p>
                    <p style="font-size: 10" id="fpinfotext"> You are seeing this message because you have not authenticated your account
                        yet, this can either mean that your cookie ran out, or you've never logged in
                        before. It'll only take a second we promise. Please note that this is a <b>Beta!</b>
                    </p>
                    <div class="form-code" id="fpcode">
                        <a href="javascript:login.showKey()" class="big_link" target="_blank" id="fprealcode">SHOW CODE</a>
                    </div>
                    <p style="font-size: 10">Post this code on <b>your</b> facepunch profile and you'll be granted access!</p>
                </div>
                <div class="form-button" style="margin-top: 48px;">
                    <a href="javascript:login.authKey()" id="formbutton" class="form-button-placeholder">Authenticate</a>
                </div>
            </div>
        </div>
        <!-- Not Gold -->
        <div class="form-default big hidden" id="form-three">
            <div class="form-elements">
                <div class="form-padding">
                    <p> Hello! </p>
                    <p style="font-size: 10"> Sorry, but this is currently for <b>Gold Members</b> only, if you want to get access I suggest
                        sending Haskell a private message on facepunch, sorry!
                    </p>
                </div>
            </div>
        </div>
        <!--Whitelisted-->
        <div class="form-default big hidden" id="form-four">
            <div class="form-elements">
                <div class="form-padding">
                    <p> Hello <b><span id="fpusername">Undefined!</span>!</b></p>
                    <p style="font-size: 10">Even though you might be a blue member, <b>Haskell</b> has granted you access to this website,
                        be it by the kindness of his heart, or you simply bribed him with your many riches. Either way, welcome aboard champ.
                        You'll need to post this code on your profile, when you do so you'll be given access to the website. Enjoy!
                    </p>
                    <div class="form-code" id="fpcode">
                        <a href="javascript:login.showKey()" class="big_link" target="_blank" id="fprealcode">SHOW CODE</a>
                    </div>
                    <p style="font-size: 10">Post this code on <b>your</b> facepunch profile and you'll be granted access!</p>
                    <div class="form-button" style="margin-top: 48px;">
                        <a href="javascript:login.authKey()" id="formbutton" class="form-button-placeholder">Authenticate</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-default big hidden" id="form-five">
            <div class="form-elements">
                <div class="form-padding">
                    <p> You have been <b>Authenticated!</b></p>
                    <p style="font-size: 10">Well.. Looks like you got in! Press the button below to get pushed onto the next area
                        with a large wooden stick. If you love the site please consider donating! Servers don't grow on trees. Also don't worry
                        too, you won't need to authenticate for a long time, unless you clear your cookies.. then you will need too. So don't
                        do that.
                    </p>
                </div>
                <div class="form-button" style="margin-top: 49px;">
                    <a href="movies.php" class="form-button-placeholder">Take me to the movies!</a>
                </div>
            </div>
        </div>
    </div>
    <div class="form-credits">
        <p class="credits">Made by <a href="http://facepunch.com/member.php?u=595738" class="short_link">Haskell</a></p>
    </div>
</section>
</body>
<footer>
    <script src="js/cookies.js"></script>
    <script src="js/login.js"></script>
    <script>
        $(document).ready(function() {
            if( getCookie("fpkey")){
                $("#form-one").fadeOut("slow",function(){
                    $("#form-one").remove();
                    $(".form-logo").css("height", "125");
                    $(".form-wrap").css("height", "400");
                    //Set the Usernames
                    if( getCookie("fpusername") ) {
                        $("#fpusername").text(getCookie("fpusername"));
                        $("#fpinfotext").text("We've saved your key for you, so its alright to still authenticate with the same key, if that key is not working, please contact" +
                        " Haskell on facepunch, a link to his profile can be found below. If it output any errors, please bring them too.");
                    }else{
                        $("#fpusername").text("Stranger");
                        $("#fpinfotext").text("If you are seeing this, it means that it broke and chrome is not allowing cookies to be set from this domain," +
                        " if this is the case, then it is advised that you restart your computer. If that does not work, then please try reinstalling chrome.");
                    }
                    $("#form-two").fadeIn("slow", function(){
                        $("#fpcode").css("opacity", "1.0");
                    });
                })
            }
        })
    </script>
</footer>
</html>