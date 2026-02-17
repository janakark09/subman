<?php
	include "../includes/db-con.php";
	
	$sqlQuery="SELECT * FROM buyer";
	$returnDataSet=mysqli_query($conn,$sqlQuery);
	
	$activeUser=$_SESSION['_UserID'];

 ?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> All Buyers</title>
</head>
<body>
    <div class="d-flex justify-content-between mb-3">
        <h4>All Buyers</h4>
        <button type="submit" class="btn btn-primary me-2" name="btnAddBuy" onclick="window.location.href='home_page.php?activity=addbuyer'">+ Add New Buyer</button> 
    </div>
    <div class="table-wrapper">
        <table class="table1" cellspacing="0">
        	<tr class="text-center">
            	<th>ID</th>
                <th>Buyer Code</th>
                <th>Buyer Name</th>
                <th>Address</th>
                <th>Tel.</th>
                <th>Contact Person</th>
                <th>Email</th>
                <th>Status</th>	
                <th></th>				
            </tr>
            <?php
			while($result1=mysqli_fetch_assoc($returnDataSet))
			{
			?>
            <tr>
            	<td class="text-center"><a href="DashBoard.php?activity=editBuyer&selectedID=<?php echo $result1['buyerID']?>"><?php echo $result1['buyerID']?></a></td>
                <td><?php echo $result1['buyerCode']?></td>
                <td><?php echo $result1['buyerName']?></td>
                <td><?php echo $result1['address']?></td>
                <td><?php echo $result1['tel']?></td>
                <td><?php echo $result1['contactPerson']?></td>
                <td><?php echo $result1['email']?></td>
                <td><?php echo $result1['status']?></td>
                <td><a href="DashBoard.php?activity=view&Criteria=Buyer&selectedID=<?php echo $result1['buyerID']?>">View</a></td>
				
            <tr>
            <?php
			}
			?>
        </table>
    </div>
</body>
</html>