let coll = document.getElementsByClassName("collapsible");
let i;

for (i = 0; i < coll.length; i++) {
  coll[i].nextElementSibling.style.display = "none";
}

$(document).ready(function() {
  $('.collapsible').click(function() {
      var content = $(this).next('.content');
      if (content.hasClass('show')) {
          content.removeClass('show').animate({ height: 0 }, 500, function(){
            content.css("display", "none");
          });
      } else {
        content.css("display", "inline-block");
        content.css("height", "0px");
        content.addClass('show').animate({ height: content.prop('scrollHeight') }, 500);
      }
  });
});
