<?php include 'functions.php';
$tid = get_sanitized_int_param($_GET,'tid');
session_start();

$isAdmin = 0;
$curUser = '';

if (isset($_SESSION['username'])) {
   $curUser = get_sanitized_string_param($_SESSION, 'username');
   $isAdmin = get_sanitized_int_param($_SESSION, 'isAdmin');
}
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
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script type="text/javascript" src="scripts/popup.js"></script>
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
         <?php
            include 'bread_crumb_template.php';
         ?>
      
         <div id="threads">
            <h1 class="nomargin"><?php if(isset($threadname)) {echo $threadname;} ?></h1>
            By <h4 class="inline nomargin"><?php if(isset($username)){echo '<a href="user.php?username=' .$username. '">' . $username . '</a>' ; }?></h2>
            at <h4 class="inline nomargin"><?php if(isset($formattedDate)) {echo $formattedDate; }?></h2>
            <p><?php if(isset($threadbody)) { echo $threadbody; } ?></p>
            <?php 
         if(isset($_SESSION['userid']) && ($_SESSION['isAdmin'] === 1 || $_SESSION['username' ] === $username)){
            echo '<button id="delete_thread" class="button" onclick=>Delete Thread</button>';
         }
         ?>   
         </div>
      <?php
      $tid = get_sanitized_string_param($_GET,'tid');
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
   let my_username = "<?php echo $curUser ?>";
   let is_admin = <?php echo $isAdmin ?>;

   let commentNum = 0;
   function getComments(notify) {
      // make an AJAX call to get comments
      $.ajax({
         url: "get_comments.php?tid=<?php echo $tid; ?>",
         dataType: "json",
         success: function (data) {
            if (data.success) {
               if (commentNum < data.comments.length) {
                  let newComments = (data.comments.length-commentNum)
                  let startIndex = commentNum
                  if(notify){
                     popup("There are " + newComments + " new comment(s)!");
                     console.log("yay")
                  }
                  commentNum = data.comments.length
                  // loop through the comments array
                  for (let i = startIndex; i < data.comments.length; i++) {
                     let comment = data.comments[i];
                     let owner = my_username === comment.username
                     createNewComment(comment.commentid, comment.comment, comment.created, comment.points, comment.username, '#comments', my_username, is_admin);
                  }


               }
            } else {
               console.error("Error: ");
               console.log(data)
            }
         },
         error: function (xhr, status, error) {
            console.error(error);
         }
      });
   }

   // call the getComments function every 5 seconds
   getComments(false);
   setInterval(function(){getComments(true)}, 5000);



</script>

</html>