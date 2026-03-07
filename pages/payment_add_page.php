    <?php
	include "../includes/db-con.php";

    $selectedVendor = 1;
    $allgrnQuery="";
    $NewID=0;
    $message="";
    $returnAll="";
    $selectedVat=0;

    //------------------ Generate New User ID --------------------------------
    $Query_id="SELECT MAX(receiptID) FROM payments";
	$return=mysqli_query($conn,$Query_id);
	$row=mysqli_fetch_assoc($return);
	$lastID=$row['MAX(receiptID)'];
	
	if(empty($lastID))
	{
		$NewID=$lastID='1001';
	}
	else
	{
		$NewID=$lastID+1;
	}
    
    //------------------ Fetch Buyer Name and Style Nos -------------------
    $sqlQuery1="SELECT * FROM  vendors WHERE status='Active'";
    $returnDataSet1=mysqli_query($conn,$sqlQuery1);

        //------------------ Fetch Payment Methods -------------------
    $sqlMethod="SELECT * FROM  payment_methods WHERE status='1'";
    $returnMethod=mysqli_query($conn,$sqlMethod);

    //------------------ Fetch Selected Vendor -------------------
    if(isset($_POST['vendorid']))
    {
        $selectedVendor=$_POST['vendorid'];
        $selectedVat=$_POST['vatPercentage'];
    }
    
    
    if($selectedVendor != ""){
            $allgrnQuery="SELECT GD.grnCode1 AS 'CODE1',CONCAT(GD.grnCode2,'/',GD.grnCode1) AS 'CODE2',GD.invoiceNo AS 'INV', SO.styleNo AS 'STYLE',SO.orderNo AS 'ORDERNO', 
                DATE_FORMAT(GD.invoiceDate,'%d/%m/%y') AS 'INVDATE',GD.recFnishedQty AS 'RECFQTY', V.vendor AS 'VEN',GD.recDamQty AS 'RECDQTY',GD.recSampleQty AS 'RECSQTY', 
                (GD.fgValue+GD.sampleValue+GD.vat) AS 'GRNVAL', DATE_FORMAT(GD.createdDT,'%d/%m/%y') AS 'GRNDATE', CONCAT(U.Fname, ' ', U.Lname) AS 'GRNBY' 
                FROM grn_details GD JOIN sub_production SP ON GD.proRecNo=SP.recordID JOIN styleorder SO ON SP.orderNoID=SO.id 
                JOIN mast_location ML ON SP.locationID=ML.locationID JOIN vendors V ON GD.VendorID=V.vendorID JOIN users U ON SP.createdBy=U.User_ID 
                JOIN agreements A ON SP.orderAgreement=A.id WHERE GD.VendorID='$selectedVendor' AND GD.status='Approved' AND 
                SP.status='Approved' AND SO.Status='Active' AND ML.status='Active' AND V.status='Active' AND V.status='Active' AND A.Status='Active' ORDER BY GD.createdDT DESC";

        $returnAll=mysqli_query($conn,$allgrnQuery);
    }

    $activeUser=$_SESSION['_UserID'];

    if(isset($_POST['btnSave']))
    {
        $receiptID=$NewID;
        $payDate=$_POST['payDate'];
        $accDetails=$_POST['acc'];
        $methodID=$_POST['methodid'];
        $payDate=$_POST['payDate'];
        $refNo=$_POST['refno'];
        $gross=$_POST['refno'];
        $vat=$selectedVat;
        $vatValue=($gross*$vat)/100;
        $netValue=$gross+$vatValue;
        $createdBy=$activeUser;
        $selectedGRNs=$_POST['selectedGRN'];

        if(empty($selectedGRNs))
        {
            $message="Please select at least one GRN.";
        }
        else
        {
            // Insert into payments table
            $insertPaymentQuery="INSERT INTO payments (receiptID, date, VendorID, payMenthod, accountdetails, refNo, grossValue, vat, vatValue, netValue, createdDT, createdBy, Status) 
                                VALUES ('$receiptID', '$payDate','$seletedVendor', '$methodID', '', '$refNo', $gross, $vat, $vatValue, $netValue, NOW(), '$activeUser', 'Pending')";
            if(mysqli_query($conn, $insertPaymentQuery))
            {
                // Get the last inserted payment ID
                $paymentID = mysqli_insert_id($conn);

                // Insert into payment_grn table for each selected GRN
                foreach($selectedGRNs as $grnID)
                {
                    $insertPaymentGrnQuery="INSERT INTO payment_grn (paymentID, grnID) VALUES ('$paymentID', '$grnID')";
                    mysqli_query($conn, $insertPaymentGrnQuery);
                }

                // Redirect to payment view page
                header("Location: payment_view_page.php?activity=paymentView&paymentID=$paymentID");
                exit();
            }
            else
            {
                $message="Error saving payment: " . mysqli_error($conn);
            }
        }
    }   
 ?>
 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
