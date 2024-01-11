<?php
include("connection.php");

$sql = "SELECT * FROM student";
$result = mysqli_query($conn, $sql);

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"data" . date('Ymd') . ".xls\"");

echo "Username\tFirst Name\tLast Name\tGender\tCountry\tState\tCity\tHobbies\n";

while ($row = mysqli_fetch_assoc($result)) {
    $countryQuery = mysqli_query($conn, "SELECT country_name FROM countries WHERE country_id = {$row['country']}");
    $country = mysqli_fetch_assoc($countryQuery)['country_name'];

    $stateQuery = mysqli_query($conn, "SELECT state_name FROM states WHERE state_id = {$row['state']}");
    $state = mysqli_fetch_assoc($stateQuery)['state_name'];

    $cityQuery = mysqli_query($conn, "SELECT city_name FROM cities WHERE city_id = {$row['city']}");
    $city = mysqli_fetch_assoc($cityQuery)['city_name'];

    $hobbies = unserialize($row['hobbies']);
    
    $rowData = array(
        $row['username'],
        $row['firstname'],
        $row['lastname'],
        $row['gender'],
        $country,
        $state,
        $city,
        implode(', ', $hobbies)  
    );

    echo implode("\t", $rowData) . "\n";
}

mysqli_close($conn);
?>
