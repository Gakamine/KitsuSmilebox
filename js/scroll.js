var compteur=16;
var action="on";
var LoadEnd=true;
$(window).on("scroll", function(){
  var height = $(document).height();
  var windowheight = $(window).scrollTop() + window.innerHeight;
  if ( windowheight >= height-20 ){
    if (action=="on" && LoadEnd) {
      LoadEnd=false;
      $.ajax({
      url: './load_more.php',
      type: 'POST',
      data: 'compteur=' + compteur,
      dataType: 'html',
      success: function(content) {
          load(content);
          }
        })
      }
    }
});

function load(content) {
  compteur=compteur+12;
  if (content!="stop") {
    document.getElementById("content_table").innerHTML+=content;
  }
  else {
   action="off";
   document.getElementById("loader").remove();
   $('body').innerHTML+="<h1>There is no more smile in the box... :'(</h1>";
 }
 LoadEnd=true;
 windowheight = $(window).scrollTop() + $(window).height();
}
