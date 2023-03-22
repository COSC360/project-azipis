<?php include 'sql.php'; ?>
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

   <header id="masthead">

      <a href="index.php"><img id="logo" src="images/logo.png" alt="Career Cafe Logo"></a>
      <div class="btn-group">
         <a href="#" class="button" onclick="openLogin()">Login</a>
         <a href="createAccount.php" class="button">Create Account</a>
      </div>
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
            $name = $row["name"];

            echo "<h2> Jobs > " . $industry . " > " . $name . "</h2>"
            ?>


         </div>

         <div id="threads">
            <a id="thread_template" href="" hidden>
               <div class="thread">

                  <figure>
                     <span class="circle"></span>
                     <img src="images/coffeecup.png" alt="coffee cup" class="overlayed">
                  </figure>

                  <div class="thread-info">

                     <h2 class="thread-name">
                        </h1>

                        <p>
                           <span class="username"></span>
                           <span class="date"></span>
                           <span class="community"></span>
                        </p>

                  </div>


               </div>
            </a>

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

<script>
   function createNewThread(tid, title, created, points) {
      var newThread = document.querySelector("#thread_template").cloneNode(true);
      newThread.id = "";
      newThread.href = "thread.php?tid=" + tid;
      newThread.hidden = false;
      newThread.querySelector(".thread-name").innerText = title;
      newThread.querySelector(".date").innerText = created;
      //newThread.querySelector(".username").value = user;
      //newThread.querySelector("#points").value = points;
      document.querySelector("#threads").appendChild(newThread);
   }
   <?php
   $result = php_select("SELECT * FROM Thread WHERE communityid = " . $_GET["cid"] . " ORDER BY created DESC");
   while ($row = mysqli_fetch_assoc($result)) {
      $tid = $row["tid"];
      $title = $row["title"];
      $created = $row["created"];
      $points = $row["points"];
      echo "createNewThread(" . $tid . ",\"" . $title . "\",\"" . $created . "\",\"" . $points . "\");";
   }
   ?>
</script>

</html>