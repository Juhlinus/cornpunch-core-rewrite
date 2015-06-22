<html>
<head>
    <meta charset="UTF-8">
    <title>CornPunch</title>
    <!-- Written by Haskell with love! This is a beta so please dont be angry-->
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <style type="text/css"></style>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <!--CSS and shit-->
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/movies.css">
</head>
<body>
<div id="loader" style="display: block;">
    <section class="nav-bar">
        <div class="nav-logo"></div>
        <div class="nav-options">
            <ul>
                <li id="movies-tab">
                    <a style="font-size: 20">Movies</a>
                    <ul>
                        <li><a href="#">New Movies</a></li>
                    </ul>
                </li>
                <li>
                    <a style="font-size: 20;" id="music-tab">Music</a>
                    <ul>
                        <li><a href="#">New Music</a></li>
                    </ul>
                </li>
                <li>
                    <a style="font-size: 20" id="games-tab">Games</a>
                    <ul>
                        <li><a href="#">New Games</a></li>
                    </ul>
                </li>
                <li>
                    <a style="font-size: 20" id="porn-tab">Porn</a>
                    <ul>
                        <li><a href="#">New Porn</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div style="float: right; width: 10%;" class="nav-options">
            <ul style="
                  width: 90%;
                  /* overflow-x: hidden; */
                  ">
                <li id="account-tab" style="
                     width: 100%;
                     ">
                    <a id="account-username" style="font-size: 20;float: right;">Undefined</a>
                    <ul style="
                        position: relative;
                        width: 100%;
                        left: 78%;
                        ">
                        <li><a href="#">Upload</a></li>
                        <li><a href="#">Settings</a></li>
                        <li><a href="#">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </section>
    <section class="movie-display">
    </section>
</div>
<script src="js/cookies.js"></script>
<script src="js/movies.js"></script>
</body>
</html>