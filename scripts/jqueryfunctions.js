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

        console.log(username);

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

function changeDescription(userid){

    $description = $('#desc-input').val();

    $.post('editUser.php', {userid: userid, value: $description, column: 'description'}, function(result){

        console.log(result);
    });

    location.reload();

}

function changeFirstname(userid){

    $firstname = $('#fname').val();

    $.post('editUser.php', {userid: userid, value: $firstname, column: 'firstname'}, function(result){

        console.log(result);
    });

    location.reload();

}

function changeLastname(userid){

    $lastname = $('#lname').val();

    $.post('editUser.php', {userid: userid, value: $lastname, column: 'lastname'}, function(result){

        console.log(result);
    });

    location.reload();

}

function changeEmail(userid){

    $email = $('#email').val()

    $.post('editUser.php', {userid: userid, value: $email, column: 'email'}, function(result){

        console.log(result);
    });

    location.reload();

}

function changePassword(userid){

    $password = $('#pw').val();

    $.post('editUser.php', {userid: userid, value: $password, column: 'password'}, function(result){

        console.log(result);
    });

    location.reload();

}

function changeImage(userid, username) {
    var fileInput = $('#img')[0];
    var formData = new FormData();
    formData.append('img', fileInput.files[0]);
    formData.append('userid', userid);
    formData.append('column', 'avatarimgpath');
    formData.append('username', username);
    $.ajax({
        url: 'editUser.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(response) {
            console.log(response);
            location.reload();
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });

}