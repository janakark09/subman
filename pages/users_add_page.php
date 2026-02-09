<?php
	include "../includes/db-con.php";
    $message="";

    //------------------ Generate New User ID --------------------------------
    $Query_id="SELECT MAX(User_ID) FROM users";
	$return=mysqli_query($conn,$Query_id);
	$row=mysqli_fetch_assoc($return);
	$lastID=$row['MAX(User_ID)'];
	
	if(empty($lastID))
	{
		$NewID=$lastID='1001';
	}
	else
	{
		$NewID=$lastID+1;
	}
	
    //------------------ Fetch Active User Types and Locations -------------------
    $sqlQuery1="SELECT * FROM  user_type WHERE status=1";
	$returnDataSet1=mysqli_query($conn,$sqlQuery1);

	$sqlQuery2="SELECT * FROM  mast_location WHERE status='Active'";
	$returnDataSet2=mysqli_query($conn,$sqlQuery2);
	
    $sqlQuery3="SELECT * FROM  vendors WHERE status='Active'";
    $returnDataSet3=mysqli_query($conn,$sqlQuery3);

	$activeUser=$_SESSION['_UserID'];
    
    //------------------ Insert New User --------------------------------
    if(isset($_POST['btnSubmit']))
    {
        $uid=$NewID;
        $Uname=strtolower($_POST['username1']);
        $email=$_POST['email'];
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $fullName=$_POST['fullname'];
        $userType=$_POST['usertype'];
        $Pswd=$_POST['password'];
        $Pswd1=$_POST['confirmpassword'];
        $uStatus=$_POST['ustatus'];
        $address=$_POST['address'];
        $tel=$_POST['tel'];
        $locID=$_POST['location'] ?? '';
        $subconID=$_POST['subcontractor'] ?? '';
        $password=md5($Pswd);

        $ac1=$_POST['check1'] ?? 'false';
        $ac2=$_POST['check2'] ?? 'false';
        $ac3=$_POST['check3'] ?? 'false';
        $ac4=$_POST['check4'] ?? 'false';
        $ac5=$_POST['check5'] ?? 'false';
        $ac6=$_POST['check6'] ?? 'false';
        $ac7=$_POST['check7'] ?? 'false';
        $ac8=$_POST['check8'] ?? 'false';
        $ac9=$_POST['check9'] ?? 'false';
        $ac10=$_POST['check10'] ?? 'false';
        $ac11=$_POST['check11'] ?? 'false';
        $ac12=$_POST['check12'] ?? 'false';
        $ac13=$_POST['check13'] ?? 'false';
        $ac14=$_POST['check14'] ?? 'false';
        $ac15=$_POST['check15'] ?? 'false';


        $query_userchk="SELECT COUNT(User_ID) FROM users WHERE Name='$Uname'";
		$result_userchk=mysqli_query($conn,$query_userchk);
		$chk=mysqli_fetch_assoc($result_userchk);
		$chk_count= $chk['COUNT(User_ID)'];
        
        if($chk_count==0)
        {

            if($Pswd == $Pswd1)
                {                    
                    $insertQuery1="INSERT INTO users (User_ID, Name, Email, Fname, Lname, fullName, User_Type, Password, Member_Status) 
                        VALUES ('$NewID','$Uname', '$email', '$fname', '$lname', '$fullName', '$userType', '$password', '$uStatus')";
                    $insertQuery2="INSERT INTO user_details (User_ID, Address, TelNumber, Joined_Date, locationID, venderID, acc1, acc2, acc3, acc4, acc5, acc6, acc7, acc8, acc9, acc10, acc11, acc12, acc13, acc14, acc15)
                        VALUES ('$NewID', '$address', '$tel', NOW(), '$locID', '$subconID', '$ac1', '$ac2', '$ac3', '$ac4', '$ac5', '$ac6', '$ac7', '$ac8', '$ac9', '$ac10', '$ac11', '$ac12', '$ac13', '$ac14', '$ac15')";
                    $result1=mysqli_query($conn, $insertQuery1);
                    $result2=mysqli_query($conn, $insertQuery2);
        
                    if($result1 && $result2)
                    {
                        $message="User added successfully.";
                    }
                    else
                    {
                        $message="Error adding User: " . mysqli_error($conn);
                    }
                    echo "<script>
                        setTimeout(function(){window.location.href = 'home_page.php?activity=users';}, 1000);
                    </script>";
                    exit();
                }
                else
                {
                    $message="*Passwords do not match. Please try again.";
                }
        }
        else
        {
            $message="Username already exists. Please choose a different username.";
            $Uname="";    
        }
        
    }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add user</title>
