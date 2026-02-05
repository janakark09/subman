<?php
	include "../includes/db-con.php";
    $message="";
	
	$sqlQuery="SELECT * FROM  mast_location";
	$returnDataSet2=mysqli_query($conn,$sqlQuery);
	
	$activeUser=$_SESSION['_UserID'];
    
    if(isset($_POST['btnSubmit']))
    {
        $loc_name=$_POST['locname'];
        $loc_address=$_POST['locaddress'];
        $loc_status=$_POST['locstatus'];
        
        $insertQuery="INSERT INTO mast_location (location, address,status, createdBy) 
                      VALUES ('$loc_name', '$loc_address', '$loc_status', '$activeUser')";
        
        if(mysqli_query($conn, $insertQuery))
        {
            $message="Location added successfully.";
        }
        else
        {
            $message="Error adding location: " . mysqli_error($conn);
        }
        echo "<script>
        setTimeout(function(){window.location.href = 'home_page.php?activity=loc';}, 1000);
      </script>";
    }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Location</title>
</head>
<body>
    <div>
        <h4>Add New Location</h4>  
    </div>
    <div>
        <form method="post">
            <div class="form-group">
                <label for="inputAddress">Location Name</label>
                <input type="text" class="form-control" id="locname" placeholder="Company Location" required name="locname">
            </div>
            <div class="form-group">
                <label for="inputAddress2">Address</label>
                <input type="text" class="form-control" id="locaddress" required name="locaddress">
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                <label for="inputState">Status</label>
                <select id="inputState" class="form-control" name="locstatus">
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