<?php
	include "../includes/db-con.php";
	
    $sqlQuery="SELECT GP.gatepassID_1 AS 'gpID1', GP.gatepassID_2 AS 'gpID2',GP.gatepassDate AS GPDATE,SO.styleNo AS 'STYLE',SO.orderNo AS 'ORDER', ML.location AS 'LOC', V.vendor AS 'VEN',GP.orderAgreement AS 'AGREEMENT', GP.status AS 'STATUS', CONCAT(U.Fname,' ',U.Lname) AS 'CREATEDBY', GP.createdDT AS 'CREATEDDATE' 
            FROM  gatepass GP JOIN gatepass_details GD ON GP.gatepassID_1=GD.gatepassID_1 JOIN mast_location AS ML ON GP.locationID=ML.locationID  
            JOIN styleorder AS SO ON GP.orderNoID=SO.id JOIN vendors AS V ON GP.vendorID=V.vendorID JOIN agreements AS AG ON GP.orderAgreement=AG.id 
            JOIN users AS U ON GP.createdBy=U.User_ID";
	$returnDataSet2=mysqli_query($conn,$sqlQuery);

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

    //------------------ Fetch Selected Order to Order Quantity Lable -------------------
    if(isset($_POST['orderNo']) && $_POST['orderNo'] != "")
    {
        $selectedOrder=$_POST['orderNo'];
        $sqlQuery4 = "SELECT S.orderQty, P.setPieces, P.vendor FROM styleorder AS S LEFT JOIN order_plan AS P ON S.id = P.orderID WHERE S.id='$selectedOrder'";
        $result4 = mysqli_query($conn, $sqlQuery4);
        if($result4 && mysqli_num_rows($result4) > 0){
            $row4 = mysqli_fetch_assoc($result4);
            $orderQuantity = $row4['orderQty'];
            $piecesPerSet = $row4['setPieces'];
            $subconQty = ($piecesPerSet > 0) ? floor($orderQuantity / $piecesPerSet) : 0;
            $selectedVendor = $row4['vendor'];
        }
    }
	
	$activeUser=$_SESSION['_UserID'];

 ?>
 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatepass</title>
</head>
<body>
    <div class="d-flex justify-content-between mb-3">
        <h4>All Gate Passes</h4>
        <button type="submit" class="btn btn-primary me-2" name="btnAddVen" onclick="window.location.href='home_page.php?activity=addgatepass'">+ Add New Gate Pass</button> 
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
                    <div class="d-lg-flex mb-3  ">
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
                        <div class="form-group col-md-4 me-3">
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
                    </div>
        </div>
    </form>
    <div class="table-wrapper">
        <table class="table1" cellspacing="0">
        	<tr class="text-center">
            	<th>Gate Pass No.</th>
                <th>Style</th>
                <th>Order No.</th>
                <th>Date</th>
                <th>Vendor</th>
                <th>Total Qty.</th>
                <th>Created By</th>
                <th>Created Date</th>	
                <th>Action</th>			
            </tr>
            <?php
            try{
			while($result1=mysqli_fetch_assoc($returnDataSet2))
			{
                ?>
                <tr>
                    <td class="text-center"><a href="DashBoard.php?activity=editGatepass&selectedID=<?php echo $result1['gpID1']?>"><?php echo $result1['gpID2']."/".$result1['gpID1']?></a></td>
                    <td><?php echo $result1['STYLE']?></td>
                    <td><?php echo $result1['ORDER']?></td>
                    <td><?php echo $result1['GPDATE']?></td>
                    <td><?php echo $result1['VEN']?></td>
                    <td><?php echo $result1['contactPerson']?></td>
                    <td><?php echo $result1['email']?></td>
                    <td class="text-center"><?php echo $result1['dailyCapacity']?></td>
                    <td class="text-center"><?php echo $result1['status']?></td>      
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
</body>
</html>
