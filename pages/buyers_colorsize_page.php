<?php
	include "../includes/db-con.php";
    $message="";
    $returnDataSet2 = "";
    $DataSet_color = "";
    $DataSet_size   = "";
    $selectedBuyer = "";
    $selectedStyle = "";
    $selectedcolors = [];

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
        //echo $selectedBuyer.", ".$selectedStyle.", ".$_POST['orderNo'];
        $sqlQuery_color = "SELECT * FROM style_colors WHERE orderNoID='$_POST[orderNo]'";
        $DataSet_color = mysqli_query($conn, $sqlQuery_color);

        $sqlQuery_size = "SELECT * FROM style_sizes WHERE orderNoID='$_POST[orderNo]'";
        $DataSet_size = mysqli_query($conn, $sqlQuery_size);
    }
    //------------------ Add New Color --------------------------------
    if(isset($_POST['AddColor']))
    {
        $newColor = $_POST['newColor'];
        $orderNo=$_POST['orderNo'];
        echo "New Color: ".$newColor." for Order No: ".$_POST['orderNo'];
        if($newColor != ""){
            
            $insertColorQuery = "INSERT INTO style_colors (color,orderNoID, active) VALUES ('$newColor','$orderNo', 1)";
            mysqli_query($conn, $insertColorQuery);
            // Refresh the color list after adding a new color
            $sqlQuery_color = "SELECT * FROM style_colors WHERE orderNoID='$orderNo'";
            $DataSet_color = mysqli_query($conn, $sqlQuery_color);
            $sqlQuery_size = "SELECT * FROM style_sizes WHERE orderNoID='$orderNo'";
            $DataSet_size = mysqli_query($conn, $sqlQuery_size);
        }
    }
    //------------------ Add New Size --------------------------------
    if(isset($_POST['AddSize']))
    {
        $newSize = $_POST['newSize'];
        $orderNo=$_POST['orderNo'];
        echo "New Size: ".$newSize." for Order No: ".$_POST['orderNo'];
        if($newSize != ""){
            
            $insertSizeQuery = "INSERT INTO style_sizes (size,orderNoID, active) VALUES ('$newSize','$orderNo', 1)";
            mysqli_query($conn, $insertSizeQuery);
            // Refresh the size list after adding a new size
            $sqlQuery_color = "SELECT * FROM style_colors WHERE orderNoID='$orderNo'";
            $DataSet_color = mysqli_query($conn, $sqlQuery_color);
            $sqlQuery_size = "SELECT * FROM style_sizes WHERE orderNoID='$orderNo'";
            $DataSet_size = mysqli_query($conn, $sqlQuery_size);
        }
    }

    //------------------ Insert New Vendor --------------------------------
    if(isset($_POST['btnSave']))
    {
        $orderNo = $_POST['orderNo'];
        $selectedColors = $_POST['colors'] ?? []; 
        $selectedSizes = $_POST['sizes'] ?? []; 

        //Set all colors to inactive
        $resetQuery = "UPDATE style_colors SET active = 0 WHERE orderNoID='$orderNo'";
        mysqli_query($conn, $resetQuery);

        //Activate only checked colors
        if(!empty($selectedColors)){
            $idsColors = implode(",", array_map('intval', $selectedColors));
            $activateQuery = "UPDATE style_colors SET active = 1 WHERE colorID IN ($idsColors) AND orderNoID='$orderNo'";
            mysqli_query($conn, $activateQuery);
        }

        //set all sizes to inactive
        $resetSizeQuery = "UPDATE style_sizes SET active = 0 WHERE orderNoID='$orderNo'";
        mysqli_query($conn, $resetSizeQuery);

        //Activate only checked sizes
        if(!empty($selectedSizes)){
            $idsSizes = implode(",", array_map('intval', $selectedSizes));
            $activateSizeQuery = "UPDATE style_sizes SET active = 1 WHERE sizeID IN ($idsSizes) AND orderNoID='$orderNo'";
            mysqli_query($conn, $activateSizeQuery);
        }

        echo "<script>
            alert('Colors and Sizes saved successfully!');
        </script>";
        // Refresh the size list after adding a new size
            $sqlQuery_color = "SELECT * FROM style_colors WHERE orderNoID='$orderNo'";
            $DataSet_color = mysqli_query($conn, $sqlQuery_color);
            $sqlQuery_size = "SELECT * FROM style_sizes WHERE orderNoID='$orderNo'";
            $DataSet_size = mysqli_query($conn, $sqlQuery_size);
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
                            <label >Style No.</label>
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
                            <label >Order No.</label>
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
                    <div class="bg-light p-4">
                        <div class="row">

                            <!-- -------------------------Color Section-------------------------------------- -->
                            <div class="col-md-6 ps-5 pe-5">
                                <h5 class="mb-3">Colors</h5>
                                <div class="bg-white p-3 rounded shadow-sm" style=" overflow-y:auto;">
                                    <!-- Color List -->
                                    <?php
                                    if($DataSet_color != ""){
                                        while($color=mysqli_fetch_assoc($DataSet_color)){
                                            ?>
                                            <div class="form-check d-flex align-items-center mb-2">
                                                <input type="checkbox" class="form-check-input me-3" style="width: 20px; height: 20px;" name="colors[]" value="<?php echo $color['colorID']; ?>" 
                                                    <?php if($color['active'] == 1) echo "checked"; ?> />
                                                <span><?php echo $color['color']; ?></span>
                                            </div>
                                        <?php
                                        }
                                    }
                                    else{
                                        echo "<p>No colors found for this order.</p>";
                                    } 
                                    ?>
                                </div>
                                
                                <div class="d-flex mt-3 mb-3 gap-3">
                                    <input type="text" class="form-control" id="newColor" name="newColor" style="width: 200px;" placeholder="Enter new color">
                                    <button type="submit" class="btn btn-primary" name="AddColor">+ Add Color</button>
                                </div>
                            </div>
                            
                            <!-- -------------------------Sizes Section------------------------------------------- -->
                            <div class="col-md-6 ps-5 pe-5">
                                <h5 class="mb-3">Sizes</h5>
                                <div class="bg-white p-3 rounded shadow-sm" style=" overflow-y:auto;">
                                    <!-- Color List -->
                                    <?php
                                    if($DataSet_size != ""){
                                        while($size=mysqli_fetch_assoc($DataSet_size)){
                                            ?>
                                            <div class="form-check d-flex align-items-center mb-2">
                                                <input type="checkbox" class="form-check-input me-3" style="width: 20px; height: 20px;" name="sizes[]" value="<?php echo $size['sizeID']; ?>" <?php if($size['active'] == 1) echo "checked"; ?> />
                                                <span><?php echo $size['size']; ?></span>
                                            </div>
                                        <?php
                                        }
                                    }
                                    else{
                                        echo "<p>No sizes found for this order.</p>";
                                    }
                                    ?>
                                </div>
                                
                                <div class="d-flex mt-3 mb-3 gap-3">
                                    <input type="text" class="form-control" id="newSize" name="newSize" style="width: 200px;" placeholder="Enter new size">
                                    <button type="submit" class="btn btn-primary" name="AddSize">+ Add Size</button>
                                </div>
                            </div>
                            <!-- ------------------------------------------------------------------- -->
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-primary save_btn" name="btnSave">Save</button>
                    </div>
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