<?php
	include "../includes/db-con.php";
    $message="";
	
	$activeUser=$_SESSION['_UserID'];
    $selectedLoc=$_GET['selectedID'];

    $sqlQuery="SELECT * FROM  mast_location WHERE locationID='$selectedLoc'";
	$returnDataSet2=mysqli_query($conn,$sqlQuery);
    $locationData=mysqli_fetch_assoc($returnDataSet2);
    
    if(isset($_POST['btnSubmit']))
    {
        $loc_address=$_POST['locaddress'];
        $loc_status=$_POST['locstatus'];
        
        $updateQuery="UPDATE mast_location SET address='$loc_address', status='$loc_status', createdBy='$activeUser' WHERE locationID='$selectedLoc'";
        
        if(mysqli_query($conn, $updateQuery))
        {
            echo "<script>alert('Location updated successfully!');</script>";
        }
        else
        {
            $message="Error updating location: " . mysqli_error($conn);
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
    <title>Edit Location</title>
</head>
<body>
    <div>
        <h4>Edit Location - <?php echo $locationData['location']; ?></h4>  
    </div>
    <div>
        <form method="post">
            <div class="form-group">
                <label for="inputAddress">Location Name</label>
                <input type="text" class="form-control" placeholder="Company Location" disabled value="<?php echo $locationData['location']; ?>">
            </div>
            <div class="form-group">
                <label for="inputAddress2">Address</label>
                <input type="text" class="form-control" placeholder="Company Address" required name="locaddress" value="<?php echo $locationData['address']; ?>">
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                <label for="inputState">Status</label>
                <select id="inputState" class="form-select" name="locstatus">
                    <option <?php if($locationData['status'] == 'Active') echo 'selected'; ?>>Active</option>
                    <option <?php if($locationData['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                </select>
                </div>
            </div>
            <input type="submit" value="Save" class="btn btn-primary mt-5 me-2 save_btn" name="btnSubmit"/>
            <input type="reset" value="Clear" class="btn btn-secondary mt-5 save_btn" name="btnClear"/>
        </form>
    </div>    
</body>
</html>