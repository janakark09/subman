<?php
	include "../includes/db-con.php";
    $suggestVendor="";
    $endDate = "";
    $startDate = "";
	
    // Fetching order and planning data with LEFT JOIN to include orders without plans
	$sqlQuery="SELECT SO.id AS SO_ID,OP.orderID AS OP_ID, SO.orderNo AS ORDER_NO, SO.styleNo AS STYLE, B.buyerName AS BUYER, SO.deliveryDate AS DELIVERY_DATE, SO.orderQty AS ORDER_QTY, 
            OP.setPieces AS PIECES, OP.subDuration AS DURATION,V.vendor AS VEN, V.vendorID AS VEN_ID, OP.startDate AS START_DATE, OP.endDate AS END_DATE, CONCAT(U.Fname,' ',U.Lname) AS PLANNEDBY, DATE_FORMAT(OP.plannedDT,'%d-%m-%Y') AS PLANNEDDT
                FROM styleorder SO JOIN styles S ON SO.styleNo=S.styleNo JOIN buyer B ON S.buyerID=B.buyerID 
                    LEFT JOIN order_plan OP ON SO.id=OP.orderID LEFT JOIN users U ON OP.plannedBy=U.user_ID LEFT JOIN vendors V ON OP.vendor=V.vendorID WHERE SO.status='Active' AND B.status='Active' AND S.status='Active'";
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
        if(isset($_POST['piecesSet'])!="" && isset($_POST['duration'])!="" && isset($_POST['vendor'])!="" && isset($_POST['startDate'])!="" && isset($_POST['endDate'])!="" && $_POST['piecesSet'] > 0 && $_POST['duration'] > 0){
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

            if(mysqli_query($conn,$insert))
            {
                echo "<script>
                    setTimeout(function(){window.location.href = 'home_page.php?activity=planning';}, 500);
                </script>";
                exit();
            }
        }
        else{
            echo "<script>alert('Please fill all fields with valid values before saving the plan.');</script>";
        }
    }

    if(isset($_POST['btnCheck']) && isset($_POST['piecesSet'])!="" && isset($_POST['duration'])!="")
    {
        $orderID = $_POST['orderID'];
        $deliveryDate = $_POST['deldate'];
        $orderQty = $_POST['orderqty'];
        $piecesPerSet = $_POST['piecesSet'];
        $duration = $_POST['duration'];
        //echo "Order ID: " . $orderID . " Delivery Date: " . $deliveryDate . " Order Qty: " . $orderQty . " Pieces Per Set: " . $piecesPerSet . " Duration: " . $duration;
        // Required daily qty
        if($piecesPerSet != "" && $duration != "" && $piecesPerSet > 0 && $duration > 0)
        {
            $setsRequired = (int)$orderQty / (int)$piecesPerSet;
            $requiredDaily = $setsRequired / (int)$duration;
        }
        else{
            $requiredDaily = 0;
            $suggestVendor = "";
            $startDate = "";
            $endDate = "";
        }
        // $requiredDaily = (int)$orderQty / (int)$duration;
        //echo " Required Daily Qty: " . $requiredDaily;
        // Find suitable vendor
        $sqlVendor = "SELECT * FROM vendors 
                    WHERE dailyCapacity >= '$requiredDaily' 
                    ORDER BY dailyCapacity ASC LIMIT 1";

        $resVendor = mysqli_query($conn, $sqlVendor);
        $vendorData = mysqli_fetch_assoc($resVendor);

        if($vendorData)
        {
            $suggestVendor = $vendorData['vendorID'];
            echo " Suggested Vendor: " . $vendorData['vendor'] . " with Daily Capacity: " . $vendorData['dailyCapacity'];
            // Calculate dates
            $endDate = $deliveryDate;
            $startDate = date('Y-m-d', strtotime($endDate . " -$duration days"));

            //echo " Suggested Start Date: " . $startDate . " End Date: " . $endDate;

            // Store results
            $suggested[$orderID] = [
                'vendor' => $suggestVendor,
                'start' => $startDate,
                'end' => $endDate
            ];
        }
    }
    else{
        $suggested = [];
    }
	$activeUser=$_SESSION['_UserID'];

 ?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Planning</title>
