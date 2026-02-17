<?php
	include "../includes/db-con.php";
	
	$sqlQuery="SELECT SO.id AS ID, SO.orderNo AS ORDER_NO, SO.styleNo AS STYLE, B.buyerName AS BUYER, SO.deliveryDate AS DELIVERY_DATE, SO.orderQty AS ORDER_QTY FROM styleorder SO JOIN styles S ON SO.styleNo=S.styleNo JOIN buyer B ON S.buyerID=B.buyerID";
	$returnDataSet=mysqli_query($conn,$sqlQuery);

    $sqlQuery1="SELECT vendor FROM vendors";
    $returnDataSet1=mysqli_query($conn,$sqlQuery1);
	
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
    <div class="d-flex justify-content-between mb-3">
        <h4>Order Planning</h4>
        <button type="submit" class="btn btn-primary me-2" name="btnAddBuy" onclick="window.location.href='home_page.php?activity=addbuyer'">+ Add New Buyer</button> 
    </div>
    <div class="table-wrapper table-responsive">
        <table class="table1 text-center" cellspacing="0" style="font-size:6pt; min-width: 100%;">
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
            </tr>
            <?php
			while($result1=mysqli_fetch_assoc($returnDataSet))
			{
			?>
            <tr>
            	<td class="text-center"><a href="DashBoard.php?activity=editStyleOrder&selectedID=<?php echo $result1['ID']?>"><?php echo $result1['ID']?></a></td>
                <td><?php echo $result1['ORDER_NO']?></td>
                <td><?php echo $result1['STYLE']?></td>
                <td><?php echo $result1['BUYER']?></td>
                <td><?php echo $result1['DELIVERY_DATE']?></td>
                <td><?php echo $result1['ORDER_QTY']?></td>
                <td style="width: 100px;"><input type="text" class="form-control" style="font-size:9pt"/></input></td>
                <td style="width: 100px;"><input type="text" class="form-control" style="font-size:9pt"/></input></td>
                <td style="width: 90px;"><input type="submit" value="Check" class="btn btn-primary" style="font-size:7pt"/></td>
                <td style="width: auto;"><select class="form-select" name="vendor" id="vendor" style="font-size:9pt">
                                <option selected hidden></option>
                                <?php 
                                    while($vendor=mysqli_fetch_assoc(result:$returnDataSet1)){
                                        ?>
                                        <option><?php echo $vendor['vendor']?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                        </td>
                <td style="width:110px;"><input type="date" class="form-control" style="font-size:8pt;"/></td>
                <td style="width:110px;"><input type="date" class="form-control" style="font-size:8pt;"/></td>
                <td style="width: 80px;"><input type="submit" value="Yes" class="btn btn-primary" style="font-size:7pt"/></td>
				
            <tr>
            <?php
			}
			?>
        </table>
    </div>
</body>
</html>