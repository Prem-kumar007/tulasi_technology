<?php include 'config.php'; ?>

<!DOCTYPE html>
<html>

<head>
<!-- Bootstrap CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
	<div class="container pt-4">
                
        <div class="text-center">
              <h2>Tulasi Technology</h2><br><hr>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value=""> &nbsp;
            <?php
             $qry = "SELECT invoice_id FROM purchases ORDER BY invoice_id DESC LIMIT 1";
             $result = $conn->query($qry);
            

             if ($result->num_rows > 0) {
                // Fetch the row as an associative array
                $row = $result->fetch_assoc();
                
                // Access the 'invoice_id' column from the fetched row
                $inc_id = $row['invoice_id'];
        
                // Output the invoice ID
                
            } else {
                $inc_id =0;
            }

            ?>
            <label for="inc">Invoice No: <?php echo $inc_id +1?></label>
        </div>
     
		<div class="table-responsive">
			<table class="table table-borderless" id="purchase_table">
				<thead>
					<tr>
                        <th class="text-center">
                            S.NO
                        </th>
						<th class="text-center">
							Category <span class="text-danger">*</span>
						</th>
						<th class="text-center">
							Code <span class="text-danger">*</span>
						</th>
                        <th class="text-center">
							Description <span class="text-danger">*</span>
						</th>
						<th class="text-center">
							Units 
						</th>
                        <th class="text-center">
							Qty <span class="text-danger">*</span>
						</th>
						<th class="text-center">
							Price/Unit <span class="text-danger">*</span>
						</th>
                        <th class="text-center">
							VAT
						</th>
                        <th class="text-center">
							Action
						</th>
                       
					</tr>
				</thead>
				<tbody id="tbody">
                    <tr class="rowClass" id="rowClass_1"> 
                        <td class="row-index text-center"> 
                            1
                        </td> 
                        <td class="text-center td_category">
                            <select class="form-select category" aria-label="Default select example">
                                <option selected>choose</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </td>
                        <td class="text-center td_code">
                            <select class="form-select code" aria-label="Default select example">
                                <option selected>choose</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </td>
                        <td class="text-center td_description">
                            <select class="form-select description" aria-label="Default select example">
                                <option selected>choose</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </td>
                        <td class="text-center td_units">
                            <input class="form-control units" type="text" value="">
                        </td>
                        <td class="text-center td_qty">
                            <input class="form-control qty numeric" type="text" min="0" value="">
                        </td>
                        <td class="text-center td_price_unit">
                            <input class="form-control price_unit numeric" type="text" value="">
                        </td>
                        <td class="text-center td_vat">
                            <select class="form-select vat" aria-label="Default select example">
                                <option selected>choose</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-primary"
                                    id="addBtn" type="button">
                                    <i class="bi bi-plus-lg"></i>
                            </button>
                        </td>
                        <td class="text-center td_basic_amt">
                            <input class="form-control basic_amt" type="hidden" value="">
                        </td>
        
                    </tr>
				</tbody>
			</table>

		</div>
        
        <table class="table table-borderless">
            <thead>
              <tr>
                <th scope="col">Basic Amount:</th>
                <th scope="col">Discount %</th>
                <th scope="col">Discount Rs</th>
                <th scope="col">Total Price</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input class="form-control" id="basic_amt" type="number" value="0" readonly></td>
                <td><input class="form-control disc numeric" id="discount" type="text" value="0"></td>
                <td><input class="form-control disc numeric" id="amt" type="text" value="0"></td>
                <td><input class="form-control" id="total_price" type="number" value="0" readonly></td>
              </tr>
            </tbody>
          </table>

          <button class="btn btn-primary"id="submit" type="button">
                Submit
          </button>
          
        
	</div>

<!-- Bootstrap JS CDN -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
	</script>
<!-- jQuery CDN -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js">
	</script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  
