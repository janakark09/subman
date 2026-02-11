<?php
	include "../includes/db-con.php";
    $message="";
    $returnDataSet2 = "";
    $selectedBuyer = "";
    $selectedStyle = "";

    //------------------ Fetch Buyer Name and Style Nos -------------------
    $sqlQuery1="SELECT * FROM  buyer WHERE status='Active'";
	$returnDataSet1=mysqli_query($conn,$sqlQuery1);

    //------------------ Fetch Selected Buyer -------------------
    if(isset($_POST['buyerid']))
    {
        $selectedBuyer=$_POST['buyerid'];
    }
    if($selectedBuyer != ""){
    $sqlQuery2 = "SELECT * FROM styles WHERE status='Active' AND buyerID='$selectedBuyer'";
    $returnDataSet2 = mysqli_query($conn,$sqlQuery2);
    }

    //------------------ Fetch Selected Style -------------------
    if(isset($_POST['styleNo']))
    {
        $selectedStyle=$_POST['styleNo'];
    }
    if($selectedStyle != ""){
    $sqlQuery3 = "SELECT * FROM styleorder WHERE Status='Active' AND styleNo='$selectedStyle'";
    $returnDataSet3 = mysqli_query($conn,$sqlQuery3);
    }

	$activeUser=$_SESSION['_UserID'];   // Assuming session is already started elsewhere
    
    //------------------ Fetch Colors for Selected Order No -------------------
    
    if(isset($_POST['btnSearch']))
    {
        $sqlQuery_color = "SELECT * FROM style_colors WHERE orderNoID='$_POST[orderNo]'";
        $DataSet_color = mysqli_query($conn, $sqlQuery_color);

        $sqlQuery_size = "SELECT * FROM style_sizes WHERE orderNoID='$_POST[orderNo]'";
        $DataSet_size = mysqli_query($conn, $sqlQuery_size);
    }
    
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
    <title>Colors and sizes</title>
</head>
<body>
    <div class="container-fluid">
            <div class="mb-5">
                <h4>Style Colors and Sizes Ratio</h4>  
            </div>
            <div>
                <form method="post">
                    <div class="form-group col-md-4 me-3">
                            <label >Buyer</label>
                            <select class="form-select" name="buyerid" id="buyerSelect" onchange="resetStyleAndOrder(); this.form.submit()"  >
                                <option selected hidden></option>
                                <?php 
                                    while($buyer=mysqli_fetch_assoc($returnDataSet1)){
                                        ?>
                                        <option value="<?php echo $buyer['buyerID']; ?>" 
                                        <?php if(isset($_POST['buyerid']) && $_POST['buyerid']==$buyer['buyerID']) echo "selected"; ?>>
                                        <?php echo $buyer['buyerName']?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                    </div>
                    <div class="d-lg-flex mb-1">
                        <div class="form-group col-md-4 me-3">
                            <label >Style</label>
                            <select class="form-select" name="styleNo" id="styleSelect" onchange="this.form.submit()">
                                <option selected hidden></option>
                                <?php 
                                    if($selectedBuyer != ""){
                                        while($styleno=mysqli_fetch_assoc($returnDataSet2)){
                                            ?>
                                            <option value="<?php echo $styleno['styleNo']; ?>" <?php if(isset($_POST['styleNo']) && $_POST['styleNo']==$styleno['styleNo']) echo "selected"; ?>><?php echo $styleno['styleNo']?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4 me-3">
                            <label >Style</label>
                            <select class="form-select" name="orderNo" id="orderSelect" >
                                <option selected hidden></option>
                                <?php 
                                    if($selectedStyle != ""){
                                        while($orderno=mysqli_fetch_assoc($returnDataSet3)){
                                            ?>
                                            <option value="<?php echo $orderno['id']?>" <?php if(isset($_POST['orderNo']) && $_POST['orderNo']==$orderno['id']) echo "selected"; ?>><?php echo $orderno['orderNo']?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary m-3 mt-4 ps-5 pe-5" name="btnSearch">Search</button> 
                    </div>
                    <hr>
                <!-- ------------------------------------------- -->
                    <div class="bg-light p-4" style="min-height:30em;">
                        <div class="row">
                            
                            <!-- Colors Section -->
                            <div class="col-md-6">
                                <h5 class="mb-3">Colors</h5>
                                    <div class="bg-white p-3 rounded shadow-sm" style="height:100%; overflow-y:auto;">

                                    <!-- Color List -->
                                    <?php
                                        while($color=mysqli_fetch_assoc($DataSet_color)){
                                            ?>
                                            <div class="form-check" >
                                                <input class="form-check-input" type="checkbox" <?php if($color['active'] == 1) echo "checked"; ?>>
                                                <label class="form-check-label"><?php echo $color['color']?></label>
                                            </div>
                                            <?php
                                        } 
                                    ?>

                                <div class="mt-3 d-flex gap-2">
                                    <button class="btn btn-primary">+ Add Color</button>
                                    <button class="btn btn-primary save_btn">Save</button>
                                </div>
                            </div>

                        
                        </div>
                    </div>
                    <!-- <input type="submit" value="Save" class="btn btn-primary mt-5 me-2 save_btn" name="btnSubmit"/>
                    <input type="reset" value="Clear" class="btn btn-secondary mt-5 save_btn" name="btnClear"/> -->

                </form>
            </div> 
    </div>

    <script>
    function resetStyleAndOrder() {
        document.getElementById('styleSelect').selectedIndex = 0;
        document.getElementById('orderSelect').innerHTML = '<option selected hidden></option>';
    }
</script>
</body>
</html>