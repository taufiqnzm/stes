function updateData() {
    // Get the selected date from the input field
    console.log("Date changed!"); // Check if this message appears in the console
    var selectedDate = document.getElementById("inputStartDate").value;

    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Configure the request (GET request to update_data.php)
    xhr.open("GET", "update_list_teacher.php?selected_date=" + selectedDate, true);

    // Define a callback function to handle the response
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Update the table content with the new data received from the server
            document.getElementById("teachers").innerHTML = xhr.responseText;
        }
    };

    // Send the AJAX request
    xhr.send();
}