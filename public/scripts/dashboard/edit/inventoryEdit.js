$(document).ready(function () {

    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
  
    $.ajax({
        url: "",
        type: "GET",
        data: {
          id: id,
        },
        cache: true,
        success: function (response) {
          console.log(id);
        },
      });
  
  
      $(".btn-submit").click(function(){
        alert("Produto Atulizado");
      })
  });