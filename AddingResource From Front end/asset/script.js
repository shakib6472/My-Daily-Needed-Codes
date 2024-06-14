jQuery(document).ready(function ($) {
  console.log("Initiate 1");

  // Handle the click event on the upload button
  $(".wp-media-library-upload").click(function (e) {
    e.preventDefault();
    console.log("Media button clicked");

    // Open the WordPress media library
    var mediaUploader = wp.media({
      frame: "select",
      multiple: false,
    });

    // When an image is selected, run a callback function
    mediaUploader.on("select", function () {
      // Get the selected image information
      var attachment = mediaUploader.state().get("selection").first().toJSON();

      // Display the selected image
      $(".wp-media-library-preview").html(
        '<img src="' +
          attachment.url +
          '" alt="' +
          attachment.alt +
          '" style="max-width: 100%; height: auto;">'
      );

      // Set the image ID in the hidden input field for form submission
      $(".wp-media-library-image-id").val(attachment.id);
    });

    // Open the media uploader
    mediaUploader.open();
  });

  $("button.add-new-resource-ajax").click(function (e) {
    $(".loading-overlay").addClass("is-active");
    console.log("object");
    var title = $("#title").val();
    var resource_type = $("#resource_type").val();
    var resouce_url = $("#resouce_url").val();
    var thumbnail_id = $(".wp-media-library-image-id").val();

    if ("" !== title && "" !== resource_type && "" !== resouce_url) {
      //Everything is Okay
      $(".error").hide(500);
      //Sending the data to backend to store
      //Sending Ajax requests
      $.ajax({
        type: "POST",
        url: tinyscholarsAjax.ajaxurl, // WordPress AJAX URL provided via wp_localize_script
        data: {
          action: "add_a_new_resource", // Action hook to handle the AJAX request in your functions.php
          title: title, // Pass form data to the backend
          resource_type: resource_type, // Pass form data to the backend
          resouce_url: resouce_url, // Pass form data to the backend
          thumbnail_id: thumbnail_id, // Pass form data to the backend
        },
        success: function (response) {
          // Handle success response
          console.log(response);
          // Reload the window
          location.reload();
        },
        error: function (xhr, textStatus, errorThrown) {
          // Handle error
          console.error("Error:", errorThrown);
          location.reload();
        },
      });
    } else {
      $(".loading-overlay").removeClass("is-active");
      $(".error").show(200);
      $(".error .error-text").text("Please Fill All The Fields");
      console.log("All Fields NOT  Filled");
    }
  });

  $(".delete-resource-item--ajax").click(function (e) {
    $(".loading-overlay").addClass("is-active");
    console.log("delete Requested");
    var post_id = $(this).data("post-id");
    var mainItem = $(this).parent().parent();

    //Sending Ajax requests
    $.ajax({
      type: "POST",
      url: tinyscholarsAjax.ajaxurl, // WordPress AJAX URL provided via wp_localize_script
      data: {
        action: "delete_resource", // Action hook to handle the AJAX request in your functions.php
        post_id: post_id, // Pass form data to the backend
      },
      success: function (response) {
        // Handle success response
        console.log(response);
        // Reload the window
        mainItem.animate({ opacity: 0 }, 500, function () {
          mainItem.hide();
        });
      },
      error: function (xhr, textStatus, errorThrown) {
        // Handle error
        console.error("Error:", errorThrown);
        $(".loading-overlay").removeClass("is-active");
        console.log("Resource Not Deleted");
      },
    });
  });

  // Adding New games
  $("button.add-new-game-ajax").click(function (e) {
    $(".loading-overlay").addClass("is-active");
    console.log("object");
    var title = $("#title").val();
    var gane_code = $("#game_code").val();
    var thumbnail_id = $(".wp-media-library-image-id").val();

    if ("" !== title && "" !== gane_code && "" !== thumbnail_id) {
      //Everything is Okay
      $(".error").hide(500);
      //Sending the data to backend to store
      //Sending Ajax requests
      $.ajax({
        type: "POST",
        url: tinyscholarsAjax.ajaxurl, // WordPress AJAX URL provided via wp_localize_script
        data: {
          action: "add_a_new_game", // Action hook to handle the AJAX request in your functions.php
          title: title, // Pass form data to the backend
          gane_code: gane_code, // Pass form data to the backend
          thumbnail_id: thumbnail_id, // Pass form data to the backend
        },
        success: function (response) {
          // Handle success response
          console.log(response);
          // Reload the window
          location.reload();
        },
        error: function (xhr, textStatus, errorThrown) {
          // Handle error
          console.error("Error:", errorThrown);
          location.reload();
        },
      });
    } else {
      $(".loading-overlay").removeClass("is-active");
      $(".error").show(200);
      $(".error .error-text").text("Please Fill All The Fields");
      console.log("All Fields NOT  Filled");
    }
  });
  // Adding New cartoon
  $("button.add-new-cartoon-ajax").click(function (e) {
    $(".loading-overlay").addClass("is-active");
    console.log("object");
    var title = $("#title").val();
    var resource_type = $("#old-category").val();
    var resouce_url = $("#resouce_url").val();
    var new_category = $("#new-category").val();
    var thumbnail_id = $(".wp-media-library-image-id").val();

    if ("" !== title && "" !== thumbnail_id && "" !== resouce_url) {
      //Everything is Okay
      $(".error").hide(500);

      console.log("Cartoon category is: " + resource_type);

      if (new_category !== "") {
        //Sending the data to backend to store
        //Sending Ajax requests
        $.ajax({
          type: "POST",
          url: tinyscholarsAjax.ajaxurl, // WordPress AJAX URL provided via wp_localize_script
          data: {
            action: "add_a_new_cartoon", // Action hook to handle the AJAX request in your functions.php
            title: title, // Pass form data to the backend
            resouce_url: resouce_url, // Pass form data to the backend
            resource_type: resource_type, // Pass form data to the backend
            thumbnail_id: thumbnail_id, // Pass form data to the backend
            new_category: new_category, // Pass form data to the backend
          },
          success: function (response) {
            // Handle success response
            console.log(response);
            // Reload the window
            location.reload();
          },
          error: function (xhr, textStatus, errorThrown) {
            // Handle error
            console.error("Error:", errorThrown);
            location.reload();
          },
        });
      } else {
        //Sending the data to backend to store
        //Sending Ajax requests
        $.ajax({
          type: "POST",
          url: tinyscholarsAjax.ajaxurl, // WordPress AJAX URL provided via wp_localize_script
          data: {
            action: "add_a_new_cartoon", // Action hook to handle the AJAX request in your functions.php
            title: title, // Pass form data to the backend
            resouce_url: resouce_url, // Pass form data to the backend
            resource_type: resource_type, // Pass form data to the backend
            thumbnail_id: thumbnail_id, // Pass form data to the backend
            new_category: new_category, // Pass form data to the backend
          },
          success: function (response) {
            // Handle success response
            console.log(response);
            // Reload the window
            location.reload();
          },
          error: function (xhr, textStatus, errorThrown) {
            // Handle error
            console.error("Error:", errorThrown);
            location.reload();
          },
        });
      }
    } else {
      $(".loading-overlay").removeClass("is-active");
      $(".error").show(200);
      $(".error .error-text").text("Please Fill All The Fields");
      console.log("All Fields NOT  Filled");
    }
  });

  $("#resource_type").change(function (e) {
    e.preventDefault();
    console.log($(this).val());
    if ("new" == $(this).val()) {
      $(".form-group.mt-4.new-category").show(500);
      $("#old-category").val('new');

    } else {
      $(".form-group.mt-4.new-category").hide(500);
      $("#old-category").val($(this).val());
    }
  });

  /* ==================================================
  * Time Table 
   ==================================================== */

  $(".edit-database-table").click(function (e) {
    e.preventDefault();

    $(".loading-overlay").addClass("is-active");
    // Get all input fields within the timetable section and remove the disabled attribute
    $(".tutor-dashboard-content input").prop("disabled", false);

    $(".tutor-dashboard-content input").addClass("border-yes");
    // Set a timer to remove the loading overlay after 1 second
    setTimeout(function () {
      $(".loading-overlay").removeClass("is-active");
    }, 1000);
  });
  $(".delete-database-table").click(function (e) {
    e.preventDefault();
    $(".cross").css("display", "flex");
  });

  $(".task-creator.clickable").click(function () {
    // Clone the last task element
    var newTask = $(this).prev(".task").clone();
    // Insert the cloned task before the "Add New" box
    $(this).before(newTask);
  });
  $(".cross").click(function () {
    // Clone the last task element
    console.log("delete Called");
    var newTask = $(this).parent(".task").remove();
    // Insert the cloned task before the "Add New" box
    $(this).before(newTask);
  });

  $(".submit-new-time-table").click(function (e) {
    var timetable = {}; // Initialize an empty object to store the timetable data
    $(".loading-overlay").addClass("is-active");
    var weekName = "Week" + $(".week_number_a").data("week");
    var weekNumber = $(".week_number_a").data("week");
    timetable[weekName] = {};
    // Loop through each week
    $(".card-item").each(function (index) {
      $(".tutor-dashboard-content input").prop("disabled", false);
      // Initialize an empty object to store days for this week
      // Loop through each day of the week
      $(this)
        .find(".card-header.day-name")
        .each(function () {
          var dayName = $(this).find("h4").text().trim(); // Get the name of the day
          timetable[weekName][dayName] = []; // Initialize an empty array to store tasks for this day

          // Loop through each task for this day
          $(this)
            .next(".card-body")
            .find(".task")
            .each(function () {
              var task = {}; // Initialize an empty object to store task data

              // Get task details from input fields
              task.name = $(this).find(".title").val();
              task.time = $(this).find(".time").val();
              task.description = $(this).find(".description").val();
              // Add task data to the timetable for this day
              timetable[weekName][dayName].push(task);
            });
        });
    });

    // Convert the timetable object to JSON
    console.log(timetable);
    var timetableJSON = JSON.stringify(timetable);
    console.log(timetableJSON);

    // Send the JSON data to the server via AJAX
    $.ajax({
      type: "POST",
      url: tinyscholarsAjax.ajaxurl, // WordPress AJAX URL provided via wp_localize_script
      data: {
        action: "submit_weekly_data", // Action hook to handle the AJAX request in your functions.php
        timetableJSON: timetableJSON, // Pass timetable data to the backend
        weekNumber: weekNumber, // Pass timetable data to the backend
      },
      success: function (response) {
        // Handle success response
        console.log(response);
        // Reload the window
        //$(".loading-overlay").removeClass("is-active");
        location.reload();
      },
      error: function (xhr, textStatus, errorThrown) {
        // Handle error
        console.error("Error:", errorThrown);
        location.reload();
        //$(".loading-overlay").removeClass("is-active");
      },
    });
  });

  $(".button-clicked").click(function (e) {
    $(".loading-overlay").addClass("is-active");
  });
});
