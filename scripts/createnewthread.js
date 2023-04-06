function createNewThread(tid,title,created,community,points,user,threadtype,location="#threads", owner, admin){
    switch(parseInt(threadtype)){
        case 1: threadtype = "images/coffeecup.png"; break;
        case 2: threadtype = "images/bean.png"; break;
        case 3: threadtype = "images/spilledcup.png"; break;
        default: threadtype = "images/coffeecup.png"; break;
    }
    var newThread = document.querySelector("#thread_template").cloneNode(true);
    newThread.id = "";
    newThread.querySelector(".thread").href = "thread.php?tid=" + tid;
    newThread.hidden = false;
    newThread.querySelector(".thread-name").innerText = title;
    newThread.querySelector(".date").innerText = created;
    newThread.querySelector(".community").innerText = community;
    newThread.querySelector(".overlayed").src = threadtype;

    // create delete thread button if owner or admin
    if(owner || admin){
        var deleteThreadButton = document.createElement("button");
        deleteThreadButton.className = "button";
        deleteThreadButton.id = "delete_thread";
        deleteThreadButton.innerText = "Delete Thread";
        deleteThreadButton.onclick = function(){
            deleteThread(tid);
        }
        newThread.querySelector(".delete_thread_div").appendChild(deleteThreadButton);
    }

    // if points == undefined, set to 0
    if(points == undefined){
        points = 0;
    }

    newThread.querySelector(".username").innerText = user || "Anonymous";
    newThread.querySelector(".points").setAttribute("tid", tid);
    newThread.querySelector(".pointnum").innerText = points;
    document.querySelector(location).appendChild(newThread);
}

function createNewUserEntry(uid,username,imgpath,desc,location="#users"){
    var newUser = document.querySelector("#user_template").cloneNode(true);
    newUser.id = "";
    newUser.hidden = false;
    newUser.querySelector(".user").href = "user.php?username=" + username;
    newUser.querySelector(".username").innerText = username;
    newUser.querySelector(".profilepic").src = imgpath;
    newUser.querySelector(".desc").innerText = desc;
    document.querySelector(location).appendChild(newUser);
}

function createNewComment(cid, comment, created, points, username, location="#comments", owner, admin){

    var newComment = document.querySelector("#comment_template").cloneNode(true);
    newComment.id = "";
    newComment.hidden = false;
    newComment.querySelector(".comment").setAttribute("cid", cid);

    // create link to user that wrote comment
    var authorElement = newComment.querySelector(".author");
    var authorLinkElement = document.createElement("a");
    authorLinkElement.href = "user.php?username=" + username;
    authorLinkElement.innerText = username;
    authorElement.appendChild(authorLinkElement);

    // create delete comment button if owner or admin
    if(owner === username || admin){
        var deleteCommentButton = document.createElement("button");
        deleteCommentButton.className = "button delete_comment";
        deleteCommentButton.innerText = "Delete Comment";
        deleteCommentButton.onclick = function(){
            deleteComment(cid);
        }
        newComment.querySelector(".delete_comment_div").appendChild(deleteCommentButton);
    }

    // if points == undefined, set to 0
    if(points == undefined){
        points = 0;
    }

    newComment.querySelector(".date").innerText = created;
    newComment.querySelector(".content").innerText = comment;
    newComment.querySelector(".pointnum").innerText = points;
    document.querySelector(location).appendChild(newComment);

}