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
                $result2 = php_select("SELECT * FROM Community WHERE communityid = " . $_GET['id'] . "");
                $row2 = mysqli_fetch_assoc($result2);

                $industry = $row2["industry"];
                $name = $row2["name"];

                echo "<h2> Jobs > " . $row2["industry"] . " > " . $row2["name"] . "</h2>"
            ?>


         </div>

         <div id="threads">
            <h1><?php echo "<b> New Post </b> in <b>" . $name . "</b>"; ?></h1>
            <form action="insertThread.php" method="post">
               <fieldset>
                  <input type="text" class="textinput" id="title" name="title" placeholder="Thread Title" required>
                  <input type="number" class="textinput" id="threadtype" name="threadtype" placeholder="Type of Thread" required>
                  <input type="text" class="textinput" id="content" name="content" placeholder="Content of Thread" required>
                  <input type="text" id="communityid" name="communityid" value="<?php echo $_GET['id'] ?>"  hidden>
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