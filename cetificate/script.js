jQuery(document).ready(function ($) {
  console.log(ajax_object.certi_all);

  $(".verify-check").click(function (e) {
    e.preventDefault();
    $(".ppbox").hide();
    $(".spiner").css("visibility", "visible");
    var id = $(".certificate-id").val();

    if ("" == id) {
      $(".spiner").css("visibility", "hidden");
      $("p.error").show(500);
    } else {
      $(".spiner").css("visibility", "visible");
      $("p.error").hide(500);

      //ajax
      $.ajax({
        type: "POST",
        url: ajax_object.ajax_url, // WordPress AJAX URL provided via wp_localize_script
        data: {
          action: "verify_the_ceritificate", // Action hook to handle the AJAX request in your functions.php
          id: id, // Pass form data to the backend
        },
        dataType: "json",
        success: function (response) {
          // Handle success response
          if (response.success) {
            console.log(response);
            console.log(response.name);
            $(".name-p").text(response.name);
            $(".dob-p").text(response.dob);
            $(".course-p").text(response.course);
            $(".issue-p").text(response.issue);
            $(".expire-p").text(response.expire);
            // Reload the window
            $(".ppbox").show(500);
          } else {
            console.log(response);
            console.log("false");
            $(".found-text").text('Certificate Not Found');
            $(".found-text").addClass('text-danger');
            $(".data-table-to-show").hide();
            $(".ppbox").show(500);
          }

          $(".spiner").css("visibility", "hidden");
        },
        error: function (xhr, textStatus, errorThrown) {
          // Handle error
          console.error("Error:", errorThrown);
        },
      });
    }
  });





  

  $(".add-new-certificate").click(function (e) {
    e.preventDefault();
    $(".spiner").css("visibility", "visible");
    var id = $("#certificae-id").val();
    var name = $("#name").val();
    var expire = $("#expire").val();
    var issue = $("#issue").val();
    var course_name = $("#course_name").val();
    var dob = $("#dob").val();

    if (
      "" !== id &&
      "" !== name &&
      "" !== dob &&
      "" !== course_name &&
      "" !== issue &&
      "" !== expire
    ) {
      $.ajax({
        type: "POST",
        url: ajax_object.ajax_url, // WordPress AJAX URL provided via wp_localize_script
        data: {
          action: "add_new_certificate", // Action hook to handle the AJAX request in your functions.php
          id: id, // Pass form data to the backend
          name: name, // Pass form data to the backend
          dob: dob, // Pass form data to the backend
          course_name: course_name, // Pass form data to the backend
          issue: issue, // Pass form data to the backend
          expire: expire, // Pass form data to the backend
        },
        dataType: "json",
        success: function (response) {
          // Handle success response
          console.log(response);
          // Reload the window
          window.location.href = ajax_object.certi_all;
        },
        error: function (xhr, textStatus, errorThrown) {
          // Handle error
          console.error("Error:", errorThrown);
        },
      });
    } else {
      $(".spiner").css("visibility", "hidden");
      $("p.error").show(500);
    }
  });
});
