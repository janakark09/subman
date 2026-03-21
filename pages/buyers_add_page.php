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
                        echo "<script>alert('Buyer added successfully!');</script>";
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
                        <input type="address" class="form-control" id="address1" name="address">
                    </div>
                    <div class="d-lg-flex mb-1">
                        <div class="form-group me-5 col-lg-4">
                            <label>Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Working Email" name="email">
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
                            <input type="text" class="form-control" id="contactperson" name="contactperson">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>BR No.</label>
                            <input type="text" class="form-control" id="brno"  name="brno">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>VAT No.</label>
                            <input type="text" class="form-control" id="vatno" name="vatno">
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

                    <input type="submit" value="Save" class="btn btn-primary mt-5 me-2 save_btn" name="btnSubmit"/>
                    <input type="reset" value="Clear" class="btn btn-secondary mt-5 save_btn" name="btnClear"/>
                </form>
            </div> 
    </div>

</body>
</html>