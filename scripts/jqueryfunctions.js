function getUserThreads(username){

    //console.log(username);

    //$("#threads").empty();

    $("#threads").children().not("#thread_template",).remove();
    $("#comments").children().not("#comment_template",).remove();
    
    $.get('getUserThreads.php', {username: username}, function(data) {

        var threads = JSON.parse(data);
        for (var i = 0; i < threads.length; i++) {
            var tid = threads[i].tid;
            var title = threads[i].title;
            var community = threads[i].communityid;
            var created = threads[i].created;
            var points = threads[i].points;
            var threadtype = threads[i].threadtype;
            var user = threads[i].username;

            createNewThread(tid, title, created, community, points, user, threadtype);
        }

    });

}

function getUserComments(username){

    //console.log(username);

    //$("#threads").empty();

    $("#threads").children().not("#thread_template").remove();
    $("#comments").children().not("#comment_template",).remove();
    
    $.get('getUserComments.php', {username: username}, function(data) {

        var threads = JSON.parse(data);
        for (var i = 0; i < threads.length; i++) {
            var cid = threads[i].cid;
            var comment = threads[i].comment;
            var created = threads[i].created;
            var points = threads[i].points;

            createNewComment(cid, comment, created, points, username);
        }

    });

}

function sendResetPassword(){

    $email = $("#email-input").val();
    
    // if valid email, send reset link
    if (ValidateEmail($email)){
        $("#valid-email").html("If the email exists, a reset link will be emailed to you.");
        $.post('sendForgotPwEmail.php', {email: $email}, function(result){
            // do something with result
            console.log(result);
        });
        
    } else {
        $("#valid-email").html("This email is not valid. Try again.");
    }


}