<?php
	include "../includes/db-con.php";
	
	$sqlQuery="SELECT * FROM styleorder JOIN buyer ON styles.buyerID=buyer.buyerID JOIN users ON styleorder.createdBy=users.user_ID JOIN styles ON styleorder.styleNo=styles.styleNo";
	$returnDataSet=mysqli_query($conn,$sqlQuery);
	
	$activeUser=$_SESSION['_UserID'];

 ?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Style Orders</title>
</head>
<body>
    <div class="d-flex justify-content-between mb-3">
        <h4>All Style Orders</h4>
        <button type="submit" class="btn btn-primary me-2" name="btnAddOrder" onclick="window.location.href='home_page.php?activity=addstyle'">+ Add New Style Order</button> 
    </div>
    <div>
        <table class="table1 text-center" cellspacing="0">
        	<tr>
                <th>ID</th>
            	<th>Buyer</th>
                <th>Style No</th>
                <th>Order No</th>
                <th>Order Quantity</th>
                <th>Delivery Date</th>
                <th>Entered By</th>
                <th>Created Date</th>
                <th>Status</th>	
                <th></th>				
            </tr>
            <?php
			while($result1=mysqli_fetch_assoc($returnDataSet))
			{
			?>
            <tr>
            	<td>
                <?php if($result1['buyerID']!=$activeUser){ ?>
                <a href="DashBoard.php?activity=editStyle&selectedID=<?php echo $result1['styleorder.id']?>"><?php echo $result1['styleorder.id']?></a>
                <?php }
				else
				{
					echo $result1['styleorder.id'];
				}?>
                </td>
                <td><?php echo $result1['buyer.buyerName']?></td>
                <td><?php echo $result1['styleorder.styleNo']?></td>
                <td><?php echo $result1['styleorder.orderNo']?></td>
                <td><?php echo $result1['styleorder.orderQty']?></td>
                <td><?php echo $result1['styleorder.deliveryDate']?></td>
                <td><?php echo $result1['users.firstName']." ".$result1['users.lastName']?></td>
                <td><?php echo $result1['styleorder.createdDT']?></td>
                <td><?php echo $result1['styleorder.Status']?></td>
                <!-- <td><a href="DashBoard.php?activity=view&Criteria=Buyer&selectedID=<?php echo $result1['buyerID']?>">View</a></td> -->
				
            <tr>
            <?php
			}
			?>
        </table>
    </div>
</body>
</html>