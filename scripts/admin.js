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
        if(data){
            var user = {};
            try{
                user = JSON.parse(data);
            } catch(e){
                console.log(e);
            }
            autoFillFields(user);
        }
    })
}

function autoFillFields(info){
    if(info.username){
        $("#desc-input").val(info.description);
        $("#fname").val(info.firstname);
        $("#lname").val(info.lastname);
        $("#email").val(info.email);
        $("#preview").attr('src',info.avatarimgpath)
    } else {
        $("#desc-input").val("");
        $("#fname").val("");
        $("#lname").val("");
        $("#email").val("");
        $("#preview").attr('src','images/profile.png')
    }

}

