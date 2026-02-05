<?php
	include "../includes/db-con.php";
	
	$sqlQuery="SELECT * FROM  mast_location";
	$returnDataSet2=mysqli_query($conn,$sqlQuery);
	
	$activeUser=$_SESSION['_UserID'];
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locations</title>
</head>
<body>
    <div class="d-flex justify-content-between mb-3">
        <h4>All Locations</h4>
        <button type="submit" class="btn btn-primary me-2" name="btnAddLoc" onclick="window.location.href='home_page.php?activity=addloc'">+ Add New Location</button> 
    </div>
    <div class="table-wrapper table-responsive">
        <table class="table1 table-responsive" cellspacing="0">
        	<tr class="text-center">
            	<th>Location ID</th>
                <th>Location Name</th>
                <th>Address</th>
                <th>Status</th>				
            </tr>
            <?php
			while($result1=mysqli_fetch_assoc($returnDataSet2))
			{
			?>
            <tr>
            	<td class="text-center">
                <a href="DashBoard.php?activity=editUser&selectedID=<?php echo $result1['locationID']?>"><?php echo $result1['locationID']?></a>
                <td class="text-center"><?php echo $result1['location']?></td>
                <td><?php echo $result1['address']?></td>
                <td class="text-center"><?php echo $result1['status']?></td>				
            <tr>
            <?php
			}
			?>
        </table>
    </div>    
</body>
</html>