<?php
include('connection.php');

$resultsState = isset($results['state']) ? $results['state'] : null;

if (isset($_POST['country_data'])) {
    $country_id = $_POST['country_data'];
    $result = mysqli_query($conn, "SELECT * FROM states WHERE country_id = $country_id");

    $res = '<option value="">Select state</option>';
    
    while ($row = mysqli_fetch_array($result)) {
        $isSelected = ($resultsState !== null && $row['state_id'] == $resultsState) ? 'selected' : '';
        $res .= '<option value="' . $row["state_id"] . '" ' . $isSelected . '>' . $row['state_name'] . '</option>';
    }

    echo $res;
}


?>


