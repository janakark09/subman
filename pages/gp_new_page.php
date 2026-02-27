<?php
    include "../includes/db-con.php";
    $message="";
    $returnDataSet2 = "";
    $DataSet_color = "";
    $DataSet_size   = "";
    $selectedBuyer = "";
    $selectedStyle = "";
    $selectedOrder = "";
    $selectedVendor = "";
    $userloc="";
    $orderQuantity = 0;
    $piecesPerSet = 0;
    $subconQty = 0;
    $totalqty = 0;
    $dailyQty = 0;
    $totaldays = 0;
    $startingDate = "";
    $endingDate = "";

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
    unset($_SESSION['gp_items']);
    }

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
    
    if(isset($_POST['vendorid']) && $_POST['vendorid'] != "")
    {
        $selectedVendor=$_POST['vendorid']; 
    }

    $agrQry = "SELECT A.id AS agr_ID, V.vendor AS VEN, SO.orderNo AS ORDERNO FROM agreements A JOIN vendors V ON A.vendorID=V.vendorID JOIN styleorder SO ON SO.id=A.styleOrderID WHERE A.styleOrderID='$selectedOrder' AND A.vendorID='$selectedVendor' AND A.Status='Active'";
    $agrResult = mysqli_query($conn, $agrQry);

    
    
    $activeUser=$_SESSION['_UserID'];   

    $locQry = "SELECT locationID FROM user_details WHERE User_ID='$activeUser'";
    $locResult = mysqli_query($conn, $locQry);

    if(mysqli_num_rows($locResult) > 0){
        $locData = mysqli_fetch_assoc($locResult);
        $userloc = $locData['locationID'];
    }

    if(!isset($_SESSION['gp_items'])){
    $_SESSION['gp_items'] = array();
    }

    if(isset($_POST['btnAdd'])){

        $cutNo   = $_POST['cutno'];
        $colorid = $_POST['colorid'];
        $sizeid  = $_POST['sizeid'];
        $matQty  = $_POST['matQty'];

        if(empty($cutNo) || empty($colorid) || empty($sizeid) || empty($matQty)){
            $message = "Please fill all fields before adding.";
        } else {

            // Create item array
            $item = array(
                "cutNo"   => $cutNo,
                "colorid" => $colorid,
                "sizeid"  => $sizeid,
                "matQty"  => $matQty
            );

            // Push into session array
            $_SESSION['gp_items'][] = $item;

            $message = "Item added successfully!";
        }
    }
    //------------------ Handle Form Submission -------------------
    if(isset($_POST['btnSubmit'])){
            $gatepassID2=$userloc."-".date('ymd'); // Example gatepassID_2 generation
            $vendorid = $_POST['vendorid'];
            $orderNo = $_POST['orderNo'];
            $gpDate=$_POST['gatepassDate'];
            $agrID = $_POST['agrtid'];            
            $status = "Pending";       
            $cutNo = $_POST['cutno'];
            $colorid = $_POST['colorid'];
            $sizeid = $_POST['sizeid'];
            $matQty = $_POST['matQty']; 
            
            //echo "gatepassID2: ".$gatepassID2."vendorid: ".$vendorid."orderNo: ".$orderNo."gpDate: ".$gpDate."agrID: ".$agrID."status: ".$status."cutNo: ".$cutNo."colorid: ".$colorid."sizeid: ".$sizeid;
        // Validate required fields
        if(empty($vendorid) || empty($orderNo) || empty($gpDate) || empty($agrID)){
            $message = "Please fill in all required fields.";
        } else {
            // Prepare and execute insert query

            try {
            
                $conn->begin_transaction();

                $sql1 = "INSERT INTO gatepass (gatepassID_2,locationID, orderNoID, gatepassDate, vendorID, orderAgreement, status, createdDT, createdBy) 
                VALUES ('$gatepassID2','$userloc', '$orderNo', '$gpDate', '$vendorid', '$agrID', '$status', NOW(), '$activeUser')";

                $conn->query($sql1);

                $last_id = $conn->insert_id;

                foreach($_SESSION['gp_items'] as $item){
                    $cutNo   = $item['cutNo'];
                    $colorid = (int)$item['colorid'];
                    $sizeid  = (int)$item['sizeid'];
                    $matQty  = (int)$item['matQty'];

                    $sql2 = "INSERT INTO gatepass_details (gpID, cutNo, colorID, sizeID, matQty) 
                            VALUES ('$last_id','$cutNo','$colorid','$sizeid','$matQty')";
                    $conn->query($sql2);
                }

                $conn->commit();
                unset($_SESSION['gp_items']);
                echo "<script>
                    setTimeout(function(){window.location.href = 'home_page.php?activity=gatepass';}, 1000);
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
    <title>Gatepass</title>
</head>
<body>
    <div class="container-fluid">
            <div class="mb-5">
                <h4>New Gate Pass</h4>  
            </div>
            <div>
                <form method="POST">
                    <!---------------------------------- Buyer Style Order Section -------------------------------------- -->
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
                    <!-- ---------------------------------------------------------------------------------------- -->
                    <div class="d-lg-flex mb-3  ">
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
                            <select class="form-select" name="orderNo" id="orderSelect" onchange="this.form.submit()">
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
                    </div>
                    <!-- ---------------------------------------------------------------------------------------- -->
                    <div class="form-group col-lg-2">
                            <label>Gatepass Date</label>
                            <input type="date" class="form-control" id="gatepassDate" required name="gatepassDate" onchange="calculateEndingDate();"
                            value="<?php echo isset($_POST['gatepassDate']) ? $_POST['gatepassDate']: '';?>">
                    </div>
                    <!-- ---------------------------------------------------------------------------------------- -->

                    <!-- Have to load agreemtn no when select vendor -->
                    <div class="d-lg-flex mb-3  mt-2">
                        <div class="form-group col-md-4 me-3 mt-1">
                            <label >Sub Contractor</label>
                            <select class="form-select" name="vendorid" id="vendorSelect" onchange="this.form.submit()"  >
                                <option selected hidden></option>
                                <?php 
                                    while($vendor=mysqli_fetch_assoc($dataSetVendors)){
                                        ?>
                                        <option value="<?php echo $vendor['vendorID']; ?>" <?php if(isset($_POST['vendorid']) && $_POST['vendorid']==$vendor['vendorID']) echo "selected"; ?>>
                                            <?php echo $vendor['vendor']?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4 me-3 mt-1">
                            <label >Order Agreement No.</label>
                            <select class="form-select" name="agrtid" id="agrSelect">
                                <option selected hidden></option>
                                <?php 
                                    if($selectedOrder != ""){
                                        while($agreement=mysqli_fetch_assoc($agrResult)){
                                            ?>
                                            <option value="<?php echo $agreement['agr_ID']; ?>" <?php if(isset($_POST['agrtid']) && $_POST['agrtid']==$agreement['agr_ID']) echo "selected";?>>
                                            <?php echo "GP ID: ".$agreement['agr_ID']."-".$agreement['VEN']." (".$agreement['ORDERNO'].")"?></option>
                                        <?php
                                        }
                                    }
                                    
                                    ?>
                            </select>
                        </div>
                    </div>
                     <!-- --------------------------------------------------------------------------------------------------------------------- -->
                    <div class="rounded container-fluid p-3 mb-3" style="background-color: lightgrey; min-height: 10em;">
                        
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
<!-- --------------------------------------------------------------------------------------------------------------------- -->
                        <div class="d-lg-flex mb-1 gap-3">
                            <div class="form-group mb-1 col-3">
                                <label for="cutno">Cut No</label>
                                <input type="text" class="form-control" id="cutno" name="cutno">
                            </div>
                            <div class="form-group mb-1 col-3 ">
                                <label for="matQty">Meterial Sets Quantity</label>
                                <input type="number" class="form-control" id="matQty" name="matQty" value="0">
                            </div>
                        </div>
                                              

                        <div class="d-lg-flex justify-content-center mb-1 mt-3 gap-2">
                            <input type="submit" value="Add" class="btn btn-primary me-2 save_btn" name="btnAdd"/>
                            <input type="button" value="Clear" class="btn btn-secondary save_btn" name="btnClear" onclick="window.location.href='home_page.php?activity=newgatepass'"/>
                        </div>
                    </div>
                    <!-- --------------------------------------------------------------------------------------------------------------------- -->
                    <div class="rowcontainer mb-3">
                        <div class="col-md-12">
                            <p class="text-danger"><?php echo $message; ?></p>
                        </div>

                    </div>

                    <div class="table-wrapper  mb-5">
                        <table class="table1" cellspacing="0" style="min-width:100%;">
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Cut No.</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Mat. Qty.</th>		
                            </tr>
                            <?php
                                if(!empty($_SESSION['gp_items'])){
                                    $no = 1;
                                    foreach($_SESSION['gp_items'] as $row){
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
                                    <td><?php echo $row['matQty']; ?></td>
                                </tr>
                                <?php
                                    }
                                }
                            ?>
                        </table>
                    </div> 
                    <div class="d-lg-flex justify-content-center mb-5 mt-3 gap-2">
                        <input type="submit" value="Save" class="btn btn-primary me-2 save_btn" name="btnSave"/>
                        <input type="button" value="Clear" class="btn btn-secondary save_btn" name="btnClear" onclick="window.location.href='home_page.php?activity=newgatepass'"/>
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

