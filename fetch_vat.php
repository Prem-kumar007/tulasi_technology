<?php
include 'config.php';

$sql = "SELECT * FROM vat";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $code_options = '<option value="">choose</option>';
    $vat_options = '<option value="">choose</option>';
    while ($row = $result->fetch_assoc()) {
        $code_options .='<option value="'.$row["Code"].'">'.$row["Code"].'</option>'; 
        $vat_options .='<option value="'.$row["vatper"].'">'.$row["vatper"].'</option>'; 
    }
 
} else {
    $code_options ='';
    $vat_options ='';
}

$response = array("code_options" => $code_options, "vat_options" => $vat_options);
echo json_encode($response);
     
$conn->close();
?>
