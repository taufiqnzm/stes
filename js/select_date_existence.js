function updateData(queryType) {
    // Get the selected date from the input field
    var selectedDate = document.getElementById("inputStartDate").value;

    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Configure the request (GET request to update_data.php)
    xhr.open("GET", "update_list_existence.php?query_type=" + queryType + "&selected_date=" + selectedDate, true);

    // Define a callback function to handle the response
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Parse the JSON response
            var result = JSON.parse(xhr.responseText);
    
            // Update the table content with the new data received from the server
            if (queryType === 'absent' || queryType === 'emergency') {
                // Update the table for 'Absent' and 'Emergency' query
                document.getElementById("teachers").innerHTML = generateAbsent_EmergencyTable(result);
            } else if (queryType === 'official_business') {
                // Update the table for 'Official Business' query
                document.getElementById("teachers").innerHTML = generateOfficialBusinessTable(result);
            } else if (queryType === 'crk' || queryType === 'haji_umrah' || queryType === 'bersalin' || queryType === 'keberadaan_jam') {
                // Update the table for 'Crk', 'Haji & Umrah', 'Bersalin', 'Keberadaan Jam', query
                document.getElementById("teachers").innerHTML = generate5existence(result);
            } else if (queryType === 'cuti_lain') {
                // Update the table for 'Cuti Lain' query
                document.getElementById("teachers").innerHTML = generateCutiLainTable(result);
            }
        }
    };
    

    // Send the AJAX request
    xhr.send();
}

// Define functions to generate tables for each query type
function generateAbsent_EmergencyTable(data) {
    var tableHtml = "<table class='table'>";
    tableHtml += "<thead>";
    tableHtml += "<tr>";
    tableHtml += "<th scope='col'>No.</th>";
    tableHtml += "<th scope='col'>Name</th>";
    tableHtml += "<th scope='col'>Major</th>";
    tableHtml += "<th scope='col'>Phone No.</th>";
    tableHtml += "<th scope='col'>Reason</th>";
    tableHtml += "<th scope='col'>Date</th>";
    tableHtml += "<th scope='col'>Time</th>"; 
    tableHtml += "</tr>";
    tableHtml += "</thead>";
    tableHtml += "<tbody>";

    for (var i = 0; i < data.length; i++) {
        var row = data[i];
        tableHtml += "<tr>";
        tableHtml += "<td>" + (i + 1) + "</td>";
        tableHtml += "<td>" + row['name'] + "</td>";
        tableHtml += "<td>" + row['major'] + "</td>";
        tableHtml += "<td>" + row['phone'] + "</td>";
        tableHtml += "<td>" + row['reason'] + "</td>";
        tableHtml += "<td>" + row['start_date'] + ' - ' + row['final_date'] + "</td>";
        tableHtml += "<td>" + row['time_leave'] + ' - ' +row['time_back'] + "</td>"; 
        tableHtml += "</tr>";
    }
    return tableHtml;
}

function generateOfficialBusinessTable(data) {
    var tableHtml = "<table class='table'>";
    tableHtml += "<thead>";
    tableHtml += "<tr>";
    tableHtml += "<th scope='col'>No.</th>";
    tableHtml += "<th scope='col'>Name</th>";
    tableHtml += "<th scope='col'>Major</th>";
    tableHtml += "<th scope='col'>Phone no.</th>";
    tableHtml += "<th scope='col'>Program Name.</th>";
    tableHtml += "<th scope='col'>Date</th>";
    tableHtml += "<th scope='col'>Time</th>"; 
    tableHtml += "</tr>";
    tableHtml += "</thead>";
    tableHtml += "<tbody>";

    for (var i = 0; i < data.length; i++) {
        var row = data[i];
        tableHtml += "<tr>";
        tableHtml += "<td>" + (i + 1) + "</td>";
        tableHtml += "<td>" + row['name'] + "</td>";
        tableHtml += "<td>" + row['major'] + "</td>";
        tableHtml += "<td>" + row['phone'] + "</td>";
        tableHtml += "<td>" + row['program_name'] + "</td>";
        tableHtml += "<td>" + row['start_date'] + ' - ' + row['final_date'] + "</td>";
        tableHtml += "<td>" + row['time_leave'] + ' - ' +row['time_back'] + "</td>"; 
        tableHtml += "</tr>";
    }
    return tableHtml;
}

function generate5existence(data) {
    var tableHtml = "<table class='table'>";
    tableHtml += "<thead>";
    tableHtml += "<tr>";
    tableHtml += "<th scope='col'>No.</th>";
    tableHtml += "<th scope='col'>Name</th>";
    tableHtml += "<th scope='col'>Major</th>";
    tableHtml += "<th scope='col'>Phone No.</th>";
    tableHtml += "<th scope='col'>Date</th>";
    tableHtml += "<th scope='col'>Time</th>"; 
    tableHtml += "</tr>";
    tableHtml += "</thead>";
    tableHtml += "<tbody>";

    for (var i = 0; i < data.length; i++) {
        var row = data[i];
        tableHtml += "<tr>";
        tableHtml += "<td>" + (i + 1) + "</td>";
        tableHtml += "<td>" + row['name'] + "</td>";
        tableHtml += "<td>" + row['major'] + "</td>";
        tableHtml += "<td>" + row['phone'] + "</td>";
        tableHtml += "<td>" + row['start_date'] + ' - ' + row['final_date'] + "</td>";
        tableHtml += "<td>" + row['time_leave'] + ' - ' +row['time_back'] + "</td>"; 
        tableHtml += "</tr>";
    }
    return tableHtml;
}

function generateCutiLainTable(data) {
    var tableHtml = "<table class='table'>";
    tableHtml += "<thead>";
    tableHtml += "<tr>";
    tableHtml += "<th scope='col'>No.</th>";
    tableHtml += "<th scope='col'>Name</th>";
    tableHtml += "<th scope='col'>Major</th>";
    tableHtml += "<th scope='col'>Phone No.</th>";
    tableHtml += "<th scope='col'>Cuti</th>";
    tableHtml += "<th scope='col'>Date</th>";
    tableHtml += "<th scope='col'>Time</th>"; 
    tableHtml += "</tr>";
    tableHtml += "</thead>";
    tableHtml += "<tbody>";

    for (var i = 0; i < data.length; i++) {
        var row = data[i];
        tableHtml += "<tr>";
        tableHtml += "<td>" + (i + 1) + "</td>";
        tableHtml += "<td>" + row['name'] + "</td>";
        tableHtml += "<td>" + row['major'] + "</td>";
        tableHtml += "<td>" + row['phone'] + "</td>";
        tableHtml += "<td>" + row['leave_type'] + "</td>";
        tableHtml += "<td>" + row['start_date'] + ' - ' + row['final_date'] + "</td>";
        tableHtml += "<td>" + row['time_leave'] + ' - ' +row['time_back'] + "</td>"; 
        tableHtml += "</tr>";
    }
    return tableHtml;
}