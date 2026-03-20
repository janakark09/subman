<?php
	include "../includes/db-con.php";
    $message="";

    $activeUser=$_SESSION['_UserID'];
    $selectedID=$_GET['selectedID'];

    $buyercode="";
    $buyername="";
    $address="";
    $tel="";
    $fax="";
    $brno="";
    $vatno="";
    $conPerson="";
    $email="";
    $status="";
    
    $sqlQuery="SELECT * FROM buyer WHERE buyerID='$selectedID'";
	$returnDataSet=mysqli_query($conn,$sqlQuery);
    $result1=mysqli_fetch_assoc($returnDataSet);

    if($result1)
    {
        $buyercode=$result1['buyerCode'];
        $buyername=$result1['buyerName'];
        $address=$result1['address'];
        $tel=$result1['tel'];
        $fax=$result1['fax'];
        $brno=$result1['brNo'];
        $vatno=$result1['vatNo'];
        $conPerson=$result1['contactPerson'];
        $email=$result1['email'];
        $status=$result1['status'];
    }

    //------------------ Insert New Vendor --------------------------------
    if(isset($_POST['btnSubmit']))
    {
        $buyername=$_POST['buyername'];
        $address=$_POST['address'];
        $tel=$_POST['tel'];
        $fax=$_POST['fax'];
        $brno=$_POST['brno'];
        $vatno=$_POST['vatno'];
        $conPerson=$_POST['contactperson'];
        $email=$_POST['email'];
        $status=$_POST['status'];

        if($buyername!="" && $address!="" && $status!="" && $email!="")
        {
            $sqlQuery="UPDATE buyer SET buyerName='$buyername', address='$address', tel='$tel', fax='$fax', 
                brNo='$brno', vatNo='$vatno', contactPerson='$conPerson', email='$email', status='$status', modifiedBy='$activeUser', modifiedDT=NOW() WHERE buyerID='$selectedID'";

            if(mysqli_query($conn,$sqlQuery))
            {
                echo "<script>alert('Buyer Updated Successfully');</script>";
                echo "<script>
                        setTimeout(function(){window.location.href = 'home_page.php?activity=allbuyers';}, 1000);
                    </script>";
                    exit();
            }
            else
            {
                echo "<script>alert('Error Occured');</script>";
            }
        }
        else
        {
            echo "<script>alert('Please Fill All Required Fields');</script>";
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
    <title>Edit Buyer</title>
</head>
<body>
    <div class="container-fluid">
            <div class="mb-5">
                <h4>Edit Buyer - <?php echo $buyername; ?></h4>  
            </div>
            <div>
                <form method="post">
                    
                    <div class="form-group mb-1 col-lg-3    ">
                        <label for="buyercode">Buyer Code</label>
                        <input type="text" class="form-control" id="buyercode" required name="buyercode" value="<?php echo $buyercode; ?>" disabled>
                    </div>
                    <div class="form-group mb-1">
                        <label for="buyername">Buyer Name</label>
                        <input type="text" class="form-control" id="buyername" required name="buyername" value="<?php echo $buyername; ?>">
                    </div>
                    <div class="form-group mb-1">
                        <label for="address1">Address</label>
                        <input type="address" class="form-control" id="address1" required name="address" value="<?php echo $address; ?>">
                    </div>
                    <div class="d-lg-flex mb-1">
                        <div class="form-group me-5 col-lg-4">
                            <label>Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Working Email" required name="email" value="<?php echo $email; ?>">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>Tel.</label>
                            <input type="telephone" class="form-control" id="tel" name="tel" value="<?php echo $tel; ?>">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>Fax</label>
                            <input type="telephone" class="form-control" id="fax" name="fax" value="<?php echo $fax; ?>">
                        </div>
                    </div>
                    <div class="d-lg-flex mb-1">
                        <div class="form-group me-5 col-lg-4">
                            <label>Contact Person</label>
                            <input type="text" class="form-control" id="contactperson" required name="contactperson" value="<?php echo $conPerson; ?>">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>BR No.</label>
                            <input type="text" class="form-control" id="brno"  required name="brno" value="<?php echo $brno; ?>">
                        </div>
                        <div class="form-group me-5 col-lg-3">
                            <label>VAT No.</label>
                            <input type="text" class="form-control" id="vatno" required name="vatno" value="<?php echo $vatno; ?>">
                        </div>
                    </div>
                <!-- ------------------------------------------- -->
                    <div class="form-row mb-2">
                        <div class="form-group col-md-4 mt-3">
                            <label for="inputState">Status</label>
                            <select id="inputState" class="form-select" name="status">
                                <option <?php if($status == 'Active') echo 'selected'; ?>>Active</option>
                                <option <?php if($status == 'Inactive') echo 'selected'; ?>>Inactive</option>
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