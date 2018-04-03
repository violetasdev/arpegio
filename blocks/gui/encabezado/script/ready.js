
function openNav() {

  if (screen.width < 780) {
      document.getElementById("mySidenav").style.width = "80%";
  }  else {
  document.getElementById("mySidenav").style.width = "35%";
  }
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
/*    var x = document.getElementsByClassName("seccionAmplia");
    var i;
    for (i = 0; i < x.length; i++) {
        x[i].style.backgroundColor = "rgba(0,0,0,0.4)";
    }*/

    $(function() {

      $("[data-drilldown-button]").click(function() {
      var contact=$(this).attr('id') ;
      var element = document.getElementById("contacto"+contact);
      element.classList.add("openM");
      $("[data-drilldown-item], [data-drilldown-button]").addClass("closeM");
      $(".wrapper").css("height", $('[data-drilldown-sub]').outerHeight())
        return false;
      });

      $("[data-drilldown-back]").click(function() {
        $('[data-drilldown-sub]').removeClass("openM");
        $("[data-drilldown-item], [data-drilldown-button]").removeClass("closeM");

        $(".wrapper").css("height", "auto");
        return false;
      });

      $("[data-drilldown-button-2]").click(function() {
        $('[data-drilldown-sub-2]').addClass("openM-sub-2");
        $("[data-drilldown-sub], [data-drilldown-button-2]").addClass("closeM");

        $(".wrapper").css("height", $('[data-drilldown-sub-2]').outerHeight());
        return false;
      });
    });