</head>
<body>
    <div class="container-fluid">
            <div class="mb-5">
                <h4>Add New User</h4>  
            </div>
            <div class="rounded col-lg-3 p-2 mb-3" style="background-color: lightgrey;">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="Radio1" value="employee">
                    <label class="form-check-label" for="Radio1">Employee</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="Radio2" value="subcontractor">
                    <label class="form-check-label" for="Radio2">Subcontractor</label>
                </div>
            </div>
            <div>
                <form method="post">
                    <div class="d-lg-flex">
                        <div class="form-group me-5 col-lg-3">
                            <label>First Name</label>
                            <input type="text" class="form-control" id="fname"  required name="fname">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>Last Name</label>
                            <input type="text" class="form-control" id="lname" required name="lname">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="inputAddress2">Name with Initials</label>
                        <input type="text" class="form-control" id="fullname" required name="fullname">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress2">Address</label>
                        <input type="text" class="form-control" id="address" required name="address">
                    </div>
                    <div class="d-lg-flex">
                        <div class="form-group me-5 col-lg-3">
                            <label>Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Working Email" required name="email">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>Tel.</label>
                            <input type="text" class="form-control" id="tel" name="tel">
                        </div>
                    </div>
                    <hr>
                    <div class="d-lg-flex">
                        <div class="form-group me-5 col-lg-3">
                            <label>Username</label>
                            <input type="text" class="form-control" id="username"  required name="username1">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>Password</label>
                            <input type="password" class="form-control" id="password" required name="password">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" id="confirmpassword" required name="confirmpassword">
                        </div>
                    </div>
                <!---------------------------------------->
                
                    <div class="form-row mt-3">
                        <div class="form-group col-md-4">
                            <label >User Type</label>
                            <select class="form-control" name="usertype">
                                <option selected hidden></option>
                                <?php 
                                    while($usertype=mysqli_fetch_assoc(result:$returnDataSet1)){
                                        ?>
                                        <option><?php echo $usertype['userType']?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>
                    <!---------------------------------------->
                    <div class="form-row d-lg-flex mt-3">
                        <div class="form-group col-md-4 me-3">
                            <label >Location</label>
                            <select class="form-control" name="location" id="locationSelect">
                                <option selected hidden></option>
                                <?php 
                                    while($location=mysqli_fetch_assoc(result:$returnDataSet2)){
                                        ?>
                                        <option value="<?php echo $location['locationID']; ?>"><?php echo $location['location']?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4 me-3">
                            <label >Subcontractor</label>
                            <select class="form-control" name="subcontractor" id="subcontractorSelect">
                                <option selected hidden></option>
                                <?php 
                                    while($location=mysqli_fetch_assoc(result:$returnDataSet3)){
                                ?>
                                        <option value="<?php echo $location['vendorID']; ?>"><?php echo $location['vendor']?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>
                    <!------------------------------->
                    <div class="form-row mb-3">
                        <div class="form-group col-md-4 mt-3">
                            <label for="inputState">Status</label>
                            <select id="inputState" class="form-control" name="ustatus">
                                <option selected>Active</option>
                                <option>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="rounded container-fluid p-2 mb-3 d-lg-flex" style="background-color: lightgrey; min-height: 10em;">
                        <div class="col-4">
                            <div class="form-check"><input class="form-check-input" type="checkbox" value="true" id="check1"><label for="check1"> Dashboard</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" value="true" id="check2"><label for="check2"> Subcontractor Management</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" value="true" id="check3"><label for="check3"> All Vendor List</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" value="true" id="check4"><label for="check4"> Merchandising</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" value="true" id="check5"><label for="check5"> Buyers</label></div>
                        </div>
                        <div class="col-4">
                            <div class="form-check"><input class="form-check-input" type="checkbox" value="" id="check6"><label for="check6"> Style Order Management</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" value="" id="check7"><label for="check7"> Dashboard</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" value="" id="check8"><label for="check8"> Dashboard</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" value="" id="check9"><label for="check9"> Dashboard</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" value="" id="check10"><label for="check10"> Dashboard</label></div>
                        </div>
                        <div class="col-4">
                            <div class="form-check"><input class="form-check-input" type="checkbox" value="" id="check11"><label for="check11"> Dashboard</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" value="" id="check12"><label for="check12"> Dashboard</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" value="" id="check13"><label for="check13"> Dashboard</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" value="" id="check14"><label for="check14"> Dashboard</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" value="" id="check15"><label for="check15"> Dashboard</label></div>
                        </div>
                    </div>

                    <input type="submit" value="Save" class="btn btn-primary mt-5 me-2 save_btn" name="btnSubmit"/>
                    <input type="reset" value="Clear" class="btn btn-secondary mt-5 save_btn" name="btnClear"/>
                    <br>
                    <p class="text-danger mt-5">*<?php echo $message?></p>
                </form>
            </div> 
    </div>

       <script>
            document.addEventListener("DOMContentLoaded", function () {

                const employeeRadio = document.getElementById("Radio1");
                const subcontractorRadio = document.getElementById("Radio2");

                const locationSelect = document.getElementById("locationSelect");
                const subcontractorSelect = document.getElementById("subcontractorSelect");

                // Initial state
                locationSelect.disabled = true;
                subcontractorSelect.disabled = true;

                employeeRadio.addEventListener("change", function () {
                    if (this.checked) {
                        locationSelect.disabled = false;
                        subcontractorSelect.disabled = true;
                        subcontractorSelect.selectedIndex = 0;
                    }
                });

                subcontractorRadio.addEventListener("change", function () {
                    if (this.checked) {
                        subcontractorSelect.disabled = false;
                        locationSelect.disabled = true;
                        locationSelect.selectedIndex = 0;
                    }
                });

            });
    </script>

</body>
</html>