  $(document).ready(function(){
      $(".main").onepage_scroll({
        sectionContainer: "section"
      });
        $("#scroll").click(function(){
        $(".main").jumpTo($(this).data('id'));
      });
    });

