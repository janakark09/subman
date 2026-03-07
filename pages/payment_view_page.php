<?php
	include "../includes/db-con.php";
    session_start();

    $gpID="";
    $vendor="";
    $message="";
    $address="";
    $tel="";
    $person="";
    $date="";
    $location="";
    $createdby="";
    $createddt="";
    $style="";
    $order="";
    $agreement="";
    $total="";
    $no = 1;
    $user="";
    $approvedby=" ";
    $approveddt="";
    $accConfirm=0;
    $status="";
    
    
    $selectedID=$_REQUEST['selectedID'];

    $receiptQuery="SELECT P.receiptID AS 'ID', DATE_FORMAT(P.Date,'%d/%m/%y') AS 'DATE', V.vendor AS 'VEN', PM.paymethod AS 'METHOD', P.accountdetails AS 'ACC', 
            P.refNo AS 'REF',P.grossValue AS 'GROSS',P.vat AS 'VAT',P.vatValue AS 'VATVAL',P.netValue AS 'NETVAL', CONCAT(U.Fname,'',U.Lname) AS 'USER',
            DATE_FORMAT(P.createdDT,'%d/%m/%y') AS 'CREATEDDT',P.Status AS 'STATUS', P.approvedBy AS 'APPROVED', DATE_FORMAT(P.approvedDT,'%d/%m/%y') AS 'APPROVEDDT'  FROM payments P 
            JOIN payment_methods PM ON P.payMenthod=PM.methodID JOIN vendors V ON P.VendorID=V.vendorID JOIN users U ON P.createdBy=U.User_ID 
            WHERE P.receiptID='$selectedID'";
    $selectedData=mysqli_query($conn,$receiptQuery);

    if($selectedData && mysqli_num_rows($selectedData)==1)
        {
            $rowData=mysqli_fetch_assoc($selectedData);
            $receiptID=$rowData['ID'];
            $paymentdate=$rowData['DATE'];
            $vendor=$rowData['VEN'];
            $method=$rowData['METHOD'];
            $accountdetails=$rowData['ACC']; 
            $refNo=$rowData['REF'];
            $grossValue=$rowData['GROSS'];
            $vat=$rowData['VAT'];
            $vatValue=$rowData['VATVAL'];
            $netValue=$rowData['NETVAL'];
            $createdby=$rowData['USER'];
            $createddate=$rowData['CREATEDDT'];
            $status=$rowData['STATUS'];
            $approvedby=$rowData['APPROVED'];
            $approveddt=$rowData['APPROVEDDT'];
        }
    
    $detailsQuery="SELECT CONCAT(GD.grnCode2,'/',GD.grnCode1) AS 'CODE2',GD.invoiceNo AS 'INV', SO.styleNo AS 'STYLE',SO.orderNo AS 'ORDERNO', 
                DATE_FORMAT(GD.invoiceDate,'%d/%m/%y') AS 'INVDATE',(GD.recFnishedQty+GD.recSampleQty) AS 'GRNQTY',   
                (GD.fgValue+GD.sampleValue+GD.vat) AS 'GRNVAL' FROM grn_details GD JOIN sub_production SP ON GD.proRecNo=SP.recordID JOIN styleorder SO ON SP.orderNoID=SO.id 
                JOIN mast_location ML ON SP.locationID=ML.locationID JOIN vendors V ON GD.VendorID=V.vendorID JOIN users U ON SP.createdBy=U.User_ID 
                JOIN agreements A ON SP.orderAgreement=A.id WHERE GD.receiptID='$selectedID' 
                ORDER BY GD.grnCode1 DESC";
    $detailsData=mysqli_query($conn,$detailsQuery);

	$activeUser=$_SESSION['_UserID'];

    $userQuery="SELECT CONCAT(U.Fname,' ',U.Lname) AS 'CURRENTU', UD.acc10 AS 'APP1' FROM users U JOIN user_details UD ON U.User_ID=UD.User_ID WHERE U.User_ID='$activeUser'";
    $userData=mysqli_query($conn,$userQuery);
    if($userData && mysqli_num_rows($userData)==1)
        {
            $rowData=mysqli_fetch_assoc($userData);
            $user=$rowData['CURRENTU'];
            $accConfirm=$rowData['APP1'];

        }

    if(isset($_POST['btnApprove']))
        {
            $updateQuery="UPDATE payments SET Status='Approved', approvedBy='$activeUser', approvedDT=NOW() WHERE receiptID='$selectedID'";
            $updateRes=mysqli_query($conn,$updateQuery);
            if($updateRes)
                {
                    echo "<script>
                    setTimeout(function(){window.location.href = 'home_page.php?activity=payList';}, 1000);
                    </script>";
                    exit();
                }
            else
                {
                    $message="Error while approving the GRN. Try again.";
                }
        }
 ?>
 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRN view</title>

    <!--bootstrap-->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>

		<!--Font-awsome-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<!--Google Font Family-->
		<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Merienda:wght@300..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../assets/css/style.css"/>
    

