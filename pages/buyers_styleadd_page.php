<?php
	include "../includes/db-con.php";
    $message="";
    $returnDataSet2 = "";

    if(isset($_POST['buyerid']))
    {
        $selectedBuyer=$_POST['buyerid'];
    }

    //------------------ Fetch Buyer Name and Style Nos -------------------
    $sqlQuery1="SELECT * FROM  buyer WHERE status='Active'";
	$returnDataSet1=mysqli_query($conn,$sqlQuery1);

    if($selectedBuyer != ""){
    //echo $selectedBuyer;
    $sqlQuery2 = "SELECT * FROM styles WHERE status='Active' AND buyerID='$selectedBuyer'";
    $returnDataSet2 = mysqli_query($conn,$sqlQuery2);
    }

	$activeUser=$_SESSION['_UserID'];
    
    //------------------ Insert New Vendor --------------------------------
    if(isset($_POST['btnSubmit']))
    {
        $styleno=$_POST['styleNo'];
        $orderno=$_POST['orderNo'];
        $orderqty=$_POST['orderQty'];
        $division=$_POST['division'];
        $proCat=$_POST['proCategory'];
        $description=$_POST['description'];
        $delDate=$_POST['deliveryDate'];
        $status=$_POST['status'];

        $query_orderchk="SELECT COUNT(orderNo) FROM styleorder WHERE orderNo='$orderno' AND styleNo='$styleno'";
		$result_orderchk=mysqli_query($conn,$query_orderchk);
		$chk=mysqli_fetch_assoc($result_orderchk);
		$chk_count= $chk['COUNT(orderNo)'];
        
        if($chk_count==0)
        {
            //echo $buyercode.",".$buyername.",".$address.",".$email.",".$tel.",".$fax.",".$conPerson.",".$brno.",".$vatno.",".$status.",".$activeUser;
            
            $insertQuery="INSERT INTO styleorder(styleNo, orderNo, orderQty, division, proCategory, description, deliveryDate, Status, createdDT, createdBy) 
                           VALUES ('$styleno','$orderno','$orderqty','$division','$proCat','$description','$delDate','$status',NOW(),'$activeUser')";
                
                    $result1=mysqli_query($conn, $insertQuery);
        
                    if($result1)
                    {
                        $message="Style Order added successfully.";
                    }
                    else
                    {
                        $message="Error adding Style Order: " . mysqli_error($conn);
                    }
                    echo "<script>
                        setTimeout(function(){window.location.href = 'home_page.php?activity=allbuyers';}, 1000);
                    </script>";
                    exit();
        }
        else
        {
            $message="This Order Number already exists. Please enter a different Order No of Style ID: ".$styleno;  
        }
        
    }

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
                    <div class="form-group col-md-4 me-3">
                            <label >Buyer</label>
                            <select class="form-control" name="buyerid" id="buyerSelect" onchange="this.form.submit()"  >
                                <option selected hidden></option>
                                <?php 
                                    while($buyer=mysqli_fetch_assoc($returnDataSet1)){
                                        ?>
                                        <option value="<?php echo $buyer['buyerID']; ?>" <?php if(isset($_POST['buyerid']) && $_POST['buyerid']==$buyer['buyerID']) echo "selected"; ?>><?php echo $buyer['buyerName']?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                    </div>
                    <div class="d-lg-flex mb-1">
                        <div class="form-group col-md-4 me-3">
                            <label >Style</label>
                            <select class="form-control" name="styleNo" id="styleSelect">
                                <option selected hidden></option>
                                <?php 
                                    if($selectedBuyer != ""){
                                        while($styleno=mysqli_fetch_assoc($returnDataSet2)){
                                            ?>
                                            <option><?php echo $styleno['styleNo']?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="form-group me-5 col-lg-4">
                            <label>Order No.</label>
                            <input type="text" class="form-control" id="orderNo" name="orderNo">
                        </div>
                    </div>
                    
                    <div class="form-group mb-1">
                        <label for="orderquantity">Order Quantity</label>
                        <input type="number" class="form-control" id="orderquantity" required name="orderQty">
                    </div>

                    <div class="d-lg-flex mb-1">
                        <div class="form-group col-md-4 me-3">
                            <label >Division</label>
                            <select class="form-control" name="division" id="divSelect">
                                <option selected hidden></option>
                                <?php 
                                    while($styleno=mysqli_fetch_assoc($returnDataSet2)){
                                        ?>
                                        <option><?php echo $styleno['styleNo']?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4 me-3">
                            <label >Product Category</label>
                            <select class="form-control" name="proCategory" id="catSelect">
                                <option selected hidden></option>
                                <?php 
                                    while($styleno=mysqli_fetch_assoc($returnDataSet2)){
                                        ?>
                                        <option><?php echo $styleno['styleNo']?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group me-5 col-lg-4">
                        <label>Order Description</label>
                        <input type="text" class="form-control" id="description" required name="description">
                    </div>
                    <div class="form-group me-5 col-lg-2">
                        <label>Delivery Date</label>
                        <input type="date" class="form-control" id="deliveryDate" required name="deliveryDate">
                    </div>
                <!-- ------------------------------------------- -->
                    <div class="form-row mb-2">
                        <div class="form-group col-md-2 mt-3">
                            <label for="inputState">Status</label>
                            <select id="inputState" class="form-control" name="status">
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