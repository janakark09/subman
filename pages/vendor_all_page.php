<?php
	include "../includes/db-con.php";
	
	$sqlQuery="SELECT * FROM vendors";
	$returnDataSet=mysqli_query($conn,$sqlQuery);
	
	$activeUser=$_SESSION['_UserID'];

 ?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> All Vendors</title>
</head>
<body>
    <div class="d-flex justify-content-between mb-3">
        <h4>All Subcontractors</h4>
        <button type="submit" class="btn btn-primary me-2" name="btnAddVen" onclick="window.location.href='home_page.php?activity=addvendor'">+ Add New Subcontractor</button> 
    </div>
    <div>
        <table class="table1 text-center" cellspacing="0">
        	<tr>
            	<th>Vendor ID</th>
                <th>Vendor Name</th>
                <th>Address</th>
                <th>Tel.</th>
                <th>Contact Person</th>
                <th>Email</th>
                <th>Daily Capacity</th>
                <th>Status</th>	
                <th></th>				
            </tr>
            <?php
			while($result1=mysqli_fetch_assoc($returnDataSet))
			{
			?>
            <tr>
            	<td>
                <?php if($result1['vendorID']!=$activeUser){ ?>
                <a href="DashBoard.php?activity=editVendor&selectedID=<?php echo $result1['vendorID']?>"><?php echo $result1['vendorID']?></a>
                <?php }
				else
				{
					echo $result1['vendorID'];
				}?>
                </td>
                <td><?php echo $result1['vendor']?></td>
                <td><?php echo $result1['address']?></td>
                <td><?php echo $result1['tel']?></td>
                <td><?php echo $result1['contactPerson']?></td>
                <td><?php echo $result1['email']?></td>
                <td><?php echo $result1['dailyCapacity']?></td>
                <td><?php echo $result1['status']?></td>
                <td><a href="DashBoard.php?activity=view&Criteria=Vendor&selectedID=<?php echo $result1['vendorID']?>">View</a></td>
				
            <tr>
            <?php
			}
			?>
        </table>
    </div>
</body>
</html>