<?php include 'sql.php';?>
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
        <button type="button" class="button centerme">Compose Thread</button>
        <button type="button" class="button centerme">Trending</button>
        <button type="button" class="button centerme">New</button>
        <button type="button" class="button centerme">Controversial</button>
         <h2>Related Topics</h2>
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
                $result = php_select("SELECT * FROM Community WHERE communityid = " . $_GET["cid"] . "");
                $row = mysqli_fetch_assoc($result);

                $industry = $row["industry"];
                $name = $row["name"];

                echo "<h2> Jobs > " . $industry . " > " . $name . "</h2>"
            ?>


         </div>

         <div id="threads">

            <a href="thread.php?id=1">
               <div class="thread">

                  <figure>
                     <span class="circle"></span>
                     <img src="images/coffeecup.png" alt="coffee cup" class="overlayed">
                  </figure>

                  <div class="thread-info">

                     <h2 class="thread-name">This is why Microsoft should make more games </h1>

                        <p>
                           <span class="username">Jim (Job Searching)</span>
                           <span class="date">10:32 am</span>
                           <span class="community">/Microsoft </span>
                        </p>

                  </div>


               </div>
            </a>

            <a href="thread.php">
               <div class="thread">

                  <figure>
                     <span class="circle"></span>
                     <img src="images/bean.png" alt="coffee cup" class="overlayed">
                  </figure>

                  <div class="thread-info">

                     <h2 class="thread-name">This is why Microsoft should make more games </h1>

                        <p>
                           <span class="username">Jim (Job Searching)</span>
                           <span class="date">10:32 am</span>
                           <span class="community">/Microsoft </span>
                        </p>

                  </div>


               </div>
            </a>

            <a href="thread.php">
               <div class="thread">

                  <figure>
                     <span class="circle"></span>
                     <img src="images/spilledcup.png" alt="coffee cup" class="overlayed">
                  </figure>

                  <div class="thread-info">

                     <h2 class="thread-name">This is why Microsoft should make more games </h1>

                        <p>
                           <span class="username">Jim (Job Searching)</span>
                           <span class="date">10:32 am</span>
                           <span class="community">/Microsoft </span>
                        </p>

                  </div>


               </div>
            </a>

            <a href="thread.php">
               <div class="thread">

                  <figure>
                     <span class="circle"></span>
                     <img src="images/spilledcup.png" alt="coffee cup" class="overlayed">
                  </figure>

                  <div class="thread-info">

                     <h2 class="thread-name">This is why Microsoft should make more games </h1>

                        <p>
                           <span class="username">Jim (Job Searching)</span>
                           <span class="date">10:32 am</span>
                           <span class="community">/Microsoft </span>
                        </p>

                  </div>


               </div>
            </a>

            <a href="thread.php">
               <div class="thread">

                  <figure>
                     <span class="circle"></span>
                     <img src="images/spilledcup.png" alt="coffee cup" class="overlayed">
                  </figure>

                  <div class="thread-info">

                     <h2 class="thread-name">This is why Microsoft should make more games </h1>

                        <p>
                           <span class="username">Jim (Job Searching)</span>
                           <span class="date">10:32 am</span>
                           <span class="community">/Microsoft </span>
                        </p>

                  </div>


               </div>
            </a>

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