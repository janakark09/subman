<?php
    include "../includes/db-con.php";
    $message="";
    $returnDataSet2 = "";
    $DataSet_color = "";
    $DataSet_size   = "";
    $selectedStyle = "";
    $selectedOrder = "";
    $activeVendor = "";
    $userloc="";

    $activeUser=$_SESSION['_UserID'];  

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
    unset($_SESSION['pro_items']);
    }

    //------------------ Fetch Location Name -------------------
    $locationQuery="SELECT * FROM  mast_location WHERE status='Active'";
    $locationDataSet=mysqli_query($conn,$locationQuery);
    
    //------------------ Fetch Styles  -------------------
    $styleQuery = "SELECT * FROM styles WHERE status='Active'";
    $styleDataSet = mysqli_query($conn,$styleQuery);


    //------------------ Fetch Selected Style -------------------
    if(isset($_POST['styleNo']))
    {
        $selectedStyle=$_POST['styleNo'];
    }
    if($selectedStyle != ""){
    $orderQuery = "SELECT * FROM styleorder WHERE Status='Active' AND styleNo='$selectedStyle'";
    $orderDataSet = mysqli_query($conn,$orderQuery);
    }

    //------------------ Fetch Selected Order to Order Quantity Lable -------------------
    if(isset($_POST['orderNo']) && $_POST['orderNo'] != "")
    {
        $selectedOrder=$_POST['orderNo']; 
    }

    //------------------ Fetch Colors and Sizes for Selected Order -------------------
    $colorQry = "SELECT * FROM style_colors WHERE orderNoID='$selectedOrder' AND active=1";
    $colorResult = mysqli_query($conn, $colorQry);

    //------------------ Fetch Sizes for Selected Order -------------------
    $sizeQry = "SELECT * FROM style_sizes WHERE orderNoID='$selectedOrder' AND active=1";
    $sizeResult = mysqli_query($conn, $sizeQry);

    //------------------ Fetch Active Vendors for Subcontractor Dropdown -------------------
    $vendorsQuery = "SELECT * FROM vendors WHERE status='Active'";
    $dataSetVendors = mysqli_query($conn, $vendorsQuery);
    
    //------------------ Fetch Vendor ID for Active User -------------------
    $userQuery = "SELECT venderID FROM user_details WHERE User_ID='$activeUser'";
    $userResult = mysqli_query($conn, $userQuery);
    if(mysqli_num_rows($userResult) > 0){
        $userData = mysqli_fetch_assoc($userResult);
        $activeVendor = $userData['venderID'];
    }
    
    // ----------------- Fetch Active Agreements for Selected Order and Vendor --------------------
    $agrQry = "SELECT A.id AS agr_ID, V.vendor AS VEN, SO.orderNo AS ORDERNO FROM agreements A JOIN vendors V ON A.vendorID=V.vendorID JOIN styleorder SO ON SO.id=A.styleOrderID WHERE A.styleOrderID='$selectedOrder' AND A.vendorID='$activeVendor' AND A.Status='Active'";
    $agrResult = mysqli_query($conn, $agrQry); 

    //------------------ Fetch Location ID for Active User -------------------
    $locQry = "SELECT locationID FROM user_details WHERE User_ID='$activeUser'";
    $locResult = mysqli_query($conn, $locQry);

    if(mysqli_num_rows($locResult) > 0){
        $locData = mysqli_fetch_assoc($locResult);
        $userloc = $locData['locationID'];
    }

    //------------------ Handle Add Item to Session -------------------
    if(!isset($_SESSION['pro_items'])){
    $_SESSION['pro_items'] = array();
    }

    if(isset($_POST['btnAdd'])){

        $cutNo   = $_POST['cutno'];
        $colorid = $_POST['colorid'];
        $sizeid  = $_POST['sizeid'];
        $finishedQty  = $_POST['proQty'];
        $fabricDamQty = $_POST['fabricDamQty'];
        $processDamQty = $_POST['processDamQty'];
        $sampleQty = $_POST['sampleQty'];

        if(empty($cutNo) || empty($colorid) || empty($sizeid)){
            $message = "Please fill all fields before adding.";
        } 
        else {
            if($finishedQty > 0 || $fabricDamQty > 0 || $processDamQty > 0 || $sampleQty > 0){
                // Create item array
                $item = array(
                    "cutNo"   => $cutNo,
                    "colorid" => $colorid,
                    "sizeid"  => $sizeid,
                    "proQty"  => $finishedQty,
                    "fabricDamQty" => $fabricDamQty,
                    "processDamQty" => $processDamQty,
                    "sampleQty" => $sampleQty
                );

                // Push into session array
                $_SESSION['pro_items'][] = $item;

                $message = "Item added successfully!";
            } 
            else {
                $message = "At least one of the quantity fields must be greater than zero.";
                return;
            }
        }
    }
    //------------------ Handle Form Submission -------------------
    if(isset($_POST['btnSave'])){
            $gpRef=$_POST['refno'];
            $orderNo = $_POST['orderNo'];
            $gpDate=$_POST['finishingDate'];
            $locid= $_POST['locationid'];
            $vendorid = $activeVendor; // Assuming vendor is determined by active user
            $agrID = $_POST['agrtid'];
            $remark = $_POST['remark'];            
            $status = "Pending";
            
            //echo "gatepassID2: ".$gatepassID2."vendorid: ".$vendorid."orderNo: ".$orderNo."gpDate: ".$gpDate."agrID: ".$agrID."status: ".$status."cutNo: ".$cutNo."colorid: ".$colorid."sizeid: ".$sizeid;
        // Validate required fields
        if(empty($vendorid) || empty($orderNo) || empty($gpDate) || empty($agrID)){
            $message = "Please fill in all required fields.";
        } else {
            // Prepare and execute insert query
            //echo "ok";
            try {
            
                $conn->begin_transaction();

                $sql1 = "INSERT INTO sub_production (gatepassRefID, orderNoID, gatepassDate, locationID, vendorID, orderAgreement, comments, status, createdBy)
                VALUES ('$gpRef', '$orderNo', '$gpDate', '$locid', '$vendorid', '$agrID', '$remark', '$status', '$activeUser')";

                $conn->query($sql1);

                $last_id = $conn->insert_id;
                //echo "last: ".$last_id;
                foreach($_SESSION['pro_items'] as $item){
                    $cutNo   = $item['cutNo'];
                    $colorid = (int)$item['colorid'];
                    $sizeid  = (int)$item['sizeid'];
                    $finishedQty  = (int)$item['proQty'];
                    $fabricDamQty = (int)$item['fabricDamQty'];
                    $processDamQty = (int)$item['processDamQty'];
                    $sampleQty = (int)$item['sampleQty'];

                    $sql2 = "INSERT INTO sub_pro_details (recID, cutNo, colorID, sizeID, finishedQty, fabDamQty, processDamQty, sampleQty) 
                            VALUES ('$last_id','$cutNo','$colorid','$sizeid','$finishedQty','$fabricDamQty','$processDamQty','$sampleQty')";
                    $conn->query($sql2);
                }

                $conn->commit();
                unset($_SESSION['pro_items']);
                echo "<script>
                    setTimeout(function(){window.location.href = 'home_page.php?activity=proRec';}, 1000);
                </script>";
                exit();
            }
            catch (Exception $e) {
                $conn->rollback();
                $message = "Error creating gatepass: " . $e->getMessage();
            }
        }
    }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production</title>
