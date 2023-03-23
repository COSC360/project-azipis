function createNewThread(tid,title,created,community,points,user,threadtype){
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
    document.querySelector("#threads").appendChild(newThread);
}