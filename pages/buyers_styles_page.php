<?php
	include "../includes/db-con.php";
	
	$sqlQuery="SELECT styleorder.id as ID,buyer.buyerName as BUYER,styles.styleNo as STYLE,styleorder.orderNo as ORDERNO,styleorder.orderQty as QTY,styleorder.deliveryDate as DELDATE,
                CONCAT(users.Fname,' ',users.Lname) as USER,styleorder.Status as STATUS,DATE_FORMAT(styleorder.createdDT,'%d/%m/%Y') as CREATEDDATE 
                FROM styleorder JOIN styles ON styleorder.styleNo = styles.styleNo JOIN buyer ON styles.buyerID = buyer.buyerID JOIN users ON styleorder.createdBy = users.user_ID;";
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
        <button type="submit" class="btn btn-primary me-2" name="btnAddOrder" onclick="window.location.href='home_page.php?activity=addstyleorder'">+ Add New Style Order</button> 
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
            </tr>
            <?php
			while($result1=mysqli_fetch_assoc($returnDataSet))
			{
			?>
            <tr>
            	<td><a href="DashBoard.php?activity=editStyle&selectedID=<?php echo $result1['ID']?>"><?php echo $result1['ID']?></a></td>
                <td><?php echo $result1['BUYER']?></td>
                <td><?php echo $result1['STYLE']?></td>
                <td><?php echo $result1['ORDERNO']?></td>
                <td><?php echo $result1['QTY']?></td>
                <td><?php echo $result1['DELDATE']?></td>
                <td><?php echo $result1['USER']?></td>
                <td><?php echo $result1['CREATEDDATE']?></td>
                <td><?php echo $result1['STATUS']?></td>				
            <tr>
            <?php
			}
			?>
        </table>
    </div>
</body>
</html>