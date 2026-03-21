<?php
	include "../includes/db-con.php";
    $message="";

    $selectedUID=$_REQUEST['selectedID'];
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

        $ac1=$ac2=$ac3=$ac4=$ac5=$ac6=$ac7=$ac8=$ac9=$ac10=$ac11=$ac12=$ac13=$ac14=$ac15=$ac16=$ac17=$ac18=$ac19=$ac20=$ac21=$ac22=$ac23=$ac24=$ac25=0;

    

    //------------------ Generate New User ID --------------------------------
    $userQuery="SELECT * FROM users JOIN user_details ON users.User_ID = user_details.User_ID WHERE users.User_ID='$selectedUID'";
	$return=mysqli_query($conn,$userQuery);
	$row=mysqli_fetch_assoc($return);


	
	if($row)
	{
		$Uname=$row['Name'];
        $email=$row['Email'];
        $fname=$row['Fname'];
        $lname=$row['Lname'];
        $fullName=$row['fullName'];
        $userType=$row['User_Type'];
        //$_POST['password']=$Pswd=$row['Password'];
        //$_POST['confirmpassword']=$Pswd1=$row['Password'];
        $uStatus=$row['Member_Status'];
        $address=$row['Address'];
        $tel=$row['TelNumber'];
        $locID=$row['locationID'];
        $subconID=$row['venderID'];

        $ac1=$row['acc1'];
        $ac2=$row['acc2'];
        $ac3=$row['acc3'];
        $ac4=$row['acc4'];
        $ac5=$row['acc5'];
        $ac6=$row['acc6'];
        $ac7=$row['acc7'];
        $ac8=$row['acc8'];
        $ac9=$row['acc9'];
        $ac10=$row['acc10'];
        $ac11=$row['acc11'];
        $ac12=$row['acc12'];
        $ac13=$row['acc13'];
        $ac14=$row['acc14'];
        $ac15=$row['acc15'];
        $ac16=$row['acc16'];
        $ac17=$row['acc17'];
        $ac18=$row['acc18'];
        $ac19=$row['acc19'];
        $ac20=$row['acc20'];
        $ac21=$row['acc21'];
        $ac22=$row['acc22'];
        $ac23=$row['acc23'];
        $ac24=$row['acc24'];
        $ac25=$row['acc25']; 
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
        $email=$_POST['email'];
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $fullName=$_POST['fullname'];
        $userType=$_POST['usertype'];
        if(isset($_POST['checkpass']))
            {
                $Pswd=$_POST['password'];
                $Pswd1=$_POST['confirmpassword'];
                if($Pswd == $Pswd1)
                {
                    $passwd=", Password="."'".md5($Pswd)."'";
                }
                else
                    {
                        $message="*Passwords do not match. Please try again.";
                        $passwd="";
                    }
            }
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


        $updateQuery1="UPDATE users SET Email='$email', Fname='$fname', Lname='$lname', fullName='$fullName', User_Type='$userType' $passwd, Member_Status='$uStatus' WHERE User_ID='$selectedUID'"; 
        $updateQuery2="UPDATE user_details SET Address='$address', TelNumber='$tel', locationID='$locID', venderID='$subconID', acc1='$ac1', acc2='$ac2', acc3='$ac3', acc4='$ac4', acc5='$ac5', acc6='$ac6', acc7='$ac7', acc8='$ac8', 
                    acc9='$ac9', acc10='$ac10', acc11='$ac11', acc12='$ac12', acc13='$ac13', acc14='$ac14', acc15='$ac15', acc16='$ac16', acc17='$ac17', acc18='$ac18', acc19='$ac19', acc20='$ac20', acc21='$ac21', acc22='$ac22', 
                    acc23='$ac23', acc24='$ac24', acc25='$ac25' WHERE User_ID='$selectedUID'";
        if($Pswd == $Pswd1)
                    {                    
                        
                        $result1=mysqli_query($conn, $updateQuery1);
                        $result2=mysqli_query($conn, $updateQuery2);
            
                        if($result1 && $result2)
                        {
                            echo "<script>alert('User Updated successfully!');</script>";
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
                    echo "<script>alert('Passwords do not match. Please try again.');</script>";
                }        
    }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit user</title>
</head>
<body>
    <div class="container-fluid">
            <div class="mb-5">
                <h4>Edit User - <?php echo $Uname; ?></h4>  
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
                    <div class="d-lg-flex">
                        <div class="form-group me-5 col-lg-3">
                            <label>First Name</label>
                            <input type="text" class="form-control" id="fname"  required name="fname" value="<?php echo $fname; ?>">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>Last Name</label>
                            <input type="text" class="form-control" id="lname" required name="lname" value="<?php echo $lname; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="inputAddress2">Name with Initials</label>
                        <input type="text" class="form-control" id="fullname" required name="fullname" value="<?php echo $fullName;?>">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress2">Address</label>
                        <input type="text" class="form-control" id="address" required name="address" value="<?php echo $address;?>">
                    </div>
                    <div class="d-lg-flex">
                        <div class="form-group me-5 col-lg-3">
                            <label>Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Working Email" required name="email" value="<?php echo $email; ?>">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>Tel.</label>
                            <input type="text" class="form-control" id="tel" name="tel" value="<?php echo $tel; ?>">
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
                <!---------------------------------------->
                
                    <div class="form-row mt-3">
                        <div class="form-group col-md-4">
                            <label >User Type</label>
                            <select class="form-select" name="usertype">
                                <option selected hidden></option>
                                <?php 
                                    while($usertype=mysqli_fetch_assoc(result:$returnDataSet1)){
                                        ?>
                                        <option <?php if($usertype['userType'] == $userType) {echo 'selected'; } ?>><?php echo $usertype['userType']?></option>
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
                            <select class="form-select" name="location" id="locationSelect1" <?php if($locID==null || $locID==0 || $locID=="") echo 'disabled'; ?>>
                                <option selected hidden></option>
                                <?php 
                                    while($location=mysqli_fetch_assoc(result:$returnDataSet2)){
                                        ?>
                                        <option value="<?php echo $location['locationID']; ?>" <?php if($location['locationID'] == $locID) echo 'selected'; ?>><?php echo $location['location']?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4 me-3">
                            <label >Subcontractor</label>
                            <select class="form-select" name="subcontractor" id="subcontractorSelect1" <?php if($subconID==null || $subconID==0 || $subconID=="") echo 'disabled'; ?>>
                                <option selected hidden></option>
                                <?php 
                                    while($vendor1=mysqli_fetch_assoc(result:$returnDataSet3)){
                                ?>
                                        <option value="<?php echo $vendor1['vendorID']; ?>" <?php if($vendor1['vendorID'] == $subconID) echo 'selected'; ?>><?php echo $vendor1['vendor']?></option>
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
                                <option <?php if($uStatus == 'Active') echo 'selected'; ?>>Active</option>
                                <option <?php if($uStatus == 'Inactive') echo 'selected'; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="rounded container-fluid p-2 mb-3 d-lg-flex" style="background-color: lightgrey; min-height: 10em;">
                        <div class="col-md-4">
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check1" name="check1" <?php if($ac1) echo 'checked'; ?>><label for="check1"> Dashboard</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check2" name="check2" <?php if($ac2) echo 'checked'; ?>><label for="check2"> Merchandising </label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check3" name="check3" <?php if($ac3) echo 'checked'; ?>><label for="check3"> Buyers Management</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check4" name="check4" <?php if($ac4) echo 'checked'; ?>><label for="check4"> Style Order Management</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check5" name="check5" <?php if($ac5) echo 'checked'; ?>><label for="check5"> Merchandising Approvals </label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check6" name="check6" <?php if($ac6) echo 'checked'; ?>><label for="check6"> Order Planning</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check7" name="check7" <?php if($ac7) echo 'checked'; ?>><label for="check7"> Confirm Order Planning</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check8" name="check8" <?php if($ac8) echo 'checked'; ?>><label for="check8"> Subcontractor Management </label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check9" name="check9" <?php if($ac9) echo 'checked'; ?>><label for="check9"> Order Agreements </label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check10" name="check10" <?php if($ac10) echo 'checked'; ?>><label for="check10"> Approve Agreements</label></div>
                        </div>
                        <div class="col-md-4">

                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check11" name="check11" <?php if($ac11) echo 'checked'; ?>><label for="check11"> Gate Passes</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check12" name="check12" <?php if($ac12) echo 'checked'; ?>><label for="check12"> Gate Pass Listing</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check13" name="check13" <?php if($ac13) echo 'checked'; ?>><label for="check13"> Gate Pass Approval</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check14" name="check14" <?php if($ac14) echo 'checked'; ?>><label for="check14"> Production Record</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check15" name="check15" <?php if($ac15) echo 'checked'; ?>><label for="check15"> Production Record Listing</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check16" name="check16" <?php if($ac16) echo 'checked'; ?>><label for="check16"> Production Record Approval</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check17" name="check17" <?php if($ac17) echo 'checked'; ?>><label for="check17"> GRN</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check18" name="check18" <?php if($ac18) echo 'checked'; ?>><label for="check18"> GRN Listing</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check19" name="check19" <?php if($ac19) echo 'checked'; ?>><label for="check19"> GRN Approval</label></div>


                        </div>
                        <div class="col-md-4">
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check20" name="check20" <?php if($ac20) echo 'checked'; ?>><label for="check20"> Payment Receipt</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check21" name="check21" <?php if($ac21) echo 'checked'; ?>><label for="check21"> Payments</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check22" name="check22" <?php if($ac22) echo 'checked'; ?>><label for="check22"> Payment Receipt Approval</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check23" name="check23" <?php if($ac23) echo 'checked'; ?>><label for="check23"> Reports</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check24" name="check24" <?php if($ac24) echo 'checked'; ?>><label for="check24"> User management</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="check25" name="check25" <?php if($ac25) echo 'checked'; ?>><label for="check25"> Location Management</label></div>
                        </div>
                    </div>

                    <input type="submit" value="Save" class="btn btn-primary mt-5 me-2 save_btn" name="btnSubmit"/>
                    <input type="reset" value="Clear" class="btn btn-secondary mt-5 save_btn" name="btnClear"/>
                    <br>
                    <p class="text-danger mt-5">*<?php echo $message?></p>
                </form>
            </div> 
    </div>
</body>
</html>