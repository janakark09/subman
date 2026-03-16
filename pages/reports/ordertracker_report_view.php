<?php
	include "../../includes/db-con.php";
    session_start();

    $gpID="";
    
    $no = 1;
    $user="";
    $message="";

    $style="";
    $order="";
    $location="";
    $vendor="";
    $fromdate="";
    $todate="";
    
    // print_r($_GET);

    $selectedBuyer = isset($_GET['buyer']) ? $_GET['buyer'] : "";
    $selectedStyle = isset($_GET['style']) ? $_GET['style'] : "";
    $selectedOrder = isset($_GET['order']) ? $_GET['order'] : "";
    $selectedLocation = isset($_GET['location']) ? $_GET['location'] : "";
    $selectedVendor = isset($_GET['vendor']) ? $_GET['vendor'] : "";
    $fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : "";
    $toDate = isset($_GET['toDate']) ? $_GET['toDate'] : "";
    $option = isset($_GET['selection1']) ? strtoupper($_GET['selection1']) : "";

    // echo 'buyer-'.$selectedBuyer." style-".$selectedStyle." order-".$selectedOrder." loc-".$selectedLocation." vendor-".$selectedVendor." from-".$fromDate." to-".$toDate." option-".$option;
    // echo "<br>";

    if($selectedStyle!="All"){
        $style=" AND SO.styleNo='$selectedStyle'";
    }
    if($selectedOrder!="All"){
        $order=" AND SO.id='$selectedOrder'";
    }
    if($selectedLocation!="All"){
        $location=" AND ML.locationID='$selectedLocation'";
    }
    if($selectedVendor!="All"){
        $vendor=" AND V.vendorID='$selectedVendor'";
    }

    if($fromDate!=""){
        if($option=="GATE PASS"){
            $fromdate=" AND GP.gatepassDate >= '$fromDate'";
        }
        else if($option=="PRODUCTION RECORDS"){
            $fromdate=" AND SP.cratedDT >= '$fromDate'";
        }
        else if($option=="GRN"){
            $fromdate=" AND GD.invoiceDate >= '$fromDate'";
        }
        else if($option=="PAYMENTS"){
            $fromdate=" AND P.createdDT >= '$fromDate'";
        }

    }
    if($toDate!=""){
        if($option=="GATE PASS"){
            $todate=" AND GP.gatepassDate <= '$toDate'";
        }
        else if($option=="PRODUCTION RECORDS"){
            $todate=" AND SP.cratedDT <= '$toDate'";
        }
        else if($option=="GRN"){
            $todate=" AND GD.invoiceDate <= '$toDate'";
        }
        else if($option=="PAYMENTS"){
            $todate=" AND P.createdDT <= '$toDate'";
        }
    }
    
    //echo $style."-".$order."-".$location."-".$vendor."-".$fromdate."-".$todate;
    // $detailsQuery="SELECT GD1.prodetailsID AS 'PROID', PD.cutNO AS 'CUT', C.color AS 'COLOR',S.size AS 'SIZE', GD1.recFinQty AS 'FQTY', GD1.recDamQty AS 'DQTY', GD1.SampleQty AS 'SQTY' 
    //             FROM grn_details1 GD1 JOIN sub_pro_details PD ON GD1.prodetailsID=PD.id
    //             JOIN style_colors C ON PD.colorID=C.colorID JOIN style_sizes S ON PD.sizeID=S.sizeID  WHERE GD1.grnNo='$slectedID'";
    // $detailsData=mysqli_query($conn,$detailsQuery);

	$activeUser=$_SESSION['_UserID'];

    $userQuery="SELECT CONCAT(U.Fname,' ',U.Lname) AS 'CURRENTU', UD.acc19 AS 'APP1' FROM users U JOIN user_details UD ON U.User_ID=UD.User_ID WHERE U.User_ID='$activeUser'";
    $userData=mysqli_query($conn,$userQuery);
    if($userData && mysqli_num_rows($userData)==1)
        {
            $rowData=mysqli_fetch_assoc($userData);
            $user=$rowData['CURRENTU'];
            $accConfirm=$rowData['APP1'];

        }
 ?>
 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracker Report</title>

    <!--bootstrap-->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>

		<!--Font-awsome-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<!--Google Font Family-->
		<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Merienda:wght@300..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css"/>
    

