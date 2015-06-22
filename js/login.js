var login = {
    requestLogin: function() {
        if ($("#fpuid").val() == "") {
            $(".form-wrap").effect("shake");
            $("#fpuid").css("border", "1px solid red");
            //Return
            return false;
        }
        $("#formbutton").text("Working...")
        //New post request
        $.ajax({
            method: "POST",
            url: "./php/ajax/process.php",
            data: {
                action: "login",
                facepunchurl: $("#fpuid").val()
            }
        })
            .done(function(data) {
                var json = jQuery.parseJSON(data)
                //If we have an error
                if (json.error != "false") {
                    if (json.error != "not gold") {
                        $("#formbutton").text(json.error + "( Try Again?)")
                        return false
                    } else {
                        $("#form-one").fadeOut("slow", function() {
                            $("#form-one").remove();
                            $(".form-logo").css("height", "125");
                            $(".form-wrap").css("height", "400");
                            //Set the Usernames
                            $("#fpusername").text(json.username);
                            $("#form-three").fadeIn("slow");
                        })

                        return false;
                    }
                } else {
                    $("#form-one").fadeOut("slow", function() {
                        $("#form-one").remove();
                        $(".form-logo").css("height", "125");
                        $(".form-wrap").css("height", "400");
                        //Set the Usernames
                        if (json.membership != "normal") {
                            $("#form-three").remove();
                            $("#form-four").remove();
                            $("#fpusername").text(json.username);
                            $("#form-two").fadeIn("slow", function() {
                                $("#fpcode").css("opacity", "1.0");
                            });
                        } else {
                            $("#form-two").remove();
                            $("#form-three").remove();
                            $("#fpusername").text(json.username);
                            $("#form-four").fadeIn("slow", function() {
                                $("#fpcode").css("opacity", "1.0");
                            });
                        }
                    })

                    //Put the key into cookies, as well as other values
                    setCookie("fpkey", json.authenticationkey, 365);
                    setCookie("fpid", json.userid, 365);
                    setCookie("fpusername", json.username, 365);

                    //Check for the cookie
                    if( !getCookie( "fpkey" )){
                        $("#fprealcode").text("CP:" + json.authenticationkey);
                        $("#fprealcode").attr("href", "http://facepunch.com/member.php?u=" + getCookie("fpid"))
                    }
                }
            });
    },
    showKey: function() {
        if( getCookie("fpkey")) {
            $("#fprealcode").text("CP:" + getCookie("fpkey"));
            $("#fprealcode").attr("href", "http://facepunch.com/member.php?u=" + getCookie("fpid"))
        }
    },

    authKey: function() {
        $("#formbutton").text("Working...")
        $.ajax({
            method: "POST",
            url: "./php/ajax/process.php",
            data: {
                action: "auth",
                key: getCookie("fpkey")
            }
        })
            .done(function(data) {
                var json = jQuery.parseJSON(data);
                if (json.error != "false") {
                    //Trash cookies
                    setCookie("fpkey", "", -10)
                    setCookie("fpid", "", -10)
                    setCookie("fpusername", "", -10)
                    //Failed!
                    $("#formbutton").text(json.error + ". (Click to retry)");
                    $("#formbutton").attr("href", "javascript:window.location.reload()");
                    //Return false
                    return false
                }
                $("#formbutton").text("Authenticated!")
                $("#form-two").remove();
                $("#form-four").remove();
                $("#form-five").fadeIn("slow", function() {

                });
            });
    }
}

