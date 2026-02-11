<?php
	include "../includes/db-con.php";
    $message="";

	$activeUser=$_SESSION['_UserID'];
    
    //------------------ Insert New Vendor --------------------------------
    if(isset($_POST['btnSubmit']))
    {
        $buyercode=$_POST['buyercode'];
        $buyername=$_POST['buyername'];
        $address=$_POST['address'];
        $tel=$_POST['tel'];
        $fax=$_POST['fax'];
        $brno=$_POST['brno'];
        $vatno=$_POST['vatno'];
        $conPerson=$_POST['contactperson'];
        $email=$_POST['email'];
        $status=$_POST['status'];


        $query_buyerchk="SELECT COUNT(buyerID) FROM buyer WHERE buyerName='$buyername'";
		$result_buyerchk=mysqli_query($conn,$query_buyerchk);
		$chk=mysqli_fetch_assoc($result_buyerchk);
		$chk_count= $chk['COUNT(buyerID)'];
        
        if($chk_count==0)
        {
            //echo $buyercode.",".$buyername.",".$address.",".$email.",".$tel.",".$fax.",".$conPerson.",".$brno.",".$vatno.",".$status.",".$activeUser;
            
            $insertQuery1="INSERT INTO buyer(buyerCode, buyerName, address, tel, fax, brNo, vatNo, contactPerson, email, status, createdBy)
                         VALUES ('$buyercode','$buyername','$address','$tel','$fax','$brno','$vatno','$conPerson','$email','$status','$activeUser')";
                
                    $result1=mysqli_query($conn, $insertQuery1);
        
                    if($result1)
                    {
                        $message="Buyer added successfully.";
                    }
                    else
                    {
                        $message="Error adding Buyer: " . mysqli_error($conn);
                    }
                    echo "<script>
                        setTimeout(function(){window.location.href = 'home_page.php?activity=allbuyers';}, 1000);
                    </script>";
                    exit();
        }
        else
        {
            $message="This Buyer already exists. Please choose a different buyer Name.";  
        }
        
    }

    // function (){
        
    // }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Buyer</title>
</head>
<body>
    <div class="container-fluid">
            <div class="mb-5">
                <h4>Add New Buyer</h4>  
            </div>
            <div>
                <form method="post">
                    
                    <div class="form-group mb-1 col-lg-3    ">
                        <label for="buyercode">Buyer Code</label>
                        <input type="text" class="form-control" id="buyercode" required name="buyercode">
                    </div>
                    <div class="form-group mb-1">
                        <label for="buyername">Buyer Name</label>
                        <input type="text" class="form-control" id="buyername" required name="buyername">
                    </div>
                    <div class="form-group mb-1">
                        <label for="address1">Address</label>
                        <input type="address" class="form-control" id="address1" required name="address">
                    </div>
                    <div class="d-lg-flex mb-1">
                        <div class="form-group me-5 col-lg-4">
                            <label>Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Working Email" required name="email">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>Tel.</label>
                            <input type="telephone" class="form-control" id="tel" name="tel">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>Fax</label>
                            <input type="telephone" class="form-control" id="fax" name="fax">
                        </div>
                    </div>
                    <div class="d-lg-flex mb-1">
                        <div class="form-group me-5 col-lg-4">
                            <label>Contact Person</label>
                            <input type="text" class="form-control" id="contactperson" required name="contactperson">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>BR No.</label>
                            <input type="text" class="form-control" id="brno"  required name="brno">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>VAT No.</label>
                            <input type="text" class="form-control" id="vatno" required name="vatno">
                        </div>
                    </div>
                <!-- ------------------------------------------- -->
                    <div class="form-row mb-2">
                        <div class="form-group col-md-4 mt-3">
                            <label for="inputState">Status</label>
                            <select id="inputState" class="form-select" name="status">
                                <option selected>Active</option>
                                <option>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- <div class="rounded container-fluid p-2 mb-3 d-lg-flex" style="background-color: lightgrey; min-height: 10em;">
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
                    </div> -->

                    <input type="submit" value="Save" class="btn btn-primary mt-5 me-2 save_btn" name="btnSubmit"/>
                    <input type="reset" value="Clear" class="btn btn-secondary mt-5 save_btn" name="btnClear"/>
                </form>
            </div> 
    </div>

</body>
</html>