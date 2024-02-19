<?php
session_start();
require_once "config.php"; // Use require_once to ensure it's included only once

// Define an array to store the categories and their corresponding labels
$categories = array(
    'Emergency' => 'emergency_percentage',
    'Absent' => 'absent_percentage',
    'Official Business' => 'official_business_percentage',
);

// Initialize an array to store the results
$teacher_data = array();

foreach ($categories as $category => $session_var) {
    // Fetch data from the "applicants" table for the current category and join with the "users" table
    $query = "SELECT applicants.name, users.major, users.phone, applicants.program_name, applicants.start_date, applicants.evidence FROM applicants
              JOIN users ON applicants.user_id = users.user_id
              WHERE applicants.existence = :category";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':category', $category);
    $stmt->execute();
    
    // Calculate the percentage of teachers for the current category
    $category_teachers = $stmt->rowCount();
    
    // Calculate the total number of teachers
    $totalTeachersQuery = "SELECT COUNT(*) as total FROM users";
    $totalTeachersResult = $conn->query($totalTeachersQuery);
    $totalTeachers = $totalTeachersResult->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Calculate the category's percentage and store it in the session
    if ($totalTeachers > 0) {
        $category_percentage = ($category_teachers / $totalTeachers) * 100;
        $category_percentage = number_format($category_percentage, 0);
    } else {
        $category_percentage = 0; // To avoid division by zero
    }
    
    $_SESSION[$session_var] = $category_percentage;
    
    // Store the teacher data for the current category
    $teachers = array();
    if ($category_teachers > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $teachers[] = $row;
        }
    }
    
    $teacher_data[$category] = $teachers;
}

// Close the database connection
$conn = null;
?>
