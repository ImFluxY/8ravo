$(document).ready(function () {

  $(".filter-span").on("click", function () {
    var category = $(this).data("category");
    var search = $("#query").val();

    $(".filter-span").each(function () {
      $(this).removeClass("active");
    });
    $(this).addClass("active");

    searchModule('display', category, search);
  });

  $("#form button").on("click",function(){

    var category = $(".filter-module .active").data("category");
    var search = $("#query").val();

    console.log('delete : ' + category + ", " + search);
    searchModule('delete', category, search);
  });

  $("#form").on("submit", function(e)
  {
    e.preventDefault();
  })

  $(".filter-module .active").trigger("click");

  $('#formSearch').on('submit', function (e) {
    $.ajax({
      type: 'post',
      url: './templates/searchUsers.php',
      data: $('#formSearch').serialize(),
      dataType: 'html',
      success: function (php) {
        $(".listUsers").empty();
        $(".listUsers").append(php);
      },
      error: function (data) {
        console.log("error : ");
        console.log(data);
      }
    });
    e.preventDefault();
  });

  $("#formSearch").trigger("submit");

  function searchModule(type, category, search)
  {
    $.ajax({
      type: 'post',
      url: './templates/searchModules.php',
      data: {
        infos: {
          category : category,
          search: search
        },
        type: type
      },
      dataType: "html",
      success: function (data) {
        $(".swiper-wrapper").empty();
        $(".swiper-wrapper").append(data);
      },
      error: function (data) {
        console.log("error : ");
        console.log(data);
      }
    });
  }

});