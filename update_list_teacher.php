<?php
session_start();
require_once "config.php"; // Use require_once to ensure it's included only once
include "restricted.php";

// Get the selected date from the request
$selectedDate = isset($_GET['selected_date']) ? $_GET['selected_date'] : date("Y-m-d");

// Fetch data from the "applicants" table for the teachers not available on the selected date
$query = "SELECT applicants.name, users.phone, applicants.start_date, applicants.final_date, applicants.time_leave, applicants.time_back, applicants.existence
          FROM applicants
          INNER JOIN users ON applicants.user_id = users.user_id
          WHERE :selectedDate BETWEEN applicants.start_date AND applicants.final_date
          ORDER BY applicants.form_id DESC";

// Prepare the query
$stmt = $conn->prepare($query);
$stmt->bindParam(':selectedDate', $selectedDate, PDO::PARAM_STR);
$stmt->execute();

// Fetch the result
$teachers_not_available_today = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate the updated table
ob_start();

// Add table headers
echo "<thead>";
echo "<tr>";
echo "<th scope='col'>No.</th>";
echo "<th scope='col'>Name</th>";
echo "<th scope='col'>No.Telephone</th>";
echo "<th scope='col'>Date</th>";
echo "<th scope='col'>Time</th>";
echo "<th scope='col'>Existences</th>";
echo "</tr>";
echo "</thead>";

echo "<tbody>";

foreach ($teachers_not_available_today as $index => $teacher) {
    echo "<tr>";
    echo "<td>" . ($index + 1) . "</td>";
    echo "<td>" . $teacher['name'] . "</td>";
    echo "<td>" . $teacher['phone'] . "</td>";
    echo "<td>" . $teacher['start_date'] . '-' . $teacher['final_date'] . "</td>";
    echo "<td>" . $teacher['time_leave'] . ' - ' . $teacher['time_back'] . "</td>";
    echo "<td>" . $teacher['existence'] . "</td>";
    echo "</tr>";
}

echo "</tbody>";

$output = ob_get_clean();

echo $output;

// Close the database connection
$conn = null;
?>
