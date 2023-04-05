var userInfo = {};


$("#change-desc").click(function(){
    if(userInfo && userInfo.userid){
        changeDescription(userInfo.userid, false, function(success){
            if(success){
                changeButtonColor($("#change-desc"), "green", "white")
            } else {
                changeButtonColor($("#change-desc"), "red", "white")
            }
        });
    }
})

$("#change-fname").click(function(){
    if(userInfo && userInfo.userid){
        changeFirstname(userInfo.userid,false,function(success){
            if(success){
                changeButtonColor($("#change-fname"), "green", "white")
            } else {
                changeButtonColor($("#change-fname"), "red", "white")
            }
        });
    }
})

$("#change-lname").click(function(){
    if(userInfo && userInfo.userid){
        changeLastname(userInfo.userid,false,function(success){
            if(success){
                changeButtonColor($("#change-lname"), "green", "white")
            } else {
                changeButtonColor($("#change-lname"), "red", "white")
            }
        });
    }
})

$("#change-email").click(function(){
    if(userInfo && userInfo.userid){
        changeEmail(userInfo.userid,false,function(success){
            if(success){
                changeButtonColor($("#change-email"), "green", "white")
            } else {
                changeButtonColor($("#change-email"), "red", "white")
            }
        });
    }
})

$("#change-pw").click(function(){
    if($("#pw").val() === $("#cpw").val()){
        if(userInfo && userInfo.userid){
            changePassword(userInfo.userid,false,function(success){
                if(success){
                    changeButtonColor($("#change-pw"), "green", "white")
                }
            });
        }
    } else {
        changeButtonColor($("#change-pw"), "red", "white")
    }
})

$("#change-img").click(function(){
    if($("#pw").val() === $("#cpw").val()){
        if(userInfo && userInfo.userid && userInfo.username){
            changeImage(userInfo.userid,userInfo.username,false,function(success){
                if(success){
                    changeButtonColor($("#change-img"), "green", "white")
                }
            });
        }
    } else {
        changeButtonColor($("#change-img"), "red", "white")
    }
})

$("#delete_thread").click(function(){
        var url = new URL(window.location.href);
        deleteThread(url.searchParams.get("tid"),false,function(success){
            if(success){
                changeButtonColor($("#delete_thread"), "green", "white")
                window.location.replace("index.php");
            }
        });
})

$(".delete_comment").click(function(){
        let elem = $(this)
        let cid = $(this).parent().attr("cid")
        deleteComment(cid,false,function(success){
            if(success == 1){
                console.log(elem)
                changeButtonColor(elem, "green", "white")

                // delete div from page
                $(elem).parent().remove();



            }
        });
})


var isRegular = 0;
$("#ban-status input").on("change", function(){
    if($(this).attr("id") === "regular"){
        isRegular = 1;
        $("#ban-options").hide();
        $("#ban-days").hide();
    } else {
        isRegular = 0;
        $("#ban-options").show();
        $("#ban-days").show();
    }
})

$("#change_ban").click(function(){
    if(userInfo && userInfo.userid){
        if(isRegular){
            unBanUser(userInfo.userid,false,function(success){
                if(success){
                    changeButtonColor($("#change_ban"), "green", "white")
                }
            });
        } else {
            let time = $("#ban-length").val();
            let picked = document.querySelector('input[name="date-type"]:checked').value;
            console.log(picked)
            if(picked === "day"){
                time = time
            } else if(picked === "month"){
                time = time * 30;
            } else if(picked === "year"){
                time = time * 365;
            }
            console.log("days:" + time);
            banUser(userInfo.userid, 1, new Date(), new Date(new Date().getTime()+(time*24*60*60*1000)),"he sucks",false,function(success){ //TODO: get adminid and banreason
                if(success){
                    changeButtonColor($("#change_ban"), "green", "white")
                }
            });
        }
    }
})

function changeButtonColor(button,color,oldcolor){
    button.css('background-color', color);
    setTimeout(function(){
        button.css('background-color', oldcolor);
    }, 500);
}

function search(e) {
    e = e || window.event;
    if(e) {
        var elem = e.srcElement || e.target;
        getUserInfo(elem.value,autoFillFields);
    }
}

function getUserInfo(username,callback){
    $.get('getUserInfo.php', {username: username}, function(data) {
        if(data){
            try{
                userInfo = JSON.parse(data);
            } catch(e){
                userInfo = {};
            }
            callback(userInfo);
        }
    })
}

function autoFillFields(info){
    if(info.username){
        if ($("#edit-fields fieldset legend").length === 0) {
            $("<legend>Editting: " + info.username + "</legend>").appendTo("#edit-fields fieldset");
        }
        $("#desc-input").prop('disabled', false);
        $("#fname").prop('disabled', false);
        $("#lname").prop('disabled', false);
        $("#email").prop('disabled', false);
        $("#preview").prop('disabled', false);

        $("#desc-input").val(info.description);
        $("#fname").val(info.firstname);
        $("#lname").val(info.lastname);
        $("#email").val(info.email);
        $("#preview").attr('src',info.avatarimgpath)
    } else {
        $("#edit-fields fieldset legend").remove();
        $("#desc-input").prop('disabled', true);
        $("#fname").prop('disabled', true);
        $("#lname").prop('disabled', true);
        $("#email").prop('disabled', true);
        $("#preview").prop('disabled', true);
        $("#desc-input").val("");
        $("#fname").val("");
        $("#lname").val("");
        $("#email").val("");
        $("#preview").attr('src','images/profile.png')
    }
}
