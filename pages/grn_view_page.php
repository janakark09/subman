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
    
    
    $slectedgrnID=$_REQUEST['selectedID'];

    $grnQuery="SELECT GD.grnCode1 AS 'CODE1',CONCAT(GD.grnCode2,'/',GD.grnCode1) AS 'CODE2',SP.recordID AS 'PROID',SO.styleNo AS 'STYLE',SO.orderNo AS 'ORDERNO', 
                DATE_FORMAT(GD.invoiceDate,'%d/%m/%y') AS 'INVDATE',GD.recFnishedQty AS 'RECFQTY', V.vendor AS 'VEN',GD.recDamQty AS 'RECDQTY',GD.recSampleQty AS 'RECSQTY', 
                SUM(GD.fgValue+GD.sampleValue+GD.vat) AS 'GRNVAL', DATE_FORMAT(GD.createdDT,'%d/%m/%y') AS 'GRNDATE', GD.createdBy AS 'GRNBY', GD.status AS 'STATUS',
                ML.location AS 'LOC', A.id AS 'AGREEMENT', GD.approvedBy AS 'APPROVED', DATE_FORMAT(GD.approvedDT,'%d/%m/%y') AS 'APPDT'
                FROM grn_details GD JOIN sub_production SP ON GD.proRecNo=SP.recordID JOIN styleorder SO ON SP.orderNoID=SO.id 
                JOIN mast_location ML ON SP.locationID=ML.locationID JOIN vendors V ON SP.vendorID=V.vendorID JOIN users U ON SP.createdBy=U.User_ID 
                JOIN agreements A ON SO.id=A.styleOrderID WHERE GD.grnCode1='$slectedgrnID'";
    $selectedData=mysqli_query($conn,$grnQuery);

    if($selectedData && mysqli_num_rows($selectedData)==1)
        {
            $rowData=mysqli_fetch_assoc($selectedData);
            $grnID=$rowData['CODE2'];
            $vendor=$rowData['VEN'];
            $proid=$rowData['PROID'];
            $invdate=$rowData['INVDATE'];
            $recfinqty=$rowData['RECFQTY']; 
            $recdamqty=$rowData['RECDQTY'];
            $recsamqty=$rowData['RECSQTY'];
            $grnval=$rowData['GRNVAL'];
            $grnby=$rowData['GRNBY'];
            $grndt=$rowData['GRNDATE'];
            $location=$rowData['LOC'];
            $style=$rowData['STYLE'];
            $order=$rowData['ORDERNO'];
            $agreement=$rowData['AGREEMENT'];
            $approvedby=$rowData['APPROVED'];
            $approveddt=$rowData['APPDT'];
            $status=$rowData['STATUS'];
        }
    
    $detailsQuery="SELECT GD1.prodetailsID AS 'PROID', PD.cutNO AS 'CUT', C.color AS 'COLOR',S.size AS 'SIZE', GD1.recFinQty AS 'FQTY', GD1.recDamQty AS 'DQTY', GD1.SampleQty AS 'SQTY' 
                FROM grn_details1 GD1 JOIN sub_pro_details PD ON GD1.prodetailsID=PD.id
                JOIN style_colors C ON PD.colorID=C.colorID JOIN style_sizes S ON PD.sizeID=S.sizeID  WHERE GD1.grnNo='$slectedgrnID'";
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
            $updateQuery="UPDATE grn_details SET status='Approved', approvedBy='$activeUser', approvedDT=NOW() WHERE grnCode1='$slectedgrnID'";
            $updateRes=mysqli_query($conn,$updateQuery);
            if($updateRes)
                {
                    echo "<script>
                    setTimeout(function(){window.location.href = 'home_page.php?activity=grnList';}, 1000);
                    </script>";
                    exit();
                }
            else
                {
                    $message="Error while approving the GRN. Try again.";
                }
        }

    if(isset($_POST['btnDel']))
        {
            $deleteQry1="DELETE FROM grn_details1 WHERE grnNo='$slectedgrnID'";
            if($deleteRes1=mysqli_query($conn,$deleteQry1)){
                $deleteQuery="DELETE FROM grn_details WHERE grnCode1='$slectedgrnID'";
                $deleteRes=mysqli_query($conn,$deleteQuery);
                if($deleteRes)
                    {
                        echo "<script>
                        setTimeout(function(){window.location.href = 'home_page.php?activity=grnList';}, 1000);
                        </script>";
                        exit();
                    }
                else
                    {
                        $message="Error while deleting the GRN. Try again.";
                    }
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
                            <div><h3 class="text-center title mb-2">GOOD RECEIVED NOTE (GRN)</h3></div>
                            <div class="row no-wrap1 ">
                                <div class="col-md-6 ps-4 mb-1 ">
                                    <table class="w-100" style="border:1px;">
                                        <tbody>
                                            <tr><td>GRN No</td><td>:</td><td> <?php echo $grnID;?></td></tr>
                                            <tr><td>Sub Contractor</td><td>:</td><td> <?php echo $vendor;?></td></tr>
                                            <tr><td>Production Rec. No.</td><td>:</td><td> <a href="#"><?php echo $proid;?></a></td></tr>
                                            <tr><td>Invoice Date</td><td>:</td><td> <?php echo $invdate;?></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6 ps-4 mb-1">
                                    <table class="w-100" style="border:1px;">
                                        <tbody>
                                            <tr><td>Location</td><td>:</td><td> <?php echo $location;?></td></tr>
                                            <tr><td>Created By</td><td>:</td><td> <?php echo $grnby;?></td></tr>
                                            <tr><td>GRN Date/Time</td><td>:</td><td> <?php echo $grndt;?></td></tr>
                                            <tr><td>Status</td><td>:</td><td> <?php echo $status;?></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!---------------------------------- Buyer Style Order Section -------------------------------------- -->

                            <div style="height:50px; font-family: times-new-roman;"><h4 class="text-center mt-3"><u>Style Order Details</u></h4></div>
                            <div class="row text-center">
                                <div class="col ps-4">
                                    <table class="w-100 table">
                                        <tr>
                                            <th>Style No.</th>
                                            <th>Order No.</th>
                                            <th>Agreement No</th>
                                            <th>Total GRN Value</th>
                                        </tr>
                                        <tr>
                                            <td><?php echo $style;?></td>
                                            <td><?php echo $order;?></td>
                                            <td><?php echo $agreement;?></td>
                                            <td><?php echo $grnval;?></td>
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
                                            <th>No.</th>
                                            <th>Cut No.</th>
                                            <th>Color.</th>
                                            <th>Size</th>
                                            <th>Finished Qty.</th>
                                            <th>Damages Qty.</th>
                                            <th>Sample Qty.</th>
                                        </tr>
                                        <?php
                                        while($details=mysqli_fetch_assoc($detailsData))
                                            {
                                        ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $details['CUT'];?></td>
                                            <td><?php echo $details['COLOR'];?></td>
                                            <td><?php echo $details['SIZE'];?></td>
                                            <td><?php echo $details['FQTY'];?></td>
                                            <td><?php echo $details['DQTY'];?></td>
                                            <td><?php echo $details['SQTY'];?></td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                        <tr>
                                            <td class="dark-cell" colspan="4">Total</td>
                                            <td class="dark-bg-cell"><?php echo $recfinqty;?></td>
                                            <td class="dark-bg-cell"><?php echo $recdamqty;?></td>
                                            <td class="dark-bg-cell"><?php echo $recsamqty;?></td>
                                        </tr>
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
                                        <label ><?php echo $createddt;?></label>
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
                                    <td>
                                        <label ></label><br>
                                        <label class="mt-4">........................................</label><br>
                                        <label>Checked by</label><br>
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
                                    <input type="submit" class="btn btn-primary save_btn" value="Delete" name="btnDel" id="btnDel"/>
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
