<?php
include "functions.php";
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
                    <a href="#" onclick="getUserUpvoted('<?php echo $username ?>')">| Upvoted </a>
                    <a href="#" onclick="getUserDownvoted('<?php echo $username ?>')">| Downvoted </a>
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

    <?php
   // if not logged in, add login/forgot pw forms
   if (!isset($_SESSION['loggedin'])) {
      include 'loginforms.php';
   }
   ?>

    <footer>



    </footer>

</body>

</html>