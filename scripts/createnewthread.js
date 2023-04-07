function createNewThread(tid, title, created, community, points, user, threadtype, location = "#threads", owner, admin, curUser) {
    switch (parseInt(threadtype)) {
        case 1: threadtype = "images/coffeecup.png"; break;
        case 2: threadtype = "images/bean.png"; break;
        case 3: threadtype = "images/spilledcup.png"; break;
        default: threadtype = "images/coffeecup.png"; break;
    }

    // Parse date
    const dateObj = new Date(created);

    // Format the date using toLocaleString() with desired options
    const options = { month: 'long', day: 'numeric', year: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true };
    const formattedDate = dateObj.toLocaleString('en-US', options);

    var newThread = document.querySelector("#thread_template").cloneNode(true);
    newThread.id = "";
    newThread.querySelector(".thread").href = "thread.php?tid=" + tid;
    newThread.hidden = false;
    newThread.querySelector(".thread-name").innerText = title;
    newThread.querySelector(".date").innerText = formattedDate;
    newThread.querySelector(".community").innerText = community;
    newThread.querySelector(".overlayed").src = threadtype;

    console.log("owner: " + owner + " admin: " + admin);

    // create delete thread button if owner or admin
    if (owner == true || admin == 1) {
        var deleteThreadButton = document.createElement("button");
        deleteThreadButton.className = "button";
        deleteThreadButton.id = "delete_thread";
        deleteThreadButton.innerText = "Delete Thread";
        deleteThreadButton.onclick = function () {
            deleteThread(tid);
        }
        newThread.querySelector(".delete_thread_div").appendChild(deleteThreadButton);
    }

    // if points == undefined, set to 0
    if (points == undefined) {
        newThread.querySelector(".pointnum").innerText = "0"
    } else {
        get_votes(tid, "thread", function (points) {
            newThread.querySelector(".pointnum").innerText = points
        });
    }

    newThread.querySelector(".username").innerText = user || "Anonymous";
    newThread.querySelector(".points").setAttribute("tid", tid);

    let upvoteButton = newThread.querySelector(".points .upvote");
    let downvoteButton = newThread.querySelector(".points .downvote");

    // show how the user voted on threads
    if (curUser != null) {
        
        get_voted_threads(curUser, function (votedThreads) {

            if (votedThreads != null) {

                votedThreads = JSON.parse(votedThreads);
                console.log(votedThreads);
                // for each thread in votedThreads, check if tid is in votedThreads

                for (var i = 0; i < votedThreads.length; i++) {


                    var returnedtid = votedThreads[i].tid;
                    var vote = parseInt(votedThreads[i].vote);

                    console.log("Returned id: " + returnedtid + " voted: " + vote);

                    if (returnedtid == tid) {

                        if (vote == 1) {
                            upvoteButton.classList.add("highlightup");
                        } else if (vote == -1) {
                            downvoteButton.classList.add("highlightdown");
                        }
                    }


                }
            }
        });

    }


    upvoteButton.onclick = function () {
        $(upvoteButton).animate({ fontSize: "1.2em" }, 100).animate({ fontSize: "1em" }, 100);
        if (!upvoteButton.classList.contains("highlightup")) {
            upvoteButton.classList.add("highlightup");
            downvoteButton.classList.remove("highlightdown");
        }
        //request to insert vote
        vote(tid, 1, 'thread', function () {
            //get updated vote count
            get_votes(tid, "thread", function (points) {
                newThread.querySelector(".pointnum").innerText = points
            });
        })
    }
    downvoteButton.onclick = function () {
        $(downvoteButton).animate({ fontSize: "1.2em" }, 100).animate({ fontSize: "1em" }, 100);
        if (!downvoteButton.classList.contains("highlightdown")) {
            downvoteButton.classList.add("highlightdown");
            upvoteButton.classList.remove("highlightup");
        }
        //request to insert vote
        vote(tid, -1, 'thread', function () {
            //get updated vote count
            get_votes(tid, "thread", function (points) {
                newThread.querySelector(".pointnum").innerText = points
            });
        })
    }
    document.querySelector(location).appendChild(newThread);
}


function createNewUserEntry(uid, username, imgpath, desc, location = "#users") {
    var newUser = document.querySelector("#user_template").cloneNode(true);
    newUser.id = "";
    newUser.hidden = false;
    newUser.querySelector(".user").href = "user.php?username=" + username;
    newUser.querySelector(".username").innerText = username;
    newUser.querySelector(".profilepic").src = imgpath;
    newUser.querySelector(".desc").innerText = desc;
    document.querySelector(location).appendChild(newUser);
}

