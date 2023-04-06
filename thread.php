<?php include 'functions.php';
$tid = get_sanitized_int_param($_GET,'tid');
session_start();
?>
<!DOCTYPE html>
<html>

<head lang="en">
   <meta charset="utf-8">
   <title>CareerCafe - Find your passion</title>
   <link rel="shortcut icon" type="image/jpg" href="images/favicon1.png">
   <link rel="stylesheet" href="css/style.css" />
   <link rel="stylesheet" href="css/login.css" />
   <link rel="stylesheet" href="css/thread.css" />
   <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
   <script type="text/javascript" src="scripts/admin.js" defer></script>
   <script type="text/javascript" src="scripts/script.js" defer></script>
   <script type="text/javascript" src="scripts/login.js" defer></script>
   <script type="text/javascript" src="scripts/createnewthread.js"></script>
   <script type="text/javascript" src="scripts/jqueryfunctions.js"></script>
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
               $result = php_select("SELECT * FROM community WHERE industry = 'Healthcare'");
               while ($row = mysqli_fetch_assoc($result)) {
                  echo "<button type='button' style='width:100%; margin-bottom: 2px;' onclick='window.location.href=\"community.php?cid=" . $row["communityid"] . "\"' class='nobutton'>";
                  echo $row["name"];
                  echo "</button>";
               }
               ?>
            </div>
            <button type="button" class="button collapsible">Government</button>
            <div class="content background">
               <?php
               $result = php_select("SELECT * FROM community WHERE industry = 'Government'");
               while ($row = mysqli_fetch_assoc($result)) {
                  echo "<button type='button' style='width:100%; margin-bottom: 2px;' onclick='window.location.href=\"community.php?cid=" . $row["communityid"] . "\"' class='nobutton'>";
                  echo $row["name"];
                  echo "</button>";
               }
               ?>
            </div>
            <button type="button" class="button collapsible">Tech</button>
            <div class="content background">
               <?php
               $result = php_select("SELECT * FROM community WHERE industry = 'Tech'");
               while ($row = mysqli_fetch_assoc($result)) {
                  echo "<button type='button' style='width:100%; margin-bottom: 2px;' onclick='window.location.href=\"community.php?cid=" . $row["communityid"] . "\"' class='nobutton'>";
                  echo $row["name"];
                  echo "</button>";
               }
               ?>
            </div>
            <button type="button" class="button collapsible">Engineering</button>
            <div class="content background">
               <?php
               $result = php_select("SELECT * FROM community WHERE industry = 'Engineering'");
               while ($row = mysqli_fetch_assoc($result)) {
                  echo "<button type='button' style='width:100%; margin-bottom: 2px;' onclick='window.location.href=\"community.php?cid=" . $row["communityid"] . "\"' class='nobutton'>";
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
                $result = php_select_prepared("SELECT * FROM thread WHERE tid = ?", "i", $tid);
                $threadname = "";
                $username = "";
                $creationtime = "";
                $threadbody = "";
                if(mysqli_num_rows($result) > 0){
                  $row = mysqli_fetch_assoc($result);
                  $result2 = php_select("SELECT * FROM community WHERE communityid = " . $row["communityid"] . "");
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
            By <h4 class="inline nomargin"><?php echo '<a href="user.php?username=' .$username. '">' . $username . '</a>' ; ?></h2>
            at <h4 class="inline nomargin"><?php echo $creationtime; ?></h2>
            <p><?php echo $threadbody; ?></p>
            <?php 
         if(isset($_SESSION['userid']) && ($_SESSION['isAdmin'] === 1 || $_SESSION['username' ] === $username)){
            echo '<button id="delete_thread" class="button" onclick=>Delete Thread</button>';
         }
         ?>   
         </div>
      <?php
      $tid = $_GET['tid'];
      $notloggedin= "value=\"Submit Comment\"";
      if(!isset($_SESSION['userid'])){
         $notloggedin = "value=\"Not Logged In\" disabled";
      }   
      echo <<<EOD
         <form action="insertComment.php" method="post">
            <fieldset id="comment-fieldset">
               <textarea class="textinput" id="comment" name="comment" placeholder="Comment" required></textarea>
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
               include 'comment_template.php';

            ?>
         </div>
         <div class="clear"></div>

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
<script>
   <?php
   $curUsername = '';
   if (isset($_SESSION['username'])){
      $curUsername = $_SESSION['username'];
   }
   $admin = 0;
   if (isset($_SESSION['isAdmin'])){
      $admin = $_SESSION['isAdmin'];
   }
   $result = php_select("SELECT * FROM comment WHERE tid = " . $_GET['tid'] . "");
   while ($row = mysqli_fetch_assoc($result)) {
      $commentId = $row["commentid"];
      $comment = $row["comment"];
      $created = $row["created"];
      $userId = $row["userid"];
      $commentUsername = get_username_from_id($userId);
      $points = get_comment_points($commentId);
      $location = '#comments';

      // if points is undefined, set to 0
      if (!isset($points)) {
         $points = 0;
      }
      

   // createNewComment
   echo "createNewComment(" . $commentId . ",\"" . $comment . "\",\"" . $created . "\",\"" . $points . "\",\"" . $commentUsername . "\",\"" . $location . "\",\"" . $curUsername . "\",\"" . $admin . "\");";
   }

   ?>


</script>

</html>