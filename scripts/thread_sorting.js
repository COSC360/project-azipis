$(document).ready(function() {
    $('#sorting_container .button').on('click',function() {
        console.log("changed sort");
        $('#sorting_container .button').removeClass('selected');
        $(this).addClass('selected');
        sorting = $(this).text().toLowerCase()
        getThreads(false,true)
    });
})

let sorting = "new";
function get_sorting(){
    return sorting;
}