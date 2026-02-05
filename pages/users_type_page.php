<?php
	include "../includes/db-con.php";
	
	$sqlQuery="SELECT * FROM user_type";
	$returnDataSet=mysqli_query($conn,$sqlQuery);
	
	$activeUser=$_SESSION['_UserID'];

    if(isset($_POST['btnSaveUserType']))
        {
        $selectedUType=$_POST['usertype'];
        $isActive=isset($_POST['check1']) ? 1 : 0;

        echo $selectedUType;
        echo $isActive;
        $updateQuery="UPDATE user_type SET status='$isActive' WHERE userType='$selectedUType'";

        mysqli_query($conn, $updateQuery);
    }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Types</title>
</head>
<body>
    <div class="d-flex justify-content-between mb-3">
        <h4>All User Types</h4>
        <button type="submit" class="btn btn-primary me-2" name="btnAddUserType" onclick="window.location.href='home_page.php?activity=addusertype'">+ Add New User Type</button> 
    </div>
    
    <div class="form-group col-md-4">
        <label >User Type</label>
        <select class="form-control" name="usertype" id="usertype">
            <option selected hidden value="" >Select User Type</option>
            <?php 
                while($usertype=mysqli_fetch_assoc($returnDataSet)){
            ?>
            <option value="<?php echo $usertype['userType']; ?>"
                     data-active="<?php echo $usertype['status']?>" >
                     <?php echo $usertype['userType']?>
            </option>
                <?php
                }
                ?>
        </select>
        <div class="form-check mt-3"><input class="form-check-input" type="checkbox" id="check1"><label for="check1"> Active</label></div>
    </div>
    <div>
        <button type="submit" class="btn btn-primary mt-5 me-2 save_btn" name="btnSaveUserType">Save</button>
    </div>

<!-- JavaScript to handle the change event of the dropdown and update the checkbox -->
    <script>
        document.getElementById('usertype').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        
        // status is "1" or "0" as string → convert to number
        const isActive = Number(selectedOption.dataset.active) === 1;

        document.getElementById('check1').checked = isActive;
        });
    </script>
</body>
</html>