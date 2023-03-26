<?php 
include 'functions.php';
$cid = get_sanitized_string_param($_GET,'cid');
session_start(); ?>
<!DOCTYPE html>
<html>

<head lang="en">
   <meta charset="utf-8">
   <title>CareerCafe - Find your passion</title>
   <link rel="stylesheet" href="css/style.css" />
   <link rel="stylesheet" href="css/login.css" />
   <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
   <script type="text/javascript" src="scripts/script.js" defer></script>
   <script type="text/javascript" src="scripts/login.js" defer></script>
   <script type="text/javascript" src="scripts/createnewthread.js"></script>
   <script type="text/javascript" src="scripts/jqueryfunctions.js"></script>
</head>

<body>

<?php include 'header.php'?>

   <div id="main">

      <article id="left-sidebar">
         <button type="button" class="button centerme" onclick="window.location.href='createthread.php?cid=<?php echo $cid; ?>'">Compose Thread</button>
         <button type="button" class="button centerme">Trending</button>
         <button type="button" class="button centerme">New</button>
         <button type="button" class="button centerme">Controversial</button>
         <h2>Related Topics</h2>
         <div class="collapsibles">
            
            

               <?php
               $result = php_select_prepared("SELECT * FROM community WHERE communityid = ?","i",$cid);
               if(mysqli_num_rows($result) > 0){
                  $row = mysqli_fetch_assoc($result);
                  $industry = $row["industry"];
                  
                  $result1 = php_select_prepared("SELECT * FROM community WHERE industry =  ?","s",$industry);
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
            $result = php_select_prepared("SELECT * FROM Community WHERE communityid = ?","i",$cid);
            if(mysqli_num_rows($result) > 0){
               $row = mysqli_fetch_assoc($result);

               $industry = $row["industry"];
               $community = $row["name"];

               echo "<h2> Jobs > " . $industry . " > " . $community . "</h2>";
            }
            ?>


         </div>

         <div id="threads">
            <?php include 'thread_template.php' ?>
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
   $result = php_select_prepared("SELECT * FROM Thread WHERE communityid = ?","i",$cid);
   while ($row = mysqli_fetch_assoc($result)) {
         $tid = $row["tid"];
         $title = $row["title"];
         $created = $row["created"];
         $points = $row["points"];
         $user = $row["userid"];
         $type = $row["threadtype"];
      echo "createNewThread(" . $tid . ",\"" . $title . "\",\"" . $created . "\",\"" . $community . "\",\"" . $points . "\",\"" . $user . "\",\"" . $type . "\");";
   }
   ?>
</script>

</html>