<?php
include 'config.php';

$sql = "SELECT * FROM ims_itemcodes";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $cat_options = '<option value="">choose</option>';
    $code_options = '<option value="">choose</option>';
    $des_options = '<option value="">choose</option>';
    while ($row = $result->fetch_assoc()) {
        $cat_options .='<option value="'.$row["cat"].'">'.$row["cat"].'</option>'; 
        $code_options .='<option value="'.$row["code"].'">'.$row["code"].'</option>'; 
        $des_options .='<option value="'.$row["description"].'">'.$row["description"].'</option>'; 
    }
 
} else {
    $cat_options ='';
    $code_options ='';
    $des_options ='';
}

$response = array("cat_options" => $cat_options, "code_options" => $code_options,"des_options" => $des_options);
echo json_encode($response);
     
$conn->close();
?>
