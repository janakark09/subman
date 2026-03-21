<?php
	include "../includes/db-con.php";
	
	$sqlQuery="SELECT * FROM users CROSS JOIN user_details ON users.User_ID=user_details.User_ID";
	$returnDataSet2=mysqli_query($conn,$sqlQuery);
	
	$activeUser=$_SESSION['_UserID'];

    if(isset($_POST['btnDelete']))
        {
            $userID = $_POST['deleteID'];
            deleteUser($conn, $userID);
        }
    function deleteUser($conn, $userID)
        {
            $sqlDeleteUserDetails = "DELETE FROM user_details WHERE User_ID = '$userID'";
            if(mysqli_query($conn, $sqlDeleteUserDetails))
            {
                
                $sqlDeleteUser = "DELETE FROM users WHERE User_ID = '$userID'";
                
                if(mysqli_query($conn, $sqlDeleteUser))
                {
                    echo "<script>alert('User deleted successfully.');</script>";
                        echo "<script>
                            setTimeout(function(){window.location.href = 'home_page.php?activity=users';}, 100);
                        </script>";
                }
                else
                {
                    echo "<script>alert('Error deleting user: " . mysqli_error($conn) . "');</script>";
                }
            }
            else
            {
                echo "<script>alert('Error deleting user details: " . mysqli_error($conn) . "');</script>";
            }
        }

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
    <div class="table-wrapper">
        <table class="table1 text-center" cellspacing="0" style="min-width:100%;">
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
                <a href="home_page.php?activity=edituser&selectedID=<?php echo $result1['User_ID']?>"><?php echo $result1['User_ID']?></a>
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
                <td class="text-center">
                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        <input type="hidden" name="deleteID" value="<?php echo $result1['User_ID']; ?>">
                        <button type="submit" name="btnDelete" class="bg-danger btn text-white">
                            Delete
                        </button>
                    </form>
                </td>
				
            <tr>
            <?php
			}
			?>
        </table>
    </div>
</body>
</html>