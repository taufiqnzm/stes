<?php
session_start();
require_once "config.php"; // Use require_once to ensure it's included only once
include "restricted.php";

if (isset($_GET['query_type'])) {
    $queryType = $_GET['query_type'];
    $result = null;

    if ($queryType === 'absent') {
        $query = "SELECT applicants.name, DATE_FORMAT(applicants.start_date, '%d-%m-%Y') AS start_date, 
                DATE_FORMAT(applicants.final_date, '%d-%m-%Y') AS final_date, 
                users.major, users.phone, applicants.reason, applicants.time_leave, applicants.time_back
          FROM applicants
          JOIN users ON applicants.user_id = users.user_id
          WHERE applicants.existence = 'Absent' 
          AND :selected_date BETWEEN applicants.start_date AND applicants.final_date
          ORDER BY applicants.form_id DESC";
    } elseif ($queryType === 'emergency') {
        $query = "SELECT applicants.name, DATE_FORMAT(applicants.start_date, '%d-%m-%Y') AS start_date, 
                 DATE_FORMAT(applicants.final_date, '%d-%m-%Y') AS final_date,
                 users.major, users.phone, applicants.reason, applicants.time_leave, applicants.time_back
          FROM applicants
          JOIN users ON applicants.user_id = users.user_id
          WHERE applicants.existence = 'Emergency' 
          AND :selected_date BETWEEN applicants.start_date AND applicants.final_date
          ORDER BY applicants.form_id DESC";
    } elseif ($queryType === 'official_business') {
        $query = "SELECT applicants.name, DATE_FORMAT(applicants.start_date, '%d-%m-%Y') AS start_date, 
                 DATE_FORMAT(applicants.final_date, '%d-%m-%Y') AS final_date,
                 users.major, users.phone, applicants.program_name,applicants.time_leave, applicants.time_back FROM applicants
          JOIN users ON applicants.user_id = users.user_id
          WHERE applicants.existence = 'Official Business' 
          AND :selected_date BETWEEN applicants.start_date AND applicants.final_date
          ORDER BY applicants.form_id DESC";
    } elseif ($queryType === 'crk') {
        $query = "SELECT applicants.name, DATE_FORMAT(applicants.start_date, '%d-%m-%Y') AS start_date, 
                 DATE_FORMAT(applicants.final_date, '%d-%m-%Y') AS final_date,
                 users.major, users.phone, applicants.time_leave, applicants.time_back
          FROM applicants
          JOIN users ON applicants.user_id = users.user_id
          WHERE applicants.existence = 'CRK' 
          AND :selected_date BETWEEN applicants.start_date AND applicants.final_date
          ORDER BY applicants.form_id DESC";
    } elseif ($queryType === 'haji_umrah') {
        $query = "SELECT applicants.name, DATE_FORMAT(applicants.start_date, '%d-%m-%Y') AS start_date, 
                 DATE_FORMAT(applicants.final_date, '%d-%m-%Y') AS final_date,
                 users.major, users.phone, applicants.time_leave, applicants.time_back
          FROM applicants
          JOIN users ON applicants.user_id = users.user_id
          WHERE applicants.existence = 'Haji Umrah' 
          AND :selected_date BETWEEN applicants.start_date AND applicants.final_date
          ORDER BY applicants.form_id DESC";
    } elseif ($queryType === 'bersalin') {
        $query = "SELECT applicants.name, DATE_FORMAT(applicants.start_date, '%d-%m-%Y') AS start_date, 
                 DATE_FORMAT(applicants.final_date, '%d-%m-%Y') AS final_date,
                 users.major, users.phone, applicants.time_leave, applicants.time_back
          FROM applicants
          JOIN users ON applicants.user_id = users.user_id
          WHERE applicants.existence = 'Cuti Bersalin' 
          AND :selected_date BETWEEN applicants.start_date AND applicants.final_date
          ORDER BY applicants.form_id DESC";
    } elseif ($queryType === 'keberadaan_jam') {
        $query = "SELECT applicants.name, DATE_FORMAT(applicants.start_date, '%d-%m-%Y') AS start_date, 
                 DATE_FORMAT(applicants.final_date, '%d-%m-%Y') AS final_date,
                 users.major, users.phone, applicants.time_leave, applicants.time_back
          FROM applicants
          JOIN users ON applicants.user_id = users.user_id
          WHERE applicants.existence = 'Keberadaan Jam' 
          AND :selected_date BETWEEN applicants.start_date AND applicants.final_date
          ORDER BY applicants.form_id DESC";
    } elseif ($queryType === 'cuti_lain') {
        $query = "SELECT applicants.name, DATE_FORMAT(applicants.start_date, '%d-%m-%Y') AS start_date, 
                 DATE_FORMAT(applicants.final_date, '%d-%m-%Y') AS final_date,
                 users.major, users.phone, applicants.leave_type, applicants.time_leave, applicants.time_back
          FROM applicants
          JOIN users ON applicants.user_id = users.user_id
          WHERE applicants.existence = 'Cuti Lain' 
          AND :selected_date BETWEEN applicants.start_date AND applicants.final_date
          ORDER BY applicants.form_id DESC";
    }

    if (isset($query)) {
        // Prepare the query
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':selected_date', $_GET['selected_date'], PDO::PARAM_STR);
        $stmt->execute();

        // Fetch the result
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Return the result as JSON
    echo json_encode($result);

    // Close the database connection
    $conn = null;
}
?>
