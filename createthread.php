<?php include 'functions.php';
$cid = get_sanitized_int_param($_GET, 'cid');
session_start();
?>
<!DOCTYPE html>
<html>

<head lang="en">
   <meta charset="utf-8">
   <title>CareerCafe - Find your passion</title>
   <link rel="stylesheet" href="css/style.css" />
   <link rel="stylesheet" href="css/login.css" />
   <link rel="stylesheet" href="css/createthread.css" />
   <script type="text/javascript" src="scripts/login.js" defer></script>
</head>

<body>

   <?php include 'header.php' ?>

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
            $result2 = php_select_prepared("SELECT * FROM community WHERE communityid = ?", "i", $cid);
            $name = "";
            if (mysqli_num_rows($result2) > 0) {
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
                  <label for="title"><b>Title</b></label>
                  <textarea class="textinput" id="title" name="title" placeholder="Thread Title" required></textarea> <br>
                  <div class="type-container">
                     <label for="threadtype">Type of Thread: </label>
                     <label>
                        <input type="radio" id="discussion" name="threadtype" value="1">
                        <img src="images/coffeecup.png" alt="discussion" class="type-img">
                     </label>
                     <label for="discussion">Discussion</label>
                     <label>
                        <input type="radio" id="acclaim" name="threadtype" value="2">
                        <img src="images/bean.png" alt="acclaim" class="type-img">
                     </label>
                     <label for="acclaim">Acclaim</label>
                     <label>
                        <input type="radio" id="criticism" name="threadtype" value="3">
                        <img src="images/spilledcup.png" alt="criticism" class="type-img">
                     </label>

                     <label for="criticism">Criticism</label>
                     <!--<input type="number" class="textinput" id="threadtype" name="threadtype" placeholder="Type of Thread" required><br> -->
                  </div>
                  <textarea class="textinput" id="content" name="content" placeholder="Content of Thread" required></textarea><br>
                  <input type="text" id="communityid" name="communityid" value="<?php echo $_GET['cid'] ?>" hidden>
                  <div class="clear"></div>
                  <input type="submit" class="button" value="Post" />
               </fieldset>

               <br>

            </form>
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