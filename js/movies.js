$(document).ready(function(){
    function a( _callback ){
        //if we don't get any cookies
        if(getCookie("fpusername")){
            $("#account-username").text(getCookie("fpusername"));
            //Do callback
            _callback();
        }else {
            console.log("Did not have username cookie so doing slow post request (ugggh)");
            $.ajax({
                method: "POST",
                url: "./php/ajax/process.php",
                data: {
                    action: "getmyinformation",
                    sessionid: getCookie("fpcpsession")
                }
            }).done(function (data) {
                var json = jQuery.parseJSON(data);
                if (json.error != "false") {
                    alert("Sorry, something went wrong!");
                    alert(json.error);
                    //Refresh
                } else {
                    //Get data
                    var information = json.information;
                    //Set the data
                    $("#account-username").text(information.username);
                    //Set the cookie
                    setCookie("fpusername",information.username, 365 );
                    //Do callback
                    _callback();
                }
            });
        }
    }
    //Loading phase
    function begin(){
        a( function(){
            $("#loader").fadeIn("fast");
        });
    }
    //Do it
    begin();
})