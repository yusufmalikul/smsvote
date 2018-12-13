$(document).ready(function(){
  $("#btndatabaru").click(function(){
    $("#btndatabaru").toggle();
    $("#databaru").fadeIn();
  })

  $(".hapus").click(function(){
    var choice = confirm("Hapus data calon?");
    if (choice) {
      // alert($(this).attr("data-id"));
      location = hapusdatacalon + "?id="+$(this).attr("data-id");
    } else {
      return false;
    }
  })

})
