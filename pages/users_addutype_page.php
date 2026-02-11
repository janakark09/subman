<?php
	include "../includes/db-con.php";
    $message="";
	
	$activeUser=$_SESSION['_UserID'];
    
    if(isset($_POST['btnSubmit']))
    {
        $utype_name=$_POST['utype'];
        $utype_status=$_POST['utypestatus'];
        
        $insertQuery="INSERT INTO user_type (userType, status) 
                      VALUES ('$utype_name', '$utype_status')";
        
        if(mysqli_query($conn, $insertQuery))
        {
            $message="User Type added successfully.";
        }
        else
        {
            $message="Error adding user type: " . mysqli_error($conn);
        }
        echo "<script>
        setTimeout(function(){window.location.href = 'home_page.php?activity=usertype';}, 1000);
      </script>";
    }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User Type</title>
</head>
<body>
    <div>
        <h4>Add New User Type</h4>  
    </div>
    <div>
        <form method="post">
            <div class="form-group">
                <label for="inputAddress">usertype</label>
                <input type="text" class="form-control" id="utype" placeholder="User Type" required name="utype">
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                <label for="inputState">Status</label>
                <select id="inputState" class="form-select" name="utypestatus">
                    <option selected>Active</option>
                    <option>Inactive</option>
                </select>
                </div>
            </div>
            <input type="submit" value="Save" class="btn btn-primary mt-5 me-2 save_btn" name="btnSubmit"/>
            <input type="reset" value="Clear" class="btn btn-secondary mt-5 save_btn" name="btnClear"/>
        </form>
    </div>    
</body>
</html>