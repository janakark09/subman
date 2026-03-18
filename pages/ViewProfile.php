<?php
	include "../includes/db-con.php";
    $message="";

	$activeUser=$_SESSION['_UserID'];

    $selectedUID=$activeUser;

        $Uname="";
        $email="";
        $fname="";
        $lname="";
        $fullName="";
        $userType="";
        $Pswd="";
        $Pswd1="";
        $uStatus="";
        $address="";
        $tel="";
        $locID="";
        $subconID="";
        $password="";
        $passwd="";    

    //------------------ Generate New User ID --------------------------------
    $userQuery="SELECT U.Name AS 'UNAME',U.Fname AS 'FNAME',U.Lname AS 'LNAME',U.fullName AS 'FULLNAME', U.User_Type AS 'UTYPE', UD.Address AS 'ADDRESS',
			 UD.TelNumber AS 'TEL',U.Email AS 'EMAIL',UD.locationID AS 'LOCID',ML.location AS 'LOC',UD.venderID AS 'VENID', V.vendor AS 'VENDOR' FROM users U JOIN user_details UD ON U.User_ID = UD.User_ID 
			LEFT JOIN mast_location ML ON ML.locationID=UD.locationID LEFT JOIN vendors V ON V.vendorID=UD.venderID WHERE U.User_ID='$selectedUID' AND U.Member_Status='Active'";
	$return=mysqli_query($conn,$userQuery);
	$row=mysqli_fetch_assoc($return);


	
	if($row)
	{
		$Uname=$row['UNAME'];
        $email=$row['EMAIL'];
        $fname=$row['FNAME'];
        $lname=$row['LNAME'];
        $fullName=$row['FULLNAME'];
        $userType=$row['UTYPE'];
        $address=$row['ADDRESS'];
        $tel=$row['TEL'];
        $locID=$row['LOCID'];
        $subconID=$row['VENID'];	
        $loc=$row['LOC'];
        $subcon=$row['VENDOR'];	
	}
    
    //------------------ Insert New User --------------------------------
    if(isset($_POST['btnSubmit']))
    {
                $Pswd=$_POST['password'];
                $Pswd1=$_POST['confirmpassword'];
            // echo "password: ".$Pswd." confirm password: ".$Pswd1." check pass: ".isset($_POST['checkpass']);
        if(isset($_POST['checkpass'])==true)
        {
            if($Pswd!="" && $Pswd1!="")
                    {                    
                        if($Pswd == $Pswd1)
                        {
                            $password=md5($Pswd);
                            $updateQuery1="UPDATE users SET Password='$password' WHERE User_ID='$selectedUID'"; 
                            $result1=mysqli_query($conn, $updateQuery1);

                            if($result1)
                            {
                                echo "<script>alert('Password Changed successfully!');</script>";
                            }
                            else
                            {
                                $message="Error Updating User: " . mysqli_error($conn);
                            }
                            echo "<script>
                                setTimeout(function(){window.location.href = 'home_page.php?activity=users';}, 500);
                            </script>";
                            exit();
                        }
                        else
                        {
                            $message="*Passwords do not match. Please try again.";
                            $passwd="";
                        }
                }
                else
                {
                    $message="*Please Enter a New password to change.";
                }  
        }
             
    }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View user</title>
</head>
<body>
    <div class="container-fluid">
            <div class="mb-5">
                <h4>User Profile - <?php echo $Uname; ?></h4>  
            </div>
            <div class="rounded col-lg-3 p-2 mb-3" >
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" <?php if($locID != '' && $locID!=null && $locID!=0) echo 'checked'; ?> disabled>
                    <label class="form-check-label" for="Radio1">Employee</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" <?php if($subconID != '' && $subconID!=null && $subconID!=0) echo 'checked'; ?> disabled>
                    <label class="form-check-label" for="Radio2">Subcontractor</label>
                </div>
            </div>
            <div>
                <form method="post">                    
                    <div class="row">
                                <div class="col-md-6 ps-4 mb-1 ">
                                    <table class="w-100" style="border:1px;">
                                        <tbody>
                                            <tr><td>User ID</td><td class="middle-cell">:</td><td> <?php echo $activeUser;?></td></tr>
                                            <tr><td>First Name</td><td class="middle-cell">:</td><td> <?php echo $fname;?></td></tr>
                                            <tr><td>Last Name</td><td class="middle-cell">:</td><td> <?php echo $lname;?></td></tr>
                                            <tr><td>Full Name</td><td class="middle-cell">:</td><td> <?php echo $fullName;?></td></tr>
                                            <tr><td>User Type</td><td class="middle-cell">:</td><td> <?php echo $userType;?></td></tr>
                                            <tr><td>Address</td><td class="middle-cell">:</td><td> <?php echo $address;?></td></tr>
                                            <tr><td>Tel</td><td class="middle-cell">:</td><td> <?php echo $tel;?></td></tr>
											<tr><td>Location</td><td class="middle-cell">:</td><td> <?php echo $loc;?></td></tr>
											<tr><td>Subcontractor</td><td class="middle-cell">:</td><td> <?php echo $subcon;?></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    <hr>
                    <div class="d-lg-flex mt-2">
                        <div class="form-group me-1 d-lg-flex justify-content-start align-items-center rounded p-2" style="background-color: lightgrey;">
                            <div class="form-group me-5">
                                <br>
                                <input class="form-check-input me-2" type="checkbox" id="checkpass" name="checkpass"><label for="checkpass"> Edit Password</label>
                            </div>
                            <div class="form-group me-5">
                                <label>Password</label>
                                <input type="password" class="form-control" id="password" <?php if(isset($_POST['checkpass'])) echo 'required'; ?> name="password" autocomplete="new-password">
                            </div>
                            <div class="form-group me-5">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" id="confirmpassword" <?php if(isset($_POST['checkpass'])) echo 'required'; ?> name="confirmpassword" autocomplete="new-password">
                            </div>
                        </div>
                        
                    </div>

                    <!-- ------------------ -->
                    <input type="submit" value="Save" class="btn btn-primary mt-5 me-2 save_btn" name="btnSubmit"/>
                    <input type="reset" value="Clear" class="btn btn-secondary mt-5 save_btn" name="btnClear"/>
                    <br>
                    <p class="text-danger mt-5"><?php echo $message?></p>
                </form>
            </div> 
    </div>
</body>
</html>