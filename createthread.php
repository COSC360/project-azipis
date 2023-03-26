<?php include 'functions.php';
$cid = get_sanitized_int_param($_GET,'cid');
session_start();
?>
<!DOCTYPE html>
<html>

<head lang="en">
   <meta charset="utf-8">
   <title>CareerCafe - Find your passion</title>
   <link rel="stylesheet" href="css/style.css" />
   <link rel="stylesheet" href="css/login.css" />
   <script type="text/javascript" src="scripts/script.js" defer></script>
   <script type="text/javascript" src="scripts/login.js" defer></script>
</head>

<body>

   <?php include 'header.php'?>

   <div id="main">

      <article id="left-sidebar">
      <h2>Related Topics</h2>
         <div class="collapsibles">



            <?php
            $result = php_select_prepared("SELECT * FROM community WHERE communityid = ?", "i", $cid);
            if (mysqli_num_rows($result) > 0) {
               $row = mysqli_fetch_assoc($result);
               $industry = $row["industry"];

               $result1 = php_select_prepared("SELECT * FROM community WHERE industry =  ?", "s", $industry);
               while ($row1 = mysqli_fetch_assoc($result1)) {
                  echo "<button type='button' class='button related' onclick='window.location.href=\"community.php?cid=" . $row1["communityid"] . "\"' >";
                  echo $row1["name"];
                  echo "</button> <br>";
               }
            }
            ?>



         </div>
      </article>

      <article id="center">

         <div id="breadcrumb">
            <?php
                $result2 = php_select_prepared("SELECT * FROM Community WHERE communityid = ?","i",$cid);
                $name = "";
                if(mysqli_num_rows($result2) > 0){
                  $row2 = mysqli_fetch_assoc($result2);

                  $industry = $row2["industry"];
                  $name = $row2["name"];

                  echo "<h2> Jobs > " . $row2["industry"] . " > " . $row2["name"] . "</h2>";
                }
            ?>


         </div>

         <div id="threads">
            <h1><?php echo "<b> New Post </b> in <b>" . $name . "</b>"; ?></h1>
            <form action="insertThread.php" method="post">
               <fieldset>
                  <input type="text" class="textinput" id="title" name="title" placeholder="Thread Title" required>
                  <input type="number" class="textinput" id="threadtype" name="threadtype" placeholder="Type of Thread" required>
                  <input type="text" class="textinput" id="content" name="content" placeholder="Content of Thread" required>
                  <input type="text" id="communityid" name="communityid" value="<?php echo $_GET['cid'] ?>"  hidden>
                  <div class="clear"></div>
                  <input type="submit" class="button"/>
               </fieldset>

               <br>

            </form>
         </div>


      </article>

   </div>

   <div class="form-popup" id="login-popup">

      <form id="login" method="get" action="login.php">

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

      <form id="login" method="get" action="login.php">

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