</head>
<body>
    <div class="d-flex justify-content-between mb-3">
        <h4>Add Payment Receipt</h4>
    </div>
    <form method="POST">
        <div class="container-fluid">
            <!---------------------------------- Vendor Style Order Section -------------------------------------- -->
            <div class="form-group col-md-4 me-3">
                            <label >Vendor</label>
                            <select class="form-select" name="vendorid" id="vendorSelect" onchange="this.form.submit()"  >
                                <option selected hidden></option>
                                <?php 
                                    while($vendor=mysqli_fetch_assoc($returnDataSet1)){
                                        ?>
                                        <option value="<?php echo $vendor['vendorID']; ?>" 
                                        <?php if(isset($_POST['vendorid']) && $_POST['vendorid']==$vendor['vendorID']) echo "selected"; ?>>
                                        <?php echo $vendor['vendor']?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
            </div>
            <!-- --------------------------------------------------------------------------------------------------- -->
            <hr>
            <div class="d-lg-flex mt-3 mb-3 gap-3" >
                    <div class="form-group col-lg-2">
                        <label>Payment Date</label>
                        <input type="date" class="form-control" id="payDate" required name="payDate"/>
                    </div>
                    <div class="form-group mb-1 col-3">
                        <label for="refno">Reference No.</label>
                        <input type="text" class="form-control" id="refno" name="refno" required/>
                    </div>
            </div>
            <div class="d-lg-flex mt-3 mb-3 gap-3" >
                    <div class="form-group col-md-4 me-3">
                            <label >Payment Method</label>
                            <select class="form-select" name="methodid" id="methodSelect" onchange="this.form.submit()"  >
                                <option selected hidden></option>
                                <?php 
                                    while($method=mysqli_fetch_assoc($returnMethod)){
                                        ?>
                                        <option value="<?php echo $method['methodID']; ?>" 
                                        <?php if(isset($_POST['methodid']) && $_POST['methodid']==$method['methodID']) echo "selected"; ?>>
                                        <?php echo $method['paymethod']?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                    </div>
                    <div class="form-group mb-1 col-3">
                        <label for="acc">Account Details</label>
                        <input type="text" class="form-control" id="acc" name="acc" required/>
                    </div>
            </div>
            <!-- -------------------------------------------------------------------------------------------------------------------- -->
             <div class="text-center p-3"><h4>GRN Details</h4></div>
            <div class="table-wrapper">
                            <table class="table1 text-center" cellspacing="0" style="font-size: 9pt;">
                                <tr class="table-header">
                                    <th hidden></th>
                                    <th>Add</th>
                                    <th>GRN No.</th>
                                    <th>Style</th>
                                    <th>Order</th>
                                    <th>Invoice No.</th>
                                    <th>Invoice Date</th>
                                    <th>Vendor</th>
                                    <th>Finished Qty.</th>
                                    <th>Damage Qty.</th>
                                    <th>Sample Qty.</th>
                                    <th>GRN Value</th>
                                    <th>GRN Date</th>
                                    <th>Created By</th>			
                                </tr>
                                <?php
                                try{
                                    while($result1=mysqli_fetch_assoc($returnAll))
                                    {
                                        ?>
                                        <tr class="flex align-items-center">
                                            <td hidden><input type="text" name="grnID" value="<?php echo $result1['CODE1']; ?>"></td> 
                                            <td><input type="checkbox" class="form-check-input" name="selectedGRN[]" value="<?php echo $result1['CODE1']; ?>"></td>
                                            <td class="text-center"><?php 
                                                    $selected= $result1['CODE1'];
                                                    $url = 'grn_view_page.php?activity=grnView&Criteria=Grn&selectedID= '.$selected;
                                                    echo '<a href="' . htmlspecialchars($url) . '" target="_blank" rel="noopener noreferrer">'.$result1['CODE2'].'</a>';
                                            ?></td> 
                                            <td><?php echo $result1['STYLE']?></td>
                                            <td><?php echo $result1['ORDERNO']?></td>
                                            <td><?php echo $result1['INV']?></td>
                                            <td ><?php echo $result1['INVDATE']?></td>
                                            <td><?php echo $result1['VEN']?></td>
                                            <td><?php echo $result1['RECFQTY']?></td>
                                            <td><?php echo $result1['RECDQTY']?></td>
                                            <td><?php echo $result1['RECSQTY']?></td>
                                            <td class="decimal-data"><?php echo $result1['GRNVAL'];?></td>
                                            <td><?php echo $result1['GRNDATE']?></td>
                                            <td><?php echo $result1['GRNBY']?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                catch(Exception $e){
                                    echo "Error: " . $e->getMessage();
                                }
                                ?>
                            </table>
            </div>
            <div class="d-lg-flex justify-content-center mb-5 mt-3 gap-2">
                <input type="submit" value="Save" class="btn btn-primary me-2 save_btn" name="btnSave"/>
                <input type="button" value="Clear" class="btn btn-secondary save_btn" name="btnClear" onclick="window.location.href='home_page.php?activity=grnAll'"/>
            </div>
        </div>

    </form>
    <div class="container text-center" >
        <label class="text-danger"><?php echo $message?></label>
    </div>
    <script>

    //call by currency-data
    let cells = document.querySelectorAll(".decimal-data");
        cells.forEach(function(cell) {
        let number = Number(cell.textContent);
        cell.textContent = number.toLocaleString('en-US', {
            style: 'decimal',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    });

    //let cells = document.querySelectorAll(".currency-data");
    // cells.forEach(function(cell) {
    // let number = Number(cell.textContent);
    // cell.textContent = number.toLocaleString('en-US', {
    //     style: 'currency',
    //     currency: 'USD'
    // });
    // });
</script>
</body>
</html>
