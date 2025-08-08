<?php 
require_once 'config.php';


if (isset($_POST['allData'])) {
    $allData = $_POST['allData'];
    if (!is_array($allData)) {
        // convert to array
        $allData = explode(',', $allData);
    }
    $i = 1;
    foreach($allData as $value){
        $value = intval($value);
        $sql = "UPDATE sorting_record SET display_order = $i WHERE id = $value";
        $conn->query($sql);
        $i++;
    }
}


?>
