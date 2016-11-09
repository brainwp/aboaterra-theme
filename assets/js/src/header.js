$(document).ready(function(){
 $(window).resize(function() {
  if ($(window).width() < 960) {
     alert('Less than 960');
  }
 else {
    alert('More than 960');
 }
});

});
