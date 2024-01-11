<?php
include('connection.php');
$resultcity=isset($results['city']) ? $results['city']:null; 
if (isset($_POST['state_data'])) {
    $state_id = $_POST['state_data'];
    $result = mysqli_query($conn, "SELECT * FROM cities WHERE state_id = $state_id");

    $res = '<option value="">Select City</option>';
    
    while ($row2 = mysqli_fetch_array($result)) {
        $isSelected = ($resultcity!==null && $row2['city_id'] == $resultcity) ? 'selected' : '';
        $res .= '<option value="' . $row2["city_id"] . '" ' . $isSelected . '>' . $row2['city_name'] . '</option>';
    }

    echo $res;
}
?>
