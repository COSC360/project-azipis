<div id="comment_template" class="relative" hidden>

    <div class='comment'>

        <h4 class='author inline'></h4>
        <h4 class='date inline'></h4>
        <p class='content'></p>

    </div>

    <div class="points" cid="">
        <form action="vote.php" method="post"></form>
        <button class="upvote" value="1" onclick="vote(this, 1, 'comment')">^</button>
            <p class="pointnum">0</p>
            <button class="downvote" value="-1" onclick="vote(this, -1, 'comment')">v</button>
    </div>

</div>