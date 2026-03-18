<?php
	include "../includes/db-con.php";
    session_start();

    $message="";

    $agrID="";
    $vendor="";
    $address="";
    $brno="";
    $vatno="";
    $process="";
    $style="";
    $order="";
    $pcsperset="";
    $totalqty="";
    $dailyqty="";
    $startDate="";
    $endDate="";
    $creditDays="";
    $fgunitprice="";
    $samupleunitprice="";
    $status="";
    $createdby="";
    $createddt="";
    $approvedby="";
    $approveddt="";
    $accConfirm=0;

    
    
    $slectedagrID=$_REQUEST['selectedID'];

    $AgrmtQuery="SELECT agr.id as ID, ven.vendor AS VENDOR, ven.address AS VENADDR, ven.brNo AS BRNO, ven.vatNo AS VATNO, pt.processType AS PROCESS,
                so.styleNo AS STYLENO, so.orderNo AS ORDERNO, agr.pcsPerSet AS PCSPERSET, agr.contractTotalQty AS TOTAL_SUBQTY, agr.dailyQty AS DAILY_QTY, agr.startedDate AS SDATE,
                agr.endDate AS EDATE, agr.creditPeriod AS CREDIT, agr.unitPriceFg AS UPRICEFG, agr.unitPriceSample AS UPRICESAM, agr.Status AS STAT,
                DATE_FORMAT(agr.createdDT,'%d/%m/%Y') AS CREATED, agr.createdBy as CREATEDBY, DATE_FORMAT(agr.approvedDT,'%d/%m/%Y') AS APPROVED,
                agr.approvedBy as APPROVEDBY    
                FROM agreements AS agr JOIN vendors AS ven ON agr.vendorID = ven.vendorID JOIN process_type AS pt ON agr.process = pt.typeid 
                JOIN styleorder AS so ON agr.styleOrderID = so.id JOIN users AS u ON agr.createdBy = u.User_ID WHERE agr.id='$slectedagrID'";
    $selectedData=mysqli_query($conn,$AgrmtQuery);

    if($selectedData && mysqli_num_rows($selectedData)==1)
        {
            $rowData=mysqli_fetch_assoc($selectedData);
            $agreementID=$rowData['ID'];
            $vendor=$rowData['VENDOR'];
            $address=$rowData['VENADDR'];
            $brno=$rowData['BRNO'];
            $vatno=$rowData['VATNO'];
            $process=$rowData['PROCESS'];
            $style=$rowData['STYLENO'];
            $order=$rowData['ORDERNO'];
            $pcsperset=$rowData['PCSPERSET'];
            $totalqty=$rowData['TOTAL_SUBQTY'];
            $dailyqty=$rowData['DAILY_QTY'];
            $startdate=$rowData['SDATE'];
            $enddate=$rowData['EDATE'];
            $creditdays=$rowData['CREDIT'];
            $fgunitprice=$rowData['UPRICEFG'];
            $samupleunitprice=$rowData['UPRICESAM'];
            $status=$rowData['STAT'];
            $createdby=$rowData['CREATEDBY'];
            $createddt=$rowData['CREATED'];
            $approvedby=$rowData['APPROVEDBY'];
            $approveddt=$rowData['APPROVED'];
        }

    //------------------------------- Get active user details --------------------------------------
	$activeUser=$_SESSION['_UserID'];

    $userQuery="SELECT CONCAT(U.Fname,' ',U.Lname) AS 'CURRENTU', UD.acc10 AS 'APP1' FROM users U JOIN user_details UD ON U.User_ID=UD.User_ID WHERE U.User_ID='$activeUser'";
    $userData=mysqli_query($conn,$userQuery);
    if($userData && mysqli_num_rows($userData)==1)
        {
            $rowData=mysqli_fetch_assoc($userData);
            $user=$rowData['CURRENTU'];
            $accConfirm=$rowData['APP1'];

        }
    //---------------------------------------------------------------------------------------------
    if(isset($_POST['btnApprove']) && $accConfirm==1)
        {
            $updateQuery="UPDATE agreements SET status='Approved', approvedBy='$activeUser', approvedDT=NOW() WHERE id='$slectedagrID'";
            $updateRes=mysqli_query($conn,$updateQuery);
            $sendNotifQry="INSERT INTO notifications (user, description, attUser, NotifyStatus) VALUES ('$activeUser', 'Agreement No: $slectedagrID has been approved by $user.',$createdby,'0')";
            $sendNotifRes=mysqli_query($conn, $sendNotifQry);
            if($updateRes && $sendNotifRes)
                {
                    echo "<script>alert('Agreement approved successfully!');</script>";
                    echo "<script>
                        setTimeout(function(){window.location.href = 'home_page.php?activity=agreements';}, 1000);
                    </script>";
                    exit();
                }
            else
                {
                    $message="Error while approving the Agreement. Try again.";
                }
        }
    //---------------------------------------------------------------------------------------------
    if(isset($_POST['btnCancel']) && $accConfirm==1)
        {
            $deleteQry1="UPDATE agreements SET status='Cancelled', canceledBy='$activeUser', canceledDT=NOW() WHERE id='$slectedagrID'";
            if($deleteRes1=mysqli_query($conn,$deleteQry1)){
                $sendNotifQry1="INSERT INTO notifications (user, description, attUser, NotifyStatus) VALUES ('$activeUser', 'Agreement No: $slectedagrID has been cancelled by $user.',$createdby,'0')";
                $sendNotifRes1=mysqli_query($conn, $sendNotifQry1);
                if($deleteRes1 && $sendNotifRes1)
                    {
                        echo "<script>alert('Agreement cancelled successfully!');</script>";
                        echo "<script>
                        setTimeout(function(){window.location.href = 'home_page.php?activity=agreements';}, 1000);
                        </script>";
                        exit();
                    }
                else
                    {
                        $message="Error while deleting the Agreement. Try again.";
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
    
    <style>
        .middle-cell{
            width: 50px;
        }
        </style>
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
                                    <h3>Original Apparel (Pvt) Ltd</h3>
                                    <p class="text-center">246/03 Welmilla, Aluthgama,  Bandaragama Bandaragama Sri Lanka.<br><b>Tel : </b>(122)(+94)11 7577700 <b>Fax : </b>(122)(+94)382291763 <br><b>E-Mail : </b>info@originalapparel.lk <b>Web : </b>www.originalapparel.lk</p>
                                </div>
                                <div class="col-3"></div>
                            <div>
                                <?php
                                if($status=="Cancelled"){
                                    ?>
                                    <div class="position-absolute top-50 start-50 translate-middle">
                                        <h1 class="display-1 text-danger" style="opacity:0.5;">CANCELLED</h1>
                                    </div>
                                    <?php
                                }
                                ?>
                                <h3 class="text-center title mb-2">SUBCONTRACT AGREEMENT</h3>
                            </div>
                            <div class="row no-wrap1 ">
                                <div class="col-md-6 ps-4 mb-1 ">
                                    <table class="w-100" style="border:1px;">
                                        <tbody>
                                            <tr><td>Agreement No</td><td>:</td><td> <?php echo $agreementID;?></td></tr>
                                            <tr><td>Sub Contractor</td><td>:</td><td> <?php echo $vendor;?></td></tr>
                                            <tr><td>Address</td><td>:</td><td> <?php echo $address;?></td></tr>
                                            <tr><td>BR No.</td><td>:</td><td> <?php echo $brno;?></td></tr>
                                            <tr><td>VAT No.</td><td>:</td><td> <?php echo $vatno;?></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6 ps-4 mb-1">
                                    <table class="w-100" style="border:1px;">
                                        <tbody>
                                            <tr><td>Created By</td><td>:</td><td> <?php echo $createdby;?></td></tr>
                                            <tr><td>Created Date/Time</td><td>:</td><td> <?php echo $createddt;?></td></tr>
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
                                            <th>Process Type</th>
                                        </tr>
                                        <tr>
                                            <td><?php echo $style;?></td>
                                            <td><?php echo $order;?></td>
                                            <td><?php echo $process;?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!---------------------------------- Item Details Section -------------------------------------- -->
                            <div class="row">
                                <div class="col-md-6 ps-4 mb-1 ">
                                    <table class="w-100" style="border:1px;">
                                        <tbody>
                                            <tr><td>Contract Total Qty.(<?php echo $pcsperset;?> pcs/set)</td><td class="middle-cell">:</td><td> <?php echo $totalqty;?></td></tr>
                                            <tr><td>Per Day Qty.(<?php echo $pcsperset;?> pcs/set)</td><td class="middle-cell">:</td><td> <?php echo $dailyqty;?></td></tr>
                                            <tr><td>Starting Date</td><td class="middle-cell">:</td><td> <?php echo $startdate;?></td></tr>
                                            <tr><td>Ending Date</td><td class="middle-cell">:</td><td> <?php echo $enddate;?></td></tr>
                                            <tr><td>Credit Period</td><td class="middle-cell">:</td><td> <?php echo $creditdays;?></td></tr>
                                            <tr><td>Unit Price(Finished Goods)</td><td class="middle-cell">:</td><td> <?php echo number_format($fgunitprice, 2);?></td></tr>
                                            <tr><td>Unit Price(Samples)</td><td class="middle-cell">:</td><td> <?php echo number_format($samupleunitprice, 2);?></td></tr>
                                        </tbody>
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
                                    if($accConfirm==1){
                                        if($status!="Cancelled" && $status!="Approved"){
                                        ?>
                                        <input type="submit" class="btn btn-primary save_btn" value="Approve" name="btnApprove" id="btnApprove"/>
                                        <input type="submit" class="btn btn-primary save_btn" value="Cancel" name="btnCancel" id="btnCancel"/>
                                        <?php
                                        }
                                        else if($status!="Cancelled"){
                                            ?>
                                            <input type="submit" class="btn btn-primary save_btn" value="Cancel" name="btnCancel" id="btnCancel"/>
                                            <?php
                                        }
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
