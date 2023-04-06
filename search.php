<?php include 'functions.php';
session_start();
$search_param = get_sanitized_string_param($_GET,'search');
?>
<!DOCTYPE html>
<html>

<head lang="en">
   <meta charset="utf-8">
   <title>CareerCafe - Find your passion</title>
   <link rel="shortcut icon" type="image/jpg" href="images/favicon1.png">
   <link rel="stylesheet" href="css/style.css" />
   <link rel="stylesheet" href="css/login.css" />
   <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
   <script type="text/javascript" src="scripts/script.js" defer></script>
   <script type="text/javascript" src="scripts/login.js" defer></script>
   <script type="text/javascript" src="scripts/createnewthread.js"></script>
   <script type="text/javascript" src="scripts/jqueryfunctions.js"></script>
</head>

<body>

   <?php include 'header.php' ?>
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
            $param1 = "%{$search_param}%";
            $types = "s";
            $result = php_select_prepared("SELECT * FROM thread WHERE title LIKE ?",$types,$param1);
            echo '<h2> Thread Results - ' . mysqli_num_rows($result) . ' users(s) found</h2>'
         ?>

         </div>
         <div id="threads">
            <?php include 'thread_template.php' ?>
         </div>
         <div id="breadcrumb">
         <?php 
            $param1 = "%{$search_param}%";
            $types = "s";
            $result2 = php_select_prepared("SELECT * FROM users WHERE username LIKE ?",$types,$param1);
            echo '<h2> Thread Results - ' . mysqli_num_rows($result2) . ' users(s) found</h2>'
               ?>
         </div>
         <div id="users">
            <?php include 'user_template.php' ?>
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
<script>
   <?php
   while ($row = mysqli_fetch_assoc($result)) {
      $communityResult = php_select("SELECT * FROM community WHERE communityid = " . $row["communityid"]);
      $community = mysqli_fetch_assoc($communityResult)["name"];
      $tid = $row["tid"];
      $title = $row["title"];
      $created = $row["created"];
      $points = get_thread_points($tid);
      $user = get_username_from_id($row["userid"]);
      $type = $row["threadtype"];
      echo "createNewThread(" . $tid . ",\"" . $title . "\",\"" . $created . "\",\"" . $community . "\",\"" . $points . "\",\"" . $user . "\",\"" . $type . "\");";
   }

   while ($row2 = mysqli_fetch_assoc($result2)) {
      if (isset($row2["userid"])) {
         $userid = $row2["userid"];
         $username = get_username_from_id($row2["userid"]);
         $imgpath = $row2["avatarimgpath"];
         $description = $row2["description"];
         echo "createNewUserEntry(" . $userid . ",\"" . $username . "\",\"" . $imgpath . "\",\"" . $description . "\");";
      }
   }
   ?>
</script>

</html>