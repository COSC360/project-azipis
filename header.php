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
 } 

?>

<div id="searchContainer">
   <form method="get" action="search.php" style="width: 100%;">
      <input id="search" name="search" type="text" minlength="2" placeholder="Search..">
   </form>
</div>


</header>