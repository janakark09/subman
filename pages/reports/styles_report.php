    <?php
	include "../includes/db-con.php";

    $selectedBuyer = "";
    $selectedStyle = "";
    $selectedOrder = "";
    $selectedLoc="";
    $selectedVendor="";
    $message="";
    $allgrnQuery="";
    $style="";
    $order="";
    $fromDate="";
    $toDate="";
    $groupBy="";

    $allgrnQuery="SELECT 
    SO.id AS ID,
    B.buyerName AS BUYER,
    S.styleNo AS STYLE,
    SO.orderNo AS ORDERNO,
    SO.orderQty AS QTY,
    SO.deliveryDate AS DELDATE,
    A.pcsPerSet AS PCS,
    IFNULL(agr.CONQTY, 0) AS CONQTY,
    IFNULL(gp.GPQTY, 0) AS GPQTY,
    IFNULL(sp.PROQTY, 0) AS PROQTY,
    IFNULL(gr.GRQTY, 0) AS GRQTY,
    IFNULL(gr.GRDAMQTY, 0) AS GRDAMQTY,
    SO.orderQty - (IFNULL(agr.CONQTY, 0)*A.pcsPerSet) AS BALQTY,
    DATE_FORMAT(SO.createdDT, '%Y-%m-%d') AS CREATEDDATE,    
    SO.Status AS STATUS

FROM styleorder SO

JOIN styles S 
    ON SO.styleNo = S.styleNo 

JOIN buyer B 
    ON S.buyerID = B.buyerID 

LEFT JOIN agreements A 
    ON A.styleOrderID = SO.id 

-- Aggregate agreements
LEFT JOIN (
    SELECT styleOrderID, SUM(contractTotalQty) AS CONQTY
    FROM agreements
    GROUP BY styleOrderID
) agr ON agr.styleOrderID = SO.id

-- Aggregate gatepass quantities
LEFT JOIN (
    SELECT GP.orderNoID, SUM(GPD.matQty) AS GPQTY
    FROM gatepass GP
    JOIN gatepass_details GPD ON GP.gatepassID_1 = GPD.gpID
    GROUP BY GP.orderNoID
) gp ON gp.orderNoID = SO.id

-- Aggregate sub-production quantities
LEFT JOIN (
    SELECT SP.orderNoID, SUM(SPD.finishedQty + SPD.sampleQty) AS PROQTY
    FROM sub_production SP
    JOIN sub_pro_details SPD ON SP.recordID = SPD.recID
    GROUP BY SP.orderNoID
) sp ON sp.orderNoID = SO.id

-- Aggregate GRN quantities
LEFT JOIN (
    SELECT SP.orderNoID, 
           SUM(GR.recFnishedQty + GR.recSampleQty) AS GRQTY,
           SUM(GR.recDamQty) AS GRDAMQTY
    FROM sub_production SP
    LEFT JOIN grn_details GR ON GR.proRecNo = SP.recordID
    GROUP BY SP.orderNoID
) gr ON gr.orderNoID = SO.id 
WHERE SO.id!=''";