<script>
	$(document).ready(() => {

        const today = new Date().toISOString().slice(0, 10);
       
        document.getElementById('date').value = today;

        function fetchVat(row_class_id){
    
            $.ajax({
                url: 'fetch_vat.php',
                method: 'GET',
                dataType: 'json', 
                success: function(data) {
                var codeOptions = data.code_options;
                var vatOptions = data.vat_options;

 
                $('#'+row_class_id).find('.vat').html(vatOptions);
                // $('.code').html(codeOptions);
                
                // Now codeOptions and vatOptions are arrays containing your options
            
              }
            });
        }
        fetchVat('rowClass_1');


        function fetch_ims_code(row_class_id){
    
            $.ajax({
                url: 'ims_item_codes.php',
                method: 'GET',
                dataType: 'json', 
                success: function(data) {
                var cat_options = data.cat_options;
                var code_options = data.code_options;
                var des_options = data.des_options;
                
                 $('#'+row_class_id).find('.category').html(cat_options);
                 $('#'+row_class_id).find('.code').html(code_options);
                 $('#'+row_class_id).find('.description').html(des_options);
                // Now codeOptions and vatOptions are arrays containing your options
            
            }
            });
        }
        fetch_ims_code('rowClass_1');

    
        $(document).on('change', '.vat', function () {

            // var basic_amt =0;

             var row = $(this).closest('tr');
             var qty = parseFloat(row.find('.qty').val()); // Get the quantity value
            var unitPrice = parseFloat(row.find('.price_unit').val()); // Get the unit price value

            var subtotal  = qty * unitPrice;
            var vatPercentOfSubtotal = (parseFloat($(this).val())/ 100) * subtotal;

            var totalPrice = subtotal + vatPercentOfSubtotal;

             
             row.find('.basic_amt').val(totalPrice);

            console.log(totalPrice,'totalPrice');
            // var unitPrice = row.find('.td_unit_price').children('.unit_price').val();
            // console.log(unitPrice,'unitPrice');

            var tot_bs_amt = 0; // Initialize total quantity outside the loop
            

            $('.td_basic_amt').find('.basic_amt').each(function () {
                var sum_bs_amt = parseFloat($(this).val()) || 0;
                tot_bs_amt += sum_bs_amt; 
            });
            $('#basic_amt').val(tot_bs_amt);
        });

        $(document).on('change', '.disc', function() {
            var total_price =0;
            if($(this).val()>=100){
                alert('Only Allowed Less Than 100 in this discount');
                $(this).val('');
            }
            if($(this).attr('id') == 'amt'){
               total_price = $('#basic_amt').val() - $(this).val();
               $('#discount').val('');
            }
            if($(this).attr('id') == 'discount'){
               total_price = $('#basic_amt').val() - parseFloat($(this).val()/100) * $('#basic_amt').val();
               $('#amt').val('');
            }
            $('#total_price').val(total_price);
        });

        $('.numeric').keypress(function(event) {
        var keyCode = event.which ? event.which : event.keyCode;
        // Allow backspace, delete, arrows, and Tab key
        if (keyCode == 8 || keyCode == 46 || (keyCode >= 37 && keyCode <= 40) || keyCode == 9) {
            return true;
        }
        // Allow only numeric values (0-9)
        if (keyCode < 48 || keyCode > 57) {
            event.preventDefault();
            alert('only Numeric allowed');
        }
    });


        $('#submit').on('click',function(){

                var basic_amt = $('#basic_amt').val();
             
               var discount = $('#discount').val();
               var amt = $('#amt').val();
                var total_price = $('#total_price').val();
                var date = $('#date').val();
                var rowsData = []; 

                $('#purchase_table #tbody tr').each(function(index, row){

                        var category    = $(this).find('.category').val();
                        var code        = $(this).find('.code').val();
                        var description = $(this).find('.description').val();
                        var units       = $(this).find('.units').val();
                        var qty         = $(this).find('.qty').val();
                        var price_unit  = $(this).find('.price_unit').val();
                        var vat         = $(this).find('.vat').val();

                        var emptyFields = [];

                        if (category === '') emptyFields.push('Category');
                        if (code === '') emptyFields.push('Code');
                        if (description === '') emptyFields.push('Description');
                       
                        if (qty === '') emptyFields.push('Quantity');
                        if (price_unit === '') emptyFields.push('Price Unit');
                        if (vat === '') emptyFields.push('VAT');
                        
                        if (emptyFields.length > 0){
                            var message = 'Please fill in the following fields in row ' + (index + 1) + ':\n' + emptyFields.join(', ') + ' Those fields are Empty';
                                alert(message);
                                return false; // Stop checking further rows
                        }
                       
                         var rowdata = {

                                    category : category,
                                    code : code,
                                    description : description,
                                    units : units,
                                    qty : qty,
                                    price_unit : price_unit,
                                    vat : vat      
                        }
                        rowsData.push(rowdata);
                });

               
                var datas = {
                    row_data:rowsData,
                    basic_amt:basic_amt,
                    discount:discount,
                    amt:amt,
                    total_price:total_price,
                    date:date
                }
                console.log(datas,'datas');

                $.ajax({
                    type: 'POST',
                    url: 'store.php', // Form action URL
                    data: datas,
                    success: function(response){
                        $('#result').html(response); // Display response in the result div

                        location.reload();
                    }
                });

        });



		let count=2;

		// Adding row on click to Add New Row button
		$('#addBtn').click(function () {
			let dynamicRowHTML = `
			<tr class="rowClass" id=rowClass_${count}> 
				<td class="row-index text-center"> 
                    ${count}
				</td> 
                <td class="text-center td_category">
                    <select class="form-select category" aria-label="Default select example">
                        <option selected>choose</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </td>
                <td class="text-center td_code">
                    <select class="form-select code" aria-label="Default select example">
                        <option selected>choose</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </td>
                <td class="text-center td_description">
                    <select class="form-select description" aria-label="Default select example">
                        <option selected>choose</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </td>
                <td class="text-center td_units">
                    <input class="form-control units" type="text" value="">
                </td>
                <td class="text-center td_qty">
                    <input class="form-control qty" type="text" value="">
                </td>
                <td class="text-center td_price_unit">
                    <input class="form-control price_unit" type="text" value="">
                </td>
                <td class="text-center td_vat">
                    <select class="form-select vat" aria-label="Default select example">
                        <option selected>choose</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </td>
                <td class="text-center"> 
                    <button class="btn btn-danger remove"
                        type="button"><i class="bi bi-trash3-fill"></i>
                    </button> 
                </td> 
                <td class="text-center td_basic_amt">
                    <input class="form-control basic_amt" type="hidden" value="">
                </td>

			</tr>`;
			$('#tbody').append(dynamicRowHTML);
            fetchVat('rowClass_'+count);
            fetch_ims_code('rowClass_'+count);
			count++;
		});

		// Removing Row on click to Remove button
		$('#tbody').on('click', '.remove', function () {
			$(this).parent('td.text-center').parent('tr.rowClass').remove(); 
		});


	})
</script>
</body>

</html>
