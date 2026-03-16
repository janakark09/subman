<?php
	include "../includes/db-con.php";
    $message="";
    $venid="";
    $Vendorname="";
    $address="";
    $email="";
    $tel="";
    $fax="";
    $conPerson="";
    $dailycapacity="";
    $brno="";
    $vatno="";
    $vatprecentage="";
    $venStatus="";
	
	$activeUser=$_SESSION['_UserID'];

    $selectedID=$_GET['selectedID'] ?? "";

    $query_vendor="SELECT * FROM vendors WHERE vendorID='$selectedID'";
    $result_vendor=mysqli_query($conn, $query_vendor);
    $vendorData=mysqli_fetch_assoc($result_vendor);

    if($vendorData){
        $Vendorname=$vendorData['vendor'];
        $address=$vendorData['address'];
        $email=$vendorData['email'];
        $tel=$vendorData['tel'];
        $fax=$vendorData['fax'];
        $conPerson=$vendorData['contactPerson'];
        $dailycapacity=$vendorData['dailyCapacity'];
        $brno=$vendorData['brNo'];
        $vatno=$vendorData['vatNo'];
        $vatprecentage=$vendorData['vatPercentage'];
        $venStatus=$vendorData['status'];
    }
    
    //------------------ Update Vendor --------------------------------
    if(isset($_POST['btnSubmit']))
    {
        echo "<script>
            if(!confirm('Are you sure you want to update this Subcontractor?')){
                event.preventDefault();
            }
            </script>";
        $venid=$selectedID;
        $address=$_POST['address'];
        $email=$_POST['email'];
        $tel=$_POST['tel'];
        $fax=$_POST['fax'];
        $conPerson=$_POST['contactperson'];
        $dailycapacity=$_POST['capacity'];
        $brno=$_POST['brno'];
        $vatno=$_POST['vatno'];
        $vatprecentage=$_POST['vatpercentage'];
        $venStatus=$_POST['venstatus'];

        $updateQuery="UPDATE vendors SET address='$address', tel='$tel', fax='$fax', brNo='$brno', vatNo='$vatno', vatPercentage='$vatprecentage', contactPerson='$conPerson', dailyCapacity='$dailycapacity', email='$email', status='$venStatus' WHERE vendorID='$venid'";
                
        $result1=mysqli_query($conn, $updateQuery);
        
        if($result1)
            {
                echo "<script>alert('Subcontractor updated successfully!');</script>";
            }
        else
            {
                $message="Error updating Subcontractor: " . mysqli_error($conn);
            }
        echo "<script>
            setTimeout(function(){window.location.href = 'home_page.php?activity=allvendors';}, 1000);
            </script>";
        exit();
    }

    // function (){
        
    // }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vendor</title>
</head>
<body>
    <div class="container-fluid">
            <div class="mb-5">
                <h4>Edit Vendor - <?php echo htmlspecialchars($Vendorname); ?></h4>  
            </div>
            <div>
                <form method="post">
                    
                    <div class="form-group mb-1">
                        <label for="vendorname">Subcontractor's name</label>
                        <input type="text" class="form-control" id="vendorname" disabled name="vendorname" value="<?php echo htmlspecialchars($Vendorname); ?>">
                    </div>
                    <div class="form-group mb-1">
                        <label for="address1">Address</label>
                        <input type="address" class="form-control" id="address1" required name="address" value="<?php echo htmlspecialchars($address); ?>">
                    </div>
                    <div class="d-lg-flex mb-1">
                        <div class="form-group me-5 col-lg-4">
                            <label>Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Working Email" required name="email" value="<?php echo htmlspecialchars($email); ?>">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>Tel.</label>
                            <input type="telephone" class="form-control" id="tel" name="tel" value="<?php echo htmlspecialchars($tel); ?>">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>Fax</label>
                            <input type="telephone" class="form-control" id="fax" name="fax" value="<?php echo htmlspecialchars($fax); ?>">
                        </div>
                    </div>
                    <div class="d-lg-flex mb-1">
                        <div class="form-group me-5 col-lg-4">
                            <label>Contact Person</label>
                            <input type="text" class="form-control" id="contactperson" required name="contactperson" value="<?php echo htmlspecialchars($conPerson); ?>">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>Capacity Per Day</label>
                            <input type="number" class="form-control" id="capacity" required name="capacity" value="<?php echo htmlspecialchars($dailycapacity); ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="d-lg-flex mb-1">
                        <div class="form-group me-5 col-lg-3">
                            <label>BR No.</label>
                            <input type="text" class="form-control" id="brno"  required name="brno" value="<?php echo htmlspecialchars($brno); ?>">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>VAT No.</label>
                            <input type="text" class="form-control" id="vatno" required name="vatno" value="<?php echo htmlspecialchars($vatno); ?>">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>VAT Percentage</label>
                            <input type="number" class="form-control" id="vatpercentage" required name="vatpercentage" value="<?php echo htmlspecialchars($vatprecentage); ?>">
                        </div>
                    </div>
                <!-- ------------------------------------------- -->
                    <div class="form-row mb-2">
                        <div class="form-group col-md-4 mt-3">
                            <label for="inputState">Status</label>
                            <select id="inputState" class="form-select" name="venstatus">
                                <option <?php if($vendorData['status']=="Active") echo "selected"; ?>>Active</option>
                                <option <?php if($vendorData['status']=="Inactive") echo "selected"; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <input type="submit" value="Save" class="btn btn-primary mt-5 me-2 save_btn" name="btnSubmit"/>
                    <input type="reset" value="Clear" class="btn btn-secondary mt-5 save_btn" name="btnClear"/>
                </form>
            </div> 
    </div>

</body>
</html>