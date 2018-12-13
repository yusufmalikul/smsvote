$(document).ready(function(){
  function checksms() {
    $.get("./system/checksms.php", {rand:(Math.random()*1000)}, function(data){});
  }

  setInterval(checksms, 3000);

  if (voting_aktif) {
    var expire = new Date();
    expire.setHours(hour_end, minute_end);
    setInterval(function(){
      var now = new Date();
      var diff = expire - now;
      var hours = Math.floor(diff / 1000 / 3600);
      var minutes = Math.floor(diff / 1000 / 60 - (hours * 60));
      var seconds = Math.floor(diff / 1000 - (minutes * 60) - (hours * 3600));
      if (diff > 0) {
        $(".countdown").html("<p class=\"countdown-running\">Waktu tersisa: "+hours + ":" + minutes + ":" + seconds+"</p>");
      } else {
        location = voting;
        // location.reload();
        // $(".countdown").html("<p class=\"countdown-finish\">Waktu sudah habis. Silahkan refresh halaman ini secara manual jika perolehan suara tidak tampil.</p>");
      }
    }, 1000);
  }
})
