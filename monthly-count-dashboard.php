<?php
require_once "config.php"; // Use require_once to ensure it's included only once
date_default_timezone_set('Asia/Kuala_Lumpur');

$currentYear = date("Y");

// Create an array to store the sums for each month of the year
$yearlyCounts = array(
    'absent' => array(),
    'official_business' => array(),
    'emergency' => array(),
    'crk' => array(),
    'cuti_lain' => array(),
    'bersalin' => array(),
    'haji_umrah' => array(),
    'keberadaan_jam' => array()
);

// Retrieve the sums for each month in the current year
for ($i = 1; $i <= 12; $i++) {
    $startOfMonth = "$currentYear-$i-01";
    $endOfMonth = date('Y-m-t', strtotime($startOfMonth));

    // Fetch and sum the data from the "dashboard" table for the current month
    $query = "SELECT SUM(absent_teacher_count) AS total_absent, SUM(official_business_teacher_count) AS total_official, SUM(emergency_teacher_count) AS total_emergency,
                     SUM(crk_teacher_count) AS total_crk, SUM(cuti_lain_count) AS total_cuti_lain, SUM(cuti_bersalin_count) AS total_bersalin, 
                     SUM(cuti_hajiUmrah_count) AS total_haji_umrah, SUM(keberadaan_jam_count) AS total_keberadaan
              FROM dashboard
              WHERE `date` BETWEEN :startOfMonth AND :endOfMonth";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':startOfMonth', $startOfMonth, PDO::PARAM_STR);
    $stmt->bindParam(':endOfMonth', $endOfMonth, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    // Store the sums for the current month in the yearlyCounts array
    $yearlyCounts['absent'][] = intval($results['total_absent']);
    $yearlyCounts['official_business'][] = intval($results['total_official']);
    $yearlyCounts['emergency'][] = intval($results['total_emergency']);
    $yearlyCounts['crk'][] = intval($results['total_crk']);
    $yearlyCounts['cuti_lain'][] = intval($results['total_cuti_lain']);
    $yearlyCounts['bersalin'][] = intval($results['total_bersalin']);
    $yearlyCounts['haji_umrah'][] = intval($results['total_haji_umrah']);
    $yearlyCounts['keberadaan_jam'][] = intval($results['total_keberadaan']);
}
?>

<script>
    var absentData = <?= json_encode($yearlyCounts['absent']) ?>;
    var officialData = <?= json_encode($yearlyCounts['official_business']) ?>;
    var emergencyData = <?= json_encode($yearlyCounts['emergency']) ?>;
    var crkData = <?= json_encode($yearlyCounts['crk']) ?>;
    var cutiLainData = <?= json_encode($yearlyCounts['cuti_lain']) ?>;
    var bersalinData = <?= json_encode($yearlyCounts['bersalin']) ?>;
    var hajiUmrahData = <?= json_encode($yearlyCounts['haji_umrah']) ?>;
    var keberadaanJamData = <?= json_encode($yearlyCounts['keberadaan_jam']) ?>;
</script>