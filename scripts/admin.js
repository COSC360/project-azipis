function search(e) {
    console.log(e)
    e = e || window.event;
    if(e.keyCode == 13) {
        var elem = e.srcElement || e.target;
        getUserInfo(elem.value);
    }
}

function getUserInfo(username){
    $.get('getUserInfo.php', {username: username}, function(data) {
        var user = JSON.parse(data);
        $("#username").text(user.username);
        $("#email").text(user.email);
        $("#points").text(user.points);
        $("#description").text(user.description);
    })
}