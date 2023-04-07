<div id="breadcrumb">


    <?php
    require_once 'functions.php';
    $tid = get_sanitized_int_param($_GET, "tid");
    $cid = get_sanitized_int_param($_GET, "cid");

    if ($tid != 0) {
        $result = php_select_prepared("SELECT * FROM thread WHERE tid = ?", "i", $tid);
        $threadname = "";
        $username = "";
        $creationtime = "";
        $threadbody = "";
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $result2 = php_select("SELECT * FROM community WHERE communityid = " . $row["communityid"] . "");
            $row2 = mysqli_fetch_assoc($result2);

            $industry = $row2["industry"];
            $name = $row2["name"];
            $threadname = $row["title"];
            $threadbody = $row["content"];
            $creationtime = $row["created"];
            $username = get_username_from_id($row["userid"]);

            // Parse the input date string
            $dateObj = DateTime::createFromFormat('Y-m-d H:i:s', $creationtime);

            // Format the date using format() with desired format string
            $formattedDate = $dateObj->format('F j, Y \a\t g:ia');

            echo "<h2> <a href='index.php'>Index</a> > " . $row2["industry"] . " > <a href='community.php?cid=" . $row["communityid"] . "'>" . $row2["name"] . "</a></h2>";
        }
    } else if ($cid != 0) {
        $result = php_select_prepared("SELECT * FROM community WHERE communityid = ?", "i", $cid);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $industry = $row["industry"];
            $community = $row["name"];

            echo "<h2> <a href='index.php'>Index</a> > " . $industry . " > <a href='community.php?cid=" . $cid . "'>" . $community . "</a></h2>";
        }
    }
    ?>


</div>