</head>
<body>
    <form method="POST">
        <div class="d-flex justify-content-between mb-3">
        <h4>Order Planning</h4>
    </div>
    <div class="table-wrapper">
        <table class="table1 text-center" cellspacing="0" style="font-size:6pt; min-width: 130%;">
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
                <th>Plan</th>
                <th>Planned By</th>
                <th>Planned Date</th>
		
            </tr>
            <?php
			while($result1=mysqli_fetch_assoc($returnDataSet))
			{
			?>
            <tr>
            	<td class="text-center">
                    <?php echo $result1['SO_ID']?>
                    <input type="hidden" name="orderID" value="<?php echo $result1['SO_ID']?>"/>
                </td>
                <td><?php echo $result1['ORDER_NO']?></td>
                <td><?php echo $result1['STYLE']?></td>
                <td><?php echo $result1['BUYER']?></td>
                <td value="<?php echo $result1['DELIVERY_DATE']?>"><?php echo $result1['DELIVERY_DATE']?></td>
                <td value="<?php echo $result1['ORDER_QTY']?>"><?php echo $result1['ORDER_QTY']?></td>
                <?php
                    if($result1['OP_ID']!=null){
                        ?>
                        <td><?php echo $result1['PIECES']?></td>
                        <td><?php echo $result1['DURATION']?></td>
                        <td><button class="btn btn-secondary" disabled style="font-size:7pt">Checked</button></td>
                        <td><?php echo $result1['VEN']?></td>
                        <td><?php echo $result1['START_DATE']?></td>
                        <td><?php echo $result1['END_DATE']?></td>
                        <td><button class="btn btn-secondary" disabled style="font-size:7pt">Planned</button></td>
                     <?php
                    }
                    else{
                    ?>
                        <td style="width: 100px;"><input type="text" class="form-control" style="font-size:9pt" name="piecesSet" value="<?php if($result1['PIECES']!=""){echo $result1['PIECES'];}else{if(isset($_POST['piecesSet'])){echo $_POST['piecesSet'];}} ?>" /></td>
                        <td style="width: 100px;"><input type="text" class="form-control" style="font-size:9pt" name="duration" value="<?php if($result1['DURATION']!=""){echo $result1['DURATION'];}else{ if(isset($_POST['duration'])){echo $_POST['duration'];} } ?>"  id="duration_<?php echo $rowId; ?>"/></td>
                        <td style="width: 90px;"><input type="submit" value="Check" class="btn btn-primary" style="font-size:7pt" name="btnCheck"/></td>
                        <td style="width: auto;"><select class="form-select" name="vendor" id="vendor" style="font-size:9pt">
                                            <option selected hidden></option>
                                            <?php
                                            mysqli_data_seek($returnDataSet1, 0);
                                            while($vendor=mysqli_fetch_assoc($returnDataSet1)){
                                                // $selected = (isset($suggested[$result1['SO_ID']]) && 
                                                //             $suggested[$result1['SO_ID']]['vendor'] == $vendor['vendorID']) 
                                                //             ? 'selected' : '';
                                            ?>
                                            <option value="<?php echo $vendor['vendorID'];?>" <?php if($vendor['vendorID']==$suggestVendor){echo 'selected';} ?>>
                                                <?php echo $vendor['vendor']?>
                                            </option>
                                            <?php } ?>
                                        </select>   
                                </td>
                        <td style="width:110px;"><input type="date" value="<?php if($startDate!=""){echo $startDate;} ?>" class="form-control" style="font-size:8pt" name="startDate" id="startDate_<?php echo $rowId; ?>" onchange="calculateEndingDate('<?php echo $rowId; ?>')"/></td>
                        <td style="width:110px;"><input type="date" value="<?php if($endDate!=""){echo $endDate;} ?>" class="form-control" style="font-size:8pt" name="endDate" id="endDate_<?php echo $rowId; ?>"/></td>
                        <td style="width: 80px;"><input type="submit" class="btn btn-primary" style="font-size:7pt" name="confirmPlan" value="Save"/></td>
                        <td hidden><input type="hidden" name="deldate" value="<?php echo $result1['DELIVERY_DATE']?>"/></td>
                        <td hidden><input type="hidden" name="orderqty" value="<?php echo $result1['ORDER_QTY']?>"/></td>
                <?php
                        }
                ?>	
                <td><?php echo $result1['PLANNEDBY']?></td>
                <td><?php echo $result1['PLANNEDDT']?></td>		
            <tr>
            <?php
			}
			?>
        </table>
    </div>
    </form>
    
<script>
function calculateEndingDate(rowId)
{
    let startDate = document.getElementById('startDate_' + rowId).value;
    let duration = document.getElementById('duration_' + rowId).value;

    if(startDate && duration > 0)
    {
        let start = new Date(startDate);
        
        // Add duration days
        start.setDate(start.getDate() + parseInt(duration));

        // Format YYYY-MM-DD
        let endDate = start.toISOString().split('T')[0];

        document.getElementById('endDate_' + rowId).value = endDate;
    }
}
</script>
</body>
</html>