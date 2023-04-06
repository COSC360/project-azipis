function vote(id,vote,type) {
    $.post("../vote.php", { id: id,vote: vote, type: type }, function(response) {
        if (response.success) {
            console.log("success")
        } else {
            console.log("fail")
        }
    }, "json").fail(function(xhr, status, error) {
        console.log("error:", error)
    });
}