$groupBy=" GROUP BY SO.orderNo";

    $returnAll=mysqli_query($conn,$allgrnQuery.$groupBy);
    
    if(isset($_POST['btnAll']))
        {
            $returnAll=mysqli_query($conn,$allgrnQuery.$groupBy);
        }

    //------------------ Fetch Buyer Name and Style Nos -------------------
    $sqlQuery1="SELECT * FROM  buyer WHERE status='Active'";
    $returnDataSet1=mysqli_query($conn,$sqlQuery1);

    //------------------ Fetch Selected Buyer -------------------
    if(isset($_POST['buyerid']))
    {
        $selectedBuyer=$_POST['buyerid'];
    }
    if($selectedBuyer != ""){
    $sqlQuery2 = "SELECT * FROM styles WHERE status='Active' AND buyerID='$selectedBuyer'";
    $returnDataSet2 = mysqli_query($conn,$sqlQuery2);
    }

    //------------------ Fetch Selected Style -------------------
    if(isset($_POST['styleNo']))
    {
        $selectedStyle=$_POST['styleNo'];
    }
    if($selectedStyle != ""){
    $sqlQuery3 = "SELECT * FROM styleorder WHERE Status='Active' AND styleNo='$selectedStyle'";
    $returnDataSet3 = mysqli_query($conn,$sqlQuery3);
    }

    if(isset($_POST['orderNo']))
    {
        $selectedOrder=$_POST['orderNo'];
    }

     //------------------ Fetch Location -------------------
    // $locationQuery="SELECT * FROM  mast_location WHERE status='Active'";
	// $locationDataSet=mysqli_query($conn,$locationQuery);

    // //------------------ Fetch Vendor Name -------------------
    // $vendorQuery="SELECT * FROM  vendors WHERE status='Active'";
    // $vendorDataSet=mysqli_query($conn,$vendorQuery);

    if(isset($_POST['btnSearch'])){
        $selectedBuyer=$_POST['buyerid'];
        $selectedStyle=$_POST['styleNo'];
        $selectedOrder=$_POST['orderNo'];
        // $selectedLoc=$_POST['locationid'];
        // $selectedVendor=$_POST['vendorid'];
        $fromDate=$_POST['fromDate'];
        $toDate=$_POST['toDate'];

        if($selectedStyle!="All"){
            $style=" AND SO.styleNo='$selectedStyle'";
        }
        if($selectedOrder!="All"){
            $order=" AND SO.id='$selectedOrder'";
        }
        // if($selectedLocation!="All"){
        //     $location=" AND ML.locationID='$selectedLocation'";
        // }
        // if($selectedVendor!="All"){
        //     $vendor=" AND V.vendorID='$selectedVendor'";
        // }
        if($fromDate!=""){
            $fromDate=" AND SO.createdDT >= '$fromDate'";
        }
        if($toDate!=""){
            $toDate=" AND SO.createdDT <= '$toDate'";
        }
        //echo $allgrnQuery.$style.$order.$fromDate.$toDate.$groupBy;
         $returnAll=mysqli_query($conn,$allgrnQuery.$style.$order.$fromDate.$toDate.$groupBy);
    }

    $activeUser=$_SESSION['_UserID'];

 ?>
 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Style report</title>
     <link rel="icon" type="image/x-icon" href="../../Resources/images/syslogo.ico">
