<?php
require_once "config.php"; // Use require_once to ensure it's included only once

$user_id = $_SESSION['user_id']; // Assuming you store the user's ID in the session

// Subquery to count absent teachers
$countAbsentQuery = "SELECT COUNT(*) as absent_personal_count
              FROM applicants
              WHERE existence = 'Absent' AND user_id = :user_id";

// Subquery to count emergency teachers
$countEmergencyQuery = "SELECT COUNT(*) as emergency_personal_count
              FROM applicants
              WHERE existence = 'Emergency' AND user_id = :user_id";

// Subquery to count official business teachers
$countOfficialBusinessQuery = "SELECT COUNT(*) as official_business_personal_count
              FROM applicants
              WHERE existence = 'Official Business' AND user_id = :user_id";
// Subquery to count CRK teachers
$countCRKQuery = "SELECT COUNT(*) as cuti_rehat_khas_personal_count
              FROM applicants
              WHERE existence = 'CRK' AND user_id = :user_id";

// Subquery to count Haji Umrah teachers
$countCutiHajiUmrahQuery = "SELECT COUNT(*) as cuti_hajiUmrah_personal_count
              FROM applicants
              WHERE existence = 'Haji Umrah' AND user_id = :user_id";

// Subquery to count Bersalin teachers
$countBersalinQuery = "SELECT COUNT(*) as cuti_bersalin_personal_count
              FROM applicants
              WHERE existence = 'Bersalin' AND user_id = :user_id";

// Subquery to count Cuti Lainteachers
$countCutiLainQuery = "SELECT COUNT(*) as cuti_lain_personal_count
              FROM applicants
              WHERE existence = 'Cuti Lain' AND user_id = :user_id";

// Subquery to count Keberadaan 4 Jam teachers
$countKeberadaanJamQuery = "SELECT COUNT(*) as keberadaan_jam_personal_count
              FROM applicants
              WHERE existence = 'Keberadaan Jam' AND user_id = :user_id";

// Execute the count query for absent teachers
$countAbsentStmt = $conn->prepare($countAbsentQuery);
$countAbsentStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$countAbsentStmt->execute();
$countAbsentResult = $countAbsentStmt->fetch(PDO::FETCH_ASSOC);

$absent_personal_count = $countAbsentResult['absent_personal_count'];

// Execute the count query for emergency teachers
$countEmergencyStmt = $conn->prepare($countEmergencyQuery);
$countEmergencyStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$countEmergencyStmt->execute();
$countEmergencyResult = $countEmergencyStmt->fetch(PDO::FETCH_ASSOC);

$emergency_personal_count = $countEmergencyResult['emergency_personal_count'];

// Execute the count query for official business teachers
$countOfficialBusinessStmt = $conn->prepare($countOfficialBusinessQuery);
$countOfficialBusinessStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$countOfficialBusinessStmt->execute();
$countOfficialBusinessResult = $countOfficialBusinessStmt->fetch(PDO::FETCH_ASSOC);

$official_business_personal_count = $countOfficialBusinessResult['official_business_personal_count'];

// Execute the count query for CRK teachers
$countCRKStmt = $conn->prepare($countCRKQuery);
$countCRKStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$countCRKStmt->execute();
$countCRKResult = $countCRKStmt->fetch(PDO::FETCH_ASSOC);

$cuti_rehat_khas_personal_count = $countCRKResult['cuti_rehat_khas_personal_count'];

// Execute the count query for Haji Umrah teachers
$countHajiUmrahStmt = $conn->prepare($countCutiHajiUmrahQuery);
$countHajiUmrahStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$countHajiUmrahStmt->execute();
$countHajiUmrahResult = $countHajiUmrahStmt->fetch(PDO::FETCH_ASSOC);

$cuti_hajiUmrah_personal_count = $countHajiUmrahResult['cuti_hajiUmrah_personal_count'];

// Execute the count query for Bersalin teachers
$countBersalinStmt = $conn->prepare($countBersalinQuery);
$countBersalinStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$countBersalinStmt->execute();
$countBersalinResult = $countBersalinStmt->fetch(PDO::FETCH_ASSOC);

$cuti_bersalin_personal_count = $countBersalinResult['cuti_bersalin_personal_count'];

// Execute the count query for Cuti Lain teachers
$countCutiLainStmt = $conn->prepare($countCutiLainQuery);
$countCutiLainStmt ->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$countCutiLainStmt ->execute();
$countCutiLainResult = $countCutiLainStmt ->fetch(PDO::FETCH_ASSOC);

$cuti_lain_personal_count = $countCutiLainResult['cuti_lain_personal_count'];

// Execute the count query for Keberadaan 4 Jam teachers
$countKeberadaanJamStmt = $conn->prepare($countKeberadaanJamQuery);
$countKeberadaanJamStmt ->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$countKeberadaanJamStmt ->execute();
$countKeberadaanJamResult = $countKeberadaanJamStmt ->fetch(PDO::FETCH_ASSOC);

$keberadaan_jam_personal_count = $countKeberadaanJamResult['keberadaan_jam_personal_count'];

?>
