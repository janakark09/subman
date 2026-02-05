<?php
	include "../includes/db-con.php";
	
	$sqlQuery="SELECT * FROM users CROSS JOIN user_details ON users.User_ID=user_details.User_ID";
	$returnDataSet2=mysqli_query($conn,$sqlQuery);
	
	$activeUser=$_SESSION['_UserID'];
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="d-flex justify-content-between mb-3">
        <h4>All Users</h4>
        <button type="submit" class="btn btn-primary me-2" name="btnAddUser" onclick="window.location.href='home_page.php?activity=adduser'">+ Add New User</button> 
    </div>
    <div>
        <table class="table1 text-center" cellspacing="0">
        	<tr>
            	<th>User ID</th>
                <th>User Name</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Status</th>
                <th>Delete</th>
				
            </tr>
            <?php
			while($result1=mysqli_fetch_assoc($returnDataSet2))
			{
			?>
            <tr>
            	<td>
                <?php if($result1['User_ID']!=$activeUser){ ?>
                <a href="DashBoard.php?activity=editUser&selectedID=<?php echo $result1['User_ID']?>"><?php echo $result1['User_ID']?></a>
                <?php }
				else
				{
					echo $result1['User_ID'];
				}?>
                </td>
                <td><?php echo $result1['Name']?></td>
                <td><?php echo $result1['Email']?></td>
                <td><?php echo $result1['User_Type']?></td>
                <td><?php echo $result1['Member_Status']?></td>
                <td><a href="DashBoard.php?activity=delete&Criteria=User&selectedID=<?php echo $result1['User_ID']?>">Delete</a></td>
				
            <tr>
            <?php
			}
			?>
        </table>
    </div>
</body>
</html>