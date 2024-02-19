<?php
require_once "config.php"; // Include your database configuration

if (isset($_GET['type'])) {
    $reportType = $_GET['type'];
} else {
    exit("Report type not specified");
}

if (isset($_GET['selected_date'])) {
    $selectedDate = $_GET['selected_date'];
} else {
    $selectedDate = null; // Set a default value or handle the case when no date is provided
}

// Function to generate a report
function generateReport($reportType, $selectedDate, $conn) {
    // Define the headers for the report (e.g., CSV or Excel)
    header('Content-Type: text/csv');
    
    // Determine the filename based on the report type
    $filename = 'list_' . $reportType . '.csv';
    
    // Set the content disposition header with the filename
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    // Create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');
    
    // Initialize headers and query based on the report type
    $headers = array();
    $query = "";
    
    if ($reportType === 'official_business') {
        $headers = array('Name', 'Start Date', 'Final Date', 'Major', 'Phone No.', 'Program Name', 'Time Leave', 'Time Back');
        
        // Build the query to fetch Official Business records
        $query = "SELECT applicants.name, applicants.start_date, applicants.final_date, users.major, users.phone, applicants.program_name, applicants.time_leave, applicants.time_back 
                  FROM applicants
                  JOIN users ON applicants.user_id = users.user_id
                  WHERE applicants.existence = 'Official Business'";

                // Add date filtering if a selected date is provided
                if (!empty($selectedDate)) {
                    $query .= " AND :selectedDate BETWEEN applicants.start_date AND applicants.final_date";
                }
    } else if ($reportType === 'absent') {
        $headers = array('Name', 'Major', 'Phone No.', 'Start Date', 'Final Date', 'Time Leave', 'Time Back');
        // Build the query with the shared structure
        $query = "SELECT applicants.name, users.major, users.phone, applicants.start_date, applicants.final_date, applicants.time_leave, applicants.time_back FROM applicants
                  JOIN users ON applicants.user_id = users.user_id
                  WHERE applicants.existence = 'Absent'";

                  // Add date filtering if a selected date is provided
                  if (!empty($selectedDate)) {  
                     $query .= " AND :selectedDate BETWEEN applicants.start_date AND applicants.final_date";
                  }
    } else if ($reportType === 'emergency') {
        $headers = array('Name', 'Major', 'Phone No.', 'Start Date', 'Final Date', 'Time Leave', 'Time Back');
        // Build the query with the shared structure
        $query = "SELECT applicants.name, users.major, users.phone, applicants.start_date, applicants.final_date, applicants.time_leave, applicants.time_back FROM applicants
                  JOIN users ON applicants.user_id = users.user_id
                  WHERE applicants.existence = 'Emergency'";

                  // Add date filtering if a selected date is provided
                  if (!empty($selectedDate)) {
                     $query .= " AND :selectedDate BETWEEN applicants.start_date AND applicants.final_date";
                  }  
    } else if ($reportType === 'list_teacher') {
        $headers = array('Name', 'Phone No.', 'Start Date', 'Final Date', 'Time Leave', 'Time Back', 'Existence');
        $query = "SELECT applicants.name, users.phone, applicants.start_date, applicants.final_date, applicants.time_leave, applicants.time_back, applicants.existence FROM applicants
                  JOIN users ON applicants.user_id = users.user_id";

                  // Add date filtering if a selected date is provided
                  if (!empty($selectedDate)) {
                     $query .= " AND :selectedDate BETWEEN applicants.start_date AND applicants.final_date";
                  }  
    } else if ($reportType === 'dashboard') {
        $headers = array('Name', 'Major','Email', 'No.Telephone','Position');
        $query = "SELECT name, major, email, phone, position  FROM users";
    } else {
        // Handle other report types here if needed
        exit("Invalid report type");
    }

    // Prepare the SQL query with the date parameter if a selected date is provided
    $stmt = $conn->prepare($query);
    if (!empty($selectedDate)) {
        $stmt->bindParam(':selectedDate', $selectedDate, PDO::PARAM_STR);
    }
    
    // Execute the prepared statement
    $stmt->execute();

    // Write the headers to the CSV
    fputcsv($output, $headers);

    // Fetch data from the database and write it to the CSV
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, $row);
    }

    // Close the database connection
    $conn = null;

    // Close the CSV file
    fclose($output);

    exit();
}

// Function to generate the dashboard report
function generateDashboardReport($conn) {
    // Define the headers for the dashboard report (e.g., CSV or Excel)
    header('Content-Type: text/csv');

    // Determine the filename for the dashboard report
    $filename = 'dashboard_report.csv';

    // Set the content disposition header with the filename
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');

    // Headers for the dashboard report
    $headers = array('Name', 'Major', 'Email', 'No.Telephone', 'Position');

    // Write the headers to the CSV
    fputcsv($output, $headers);

    // Fetch data from the database and write it to the CSV
    $query = "SELECT name, major, email, phone, position FROM users";
    $stmt = $conn->query($query);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, $row);
    }

    // Close the database connection
    $conn = null;

    // Close the CSV file
    fclose($output);

    exit();
}

generateReport($reportType, $selectedDate, $conn);
?>