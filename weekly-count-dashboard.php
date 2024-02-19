<?php
require_once "config.php"; // Use require_once to ensure it's included only once
date_default_timezone_set('Asia/Kuala_Lumpur');

$currentDate = date("Y-m-d");

// Create an array to store the counts for each day of the week
$weeklyCounts = array(
    'absent' => array(),
    'official_business' => array(),
    'emergency' => array(),
    'crk' => array(),
    'cuti_lain' => array(),
    'bersalin' => array(),
    'haji_umrah' => array(),
    'keberadaan_jam' => array()
);

// Retrieve the counts for each day in the past week
for ($i = 1; $i <= 7; $i++) {
    $day = date('Y-m-d', strtotime("-$i days", strtotime($currentDate)));

    // Fetch data from the "dashboard" table for the current day
    $query = "SELECT absent_teacher_count, official_business_teacher_count, emergency_teacher_count,
                     crk_teacher_count, cuti_lain_count, cuti_bersalin_count, cuti_hajiUmrah_count,
                     keberadaan_jam_count
              FROM dashboard
              WHERE `date` = :day";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':day', $day, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Store the counts in the weeklyCounts array
        $weeklyCounts['absent'][] = $result['absent_teacher_count'];
        $weeklyCounts['official_business'][] = $result['official_business_teacher_count'];
        $weeklyCounts['emergency'][] = $result['emergency_teacher_count'];
        $weeklyCounts['crk'][] = $result['crk_teacher_count'];
        $weeklyCounts['cuti_lain'][] = $result['cuti_lain_count'];
        $weeklyCounts['bersalin'][] = $result['cuti_bersalin_count'];
        $weeklyCounts['haji_umrah'][] = $result['cuti_hajiUmrah_count'];
        $weeklyCounts['keberadaan_jam'][] = $result['keberadaan_jam_count'];
    } else {
        // If no data is available for the day, set counts to 0
        $weeklyCounts['absent'][] = 0;
        $weeklyCounts['official_business'][] = 0;
        $weeklyCounts['emergency'][] = 0;
        $weeklyCounts['crk'][] = 0;
        $weeklyCounts['cuti_lain'][] = 0;
        $weeklyCounts['bersalin'][] = 0;
        $weeklyCounts['haji_umrah'][] = 0;
        $weeklyCounts['keberadaan_jam'][] = 0;
    }
}

// Calculate the sum of counts for each type
$sumAbsent = array_sum($weeklyCounts['absent']);
$sumOfficial = array_sum($weeklyCounts['official_business']);
$sumEmergency = array_sum($weeklyCounts['emergency']);
$sumCrk = array_sum($weeklyCounts['crk']);
$sumCutiLain = array_sum($weeklyCounts['cuti_lain']);
$sumBersalin = array_sum($weeklyCounts['bersalin']);
$sumHajiUmrah = array_sum($weeklyCounts['haji_umrah']);
$sumKeberadaan = array_sum($weeklyCounts['keberadaan_jam']);

echo "<script>";
echo "var sumAbsent = $sumAbsent;";
echo "var sumOfficial = $sumOfficial;";
echo "var sumEmergency = $sumEmergency;";
echo "var sumCrk = $sumCrk;";
echo "var sumCutiLain = $sumCutiLain;";
echo "var sumBersalin = $sumBersalin;";
echo "var sumHajiUmrah = $sumHajiUmrah;";
echo "var sumKeberadaan = $sumKeberadaan;";
echo "</script>";

?>
