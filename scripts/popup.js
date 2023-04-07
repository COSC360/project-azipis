function popup(msg){
    let popup = $("<div id=\"popup-notification\"><p>" + msg + "</p></div>")
    $("body").append(popup);

    showPopup()
    $(popup).css("display", "block");
    $(popup).fadeOut(5000, function(){
        $(this).remove();
    });

    function showPopup() {
    }
}