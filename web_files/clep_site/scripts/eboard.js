$(document).ready(function() {
  //show add-event form
  $("#add-member").click(function(){
    $('#add-member').addClass("hidden");
    $("#addMember").removeClass("hidden");
  })
  //hide form
  $('#hide-form').click(function(){
    $('#add-member').removeClass("hidden");
    $("#addMember").addClass("hidden");
  })
});