</head>
<body>
    <div class="d-flex justify-content-between mb-3">
        <h4>Style Report</h4>
    </div>
    <form method="POST">
        <div class="container-fluid">
            <div class="d-lg-flex mb-3">
                <div class="form-group col-md-4 me-3">
                            <label >Buyer</label>
                            <select class="form-select" name="buyerid" id="buyerSelect" onchange="resetStyleAndOrder(); this.form.submit()"  >
                                <option selected>All</option>
                                <?php 
                                    while($buyer=mysqli_fetch_assoc($returnDataSet1)){
                                        ?>
                                        <option value="<?php echo $buyer['buyerID']; ?>" 
                                        <?php if(isset($_POST['buyerid']) && $_POST['buyerid']==$buyer['buyerID']) echo "selected"; ?>>
                                        <?php echo $buyer['buyerName']?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                </div>
                <div class="form-group col-md-4 me-3">
                            <label >Style No.</label>
                            <select class="form-select" name="styleNo" id="styleSelect" onchange="this.form.submit()">
                                <option selected>All</option>
                                <?php 
                                    if($selectedBuyer != ""){
                                        while($styleno=mysqli_fetch_assoc($returnDataSet2)){
                                            ?>
                                            <option value="<?php echo $styleno['styleNo']; ?>" <?php if(isset($_POST['styleNo']) && $_POST['styleNo']==$styleno['styleNo']) echo "selected"; ?>><?php echo $styleno['styleNo']?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                            </select>
                </div>
                <div class="form-group col-md-4 me-5">
                            <label >Order No.</label>
                            <select class="form-select" name="orderNo" id="orderSelect" onchange="this.form.submit()">
                                <option selected>All</option>
                                <?php 
                                    if($selectedStyle != ""){
                                        while($orderno=mysqli_fetch_assoc($returnDataSet3)){
                                            ?>
                                            <option value="<?php echo $orderno['id']?>" <?php if(isset($_POST['orderNo']) && $_POST['orderNo']==$orderno['id']) echo "selected"; ?>><?php echo $orderno['orderNo']?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                            </select>
                </div>
            </div>   <!----> 
            
            <div class="d-lg-flex mb-3 gap-3">
                <div class="col-6 gap3 d-lg-flex gap-3">
                    <div class="form-group col-md-4">
                        <label>From(Created Date)</label>
                        <input type="date" class="form-control" id="fromDate" name="fromDate" value="<?php echo isset($_POST['fromDate']) ? $_POST['fromDate'] : ''; ?>" onchange="this.form.submit()"/>
                    </div>
                    <div class="form-group col-md-4">
                        <label>To(Created Date)</label>
                        <input type="date" class="form-control" id="toDate" name="toDate" value="<?php echo isset($_POST['toDate']) ? $_POST['toDate'] : ''; ?>" onchange="this.form.submit()"/>
                    </div>
                </div>
                <div class="col-6 gap3 d-lg-flex justify-content-end gap-3">
                    <div class="form-group">
                        <br>
                        <button type="Search" class="btn btn-primary me-2 save_btn" name="btnSearch" id="btnSearch">Search</button>
                        <input type="button" class="btn btn-primary me-2 save_btn" value="All" name="btnAll" id="btnAll" onclick="window.location.href='home_page.php?activity=rptStyles'"/>
                    </div>
                </div>
            </div>
            <!-- ------------------------------------------ Table View ------------------------------------------ -->
             <div class="table-wrapper">
                <table class="report-table text-center" cellspacing="0" style="font-size: 9pt;">
                    <tr class="table-header">
                        <th>Buyer</th>
                        <th>Style No</th>
                        <th>Order No</th>
                        <th>Order Quantity</th>
                        <th>Delivery Date</th>
                        <th>Pcs Per Set</th>
                        <th>Agreement Qty (Sets)</th>
                        <th>Gate Pass Qty</th>
                        <th>Finished Qty</th>
                        <th>GRN Qty</th>
                        <th>Rec. Damage Qty</th>
                        <th>Bal. Qty(order)</th>
                        <th>Created Date</th>
                        <th>Status</th>		
                    </tr>
                    <?php
                    try{
                        while($result1=mysqli_fetch_assoc($returnAll))
                        {
                            ?>
                            <tr class="flex align-items-center">
                                <td><?php echo $result1['BUYER']?></td>
                                <td><?php echo $result1['STYLE']?></td>
                                <td><?php echo $result1['ORDERNO']?></td>
                                <td><?php echo $result1['QTY']?></td>
                                <td><?php echo $result1['DELDATE']?></td>
                                <td><?php echo $result1['PCS']?></td>
                                <td><?php echo $result1['CONQTY']?></td>
                                <td><?php echo $result1['GPQTY']?></td>
                                <td><?php echo $result1['PROQTY']?></td>
                                <td><?php echo $result1['GRQTY']?></td>
                                <td><?php echo $result1['GRDAMQTY']?></td>
                                <td><?php echo $result1['BALQTY']?></td>
                                <td><?php echo $result1['CREATEDDATE']?></td>
                                <td><?php echo $result1['STATUS']?></td>
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
    </form>

    <script>
    function resetStyleAndOrder() {
        document.getElementById('styleSelect').selectedIndex = 0;
        document.getElementById('orderSelect').innerHTML = '<option selected hidden></option>';
    }
    let cells = document.querySelectorAll(".decimal-data");
        cells.forEach(function(cell) {
        let number = Number(cell.textContent);
        cell.textContent = number.toLocaleString('en-US', {
            style: 'decimal',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    });
</script>

</body>
</html>
