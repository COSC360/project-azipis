<?php include 'functions.php';
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
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script type="text/javascript" src="scripts/popup.js"></script>
   <script type="text/javascript" src="scripts/script.js" defer></script>
   <script type="text/javascript" src="scripts/login.js" ></script>
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

            <h2> Popular Threads </h2>


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
   let my_username = "<?php echo $curUser ?>";
   let is_admin = <?php echo $isAdmin ?>;
   let threadNum = 0;

   function getThreads(notify) {
      // make an AJAX call to get threads
      $.ajax({
         url: "get_threads.php?all=1",
         dataType: "json",
         success: function(data) {
            if (data.success) {
               if (threadNum < data.threads.length) {
                  let newThreads = (data.threads.length - threadNum)
                  let startIndex = threadNum
                  if (notify) {
                     popup("There are " + newThreads + " new thread(s)!");
                     console.log("yay")
                  }
                  console.log(data.threads[i])
                  threadNum = data.threads.length
                  // loop through the threads array
                  for (let i = startIndex; i < data.threads.length; i++) {
                     let thread = data.threads[i];
                     let owner = my_username === thread.username
                     createNewThread(thread.tid, thread.title, thread.created, thread.cname, thread.points, thread.username, thread.threadtype, "#threads", owner, is_admin, my_username);
                  }



               }
            } else {
               console.error("Error: ");
               console.log(data)
            }
         },
         error: function(xhr, status, error) {
            console.error(error);
         }
      });
   }

   // call the getThreads function every 5 seconds
   getThreads(false)
   setInterval(function() {
      getThreads(true)
   }, 5000);


</script>

</html>