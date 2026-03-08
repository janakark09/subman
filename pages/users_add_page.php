<?php
	include "../includes/db-con.php";
    $message="";
    $NewID=0;

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

        $ac1=isset($_POST['check1']) ? 1 : 0;
        $ac2=isset($_POST['check2']) ? 1 : 0;
        $ac3=isset($_POST['check3']) ? 1 : 0;
        $ac4=isset($_POST['check4']) ? 1 : 0;
        $ac5=isset($_POST['check5']) ? 1 : 0;
        $ac6=isset($_POST['check6']) ? 1 : 0;
        $ac7=isset($_POST['check7']) ? 1 : 0;
        $ac8=isset($_POST['check8']) ? 1 : 0;
        $ac9=isset($_POST['check9']) ? 1 : 0;
        $ac10=isset($_POST['check10']) ? 1 : 0;
        $ac11=isset($_POST['check11']) ? 1 : 0;
        $ac12=isset($_POST['check12']) ? 1 : 0;
        $ac13=isset($_POST['check13']) ? 1 : 0;
        $ac14=isset($_POST['check14']) ? 1 : 0;
        $ac15=isset($_POST['check15']) ? 1 : 0;
        $ac16=isset($_POST['check16']) ? 1 : 0;
        $ac17=isset($_POST['check17']) ? 1 : 0;
        $ac18=isset($_POST['check18']) ? 1 : 0;
        $ac19=isset($_POST['check19']) ? 1 : 0;
        $ac20=isset($_POST['check20']) ? 1 : 0;
        $ac21=isset($_POST['check21']) ? 1 : 0;
        $ac22=isset($_POST['check22']) ? 1 : 0;
        $ac23=isset($_POST['check23']) ? 1 : 0;
        $ac24=isset($_POST['check24']) ? 1 : 0;
        $ac25=isset($_POST['check25']) ? 1 : 0;

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
                        $insertQuery2="INSERT INTO user_details (User_ID, Address, TelNumber, Joined_Date, locationID, venderID, acc1, acc2, acc3, acc4, acc5, acc6, acc7, acc8, acc9, acc10, acc11, acc12, acc13, acc14, acc15, acc16, acc17, acc18, acc19, acc20, acc21, acc22, acc23, acc24, acc25)
                            VALUES ('$NewID', '$address', '$tel', NOW(), '$locID', '$subconID', '$ac1', '$ac2', '$ac3', '$ac4', '$ac5', '$ac6', '$ac7', '$ac8', '$ac9', '$ac10', '$ac11', '$ac12', '$ac13', '$ac14', '$ac15', '$ac16', '$ac17', '$ac18', '$ac19', '$ac20', '$ac21', '$ac22', '$ac23', '$ac24', '$ac25')";
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
            <div class="rounded col-lg-3 p-2 mb-3" style="background-color: lightgrey;" >
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="Radio1" value="employee" >
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
                            <select class="form-select" name="usertype">
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
                            <select class="form-select" name="location" id="locationSelect">
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
                            <select class="form-select" name="subcontractor" id="subcontractorSelect">
                                <option selected hidden></option>
                                <?php 
                                    while($location1=mysqli_fetch_assoc(result:$returnDataSet3)){
                                ?>
                                        <option value="<?php echo $location1['vendorID']; ?>"><?php echo $location1['vendor']?></option>
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
                            <select id="inputState" class="form-select" name="ustatus">
                                <option selected>Active</option>
                                <option>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="rounded container-fluid p-2 mb-3 d-lg-flex" style="background-color: lightgrey; min-height: 10em;">
                        <div class="col-md-4">
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check1" name="check1"><label for="check1"> Dashboard</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check2" name="check2"><label for="check2"> Merchandising </label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check3" name="check3"><label for="check3"> Buyers Management</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check4" name="check4"><label for="check4"> Style Order Management</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check5" name="check5"><label for="check5"> Merchandising Approvals </label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check6" name="check6"><label for="check6"> Order Planning</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check7" name="check7"><label for="check7"> Confirm Order Planning</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check8" name="check8"><label for="check8"> Subcontractor Management </label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check9" name="check9"><label for="check9"> Order Agreements </label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check10" name="check10"><label for="check10"> Approve Agreements</label></div>
                        </div>
                        <div class="col-md-4">

                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check11" name="check11"><label for="check11"> Gate Passes</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check12" name="check12"><label for="check12"> Gate Pass Listing</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check13" name="check13"><label for="check13"> Gate Pass Approval</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check14" name="check14"><label for="check14"> Production Record</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check15" name="check15"><label for="check15"> Production Record Listing</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check16" name="check16"><label for="check16"> Production Record Approval</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check17" name="check17"><label for="check17"> GRN</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check18" name="check18"><label for="check18"> GRN Listing</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check19" name="check19"><label for="check19"> GRN Approval</label></div>



                        </div>
                        <div class="col-md-4">
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check20" name="check20"><label for="check20"> Payment Receipt</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check21" name="check21"><label for="check21"> Payments</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check22" name="check22"><label for="check22"> Payment Receipt Approval</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check23" name="check23"><label for="check23"> Reports</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check24" name="check24"><label for="check24"> User management</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check25" name="check25"><label for="check25"> Location Management</label></div>
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