<?php
	include "../includes/db-con.php";
	
    // Fetching order and planning data with LEFT JOIN to include orders without plans
	$sqlQuery="SELECT OP.orderID AS OP_ID, SO.orderNo AS ORDER_NO, SO.styleNo AS STYLE, B.buyerName AS BUYER, SO.deliveryDate AS DELIVERY_DATE, SO.orderQty AS ORDER_QTY, 
            OP.setPieces AS PIECES, OP.subDuration AS DURATION,V.vendor AS VEN, V.vendorID AS VEN_ID, OP.startDate AS START_DATE, OP.endDate AS END_DATE, CONCAT(U.Fname,' ',U.Lname) AS PLANNEDBY, DATE_FORMAT(OP.plannedDT,'%d-%m-%Y') AS PLANNEDDT
                FROM order_plan OP JOIN styleorder SO ON OP.orderID=SO.id JOIN styles S ON SO.styleNo=S.styleNo JOIN buyer B ON S.buyerID=B.buyerID 
                    JOIN users U ON OP.plannedBy=U.user_ID JOIN vendors V ON OP.vendor=V.vendorID
                 WHERE SO.status='Active' AND B.status='Active' AND S.status='Active'";
                    //WHERE OP.planStatus IS NULL OR OP.planStatus='Pending'
	$returnDataSet=mysqli_query($conn,$sqlQuery);

    // ------------------------------- Loading vendor list for dropdown -------------------------------------------------
    $sqlQuery1="SELECT vendor,vendorID FROM vendors";
    $returnDataSet1=mysqli_query($conn,$sqlQuery1);

    // ------------------------------- Loading existing order plans to check availability------------------------------------
    $sqlQuery2="SELECT * FROM order_plan";
    $returnDataSet2=mysqli_query($conn,$sqlQuery2);
	
    // -------------------------- Saving a new plan ------------------------------------------
    if(isset($_POST['confirmPlan']))
    {
        $orderID = $_POST['orderID'];
        $piecesPerSet = $_POST['piecesSet'];
        $duration = $_POST['duration'];
        $vendor = $_POST['vendor'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
         $user = $_SESSION['_UserID'];

        //echo "Order ID: " . $orderID . "piecesPerSet: " . $piecesPerSet . "duration: " . $duration . "vendor: " . $vendor . "startDate: " . $startDate . "endDate: " . $endDate . "user: " . $user;
        $insert = "INSERT INTO order_plan 
                (orderID, setPieces, subDuration, vendor, startDate, endDate,planStatus, plannedBy)
                VALUES
                ('$orderID','$piecesPerSet','$duration','$vendor','$startDate','$endDate','Pending','$user')";

        mysqli_query($conn,$insert);
    }

    if(isset($_POST['btnCheck']))
    {
        $deliveryDate = $_POST['deldate'];
        $orderQty = $_POST['orderqty'];
        $piecesPerSet = $_POST['piecesSet'];
        $duration = $_POST['duration'];
        $vendor = $_POST['vendor'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];

        
    }
	$activeUser=$_SESSION['_UserID'];

 ?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Confirm Planning</title>
</head>
<body>
    <form method="POST">
        <div class="d-flex justify-content-between mb-3">
        <h4>Confirm Order Planning</h4>
    </div>
    <div class="table-wrapper">
        <table class="table1 text-center" cellspacing="0" style="font-size:6pt; min-width: 110%;">
        	<tr class="text-center">
            	<th>ID</th>
                <th>Order No</th>
                <th>Style No</th>
                <th>Buyer</th>
                <th>Delivery Date</th>
                <th>Order Qty.</th>	
                <th>Pieces Per Set</th>
                <th>Sub Order Duration(Days)</th>	
                <th>Check Availability</th>	
                <th>Subcontractor</th>	
                <th>Started Date</th>
                <th>End Date</th>
                <th>Confirm</th>
                <th>Planned By</th>
                <th>Planned Date</th>
		
            </tr>
            <?php
			while($result1=mysqli_fetch_assoc($returnDataSet))
			{
			?>
            <tr>
            	<td class="text-center">
                    <a href="DashBoard.php?activity=editStyleOrder&selectedID=<?php echo $result1['OP_ID']?>"><?php echo $result1['OP_ID']?>
                    </a>
                    <input type="hidden" name="orderID" value="<?php echo $result1['OP_ID']?>"/>
                </td>
                <td><?php echo $result1['ORDER_NO']?></td>
                <td><?php echo $result1['STYLE']?></td>
                <td><?php echo $result1['BUYER']?></td>
                <td name="deldate" value="<?php echo $result1['DELIVERY_DATE']?>"><?php echo $result1['DELIVERY_DATE']?></td>
                <td name="orderqty" value="<?php echo $result1['ORDER_QTY']?>"><?php echo $result1['ORDER_QTY']?></td>
                <td><?php echo $result1['PIECES']?></td>
                <td><?php echo $result1['DURATION']?></td>
                <td><button class="btn btn-secondary" disabled style="font-size:7pt">Checked</button></td>
                <td><?php echo $result1['VEN']?></td>
                <td><?php echo $result1['START_DATE']?></td>
                <td><?php echo $result1['END_DATE']?></td>
                <td><button class="btn btn-secondary" disabled style="font-size:7pt">Planned</button></td>
                <td style="width: 100px;"><input type="text" class="form-control" style="font-size:9pt" name="piecesSet" value="<?php echo $result1['PIECES']?>"/></td>
                <td style="width: 100px;"><input type="text" class="form-control" style="font-size:9pt" name="duration" value="<?php echo $result1['DURATION']?>"/></td>
                <td style="width: 90px;"><input type="submit" value="Check" class="btn btn-primary" style="font-size:7pt" name="btnCheck"/></td>
                <td style="width: auto;"><select class="form-select" name="vendor" id="vendor" style="font-size:9pt">
                                <option selected hidden></option>
                                        <?php 
                                            mysqli_data_seek($returnDataSet1, 0);
                                            while($vendor=mysqli_fetch_assoc($returnDataSet1)){
                                                ?>
                                                <option value="<?php echo $vendor['vendorID'];?>"><?php echo $vendor['vendor']?></option>
                                            <?php
                                            }
                                            ?>
                                    </select>
                </td>
                <td style="width:110px;"><input type="date" class="form-control" style="font-size:8pt" name="startDate"/></td>
                <td style="width:110px;"><input type="date" class="form-control" style="font-size:8pt" name="endDate"/></td>
                <td style="width: 80px;"><input type="submit" class="btn btn-primary" style="font-size:7pt" name="confirmPlan"/></td>
                <td><?php echo $result1['PLANNEDBY']?></td>
                <td><?php echo $result1['PLANNEDDT']?></td>		
            <tr>
            <?php
			}
			?>
        </table>
    </div>
    </form>
</body>
</html>