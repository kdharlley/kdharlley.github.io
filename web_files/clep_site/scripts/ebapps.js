$(document).ready(function() {
    //when the show button is clicked, show the event details
    $(".open_position .show-event-details").click(function(){
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

  });
