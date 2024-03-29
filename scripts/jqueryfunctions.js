function getUserThreads(username, owner, admin){

    console.log(username + " " + owner + " " + admin);

    var curUser = owner;

    if (username === owner){
        owner = true;
    } else {
        owner = false;
    }

    //$("#threads").empty();
    var location = '#threads';

    $("#threads").children().not("#thread_template",).remove();
    $("#comments").children().not("#comment_template",).remove();
    
    $.get('getUserThreads.php', {username: username}, function(data) {

        var threads = JSON.parse(data);
        for (var i = 0; i < threads.length; i++) {
            var tid = threads[i].tid;
            var title = threads[i].title;
            var community = threads[i].cname;
            var created = threads[i].created;
            var points = threads[i].points;
            var threadtype = threads[i].threadtype;
            var user = threads[i].username;

            if (points == undefined){
                points = 0;
            }

            createNewThread(tid, title, created, community, points, user, threadtype, location, owner, admin, curUser);
        }

    });

}

function getUserComments(username, owner, admin){

    console.log(username + " " + owner + " " + admin);
    var location = '#comments';

    //$("#threads").empty();

    $("#threads").children().not("#thread_template").remove();
    $("#comments").children().not("#comment_template",).remove();
    
    $.get('getUserComments.php', {username: username}, function(data) {

        var threads = JSON.parse(data);
        for (var i = 0; i < threads.length; i++) {
            var cid = threads[i].commentid;
            var comment = threads[i].comment;
            var created = threads[i].created;
            var points = threads[i].points;

            if (points == undefined){
                points = 0;
            }

            createNewComment(cid, comment, created, points, username, location , owner, admin);
        }

    });

}

function getUserUpvoted(username, owner, admin){

    let curUser = owner;    
    
    $("#threads").children().not("#thread_template").remove();
    $("#comments").children().not("#comment_template").remove();

    $.get('getUserVoted.php', {username: username, type: 'up'}, function(data) {

        //console.log(data);
        
        var threads = JSON.parse(data);
        for (var i = 0; i < threads.length; i++) {
            
            if (threads[i].tid != undefined){

                // get thread information and create new thread
                var tid = threads[i].tid;
                var title = threads[i].title;
                var community = threads[i].communityid;
                var created = threads[i].created;
                var points = threads[i].points;
                var threadtype = threads[i].threadtype;
                var user = threads[i].username;

                if (username === owner){
                    owner = true;
                } else {
                    owner = false;
                }

                if (points == undefined){
                    points = 0;
                }

                createNewThread(tid, title, created, community, points, user, threadtype, '#threads', owner, admin, curUser);

            } else if (threads[i].commentid != undefined){

                // get comment information and create new comment
                var cid = threads[i].commentid;
                var comment = threads[i].comment;
                var created = threads[i].created;
                var points = threads[i].points;
                username = threads[i].username;

                if (points == undefined){
                    points = 0;
                }

                createNewComment(cid, comment, created, points, username, '#comments', owner, admin);
                
            
            } else {
                console.log("error");
            }

        }
    })
}

