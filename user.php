<?php
include "sql.php";
include 'security.php';
$username = get_sanitized_string_param($_GET, 'username');
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
    <script type="text/javascript" src="scripts/createnewthread.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script type="text/javascript" src="scripts/jqueryfunctions.js" defer></script>
</head>

<body>

    <?php include 'header.php' ?>

    <div id="main">

        <article id="left-sidebar">

            <div id="avatar-div">

                <figure id="avatar-fig">
                    <?php

                    if (isset($_SESSION['username'])) {
                        echo '<img src="' . $_SESSION['avatarimgpath'] . '" alt="Avatar Image">';
                        echo '<figcaption>' . $_SESSION['username'] . '</figcaption>';
                    } else {
                        $result = php_select_prepared("SELECT avatarimgpath FROM users WHERE username = ?", "s", $username);
                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $imgpath = $row['avatarimgpath'];
                            echo '<img src="' . $imgpath . '" alt="Avatar Image">';
                            echo '<figcaption>' . $username . '</figcaption>';
                        } else {
                            die();
                        }
                    }


                    ?>
                </figure>

            </div>

            <div id="description">
                <p style="padding: 5px;">
                    <?php

                    if (isset($_SESSION['description'])) {
                        echo $_SESSION['description'];
                    } else {
                        $result = php_select_prepared("SELECT description FROM users WHERE username = ?", "s", $username);
                        $row = mysqli_fetch_assoc($result);
                        echo $row['description'];
                    }
                    ?>
                </p>
            </div>

            <div id="options">

                <?php
                if (isset($_SESSION['username'])) {

                    if ($_SESSION['username'] === $username) {

                        echo '<a href="user.php?username=' . $_SESSION['username'] . '" class="button">Profile</a>';
                        echo '<a href="settings.php?"username=' . $_SESSION['username'] . '" class="button">User Settings</a>';
                        echo '<a href="logout.php" class="button">Logout</a>';
                    }

                    if ($_SESSION['isAdmin'] === 1) {
                        echo '<a href="admin.php?username=' . $_SESSION['username'] . '" class="button">Admin</a>';
                    }
                }
                ?>
            </div>




        </article>

        <article id="center">

            <div id="breadcrumb">
                <h2> <a href="#" onclick="getUserThreads('<?php echo $username ?>')">Posts </a>
                    <a href="#" onclick="getUserComments('<?php echo $username ?>')">| Comments </a>
                    | Upvoted
                    | Downvoted
                </h2>


            </div>

            <div id="threads">
                <?php include 'thread_template.php' ?>
            </div>

            <div id="comments">
                <?php include 'comment_template.php' ?>
            </div>

        </article>

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