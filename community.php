<?php
include 'functions.php';
$cid = get_sanitized_string_param($_GET, 'cid');
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
   <script type="text/javascript" src="scripts/thread_sorting.js"></script>
   <script type="text/javascript" src="scripts/script.js" defer></script>
   <script type="text/javascript" src="scripts/login.js" defer></script>
   <script type="text/javascript" src="scripts/createnewthread.js"></script>
   <script type="text/javascript" src="scripts/jqueryfunctions.js"></script>
</head>

<body>

   <?php include 'header.php' ?>

   <div id="main">

      <article id="left-sidebar">
         <div id="organizethreadbuttons">
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
            <button type="button" class="button centerme" onclick="window.location.href='createthread.php?cid=<?php echo $cid; ?>'">Compose Thread</button>
            <?php } else { ?>
            <button type="button" class="button centerme" onclick="openLogin()">Compose Thread</button>
            <?php } ?>
            <div id="sorting_container">
               <button type="button" class="button">Trending</button>
               <button type="button" class="button selected">New</button>
               <button type="button" class="button">Controversial</button>
            </div>
         </div>
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

         <?php
            include 'bread_crumb_template.php';
         ?>

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
   let sortby = 'new'

   function getThreads(notify,force=false) {
      // make an AJAX call to get threads
      sortby = get_sorting()
      $.ajax({
         url: "get_threads.php?cid=<?php echo $cid ?>&sort=" + sortby,
         dataType: "json",
         success: function (data) {
            if (data.success) {
               if (threadNum < data.threads.length || force) {
                  let newThreads = (data.threads.length-threadNum)
                  let startIndex = 0
                  if(notify && !force){
                     popup("There are " + newThreads + " new thread(s)!");
                     console.log("yay")
                  }
                  threadNum = data.threads.length;
                  $("#threads .thread").parent().not("#thread_template").remove();
                  // loop through the threads array
                  for (let i = startIndex; i < data.threads.length; i++) {
                     let thread = data.threads[i];
                     let owner = my_username === thread.username
                     createNewThread(thread.tid, thread.title, thread.created, thread.cname, thread.points, thread.username, thread.threadtype,"#threads",owner,is_admin);
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

   // call the getThreads function every 5 seconds
   getThreads(false, null)
   setInterval(function(){getThreads(true)}, 5000);



</script>

</html>