</head>
<body>
    <form method="POST">
        <div class="container ps-5 pe-5">
            <div class="ms-5 me-5 ps-5 pe-5">
                <div class="d-flex row" style="padding-bottom:25px;">
                                <div class="col-3 text-center justify-content-center align-items-center d-flex">
                                    <img src="../../Resources/images/logo.png" alt="Logo" class="img-fluid"  />
                                </div>
                                <div class="col-6 text-center pt-3">
                                    <h3>Original Apparel (Pvt) Ltd</h3>
                                    <p class="text-center">246/03 Welmilla, Aluthgama,  Bandaragama Bandaragama Sri Lanka.<br><b>Tel : </b>(122)(+94)11 7577700 <b>Fax : </b>(122)(+94)382291763 <br><b>E-Mail : </b>info@originalapparel.lk <b>Web : </b>www.originalapparel.lk</p>
                                </div>
                                <div class="col-3"></div>
                            <div><h3 class="text-center title mb-2">ORDER TRACKER REPORT - <?php echo $option; ?></h3></div>
                            
                            <!---------------------------------- Buyer Style Order Section -------------------------------------- -->

                            <div style="height:50px; font-family: times-new-roman;"><h4 class="text-center mt-3"><u>Style Order Details</u></h4></div>
                            <div class="row text-center">
                                <div class="col ps-4">
                                    <table class="w-100 table">
                                        <tr>
                                            <th>Style No:</th>
                                            <th>Order No:</th>
                                            <th>Location:</th>
                                            <th>Subcontractor:</th>
                                        </tr>
                                        <tr>
                                            <td><?php echo $selectedStyle;?></td>
                                            <td><?php if($selectedOrder!="All")
                                            {
                                                $orderdata=mysqli_query($conn,"SELECT orderNo FROM styleorder WHERE id='$selectedOrder'"); 
                                                        if($orderdata && mysqli_num_rows($orderdata)==1){$rowData=mysqli_fetch_assoc($orderdata);echo $rowData['orderNo'];} 
                                            }
                                            else
                                            {
                                                echo "All";
                                            }?></td>
                                            <td><?php if($selectedLocation!="All")
                                            {
                                                $locdata=mysqli_query($conn,"SELECT location FROM mast_location WHERE locationID='$selectedLocation'"); 
                                                        if($locdata && mysqli_num_rows($locdata)==1){$rowData=mysqli_fetch_assoc($locdata);echo $rowData['location'];} 
                                            }
                                            else
                                            {
                                                echo "All";
                                            }?></td>
                                            <td><?php if($selectedVendor!="All")
                                            {
                                                $vendordata=mysqli_query($conn,"SELECT vendor FROM vendors WHERE vendorID='$selectedVendor'"); 
                                                        if($vendordata && mysqli_num_rows($vendordata)==1){$rowData=mysqli_fetch_assoc($vendordata);echo $rowData['vendor'];}
                                            }
                                            else
                                            {
                                                echo "All";
                                            }
                                             ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div style="height:50px; font-family: times-new-roman;"><h4 class="text-center mt-5"><u>Parts Details</u></h4></div>
                            <!---------------------------------- Item Details Section -------------------------------------- -->
                            <?php
                                switch($option)
                                    {
                                        case "GATE PASS":
                                            ?>
                                            <div class="row text-center">
                                                <div class="col ps-4">
                                                    <table class="w-100 report-table text-center">
                                                        <tr>
                                                            <th>Gate Pass No.</th>
                                                            <th>Style</th>
                                                            <th>Order No.</th>
                                                            <th>Date</th>
                                                            <th>Vendor</th>
                                                            <th>Total Qty.</th>
                                                            <th>Created By</th>
                                                            <th>Created Date</th>	
                                                            <th>Status</th>
                                                        </tr>
                                                        <?php
                                                        try{
                                                            
                                                               $gpQuery="SELECT GP.gatepassID_1 AS 'gpID1', CONCAT(GP.gatepassID_2,'/', GP.gatepassID_1) AS 'gpID2',GP.gatepassDate AS 'GPDATE',SO.styleNo AS 'STYLE',SO.orderNo AS 'ORDERNO', ML.location AS 'LOC',
                                                                        V.vendor AS 'VEN',GP.orderAgreement AS 'AGREEMENT',SUM(GD.matQty) AS 'TOTAL', GP.status AS 'STATUS', CONCAT(U.Fname,' ',U.Lname) AS 'CREATEDBY', DATE_FORMAT(GP.createdDT,'%d/%m/%y') AS 'CREATEDDATE' 
                                                                        FROM  gatepass GP JOIN gatepass_details GD ON GP.gatepassID_1=GD.gpID JOIN mast_location AS ML ON GP.locationID=ML.locationID  
                                                                        JOIN styleorder AS SO ON GP.orderNoID=SO.id JOIN vendors AS V ON GP.vendorID=V.vendorID JOIN agreements AS AG ON GP.orderAgreement=AG.id 
                                                                        JOIN users AS U ON GP.createdBy=U.User_ID 
                                                                        WHERE GP.status!='' $style $order $location $vendor $fromdate $todate GROUP BY GD.gpID ORDER BY GP.gatepassID_1 DESC";

                                                                $returnGP=mysqli_query($conn,$gpQuery);

                                                            while($resultgp=mysqli_fetch_assoc($returnGP))
                                                            {
                                                                ?>
                                                                <tr class="flex align-items-center">
                                                                    <td class="text-center"><?php 
                                                                            $selected= $resultgp['gpID1'];
                                                                            $url = '../gp_view_page.php?selectedID= '.$selected; 
                                                                            echo '<a href="' . htmlspecialchars($url) . '" target="_blank" rel="noopener noreferrer" class="text-decoration-none">' . $resultgp['gpID2'] . '</a>';
                                                                    ?></td> 
                                                                    <td><?php echo $resultgp['STYLE']?></td>
                                                                    <td><?php echo $resultgp['ORDERNO']?></td>
                                                                    <td><?php echo $resultgp['GPDATE']?></td>
                                                                    <td><?php echo $resultgp['VEN']?></td>
                                                                    <td><?php echo $resultgp['TOTAL']?></td>
                                                                    <td><?php echo $resultgp['CREATEDBY']?></td>
                                                                    <td class="text-center"><?php echo $resultgp['CREATEDDATE']?></td>
                                                                    <td class="text-center"><?php echo $resultgp['STATUS']?></td>
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
                                            </div>
                                            <?php
                                            break;
                                        case "PRODUCTION RECORDS":
                                            ?>
                                            <div class="row text-center">
                                                <div class="col ps-4">
                                                    <table class="w-100 report-table text-center">
                                                        <tr>
                                                            <th>Record No.</th>
                                                            <th>Style</th>
                                                            <th>Order No.</th>
                                                            <th>Date</th>
                                                            <th>Vendor</th>
                                                            <th>Finished Qty.</th>
                                                            <th>Total Damages</th>
                                                            <th>Total Samples</th>
                                                            <th>Entered By</th>
                                                            <th>Entered Date</th>	
                                                            <th>Status</th>
                                                        </tr>
                                                        <?php
                                                        try{
                                                               $proQuery="SELECT SP.recordID AS 'recID',Sp.gatepassRefID AS 'REF', SP.gatepassDate AS 'GPDATE', SO.styleNo AS 'STYLE', SO.orderNo AS 'ORDERNO', ML.location AS 'LOC',
                                                                            V.vendor AS 'VEN',SP.orderAgreement AS 'AGREEMENT',SUM(PD.finishedQty) AS 'FINQTY',(SUM(PD.fabDamQty)+SUM(PD.processDamQty)) AS 'DAMQTY',SUM(PD.sampleQty) AS 'SMQTY', SP.status AS 'STATUS', CONCAT(U.Fname,' ',U.Lname) AS 'CREATEDBY', DATE_FORMAT(SP.cratedDT,'%d/%m/%y') AS 'CREATEDDATE' 
                                                                            FROM  sub_production SP JOIN sub_pro_details PD ON SP.recordID=PD.recID 
                                                                            JOIN mast_location AS ML ON SP.locationID=ML.locationID JOIN styleorder AS SO ON SP.orderNoID=SO.id JOIN vendors AS V ON SP.vendorID=V.vendorID 
                                                                            JOIN agreements AS AG ON SP.orderAgreement=AG.id JOIN users AS U ON SP.createdBy=U.User_ID 
                                                                            WHERE SP.recordID!='' $style $order $location $vendor $fromdate $todate ORDER BY SP.cratedDT DESC";

                                                                $returnPro=mysqli_query($conn,$proQuery);
                                                                
                                                            while($resultPro=mysqli_fetch_assoc($returnPro))
                                                            {
                                                                ?>
                                                                <tr class="flex align-items-center">
                                                                    <td class="text-center"><?php 
                                                                            $selected= $resultPro['recID'];
                                                                            $url = '../pro_view_page.php?selectedID= '.$selected;
                                                                            echo '<a href="' . htmlspecialchars($url) . '" target="_blank" rel="noopener noreferrer" class="text-decoration-none">' . $resultPro['recID'] . '</a>';
                                                                    ?></td> 
                                                                    <td><?php echo $resultPro['STYLE']?></td>
                                                                    <td><?php echo $resultPro['ORDERNO']?></td>
                                                                    <td><?php echo $resultPro['GPDATE']?></td>
                                                                    <td><?php echo $resultPro['VEN']?></td>
                                                                    <td><?php echo $resultPro['FINQTY']?></td>
                                                                    <td><?php echo $resultPro['DAMQTY']?></td>
                                                                    <td><?php echo $resultPro['SMQTY']?></td>
                                                                    <td><?php echo $resultPro['CREATEDBY']?></td>
                                                                    <td class="text-center"><?php echo $resultPro['CREATEDDATE']?></td>
                                                                    <td class="text-center"><?php echo $resultPro['STATUS']?></td>
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
                                            </div>
                                            <?php
                                            break;

                                        case "GRN":
                                            ?>
                                            <div class="row text-center">
                                                <div class="col ps-4">
                                                    <table class="w-100 report-table text-center">
                                                        <tr>
                                                            <th>GRN No.</th>
                                                            <th>Product. ID</th>
                                                            <th>Style</th>
                                                            <th>Order</th>
                                                            <th>Invoice Date</th>
                                                            <th>Vendor</th>
                                                            <th>Finished Qty.</th>
                                                            <th>Damage Qty.</th>
                                                            <th>Sample Qty.</th>
                                                            <th>GRN Value</th>
                                                            <th>Status</th>
                                                            <th>Created Date</th>
                                                            <th>Created By</th>
                                                        </tr>
                                                        <?php
                                                        try{
                                                               $grnQuery="SELECT GD.grnCode1 AS 'CODE1',CONCAT(GD.grnCode2,'/',GD.grnCode1) AS 'CODE2',SP.recordID AS 'PROID',SO.styleNo AS 'STYLE',SO.orderNo AS 'ORDERNO', 
                                                                DATE_FORMAT(GD.invoiceDate,'%d/%m/%y') AS 'INVDATE',GD.recFnishedQty AS 'RECFQTY', V.vendor AS 'VEN',GD.recDamQty AS 'RECDQTY',GD.recSampleQty AS 'RECSQTY', 
                                                                (GD.fgValue+GD.sampleValue+GD.vat) AS 'GRNVAL', DATE_FORMAT(GD.createdDT,'%d/%m/%y') AS 'GRNDATE', CONCAT(U.Fname, ' ', U.Lname) AS 'GRNBY', GD.status AS 'STATUS'
                                                                FROM grn_details GD JOIN sub_production SP ON GD.proRecNo=SP.recordID JOIN styleorder SO ON SP.orderNoID=SO.id 
                                                                JOIN mast_location ML ON SP.locationID=ML.locationID JOIN vendors V ON SP.vendorID=V.vendorID JOIN users U ON SP.createdBy=U.User_ID 
                                                                WHERE GD.status!='' $style $order $location $vendor $fromdate $todate ORDER BY GD.createdDT DESC";

                                                                $returnGrn=mysqli_query($conn,$grnQuery);
                                                                
                                                            while($result1=mysqli_fetch_assoc($returnGrn))
                                                            {
                                                                ?>
                                                                <tr class="flex align-items-center">
                                                                    <td class="text-center"><?php 
                                                                            $selected= $result1['CODE1'];
                                                                            $url = '../grn_view_page.php?selectedID= '.$selected;
                                                                            echo '<a href="' . htmlspecialchars($url) . '" target="_blank" rel="noopener noreferrer" class="text-decoration-none">' . $result1['CODE2'] . '</a>';
                                                                    ?></td> 
                                                                    <td><?php echo $result1['PROID']?></td>
                                                                    <td><?php echo $result1['STYLE']?></td>
                                                                    <td><?php echo $result1['ORDERNO']?></td>
                                                                    <td ><?php echo $result1['INVDATE']?></td>
                                                                    <td><?php echo $result1['VEN']?></td>
                                                                    <td><?php echo $result1['RECFQTY']?></td>
                                                                    <td><?php echo $result1['RECDQTY']?></td>
                                                                    <td><?php echo $result1['RECSQTY']?></td>
                                                                    <td class="decimal-data"><?php echo $result1['GRNVAL']?></td>
                                                                    <td><?php echo $result1['STATUS']?></td>
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
                                            </div>
                                            <?php
                                            break;

                                        case "PAYMENTS":
                                            ?>
                                            <div class="row text-center">
                                                <div class="col ps-4">
                                                    <table class="w-100 report-table text-center">
                                                        <tr>
                                                            <th>Receipt No.</th>
                                                            <th>Payment Date</th>
                                                            <th>Net Value</th>
                                                            <th>Vendor</th>
                                                            <th>Status</th>
                                                            <th>Created Date</th>
                                                            <th>Created By</th>
                                                        </tr>
                                                        <?php
                                                        try{
                                                               $payQuery="SELECT P.receiptID AS 'ID', DATE_FORMAT(P.Date,'%d/%m/%y') AS 'DATE', V.vendor AS 'VEN', P.netValue AS 'NETVAL', CONCAT(U.Fname,' ',U.Lname) AS 'USER',
                                                                                DATE_FORMAT(P.createdDT,'%d/%m/%y') AS 'CREATEDDT',P.Status AS 'STATUS' 
                                                                                FROM payments P JOIN payment_methods PM ON P.payMenthod=PM.methodID JOIN vendors V ON P.VendorID=V.vendorID
                                                                                JOIN users U ON P.createdBy=U.User_ID JOIN grn_details G ON P.receiptID=G.receiptID JOIN mast_location ML ON G.locationID=ML.locationID
                                                                                JOIN sub_production SP ON G.proRecNo=SP.recordID JOIN styleorder SO ON SP.orderNoID=SO.id 
                                                                                WHERE P.receiptID!='' $style $order $location $vendor $fromdate $todate ORDER BY P.createdDT DESC";

                                                                $returnPay=mysqli_query($conn,$payQuery);
                                                                
                                                            while($resPay=mysqli_fetch_assoc($returnPay))
                                                            {
                                                                ?>
                                                                <tr class="flex align-items-center">
                                                                    <td class="text-center"><?php 
                                                                            $selected= $resPay['ID'];
                                                                            $url = '../payment_view_page.php?selectedID= '.$selected;
                                                                            echo '<a href="' . htmlspecialchars($url) . '" target="_blank" rel="noopener noreferrer" class="text-decoration-none">' . $resPay['ID'] . '</a>';
                                                                    ?></td> 
                                                                    <td><?php echo $resPay['DATE'];?></td>
                                                                    <td class="decimal-data"><?php echo $resPay['NETVAL'];?></td>
                                                                    <td><?php echo $resPay['VEN'];?></td>
                                                                    <td ><?php echo $resPay['STATUS'];?></td>
                                                                    <td><?php echo $resPay['CREATEDDT'];?></td>
                                                                    <td><?php echo $resPay['USER'];?></td>
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
                                            </div>
                                            <?php
                                            break;

                                        default:
                                            $message="Invalid selection.";
                                    }
                            ?>
                            
                                                        
                            <div class="row justify-content-center gap-3 mt-5 no-print">
                                <hr>
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
