// when the document has loaded
$(document).ready(function() {

  //when the show button is clicked, show the event details
  $(".event .show-event-details").click(function(){
    $(this).parent().next().removeClass("hidden");
    $(this).addClass("hidden");
    // $(".event-details").removeClass("hidden");
    // $(".show-event-details").addClass("hidden");
  })

  //when the show less button is clicked, remove event details
  $(".show-less").click(function(){
      $(this).parent().addClass("hidden");
      $(this).parent().prev().find(".show-event-details").removeClass("hidden");
      // $("#show-less").addClass("hidden");
  })
  //show add-event form
  $("#add-event").click(function(){
    $('#add-event').addClass("hidden");
    $("#addEvent").removeClass("hidden");
  })
  //hide form
  $('#hide-form').click(function(){
    $('#add-event').removeClass("hidden");
    $("#addEvent").addClass("hidden");
  })
});
