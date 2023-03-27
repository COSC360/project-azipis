<?php
// TO BE IMPLEMENTED


include 'functions.php';

$error = '';

if (isset($_GET["resettoken"]) && isset($_GET["email"])) {
    $resettoken = $_GET["resettoken"];
    $email = $_GET["email"];
    $curDate = date("Y-m-d H:i:s");

    $query = "SELECT * FROM passwordreset WHERE email = ? AND resettoken = ?";
    $types = "ss";
    $result = php_select_prepared($query, $types, $email, $resettoken);
    $row = mysqli_num_rows($result);
    if ($row == "") {
        $error .= '<h2>Invalid Link</h2>
                    <p>The link is invalid/expired. Either you did not copy the correct link
                    from the email, or you have already used the key in which case it is 
                    deactivated.</p>
                    <p><a href="index.php">Click here</a> to reset password.</p>';
    } else {
        $row = mysqli_fetch_assoc($result);
        $expDate = $row['resettokenexp'];

        if ($expDate >= $curDate) {
?>
            <br />
            <form method="post" action="" name="update">
                <input type="hidden" name="action" value="update" />
                <br /><br />
                <label><strong>Enter New Password:</strong></label><br />
                <input type="password" name="pass1" maxlength="15" minlength="6" required />
                <br /><br />
                <label><strong>Re-Enter New Password:</strong></label><br />
                <input type="password" name="pass2" maxlength="15" minlength="6" required />
                <br /><br />
                <input type="hidden" name="email" value="<?php echo $email; ?>" />
                <input type="submit" value="Reset Password" />
            </form>
<?php
        } else {
            $error .= "<h2>Link Expired</h2>
<p>The link is expired. You are trying to use the expired link which 
as valid only 24 hours (1 days after request).<br /><br /></p>";
        }
    }
    if ($error != "") {
        echo "<div class='error'>" . $error . "</div><br />";
    }
} // isset email key validate end


if (isset($_POST["email"]) && isset($_POST["action"]) &&
    ($_POST["action"] == "update")
) {
    $error = "";
    $pass1 = get_sanitized_string_param($_POST,"pass1");
    $pass2 = get_sanitized_string_param($_POST,"pass2");
    $email = get_sanitized_string_param($_POST,"email");

    if ($pass1 != $pass2) {
        $error .= "<p>Password do not match, both password should be same.<br /><br /></p>";
    }
    if ($error != "") {
        echo "<div class='error'>" . $error . "</div><br />";
    } else {
        $hashed_password = password_hash($pass1, PASSWORD_DEFAULT);

        $updatePwQuery = 'UPDATE users SET password = ? WHERE email = ?';
        $pwTypes = 'ss';
        $updatePwSuccess = php_update($updatePwQuery, $pwTypes, $hashed_password, $email);

        $delTokQuery = 'DELETE from passwordreset WHERE email = ?';
        $tokTypes = 's';
        $delTokenSuccess = php_delete_prepared($delTokQuery, $tokTypes, $email);

        /*
        mysqli_query(
            getConnection(),
            "UPDATE `users` SET `password`='" . $hashed_password . "' WHERE `email`='" . $email . "';"
        );

        mysqli_query(getConnection(), "DELETE FROM `passwordreset` WHERE `email`='" . $email . "';");

        */

        echo '<div class="error"><p>Congratulations! Your password has been updated successfully.</p>
<p><a href="index.php">
Click here</a> to Login.</p></div><br />';
    }
}

?>