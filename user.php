<?php
include "sql.php";
session_start();
?>
<!DOCTYPE html>
<html>

<head lang="en">
    <meta charset="utf-8">
    <title>CareerCafe - Create Account</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/form.css" />
    <link rel="stylesheet" href="css/login.css" />
    <script type="text/javascript" src="scripts/form.js" defer></script>
    <script type="text/javascript" src="scripts/script.js" defer></script>
    <script type="text/javascript" src="scripts/login.js" defer></script>
</head>

<body>

    <header id="masthead">

        <a href="index.php"><img id="logo" src="images/logo.png" alt="Career Cafe Logo"></a>
        <?php
        // Load header based on if logged in or not
        if (isset($_SESSION['loggedin'])) {
            if ($_SESSION['loggedin'] == true) {
                php_get_logged_in_header();
            }
        } else {
            php_get_header();
        } ?>
        <div id="searchContainer">
            <input id="search" type="text" placeholder="Search..">
        </div>


    </header>

    <div id="main">

        <article id="left-sidebar">

            <div id="avatar-div">

                <figure id="avatar-fig">
                    <?php

                    if (isset($_SESSION['username'])) {
                        echo '<img src="' . $_SESSION['avatarimgpath'] . '" alt="Avatar Image">';
                        echo '<figcaption>' . $_SESSION['username'] . '</figcaption>';
                    } else {
                        $result = php_select("SELECT avatarimgpath FROM users WHERE username = '" . $_GET['username'] . "'");
                        $row = mysqli_fetch_assoc($result);
                        $imgpath = $row['avatarimgpath'];
                        echo '<img src="' . $imgpath . '" alt="Avatar Image">';
                        echo '<figcaption>' . $_GET['username'] . '</figcaption>';
                    }


                    ?>
                </figure>

            </div>

            <div id="description">
                <?php

                if (isset($_SESSION['description'])) {
                    echo $_SESSION['description'];
                } else {
                    $result = php_select("SELECT description FROM users WHERE username = '" . $_GET['username'] . "'");
                    $row = mysqli_fetch_assoc($result);
                    echo $row['description'];
                }

                ?>

            </div>




        </article>

        <article id="center">

            <div id="breadcrumb">

                <h2> Posts | Comments | Saved | Upvoted | Downvoted </h2>


            </div>

            <div id="threads">

                Breadcrumb options need hrefs

                <br>

                Needs to be implemented



            </div>

    </div>




    </article>

    </div>

    <div class="form-popup" id="login-popup">

        <form id="login" method="post" action="login.php">

            <h2> Login </h2>

            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Enter Email" name="email" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" minlength="6" required>

            <button id="forgot-psw" class="button" onclick="openForgotPsw()">Forgot password?</button>

            <button type="submit" class="btn">Login</button>
            <button type="button" class="btn cancel" onclick="closeLogin()">Close</button>
        </form>
    </div>

    <div class="form-popup" id="forgotpsw-popup">

        <form id="login" method="post" action="login.php">

            <h2> Forgot password </h2>

            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Enter Email" name="email" required>

            <button type="submit" class="btn">Reset my password</button>
            <button type="button" class="btn cancel" onclick="closeForgotPsw()">Close</button>
        </form>
    </div>

    <footer>



    </footer>

</body>

</html>