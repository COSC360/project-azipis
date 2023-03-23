function createNewThread(tid,title,created,community,points,user,threadtype,location="#threads"){
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
    newThread.querySelector(".username").innerText = user || "Anonymous";
    //newThread.querySelector("#points").value = points;
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