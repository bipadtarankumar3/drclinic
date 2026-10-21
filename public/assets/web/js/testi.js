

// load more
$(document).ready(function () {
    $(".testi-main-area").slice(0, 1).show();
    $("#load").on("click", function (e) {
      e.preventDefault();
      $(".testi-main-area:hidden").slice(0, 1).slideDown();
    });
  });
  
  
  // end load more




















