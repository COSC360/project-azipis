<?php include 'sql.php';
include 'security.php';
$tid = get_sanitized_int_param($_GET,'tid');
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
         <h2>Popular Communities</h2>
         <div class="collapsibles">
            <button type="button" class="button collapsible">Healthcare</button>
            <div class="content background">
               <?php
               $result = php_select("SELECT * FROM Community WHERE industry = 'Healthcare'");
               while ($row = mysqli_fetch_assoc($result)) {
                  echo "<button type='button' onclick='location.href=/industry.php'class='nobutton'>";
                  echo $row["name"];
                  echo "</button>";
               }
               ?>
            </div>
            <button type="button" class="button collapsible">Government</button>
            <div class="content background">
            <?php
               $result = php_select("SELECT * FROM Community WHERE industry = 'Government'");
               while ($row = mysqli_fetch_assoc($result)) {
                  echo "<button type='button' onclick='location.href=/industry.php'class='nobutton'>";
                  echo $row["name"];
                  echo "</button>";
               }
               ?>
            </div>
            <button type="button" class="button collapsible">Tech</button>
            <div class="content background">
            <?php
               $result = php_select("SELECT * FROM Community WHERE industry = 'Tech'");
               while ($row = mysqli_fetch_assoc($result)) {
                  echo "<button type='button' onclick='location.href=/industry.php'class='nobutton'>";
                  echo $row["name"];
                  echo "</button>";
               }
               ?>
            </div>
            <button type="button" class="button collapsible">Engineering</button>
            <div class="content background">
            <?php
               $result = php_select("SELECT * FROM Community WHERE industry = 'Engineering'");
               while ($row = mysqli_fetch_assoc($result)) {
                  echo "<button type='button' onclick='location.href=/industry.php'class='nobutton'>";
                  echo $row["name"];
                  echo "</button>";
               }
               ?>
            </div>
         </div>
      </article>

      <article id="center">

         <div id="breadcrumb">
            <?php
                $result = php_select_prepared("SELECT * FROM Thread WHERE tid = ?", "i", $tid);
                $threadname = "";
                $username = "";
                $creationtime = "";
                $threadbody = "";
                if(mysqli_num_rows($result) > 0){
                  $row = mysqli_fetch_assoc($result);
                  $result2 = php_select("SELECT * FROM Community WHERE communityid = " . $row["communityid"] . "");
                  $row2 = mysqli_fetch_assoc($result2);

                  $industry = $row2["industry"];
                  $name = $row2["name"];
                  $threadname = $row["title"];
                  $threadbody = $row["content"];
                  $creationtime = $row["created"];
                  $username = get_username_from_id($row["userid"]);

                  echo "<h2> Jobs > " . $row2["industry"] . " > <a href='community.php?cid=" . $row["communityid"] . "'>" . $row2["name"] . "</a></h2>";
                } else {
                  die();
                }
            ?>


         </div>

         <div id="threads">
            <h1 class="nomargin"><?php echo $threadname; ?></h1>
            By <h4 class="inline nomargin"><?php echo $username; ?></h2>
            at <h4 class="inline nomargin"><?php echo $creationtime; ?></h2>
            <p><?php echo $threadbody; ?></p>
         </div>
      <?php
      $tid = $_GET['tid'];
      $notloggedin= "value=\"Submit Comment\"";
      if(!isset($_SESSION['uid'])){
         $notloggedin = "value=\"Not Logged In\" disabled";
      }   
      echo <<<EOD
         <form action="insertComment.php" method="post">
            <fieldset>
               <input type="text" class="textinput" id="comment" name="comment" placeholder="Comment" required>
               <input type="text" id="tid" name="tid" value="$tid" hidden>
               <div class="clear"></div>
               <input type="submit" class="button" $notloggedin/>
            </fieldset>

            <br>

         </form>
         EOD;
         ?>
         <div id="comments">
            <?php
               $result = php_select("SELECT * FROM Comment WHERE tid = " . $_GET['tid'] . "");
               while ($row = mysqli_fetch_assoc($result)) {
                  echo "<div class='comment'>";
                  echo "<h4 class='author inline'>";
                  echo get_username_from_id($row["userid"]);
                  echo "</h4> at ";
                  echo "<h4 class='date inline'>";
                  echo $row["created"];
                  echo "</h4>";
                  echo "<p class='content'>";
                  echo $row["comment"];
                  echo "</p>";
                  echo "</div>";
               }
            ?>
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