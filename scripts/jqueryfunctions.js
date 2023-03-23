function getUserThreads(username){

    console.log(username);

    //$("#threads").empty();

    $("#threads").find('a').not("#thread_template").remove();
    
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
