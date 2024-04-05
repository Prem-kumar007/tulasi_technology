<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
 
    $row_data = $_POST['row_data'];
    $basic_amt = $_POST['basic_amt'];
    $dis_per =$_POST['discount']; 
    $dis_amt =$_POST['amt'];
    $tot_price = $_POST['total_price'];
    $date = $_POST['date'];
    $invoic_sql = "INSERT INTO invoice(invoice) VALUES (NULL)";

    if ($conn->query($invoic_sql) === TRUE) {
    
        $invoice_id = $conn->insert_id;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

     // Loop through each row of data and insert into the purchase_table
     foreach ($row_data as $row) {
        $category = $row['category'];
        $code = $row['code'];
        $description = $row['description'];
        $units = $row['units'];
        $qty = $row['qty'];
        $price_unit = $row['price_unit'];
        $vat = $row['vat'];
       
        // Prepare and execute the SQL insert statement
        $sql = "INSERT INTO purchases (category, code, description, units,date, qty, price_unit, vat,basic_amt,dis_per,dis_amt,tot_price,invoice_id)
                VALUES ('$category', '$code', '$description', '$units','$date', '$qty', '$price_unit', '$vat','$basic_amt','$dis_per','$dis_amt','$tot_price','$invoice_id')";

        if ($conn->query($sql) === TRUE) {
            echo "Data inserted successfully.";
        } else {
          
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    } else {
        // Handle non-POST requests
        echo "Invalid request!";
    }

?>