</head>
<body>
    <div class="container-fluid">
            <div class="mb-5">
                <h4>New Production Record</h4>  
            </div>
            <div>
                <form method="POST">
                    <!---------------------------------- Buyer Style Order Section -------------------------------------- -->
                    <div class="form-group col-md-4 me-3">
                            <label >Location</label>
                            <select class="form-select" name="locationid" id="locSelect" onchange="resetStyleAndOrder(); this.form.submit()"  >
                                <option selected hidden></option>
                                <?php 
                                    while($location=mysqli_fetch_assoc($locationDataSet)){
                                        ?>
                                        <option value="<?php echo $location['locationID']; ?>" 
                                        <?php if(isset($_POST['locationid']) && $_POST['locationid']==$location['locationID']) echo "selected"; ?>>
                                        <?php echo $location['location']?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                    </div>
                    <!-- ------------------------------------------------------------------ -->
                    <div class="d-lg-flex mb-3  ">
                        <div class="form-group col-md-4 me-3">
                            <label >Style No.</label>
                            <select class="form-select" name="styleNo" id="styleSelect" onchange="this.form.submit()">
                                <option selected hidden></option>
                                <?php 
                                    while($styleno=mysqli_fetch_assoc($styleDataSet)){
                                                ?>
                                                <option value="<?php echo $styleno['styleNo']; ?>" <?php if(isset($_POST['styleNo']) && $_POST['styleNo']==$styleno['styleNo']) echo "selected"; ?>><?php echo $styleno['styleNo']?></option>
                                            <?php
                                            }   
                                    ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4 me-3">
                            <label >Order No.</label>
                            <select class="form-select" name="orderNo" id="orderSelect" onchange="this.form.submit()">
                                <option selected hidden></option>
                                <?php 
                                    if($selectedStyle != ""){
                                        while($orderno=mysqli_fetch_assoc($orderDataSet)){
                                            ?>
                                            <option value="<?php echo $orderno['id']?>" <?php if(isset($_POST['orderNo']) && $_POST['orderNo']==$orderno['id']) echo "selected"; ?>><?php echo $orderno['orderNo']?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>
                    <!-- ------------------------------------------------------------------ -->
                     <div class="d-lg-flex mb-3 gap-3" >
                        <div class="form-group col-lg-2">
                            <label>Finishing Date</label>
                            <input type="date" min="<?php echo $todayStr; ?>" class="form-control" id="finishingDate" required name="finishingDate" 
                            value="<?php echo isset($_POST['finishingDate']) ? $_POST['finishingDate']: '';?>">
                        </div>
                        <div class="form-group mb-1 col-3">
                                <label for="refno">Gatepass Reference No.</label>
                                <input type="text" class="form-control" id="refno" name="refno">
                            </div>
                     </div>
                    <!-- ------------------------------------------------------------------ -->
                        <div class="form-group col-md-4 me-3 mt-1">
                            <label >Order Agreement No.</label>
                            <select class="form-select" name="agrtid" id="agrSelect">
                                <option selected hidden></option>
                                <?php 
                                    if($selectedOrder != ""){
                                        while($agreement=mysqli_fetch_assoc($agrResult)){
                                            ?>
                                            <option value="<?php echo $agreement['agr_ID']; ?>" <?php if(isset($_POST['agrtid']) && $_POST['agrtid']==$agreement['agr_ID']) echo "selected";?>>
                                            <?php echo "Agr. ID: ".$agreement['agr_ID']." (".$agreement['VEN']." - ".$agreement['ORDERNO'].")"?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                            </select>
                        </div>

                        <div class="form-group mb-1 col">
                                <label for="remark">Remarks</label>
                                <input type="text" class="form-control" id="remark" name="remark">
                        </div>

                     <!-- ---------------------------------- Colors Sizes and Quantity Section -------------------------------- -->
                    <div class="rounded container-fluid p-3 mb-3 mt-4" style="background-color: lightgrey; min-height: 10em;">
                        
                        <div class="d-lg-flex mb-1 gap-3">
                            <div class="form-group col-md-6 me-3 mt-1">
                                <label >Color</label>
                                <select class="form-select" name="colorid" id="colorselect">
                                    <option selected hidden></option>
                                    <?php 
                                        while($color=mysqli_fetch_assoc($colorResult)){
                                            ?>
                                            <option value="<?php echo $color['colorID']; ?>" ><?php echo $color['color']?></option>
                                        <?php
                                        }
                                        ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4 me-3 mt-1">
                                <label >Size</label>
                                <select class="form-select" name="sizeid" id="size">
                                    <option selected hidden></option>
                                    <?php 
                                        while($size=mysqli_fetch_assoc($sizeResult)){
                                            ?>
                                            <option value="<?php echo $size['sizeID']; ?>"><?php echo $size['size']?></option>
                                        <?php
                                        }
                                        ?>
                                </select>
                            </div>
                        </div>
                        <!-- ------------------------------------------------------------------ -->
                        <div class="d-lg-flex mb-1 gap-3">
                            <div class="form-group mb-1 col-3">
                                <label for="cutno">Cut No</label>
                                <input type="text" class="form-control" id="cutno" name="cutno">
                            </div>
                            <div class="form-group mb-1 col-3 ">
                                <label for="proQty">Production Qty.(Without Damages and Samples)</label>
                                <input type="number" min="0" class="form-control" id="proQty" name="proQty" value="0">
                            </div>
                        </div>
                        <!-- ------------------------------------------------------------------ -->
                        <div class="d-lg-flex mb-1 gap-3">
                            <div class="form-group mb-1 col-3">
                                <label for="fabDamdQty">Fabric Damaged Qty.</label>
                                <input type="number" min="0" class="form-control" id="fabDamdQty" name="fabricDamQty" value="0">
                            </div>
                            <div class="form-group mb-1 col-3 ">
                                <label for="processDamdQty">Process Damaged Qty.</label>
                                <input type="number" min="0" class="form-control" id="processDamdQty" name="processDamQty" value="0">
                            </div>
                            <div class="form-group mb-1 col-3 ">
                                <label for="sampleQty">Sample Qty.</label>
                                <input type="number" min="0" class="form-control" id="sampleQty" name="sampleQty" value="0">
                            </div>
                        </div>                

                        <!-- ------------------------------------------------------------------ -->
                        <div class="d-lg-flex justify-content-center mb-1 mt-3 gap-2">
                            <input type="submit" value="Add" class="btn btn-primary me-2 save_btn" name="btnAdd"/>
                            <input type="button" value="Clear" class="btn btn-secondary save_btn" name="btnClear" onclick="window.location.href='home_page.php?activity=proAdd'"/>
                        </div>
                    </div>
                    <!-- --------------------------------------------------------------------------------------------------------------------- -->
                    <div class="rowcontainer mb-3">
                        <div class="col-md-12">
                            <p class="text-danger"><?php echo $message; ?></p>
                        </div>

                    </div>

                    <div class="table-wrapper  mb-5">
                        <table class="table1 text-center" cellspacing="0" style="min-width:100%;">
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Cut No.</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Production Qty.</th>
                                <th>Fabric Damaged Qty.</th>
                                <th>Process Damaged Qty.</th>
                                <th>Sample Qty.</th>
                            </tr>
                            <?php
                                if(!empty($_SESSION['pro_items'])){
                                    $no = 1;
                                    foreach($_SESSION['pro_items'] as $row){
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $row['cutNo']; ?></td>
                                    <td><?php 
                                    $colorName = ''; 
                                    $sizeName = ''; 
                                    $colorRes = mysqli_query($conn, "SELECT color FROM style_colors WHERE colorID='".$row['colorid']."'"); 
                                    if($c = mysqli_fetch_assoc($colorRes)) $colorName = $c['color'];
                                    $sizeRes = mysqli_query($conn, "SELECT size FROM style_sizes WHERE sizeID='".$row['sizeid']."'"); 
                                    if($s = mysqli_fetch_assoc($sizeRes)) $sizeName = $s['size'];
                                    echo $colorName; 
                                     ?></td>
                                    <td><?php echo $sizeName; ?></td>
                                    <td><?php echo $row['proQty']; ?></td>
                                    <td><?php echo $row['fabricDamQty']; ?></td>
                                    <td><?php echo $row['processDamQty']; ?></td>
                                    <td><?php echo $row['sampleQty']; ?></td>
                                </tr>
                                <?php
                                    }
                                }
                            ?>
                        </table>
                    </div> 
                    <div class="d-lg-flex justify-content-center mb-5 mt-3 gap-2">
                        <input type="submit" value="Save" class="btn btn-primary me-2 save_btn" name="btnSave"/>
                        <input type="button" value="Clear" class="btn btn-secondary save_btn" name="btnClear" onclick="window.location.href='home_page.php?activity=proAdd'"/>
                    </div>
                </form>
            </div> 
    </div>
<!-- --------------------------------------------- JS Functions ----------------------------------------------------- -->
    <script>
    function resetStyleAndOrder() {
        document.getElementById('styleSelect').selectedIndex = 0;
        document.getElementById('orderSelect').innerHTML = '<option selected hidden></option>';
    }
</script>
</body>
</html>

