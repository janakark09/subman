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
    
    
    $slectedgpID=$_REQUEST['selectedID'];

    $gpQuery="SELECT GP.gatepassID_1 AS 'gpID1', CONCAT(GP.gatepassID_2,'/', GP.gatepassID_1) AS 'gpID2',GP.gatepassDate AS 'GPDATE',SO.styleNo AS 'STYLE',SO.orderNo AS 'ORDERNO', ML.location AS 'LOC', 
        V.vendor AS 'VEN',V.address AS 'ADDR',V.tel AS 'TEL',V.contactPerson AS 'CONP',GP.orderAgreement AS 'AGREEMENT',SUM(GD.matQty) AS 'TOTAL', GP.status AS 'STATUS', CONCAT(U.Fname,' ',U.Lname) AS 'CREATEDBY', 
            GP.createdBy AS CREATEDBYID,DATE_FORMAT(GP.createdDT,'%d/%m/%y %h:%m %p') AS 'CREATEDDATE',GP.approvedBy AS 'APPROVED',DATE_FORMAT(GP.approvedDT,'%d/%m/%y %h:%m %p') AS 'APPDT' 
                    FROM  gatepass GP JOIN gatepass_details GD ON GP.gatepassID_1=GD.gpID JOIN mast_location AS ML ON GP.locationID=ML.locationID  
                    JOIN styleorder AS SO ON GP.orderNoID=SO.id JOIN vendors AS V ON GP.vendorID=V.vendorID JOIN agreements AS AG ON GP.orderAgreement=AG.id 
                    JOIN users AS U ON GP.createdBy=U.User_ID WHERE GP.gatepassID_1='$slectedgpID'";
    $selectedData=mysqli_query($conn,$gpQuery);
    if($selectedData && mysqli_num_rows($selectedData)==1)
        {
            $rowData=mysqli_fetch_assoc($selectedData);
            $gpID=$rowData['gpID2'];
            $vendor=$rowData['VEN'];
            $address=$rowData['ADDR'];
            $tel=$rowData['TEL'];
            $person=$rowData['CONP'];
            $date=$rowData['GPDATE'];
            $location=$rowData['LOC'];
            $createdby=$rowData['CREATEDBY'];
            $createdbyid=$rowData['CREATEDBYID'];
            $createddt=$rowData['CREATEDDATE'];
            $style=$rowData['STYLE'];
            $order=$rowData['ORDERNO'];
            $agreement=$rowData['AGREEMENT'];
            $total=$rowData['TOTAL'];
            $approvedby=$rowData['APPROVED'];
            $approveddt=$rowData['APPDT'];
            $status=$rowData['STATUS'];
        }
    
    $detailsQuery="SELECT GD.cutNo AS 'CUT',C.color AS 'COLOR',S.size AS 'SIZE', GD.matQty AS 'QTY' FROM gatepass_details GD 
                JOIN style_colors C ON GD.colorID=C.colorID JOIN style_sizes S ON GD.sizeID=S.sizeID  WHERE GD.gpID='$slectedgpID'";
    $detailsData=mysqli_query($conn,$detailsQuery);

	$activeUser=$_SESSION['_UserID'];

    $userQuery="SELECT CONCAT(U.Fname,' ',U.Lname) AS 'CURRENTU', UD.acc13 AS 'APP1' FROM users U JOIN user_details UD ON U.User_ID=UD.User_ID WHERE U.User_ID='$activeUser'";
    $userData=mysqli_query($conn,$userQuery);
    if($userData && mysqli_num_rows($userData)==1)
        {
            $rowData=mysqli_fetch_assoc($userData);
            $user=$rowData['CURRENTU'];
            $accConfirm=$rowData['APP1'];

        }

    if(isset($_POST['btnApprove']))
        {
            $updateQuery="UPDATE gatepass SET status='Approved', approvedBy='$activeUser', approvedDT=NOW() WHERE gatepassID_1='$slectedgpID'";
            $updateRes=mysqli_query($conn,$updateQuery);
             $sendNotifQry="INSERT INTO notifications (user, description, attUser, NotifyStatus) VALUES ('$activeUser', 'Gatepass No: $slectedgpID has been approved by $user.',$createdbyid,'0')";
            $sendNotifRes=mysqli_query($conn, $sendNotifQry);
            if($updateRes && $sendNotifRes)
                {
                    echo "<script>
                    setTimeout(function(){window.location.href = 'home_page.php?activity=gatepass';}, 1000);
                    </script>";
                    exit();
                }
            else
                {
                    $message="Error while approving the gate pass. Try again.";
                }
        }
 ?>
 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatepass view</title>

     <link rel="icon" type="image/x-icon" href="../Resources/images/syslogo.ico">

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
                                <div class="col-3 text-center justify-content-center align-items-center pt-3">
                                    <img src="../Resources/images/logo.png" alt="Logo" class="img-fluid"  />
                                </div>
                                <div class="col-6 text-center pt-3">
                                    <h3>Original Apparel (Pvt) Ltd</h3>
                                    <p class="text-center">246/03 Welmilla, Aluthgama,  Bandaragama Bandaragama Sri Lanka.<br><b>Tel : </b>(122)(+94)11 7577700 <b>Fax : </b>(122)(+94)382291763 <br><b>E-Mail : </b>info@originalapparel.lk <b>Web : </b>www.originalapparel.lk</p>
                                </div>
                                <div class="col-3"></div>
                            </div>
                            <div><h3 class="text-center title mb-2">GATE PASS</h3></div>
                            <div class="row no-wrap1 ">
                                <div class="col-md-6 ps-4 mb-1 ">
                                    <table class="w-100" style="border:1px;">
                                        <tbody>
                                            <tr><td>Gate Pass No</td><td>:</td><td> <?php echo $gpID;?></td></tr>
                                            <tr><td>Sub Contractor</td><td>:</td><td> <?php echo $vendor;?></td></tr>
                                            <tr><td>Address</td><td>:</td><td> <?php echo $address;?></td></tr>
                                            <tr><td>Tel</td><td>:</td><td> <?php echo $tel;?></td></tr>
                                            <tr><td>Contact Person</td><td>:</td><td> <?php echo $person;?></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6 ps-4 mb-1">
                                    <table class="w-100" style="border:1px;">
                                        <tbody>
                                            <tr><td>Gate Pass Date</td><td>:</td><td> <?php echo $date;?></td></tr>
                                            <tr><td>Location</td><td>:</td><td> <?php echo $location;?></td></tr>
                                            <tr><td>Created By</td><td>:</td><td> <?php echo $createdby;?></td></tr>
                                            <tr><td>Created Date/Time</td><td>:</td><td> <?php echo $createddt;?></td></tr>
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
                                            <th>Total Qty.</th>
                                        </tr>
                                        <tr>
                                            <td><?php echo $style;?></td>
                                            <td><?php echo $order;?></td>
                                            <td><?php echo $agreement;?></td>
                                            <td><?php echo $total;?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            <!---------------------------------- Item Details Section -------------------------------------- -->

                            <div style="height:50px; font-family: times-new-roman;"><h4 class="text-center mt-5"><u>Parts Details</u></h4></div>
                            <div class="row text-center">
                                <div class="col ps-4">
                                    <table class="w-100 report-table">
                                        <tr>
                                            <th>No.</th>
                                            <th>Cut No.</th>
                                            <th>Color.</th>
                                            <th>Size</th>
                                            <th>Material Sets Qty.</th>
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
                                            <td><?php echo $details['QTY'];?></td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                        <tr>
                                            <td class="dark-cell" colspan="4">Total</td>
                                            <td class="dark-bg-cell"><?php echo $total;?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div style="height:50px;"></div>
                            <div class="row justify text-center">
                                <div class="col-xl-2 col-md-4">
                                    <label ><?php echo $user;?></label><br>
                                    <label class="mt-4">........................................</label><br>
                                    <label>Printed by</label><br>
                                    <label ><?php echo $createddt;?></label>
                                </div>
                                <div class="col-xl-2 col-md-4">
                                    <label ><?php
                                    $user='';
                                    $userRes=mysqli_query($conn,"SELECT CONCAT(Fname,' ',Lname) AS 'APPUS' FROM users WHERE User_ID='$approvedby'");
                                    if($u1=mysqli_fetch_assoc($userRes)) $user=$u1['APPUS'];
                                    echo $user;?></label><br>
                                    <label class="mt-4">........................................</label><br>
                                    <label>Approved by</label><br>
                                    <label ><?php echo $approveddt;?></label>
                                </div>
                                <div class="col-xl-2 col-md-4">
                                    <label ></label><br>
                                    <label class="mt-4">........................................</label><br>
                                    <label>Security Checked by</label><br>
                                </div>
                                <div class="col-xl-2 col-md-4">
                                    <label></label><br>
                                    <label class="mt-4">........................................</label><br>
                                    <label>Received by</label><br>
                                </div>
                                <div class="col-xl-2 col-md-4">
                                    <label >Vehicle No:</label><br>
                                    <label class="mt-4">................................</label>
                                </div>
                            </div>
                            <div class="row justify-content-center gap-3 mt-5 no-print">
                                <hr>
                                <?php
                                    if($accConfirm==1 && $status!="Approved")
                                    {
                                    ?>
                                    <input type="submit" class="btn btn-primary save_btn" value="Approve" name="btnApprove" id="btnApprove"/>
                                    <?php
                                    }
                                ?>
                                <button type="button" class="btn btn-success save_btn" onclick="window.print()">Print</button>
                            </div>
            </div>
            
        </div>
    </form>
    
    <div class="container text-center" >
        <label class="text-danger"><?php echo $message?></label>
    </div>

</body>
</html>
