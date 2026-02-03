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
                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
            </div>
            <div class="form-group">
                <label for="inputAddress2">Address 2</label>
                <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                <label for="inputState">State</label>
                <select id="inputState" class="form-control">
                    <option selected>Choose...</option>
                    <option>...</option>
                </select>
                </div>
            </div>
            <input type="submit" value="Save" class="btn btn-primary mt-5 savebtn" name="btnSubmit"/>
        </form>
    </div>    
</body>
</html>