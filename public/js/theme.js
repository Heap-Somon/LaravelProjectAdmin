// Attach click event to all delete buttons dynamically
$(document).on("click", "#remove-post-key", function () {
    var postId = $(this).data("value");  // Get correct category ID
    $("#remove-val").val(postId); // Set it inside the modal
});