</head>
<body>
    <form method="POST">
        <div class="container ps-5 pe-5">
            <div class="ms-5 me-5 ps-5 pe-5">
                <div class="d-flex row" style="padding-bottom:25px;">
                                <div class="col-3 text-center">
                                    <img src="../Resources/images/logo.png" alt="Logo" class="img-fluid"  />
                                </div>
                                <div class="col-6 text-center pt-3">
                                    <h3>Original Apparel (Pvt) Ltd</h3>
                                    <p class="text-center">246/03 Welmilla, Aluthgama,  Bandaragama Bandaragama Sri Lanka.<br><b>Tel : </b>(122)(+94)11 7577700 <b>Fax : </b>(122)(+94)382291763 <br><b>E-Mail : </b>info@originalapparel.lk <b>Web : </b>www.originalapparel.lk</p>
                                </div>
                                <div class="col-3"></div>
                            <div><h3 class="text-center title mb-2">PAYMENT RECEIPT</h3></div>
                            <div class="row no-wrap1 ">
                                <div class="col-md-6 ps-4 mb-1 ">
                                    <table class="w-100" style="border:1px;">
                                        <tbody>
                                            <tr><td>Receipt No</td><td>:</td><td> <?php echo $receiptID;?></td></tr>
                                            <tr><td>Subcontractor</td><td>:</td><td> <?php echo $vendor;?></td></tr>
                                            <tr><td>Payment Method</td><td>:</td><td> <?php echo $method;?></td></tr>
                                            <tr><td>Account Details</td><td>:</td><td> <?php echo $accountdetails;?></td></tr>
                                            <tr><td>Reference</td><td>:</td><td> <?php echo $refNo;?></td></tr>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6 ps-4 mb-1">
                                    <table class="w-100" style="border:1px;">
                                        <tbody>
                                            <tr><td>Payment Date</td><td>:</td><td> <?php echo $paymentdate;?></td></tr>
                                            <tr><td>Created By</td><td>:</td><td> <?php echo $createdby;?></td></tr>
                                            <tr><td>Created Date/Time</td><td>:</td><td> <?php echo $createddate;?></td></tr>
                                            <tr><td>Status</td><td>:</td><td> <?php echo $status;?></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!---------------------------------- Buyer Style Order Section -------------------------------------- -->

                            <!-- <div style="height:50px; font-family: times-new-roman;"><h4 class="text-center mt-3 "><u>Style Order Details</u></h4></div> -->
                            <div class="row mt-5">
                                <div class="col-8 ps-4">
                                    <table class="w-100 table">
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>Value</th>
                                        </tr>
                                        <tr>
                                            <td>Gross Value</td>
                                            <td> : </td>
                                            <td class=text-end><?php echo number_format($grossValue,2);?></td>
                                        </tr>
                                        <tr>
                                            <td>Vat</td>
                                            <td> : </td>
                                            <td class=text-end><?php echo '('.$vat.'%) '.number_format($vatValue,2);?></td>
                                        </tr>
                                        <tr>
                                            <td>Net Value</td>
                                            <td> : </td>
                                            <td class=text-end><?php echo number_format($netValue,2);?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!---------------------------------- Item Details Section -------------------------------------- -->

                            <div style="height:50px; font-family: times-new-roman;"><h4 class="text-center mt-5"><u>Parts Details</u></h4></div>
                            <div class="row text-center">
                                <div class="col ps-4">
                                    <table class="w-100 report-table text-center">
                                        <tr>
                                            <th>GRN No.</th>
                                            <th>Date</th>
                                            <th>Invoice No.</th>
                                            <th>Style</th>
                                            <th>Order</th>
                                            <th>GRN Qty.</th>
                                            <th>GRN Value</th>
                                        </tr>
                                        <?php
                                        while($details=mysqli_fetch_assoc($detailsData))
                                            {
                                        ?>
                                        <tr>
                                            <td><?php echo $details['CODE2'];?></td>
                                            <td><?php echo $details['INVDATE'];?></td>
                                            <td><?php echo $details['INV'];?></td>
                                            <td><?php echo $details['STYLE'];?></td>
                                            <td><?php echo $details['ORDERNO'];?></td>
                                            <td><?php echo $details['GRNQTY'];?></td>
                                            <td><?php echo $details['GRNVAL'];?></td>                                        </tr>
                                        <?php
                                            }
                                        ?>
                                    </table>
                                </div>
                            </div>
                            <!-- -------------------------------------------------------------------------------- -->
                            <div class="row justify text-center">
                                <table class="w-100 text-center no-border-table mt-5" style="border:1px solid;">
                                <tr>
                                    <td>
                                        <label ><?php echo $user;?></label><br>
                                        <label class="mt-4">........................................</label><br>
                                        <label>Printed by</label><br>
                                        <label ><?php echo date('d/m/Y');?></label>
                                    </td>
                                    <td>
                                        <label ><?php
                                        $user='';
                                        $userRes=mysqli_query($conn,"SELECT CONCAT(Fname,' ',Lname) AS 'APPUS' FROM users WHERE User_ID='$approvedby'");
                                        if($u1=mysqli_fetch_assoc($userRes)) $user=$u1['APPUS'];
                                        echo $user;?></label><br>
                                        <label class="mt-4">........................................</label><br>
                                        <label>Approved by</label><br>
                                        <label ><?php echo $approveddt;?></label>
                                    </td>
                                </tr>
                            </table>
                            </div>
                            
                            <div class="row justify-content-center gap-3 mt-5 no-print">
                                <hr>
                                <?php
                                    if($accConfirm==1 && $status!="Approved"){
                                    ?>
                                    <input type="submit" class="btn btn-primary save_btn" value="Approve" name="btnApprove" id="btnApprove"/>
                                    <?php
                                    }
                                ?>
                                <button type="button" class="btn btn-success save_btn" onclick="window.print()">Print</button>
                            </div>
                            </div>
            </div>
            
        </div>
    </form>
    
    <div class="container text-center" >
        <label class="text-danger"><?php echo $message?></label>
    </div>

</body>
</html>
