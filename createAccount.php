<?php include 'functions.php';
session_start();
?>
<!DOCTYPE html>
<html>

<head lang="en">
   <meta charset="utf-8">
   <title>CareerCafe - Create Account</title>
   <link rel="stylesheet" href="css/style.css" />
   <link rel="stylesheet" href="css/form.css" />
   <link rel="stylesheet" href="css/login.css" />
   <script type="text/javascript" src="scripts/form.js" defer></script>
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

            <h2> Create Account </h2>


         </div>

         <div id="threads">
            <form action="insertUser.php" method="post" enctype="multipart/form-data">
               <fieldset>
                  <input type="text" class="textinput" id="fname" name="fname" placeholder="First Name" required>
                  <input type="text" class="textinput" id="lname" name="lname" placeholder="Last Name" required>
                  <input type="text" class="textinput" id="username" name="username" placeholder="User name" required>
                  <input type="email" class="textinput" id="email" name="email" placeholder="Email" required> <br>
                  <input type="password" minlength=6 onChange="confirmPassword()" class="textinput" id="pw" name="pw" placeholder="Password" required>
                  <input type="password" minlength=6 onChange="confirmPassword()" class="textinput" id="cpw" placeholder="Confirm Password" required>
                  <div class="clear"></div>
                  <div class="imgInput">
                     <h4>Upload image</h4>
                     <div id="imgWrapper">
                        <label class="custom-file-upload">
                           <input accept="image/*" type="file" onChange="previewFile(event)" id="img" name="img" required>
                           ✎
                        </label>
                        <img id="preview" src="images/profile.png" alt="your image"/>
                     </div>
                  </div>
                  <input type="submit" onClick="submitAttempt()" class="button"/>
               </fieldset>

               <br>

            </form>


            </div>

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

</html>