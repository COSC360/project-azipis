<?php include 'sql.php';
session_start(); ?>
<!DOCTYPE html>
<html>

<head lang="en">
   <meta charset="utf-8">
   <title>CareerCafe - Find your passion</title>
   <link rel="stylesheet" href="css/style.css" />
   <link rel="stylesheet" href="css/login.css" />
   <script type="text/javascript" src="scripts/script.js" defer></script>
   <script type="text/javascript" src="scripts/login.js" defer></script>
   <script type="text/javascript" src="scripts/createnewthread.js"></script>
</head>

<body>

   <header id="masthead">

      <a href="index.php"><img id="logo" src="images/logo.png" alt="Career Cafe Logo"></a>
      <?php 
      // Load header based on if logged in or not
         if (isset($_SESSION['loggedin'])){
            if ($_SESSION['loggedin'] == true){
               php_get_logged_in_header();
            }
         }
          else {
            php_get_header();
       }?>
      <div id="searchContainer">
         <input id="search" type="text" placeholder="Search..">
      </div>


   </header>

   <div id="main">

      <article id="left-sidebar">
         <button type="button" class="button centerme" onclick="window.location.href='createthread.php?cid=<?php echo $_GET["cid"]; ?>'">Compose Thread</button>
         <button type="button" class="button centerme">Trending</button>
         <button type="button" class="button centerme">New</button>
         <button type="button" class="button centerme">Controversial</button>
         <h2>Related Topics</h2>
         <div class="collapsibles">
            
            

               <?php
               $result = php_select("SELECT * FROM community WHERE communityid = " . $_GET["cid"] . "");
               $row = mysqli_fetch_assoc($result);
               $industry = $row["industry"];
               
               $result1 = php_select("SELECT * FROM community WHERE industry =  '". $industry . "'");
               while ($row1 = mysqli_fetch_assoc($result1)) {
                  echo "<button type='button' class='button related' onclick='window.location.href=\"community.php?cid=" . $row1["communityid"] . "\"' >";
                  echo $row1["name"];
                  echo "</button> <br>";
               }
               ?>

            
            
         </div>
      </article>

      <article id="center">

         <div id="breadcrumb">
            <?php
            $result = php_select("SELECT * FROM Community WHERE communityid = " . $_GET["cid"] . "");
            $row = mysqli_fetch_assoc($result);

            $industry = $row["industry"];
            $community = $row["name"];

            echo "<h2> Jobs > " . $industry . " > " . $community . "</h2>"
            ?>


         </div>

         <div id="threads">
         <div id="thread_template" class="relative" hidden>
               <a class="thread" href="">

                  <figure>
                     <span class="circle"></span>
                     <img src="images/coffeecup.png" alt="coffee cup" class="overlayed">
                  </figure>

                  <div class="thread-info">

                     <h2 class="thread-name"></h2>

                        <p>
                           <span class="username"></span>
                           <span class="date"></span>
                           <span class="community"></span>
                        </p>

                  </div>


            </a>
               <div class="points">
                  <form action="vote.php" method="post"></form>
                     <button>^</button>
                     <p class="pointnum">0</p>
                     <button>v</button>
                  </div>
            </div>
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

      <form id="login" method="get" action="resetpsw.php">

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

<script>
   <?php
   $result = php_select("SELECT * FROM Thread WHERE communityid = " . $_GET["cid"] . " ORDER BY created DESC");
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