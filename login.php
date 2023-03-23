<?php

// Initialize session
session_start();

require_once "sql.php";

$email = $psw = "";
$email_err = $psw_err = $login_err = "";


$conn = getConnection();


// If data is POST
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if (empty(trim($_POST["email"]))){
        $email_err = "Please enter email";
    } else {
        $email = trim($_POST["email"]);
    }


    // Check if password is empty
    if (empty(trim($_POST["psw"]))){
        $psw_err = "Please enter password";
    } else {
        $psw = trim($_POST["psw"]);
    }

    // validate login
    if (empty($email_err) && empty($psw_err)){
        $sql = "SELECT * FROM users WHERE email = ?";

        if ($stmt = mysqli_prepare($conn, $sql)){
            // Bind variable to prepared statement as parameter
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            $param_email = $email;

            // Attempt to execute prepared statement
            if(mysqli_stmt_execute($stmt)){

                //store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes verify password
                if(mysqli_stmt_num_rows($stmt) == 1){

                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $uid, $username, $email, $hashed_psw, $desc, $av_img_path, $fname, $lname, $admin);

                    if(mysqli_stmt_fetch($stmt)){

                        if (password_verify($psw, $hashed_psw)){

                            // Password is correct, start a new session
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["uid"] = $uid;
                            $_SESSION["username"] = $username;
                            $_SESSION["email"] = $email;
                            $_SESSION["description"] = $desc;
                            $_SESSION["avatarimgpath"] = $av_img_path;
                            $_SESSION["firstname"] = $fname;
                            $_SESSION["lastname"] = $lname;
                            $_SESSION['isAdmin'] = $admin;

                            header("Location: index.php");

                        } else {
                            
                            // Password invalid, display error message
                            $login_err = "Invalid email or password. (PASSWORD)";
                            echo $login_err;

                        }

                    }

                } else {

                    // Username doesn't exist, display error message
                    $login_err = "Invalid email or password. (EMAIL)";
                    echo $login_err;

                }


            } else {
                echo "Something went wrong. Please try again.";
            }

            mysqli_stmt_close($stmt);

        }

    }

    mysqli_close($conn);

}

?>