<div id="thread_template" class="relative" hidden>
    <a class="thread" href="">
        <figure>
            <span class="circle"></span>
            <img src="images/coffeecup.png" alt="coffee cup" class="overlayed">
        </figure>
        <div class="thread-info">

            <h2 class="thread-name"></h2>

            <p>
                <span class="username"></span>
                <span class="date"></span>
                <span class="community"></span>
            </p>

        </div>
    </a>

    <div class="delete_thread_div">
    </div>

    <div class="points" tid="">
        <form action="vote.php" method="post"></form>
        <button class="upvote" value="1" onclick="">^</button>
        <p class="pointnum">0</p>
        <button class="downvote" value="-1" onclick="">v</button>
    </div>
</div>