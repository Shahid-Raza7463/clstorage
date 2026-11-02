function showConfirmation(event) {
    event.preventDefault(); // Prevent form submission

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Delete It!",
    }).then((result) => {
        if (result.isConfirmed) {
            // Swal.fire("Deleted!", "Your file has been deleted.", "success");

            event.target.closest(".form1").submit(); // Submit the form
        }
    });
}

// this code related for delete data in index after conformation
// $(document).ready(function () {
//     $(".form1").on("submit", function () {
//         // Display the confirmation box and store ok and cancel in result
//         var result = confirm("Are you sure you want to delete?");
//         if (result) {
//             var form = $(this);
//             form.unbind("submit").submit(); // Submit the form
//         } else {
//             // If the user cancels, do nothing
//             return false;
//         }
//     });
// });
