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
    <link rel="stylesheet" href="css/updateform.css" />
    <script type="text/javascript" src="scripts/form.js" defer></script>
    <script type="text/javascript" src="scripts/script.js" defer></script>
    <script type="text/javascript" src="scripts/login.js" defer></script>
    <script type="text/javascript" src="scripts/createnewthread.js" defer></script>
    <script type="text/javascript" src="scripts/admin.js" defer></script>
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

                    if (isset($_SESSION['username']) && ($_SESSION['username']) == $username) {
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
                        echo '<a href="settings.php?username=' . $_SESSION['username'] . '" class="button">User Settings</a>';
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
                <h2> User Profile > Admin Features </h2>


            </div>

            <div>
                <label for="user">Choose user to edit:</label>
                <input list="users" name="user" id="user" onkeydown="search()" required>
                <datalist id="users">
                    <?php
                    $result = php_select("SELECT username FROM users");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['username'] . '">';
                    }
                    ?>
                </datalist>
                <div id="edit-fields">
                        <form action="editUser.php" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <div class="field-div">
                                    <textarea class="textinput" id="desc-input" name="desc-input" placeholder=></textarea> <br>
                                    <button type="button" class="button" id="change-desc" onclick="">Change</button>
                                </div>
                                <br>
                                <div class="field-div">
                                    <input type="text" class="textinput" id="fname" name="fname" placeholder= required> <br>
                                    <button type="button" class="button" id="change-fname" onclick="">Change</button>
                                </div>
                                <div class="field-div">
                                    <input type="text" class="textinput" id="lname" name="lname" placeholder= required> <br>
                                    <button type="button" class="button" id="change-lname" onclick="">Change</button>
                                </div>
                                <div class="field-div">
                                    <input type="email" class="textinput" id="email" name="email" placeholder= required> <br>
                                    <button type="button" class="button" id="change-email" onclick="">Change</button>
                                </div>
                                <div class="field-div">

                                    <input type="password" minlength=6 onChange="confirmPassword()" class="textinput" id="pw" name="pw" placeholder="Password" required> <br>
                                    <input type="password" minlength=6 onChange="confirmPassword()" class="textinput" id="cpw" placeholder="Confirm Password" required>
                                    <button type="button" class="button" id="change-pw" onclick="">Change</button>

                                </div>


                                <div class="clear"></div>

                                <div class="field-div">
                                    <div class="imgInput">
                                        <h4>Upload image</h4>
                                        <div id="imgWrapper">
                                            <label class="custom-file-upload">
                                                <input accept="image/*" type="file" onChange="previewFile(event)" id="img" name="img" required>
                                                ✎
                                            </label>
                                            <img id="preview" src="images/profile.png" alt="your image" />
                                        </div>
                                    </div>
                                    <button type="button" class="button" id="change-img" onclick="">Change</button>

                                </div>
                            </fieldset>

                            <br>

                        </form>


                    </div>

            </div>
    </div>

    <br>

    </form>


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