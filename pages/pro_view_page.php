<?php
	include "../includes/db-con.php";
    session_start();

    $no = 1;
    $recID="";
    $gpRef="";
    $gpDate="";
    $style="";
    $order="";
    $location="";
    $address="";
    $vendor="";
    $venAddrs="";
    $venTel="";
    $agreement="";
    $proQty="";
    $damQty="";
    $sampleQty="";
    $status="";
    $createdby="";
    $createddt="";
    $approvedby="";
    $approveddt="";
    
    $user="";
    $accConfirm=0;
    $message="";
    
    
    $slectedrecID=$_REQUEST['selectedID'];

    $recQuery="SELECT SP.recordID AS 'recID',Sp.gatepassRefID AS 'REF', SP.gatepassDate AS 'GPDATE', SO.styleNo AS 'STYLE', SO.orderNo AS 'ORDERNO', ML.location AS 'LOC', ML.address AS 'ADDR',
                V.vendor AS 'VEN',V.address AS 'VADDR',V.tel AS 'VTEL',V.fax AS 'VFAX',V.email AS 'VEMAIL', SP.orderAgreement AS 'AGREEMENT',SUM(PD.finishedQty) AS 'FINQTY',(SUM(PD.fabDamQty)+SUM(PD.processDamQty)) AS 'DAMQTY',SUM(PD.sampleQty) AS 'SMQTY', 
                SP.status AS 'STATUS', CONCAT(U.Fname,' ',U.Lname) AS 'CREATEDBY',SP.createdBy AS 'CREATEDBYID', DATE_FORMAT(SP.cratedDT,'%d/%m/%y') AS 'CREATEDDT', SP.approvedBy AS 'APPROVED', DATE_FORMAT(SP.approvedDT,'%d/%m/%y') AS 'APPDT' 
                    FROM  sub_production SP JOIN sub_pro_details PD ON SP.recordID=PD.recID 
                    JOIN mast_location AS ML ON SP.locationID=ML.locationID  
                    JOIN styleorder AS SO ON SP.orderNoID=SO.id 
                    JOIN vendors AS V ON SP.vendorID=V.vendorID 
                    JOIN agreements AS AG ON SP.orderAgreement=AG.id 
                    JOIN users AS U ON SP.createdBy=U.User_ID WHERE SP.recordID='$slectedrecID'";
                    
    $selectedData=mysqli_query($conn,$recQuery);
    if($selectedData && mysqli_num_rows($selectedData)==1)
        {
            $rowData=mysqli_fetch_assoc($selectedData);
            $recID=$rowData['recID'];
            $gpRef=$rowData['REF'];
            $gpDate=$rowData['GPDATE'];
            $style=$rowData['STYLE'];
            $order=$rowData['ORDERNO'];
            $location=$rowData['LOC'];
            $address=$rowData['ADDR'];
            $vendor=$rowData['VEN'];
            $venAddrs=$rowData['VADDR'];
            $venTel=$rowData['VTEL'];
            $venFax=$rowData['VFAX'];
            $venEmail=$rowData['VEMAIL'];
            $agreement=$rowData['AGREEMENT'];
            $proQty=$rowData['FINQTY'];
            $damQty=$rowData['DAMQTY'];
            $sampleQty=$rowData['SMQTY'];
            $status=$rowData['STATUS'];
            $createdby=$rowData['CREATEDBY'];
            $createdbyid=$rowData['CREATEDBYID'];
            $createddt=$rowData['CREATEDDT'];
            $approvedby=$rowData['APPROVED'];
            $approveddt=$rowData['APPDT'];
            // $tel=$rowData['TEL'];
            // $person=$rowData['CONP'];
        }
    
    $detailsQuery="SELECT PD.cutNo AS 'CUT',C.color AS 'COLOR',S.size AS 'SIZE', PD.finishedQty AS 'FQTY', PD.processDamQty AS 'DQTY', PD.sampleQty AS 'SQTY' FROM sub_pro_details PD 
                JOIN style_colors C ON PD.colorID=C.colorID JOIN style_sizes S ON PD.sizeID=S.sizeID  WHERE PD.recID='$slectedrecID'";

    $detailsData=mysqli_query($conn,$detailsQuery);

	$activeUser=$_SESSION['_UserID'];

    $userQuery="SELECT CONCAT(U.Fname,' ',U.Lname) AS 'CURRENTU', UD.acc16 AS 'APP1' FROM users U JOIN user_details UD ON U.User_ID=UD.User_ID WHERE U.User_ID='$activeUser'";
    $userData=mysqli_query($conn,$userQuery);
    if($userData && mysqli_num_rows($userData)==1)
        {
            $rowData=mysqli_fetch_assoc($userData);
            $user=$rowData['CURRENTU'];
            $accConfirm=$rowData['APP1'];

        }

    if(isset($_POST['btnApprove']))
        {
            $updateQuery="UPDATE sub_production SET status='Approved', approvedBy='$activeUser', approvedDT=NOW() WHERE recordID='$slectedrecID'";
            $updateRes=mysqli_query($conn,$updateQuery);
            
            $sendNotifQry1="INSERT INTO notifications (user, description, attUser, NotifyStatus) VALUES ('$activeUser', 'Production Record No: $slectedrecID has been approved by $user.',$createdbyid,'0')";
            $sendNotifRes1=mysqli_query($conn, $sendNotifQry1);

            if($updateRes && $sendNotifRes1)
                {
                    echo "<script>
                    setTimeout(function(){window.location.href = 'home_page.php?activity=proRec';}, 1000);
                    </script>";
                    exit();
                }
            else
                {
                    $message="Error while approving the production record. Try again.";
                }
        }
 ?>
 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production view</title>

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
                                <div class="col-3 text-center justify-content-center align-items-center d-flex">
                                    <img src="../Resources/images/logo.png" alt="Logo" class="img-fluid"  />
                                </div>
                                <div class="col-6 text-center pt-3">
                                    <h3><?php echo $vendor; ?></h3>
                                    <p class="text-center"><?php echo $venAddrs; ?><br><b>Tel : </b><?php echo $venTel;?> <b>Fax : </b><?php echo $venFax;?> <br><b>E-Mail : </b><?php echo $venEmail;?></p>
                                </div>
                                <div class="col-3"></div>
                            <div><h3 class="text-center title mb-2">SUBCONTRACT PRODUCTION SHEET</h3></div>
                            <div class="row no-wrap1">
                                <div class="col-md-6 ps-4 mb-3">
                                    <table class="w-100" style="border:1px;">
                                        <tbody>
                                            <tr><td>Record No.</td><td>:</td><td> <?php echo $recID;?></td></tr>
                                            <tr><td>Gate pass to</td><td>:</td><td> <?php echo $location;?></td></tr>
                                            <tr><td>Address</td><td>:</td><td> <?php echo $address;?></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6 ps-4 mb-3">
                                    <table class="w-100" style="border:1px;">
                                        <tbody>
                                            <tr><td>Finishing Date</td><td>:</td><td> <?php echo $gpDate;?></td></tr>
                                            <tr><td>Ref. No.</td><td>:</td><td> <?php echo $gpRef;?></td></tr>
                                            <tr><td>Entered By</td><td>:</td><td> <?php echo $createdby;?></td></tr>
                                            <tr><td>Entered Date/Time</td><td>:</td><td> <?php echo $createddt;?></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!---------------------------------- Buyer Style Order Section -------------------------------------- -->

                            <div style="height:50px; font-family: times-new-roman;"><h4 class="text-center mt-3"><u>Order Details</u></h4></div>
                            <div class="row text-center">
                                <div class="col ps-4">
                                    <table class="w-100 table">
                                        <tr>
                                            <th>Style No.</th>
                                            <th>Order No.</th>
                                            <th>Agr. No</th>
                                            <th>Total(Finished)</th>
                                            <th>Total(Damages)</th>
                                            <th>Total(Sample)</th>
                                        </tr>
                                        <tr>
                                            <td><?php echo $style;?></td>
                                            <td><?php echo $order;?></td>
                                            <td><?php echo $agreement;?></td>
                                            <td><?php echo $proQty;?></td>
                                            <td><?php echo $damQty;?></td>
                                            <td><?php echo $sampleQty;?></td>
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
                                            <td class="dark-bg-cell"><?php echo $proQty;?></td>
                                            <td class="dark-bg-cell"><?php echo $damQty;?></td>
                                            <td class="dark-bg-cell"><?php echo $sampleQty;?></td>
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
                                    <td>
                                        <label></label><br>
                                        <label class="mt-4">........................................</label><br>
                                        <label>Received by</label><br>
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
