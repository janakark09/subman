<?php
	include "../includes/db-con.php";

    $selectedBuyer = "";
    $selectedStyle = "";
    $selectedOrder = "";
    $message="";
    $allQuery="";

    $allQuery="SELECT SP.recordID AS 'recID',Sp.gatepassRefID AS 'REF', SP.gatepassDate AS 'GPDATE', SO.styleNo AS 'STYLE', SO.orderNo AS 'ORDERNO', ML.location AS 'LOC',
         V.vendor AS 'VEN',SP.orderAgreement AS 'AGREEMENT',SUM(PD.finishedQty) AS 'FINQTY',(SUM(PD.fabDamQty)+SUM(PD.processDamQty)) AS 'DAMQTY',SUM(PD.sampleQty) AS 'SMQTY', SP.status AS 'STATUS', CONCAT(U.Fname,' ',U.Lname) AS 'CREATEDBY', DATE_FORMAT(SP.cratedDT,'%d/%m/%y') AS 'CREATEDDATE' 
                    FROM  sub_production SP JOIN sub_pro_details PD ON SP.recordID=PD.recID 
                    JOIN mast_location AS ML ON SP.locationID=ML.locationID  
                    JOIN styleorder AS SO ON SP.orderNoID=SO.id 
                    JOIN vendors AS V ON SP.vendorID=V.vendorID 
                    JOIN agreements AS AG ON SP.orderAgreement=AG.id 
                    JOIN users AS U ON SP.createdBy=U.User_ID ";
    $orderby="GROUP BY PD.recID ORDER BY SP.recordID DESC";

    $returnAll=mysqli_query($conn,$allQuery.$orderby);
    
    if(isset($_POST['btnAll']))
        {
            $returnAll=mysqli_query($conn,$allQuery.$orderby);
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

    if(isset($_POST['btnSearch']) && $selectedOrder!=""){
        //echo $selectedOrder;
        $srchQry=$allQuery." WHERE SP.orderNoID='$selectedOrder' ".$orderby;
        $returnAll=mysqli_query($conn,$srchQry);
    }
    elseif(isset($_POST['btnSearch']) && $selectedOrder=="")
        {
            $message = "All production records Loaded. *Please select a Order No to search.";
        }

	$activeUser=$_SESSION['_UserID'];

 ?>
 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production</title>
</head>
<body>
    <div class="d-flex justify-content-between mb-3">
        <h4>All Production Records</h4>
    </div>
    <form method="POST">
        <div class="container-fluid">
            <!---------------------------------- Buyer Style Order Section -------------------------------------- -->
                    <div class="form-group col-md-4 me-3">
                            <label >Buyer</label>
                            <select class="form-select" name="buyerid" id="buyerSelect" onchange="resetStyleAndOrder(); this.form.submit()"  >
                                <option selected hidden></option>
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
                    <div class="d-lg-flex mb-3">
                        <div class="form-group col-md-4 me-3">
                            <label >Style No.</label>
                            <select class="form-select" name="styleNo" id="styleSelect" onchange="this.form.submit()">
                                <option selected hidden></option>
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
                                <option selected hidden></option>
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
                        <div class="form-group col-md-4 me-3 ms-5">
                            <br>
                            <button type="Search" class="btn btn-primary me-2 save_btn" name="btnSearch" id="btnSearch">Search</button>
                            <button type="All" class="btn btn-primary me-2 save_btn" name="btnAll" id="btnAll" onclick="resetStyleAndOrder()">All</button>
                        </div> 
                    </div>
        </div>
    </form>
    <div class="table-wrapper">
        <table class="table1 text-center" cellspacing="0" style="min-width: 100%;">
        	<tr class="table-header">
            	<th>Gate Pass No.</th>
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
                <th>Action</th>			
            </tr>
            <?php
            try{
                while($result1=mysqli_fetch_assoc($returnAll))
                {
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $result1['recID']?></td>
                        <td><?php echo $result1['STYLE']?></td>
                        <td><?php echo $result1['ORDERNO']?></td>
                        <td><?php echo $result1['GPDATE']?></td>
                        <td><?php echo $result1['VEN']?></td>
                        <td><?php echo $result1['FINQTY']?></td>
                        <td><?php echo $result1['DAMQTY']?></td>
                        <td><?php echo $result1['SMQTY']?></td>
                        <td><?php echo $result1['CREATEDBY']?></td>
                        <td class="text-center"><?php echo $result1['CREATEDDATE']?></td>
                        <td class="text-center"><?php echo $result1['STATUS']?></td>
                        <td class="text-center"><?php 
                                $selected= $result1['recID'];
                                $url = 'pro_view_page.php?activity=proView&Criteria=Production&selectedID= '.$selected;
                                echo '<a href="' . htmlspecialchars($url) . '" target="_blank" rel="noopener noreferrer">View</a>';
                        ?></td> 
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
    <div class="container text-center" >
        <label class="text-danger"><?php echo $message?></label>
    </div>
    <script>
    function resetStyleAndOrder() {
        document.getElementById('styleSelect').selectedIndex = 0;
        document.getElementById('orderSelect').innerHTML = '<option selected hidden></option>';
    }
</script>
</body>
</html>