function createNewComment(cid, comment, created, points, username, location = "#comments", owner, admin) {

    var newComment = document.querySelector("#comment_template").cloneNode(true);
    newComment.id = "";
    newComment.hidden = false;
    newComment.querySelector(".comment").setAttribute("cid", cid);

    // Parse date
    const dateObj = new Date(created);

    // Format the date using toLocaleString() with desired options
    const options = { month: 'long', day: 'numeric', year: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true };
    const formattedDate = dateObj.toLocaleString('en-US', options);

    // create link to user that wrote comment
    var authorElement = newComment.querySelector(".author");
    var authorLinkElement = document.createElement("a");
    authorLinkElement.href = "user.php?username=" + username;
    authorLinkElement.innerText = username;
    authorElement.appendChild(authorLinkElement);

    // create delete comment button if owner or admin
    if (owner === username || admin == 1) {
        var deleteCommentButton = document.createElement("button");
        deleteCommentButton.className = "button delete_comment";
        deleteCommentButton.innerText = "Delete Comment";
        deleteCommentButton.onclick = function () {
            deleteComment(cid);
        }
        newComment.querySelector(".delete_comment_div").appendChild(deleteCommentButton);
    }

    // if points == undefined, set to 0
    if (points == undefined) {
        newComment.querySelector(".pointnum").innerText = 0;
    } else {
        get_votes(cid, "comment", function (points) {
            newComment.querySelector(".pointnum").innerText = points
        });
    }

    let upvoteButton = newComment.querySelector(".points .upvote");
    let downvoteButton = newComment.querySelector(".points .downvote");

    // show how the user voted on comments

    if (owner != null) {
        
        get_voted_comments(owner, function (votedThreads) {

            if (votedThreads != null) {

                console.log(votedThreads);

                votedThreads = JSON.parse(votedThreads);
                console.log(votedThreads);
                // for each thread in votedThreads, check if tid is in votedThreads

                for (var i = 0; i < votedThreads.length; i++) {


                    var returnedcid = votedThreads[i].commentid;
                    var vote = parseInt(votedThreads[i].vote);

                    console.log("Returned id: " + returnedcid + " voted: " + vote);

                    if (returnedcid == cid) {

                        if (vote == 1) {
                            upvoteButton.classList.add("highlightup");
                        } else if (vote == -1) {
                            downvoteButton.classList.add("highlightdown");
                        }
                    }


                }
            }
        });

    }

    upvoteButton.onclick = function () {
        $(upvoteButton).animate({ fontSize: "1.2em" }, 100).animate({ fontSize: "1em" }, 100);
        if (!upvoteButton.classList.contains("highlightup")) {
            upvoteButton.classList.add("highlightup");
            downvoteButton.classList.remove("highlightdown");
        }
        vote(cid, 1, 'comment');
        get_votes(cid, "comment", function (points) {
            newComment.querySelector(".pointnum").innerText = points
        });
    }
    downvoteButton.onclick = function () {
        $(downvoteButton).animate({ fontSize: "1.2em" }, 100).animate({ fontSize: "1em" }, 100);
        if (!downvoteButton.classList.contains("highlightdown")) {
            downvoteButton.classList.add("highlightdown");
            upvoteButton.classList.remove("highlightup");
        }
        vote(cid, -1, 'comment', function () {
            get_votes(cid, "comment", function (points) {
                newComment.querySelector(".pointnum").innerText = points
            });
        });
    }
    newComment.querySelector(".date").innerText = formattedDate;
    newComment.querySelector(".content").innerText = comment;
    document.querySelector(location).appendChild(newComment);

}

function get_votes(id, type, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "get_votes.php?id=" + id + "&type=" + type, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    console.log("points:", response.points);
                    if (!response.points) response.points = 0;
                    callback(response.points);
                } else {
                    console.log("fail");
                    console.log(xhr.responseText)
                    callback(0);
                }
            } else {
                console.log("error:", xhr.statusText);
                callback(0);
            }
        }
    };
    xhr.send();
}

function vote(id, vote, type, callback) {
    $.post("vote.php", { id: id, vote: vote, type: type }, function (response) {
        if (response.success) {
            if (callback) callback()
        } else {
            console.log("voting failed!", response)
            if (callback) callback()
        }
    }, "json").fail(function (xhr, status, error) {
        console.log("error:", error)
        if (callback) callback()
    });
}

// function that calls the get_user_voted_tid function from function.php
function get_voted_threads(username, callback) {

    $.ajax({
        url: 'functions.php',
        data: {
            'action': 'get_user_voted_tid',
            'username': username
        },
        type: 'POST',
        success: function (response) {

            callback(response);

        },
        error: function (xhr, status, error) {
            console.log("error:", error);
        }
    });

}

// function that calls the get_user_voted_cid function from function.php
function get_voted_comments(username, callback) {
    
    $.ajax({
        url: 'functions.php',
        data: {
            'action': 'get_user_voted_cid',
            'username': username
        },
        type: 'POST',
        success: function (response) {

            callback(response);

        },
        error: function (xhr, status, error) {
            console.log("error:", error);
        }
    });
}
