<?php
	include "../includes/db-con.php";
    $message="";
	
    $sqlQuery1="SELECT * FROM  user_type WHERE status='Active'";
	$returnDataSet1=mysqli_query($conn,$sqlQuery1);

	$sqlQuery2="SELECT * FROM  mast_location WHERE status='Active'";
	$returnDataSet2=mysqli_query($conn,$sqlQuery2);
	
    $sqlQuery3="SELECT * FROM  vendors WHERE status='Active'";
    $returnDataSet3=mysqli_query($conn,$sqlQuery3);

	$activeUser=$_SESSION['_UserID'];
    
    if(isset($_POST['btnSubmit']))
    {
        $name=$_POST['locname'];
        $email=$_POST['locaddress'];
        $fname=$_POST['locstatus'];
        $lname=$_POST['locstatus'];
        $fullName=$_POST['locstatus'];
        $userType=$_POST['locstatus'];
        $password=$_POST['locstatus'];
        
        $insertQuery="INSERT INTO users (Name, Email, Fname, Lname, fullName, User_Type, Password, Member_Status) VALUES ('', '".$_POST['fname']."', '".$_POST['email']."', '".$_POST['fname']."', '".$_POST['lname']."', '".$_POST['fullname']."', '".$_POST['usertype']."', '".$_POST['password']."', '$loc_status')";
        
        if(mysqli_query($conn, $insertQuery))
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
                            <input type="text" class="form-control" id="locname" placeholder="Company Location" required name="locname">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>Last Name</label>
                            <input type="text" class="form-control" id="locaddress" required name="locaddress">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="inputAddress2">Name with Initials</label>
                        <input type="text" class="form-control" id="locaddress" required name="locaddress">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress2">Address</label>
                        <input type="text" class="form-control" id="locaddress" required name="locaddress">
                    </div>
                    <div class="d-lg-flex">
                        <div class="form-group me-5 col-lg-3">
                            <label>Email</label>
                            <input type="email" class="form-control" id="locname" placeholder="Working Email" required name="locname">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>Tel.</label>
                            <input type="text" class="form-control" id="locaddress" required name="locaddress">
                        </div>
                    </div>
                    <hr>
                    <div class="d-lg-flex">
                        <div class="form-group me-5 col-lg-3">
                            <label>Username</label>
                            <input type="text" class="form-control" id="locname"  required name="locname">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>Password</label>
                            <input type="password" class="form-control" id="locaddress" required name="locaddress">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" id="locaddress" required name="locaddress">
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
                                ?>
                            </select>
                        </div>
                    </div>
                    <!------------------------------->
                    <div class="form-row mb-3">
                        <div class="form-group col-md-4 mt-3">
                            <label for="inputState">Status</label>
                            <select id="inputState" class="form-control" name="locstatus">
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