function getUserDownvoted(username, owner, admin){

    let curUser = owner;
    
    $("#threads").children().not("#thread_template").remove();
    $("#comments").children().not("#comment_template").remove();

    $.get('getUserVoted.php', {username: username, type: 'down'}, function(data) {
        
        var threads = JSON.parse(data);
        for (var i = 0; i < threads.length; i++) {
            
            if (threads[i].tid != undefined){

                // get thread information and create new thread
                var tid = threads[i].tid;
                var title = threads[i].title;
                var community = threads[i].communityid;
                var created = threads[i].created;
                var points = threads[i].points;
                var threadtype = threads[i].threadtype;
                var user = threads[i].username;

                if (username === owner){
                    owner = true;
                } else {
                    owner = false;
                }

                if (points == undefined){
                    points = 0;
                }

                createNewThread(tid, title, created, community, points, user, threadtype, '#threads', owner, admin, curUser);

            } else if (threads[i].commentid != undefined){

                // get comment information and create new comment
                var cid = threads[i].commentid;
                var comment = threads[i].comment;
                var created = threads[i].created;
                var points = threads[i].points;
                username = threads[i].username;

                if (points == undefined){
                    points = 0;
                }

                createNewComment(cid, comment, created, points, username, '#comments', owner, admin);
                
            
            } else {
                console.log("error");
            }

        }
    })
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

function changeDescription(userid,username,reload=true,callback){

    $description = $('#desc-input').val();

    $.post('editUser.php', {userid: userid, username: username, value: $description, column: 'description'}, function(result){

        console.log(result);
        if(callback) callback(result);
    });

    if(reload){
        location.reload();
    }

}

function changeFirstname(userid,username,reload=true,callback){

    $firstname = $('#fname').val();

    $.post('editUser.php', {userid: userid, username: username, value: $firstname, column: 'firstname'}, function(result){

        console.log(result);
        if(callback) callback(result);
    });

    if(reload){
        location.reload();
    }

}

function changeLastname(userid,username,reload=true,callback){

    $lastname = $('#lname').val();

    $.post('editUser.php', {userid: userid,username: username, value: $lastname, column: 'lastname'}, function(result){

        console.log(result);
        if(callback) callback(result);
    });

    if(reload){
        location.reload();
    }

}

function changeEmail(userid,username,reload=true,callback){

    $email = $('#email').val()

    $.post('editUser.php', {userid: userid, username: username, value: $email, column: 'email'}, function(result){

        console.log(result);
        if(callback) callback(result);
    });

    if(reload){
        location.reload();
    }

}

function changePassword(userid,username,reload=true,callback){

    $password = $('#pw').val();

    $.post('editUser.php', {userid: userid, username: username, value: $password, column: 'password'}, function(result){

        console.log(result);
        if(callback) callback(result);
    });

    if(reload){
        location.reload();
    }

}

function changeImage(userid, username,reload=true,callback) {
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
            if(reload){
                location.reload();
            }
            if(callback) callback(response);
        },
        error: function(xhr, status, error) {
            if(callback) callback(error);
            console.log(error);
        }
    });

}


function deleteThread(tid,reload=true,callback){
    $.post('deleteThread.php', {tid: tid}, function(result){
        console.log(result);
        if(callback) callback(result);
    }).fail(function(xhr, status, error) {
        console.log(error);
    })
    if(reload){
        location.reload();
    }
}

function deleteComment(cid,reload=true,callback){
    $.post('deleteComment.php', {cid: cid}, function(result){
        console.log(result)
        if(callback) callback(result);
    }).fail(function(xhr, status, error) {
        console.log(error);
    })
    if(reload){
        location.reload();
    }
}
//userid, adminid, bandate, expiredate, banreason
function banUser(userid, adminid, bandate, expiredate, banreason, reload=true,callback){
    $.post('banUser.php', {userid: userid, adminid: adminid, bandate: bandate.toISOString().slice(0, 19).replace('T', ' '), expiredate: expiredate.toISOString().slice(0, 19).replace('T', ' '), banreason: banreason}, function(result){
        console.log(result);
        if(callback) callback(result);
    }).fail(function(xhr, status, error) {
        console.log(error);
    })
    if(reload){
        location.reload();
    }
}

function unBanUser(userid,reload=true,callback){
    $.post('unBanUser.php', {userid: userid}, function(result){
        console.log(result);
        if(callback) callback(result);
    }).fail(function(xhr, status, error) {
        console.log(error);
    })
    if(reload){
        location.reload();
    }
}

function getIsBanned(userid,callback){
    $.post('getIsBanned.php', {userid: userid}, function(result){
        console.log(result);
        if(callback) callback(result);
    }).fail(function(xhr, status, error) {
        console.log(error);
    })
}
