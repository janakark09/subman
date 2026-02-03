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
    <div>
        <h4>All Locations</h4>  
    </div>
    <div>
        <table class="table1" cellspacing="0">
        	<tr>
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
            	<td>
                <a href="DashBoard.php?activity=editUser&selectedID=<?php echo $result1['User_ID']?>"><?php echo $result1['User_ID']?></a>
                <?php echo $result1['locationID'];?></td>
                <td><?php echo $result1['location']?></td>
                <td><?php echo $result1['address']?></td>
                <td><?php echo $result1['status']?></td>				
            <tr>
            <?php
			}
			?>
        </table>
    </div>    
</body>
</html>