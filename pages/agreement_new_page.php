<?php
    include "../includes/db-con.php";
    $message="";
    $returnDataSet2 = "";
    $DataSet_color = "";
    $DataSet_size   = "";
    $selectedBuyer = "";
    $selectedStyle = "";
    $selectedOrder = "";
    $orderQuantity = 0;
    $piecesPerSet = 0;
    $subconQty = 0;
    $totalqty = 0;
    $dailyQty = 0;
    $totaldays = 0;
    $startingDate = "";
    $endingDate = "";

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
        $sqlQuery4 = "SELECT orderQty FROM styleorder WHERE id='$selectedOrder'";
        $result4 = mysqli_query($conn, $sqlQuery4);
        if($result4 && mysqli_num_rows($result4) > 0){
            $row4 = mysqli_fetch_assoc($result4);
            $orderQuantity = $row4['orderQty'];
        }
    }

    //------------------ Calculate Subcontract Quantity ----------------------
    if(isset($_POST['pieces']) && $_POST['pieces'] != "" && $orderQuantity > 0)
    {
        $piecesPerSet = $_POST['pieces'];
        $subconQty = floor($orderQuantity / $piecesPerSet);
    }

    //------------------ Fetch Active Vendors for Subcontractor Dropdown -------------------
    $vendorsQuery = "SELECT * FROM vendors WHERE status='Active'";
    $dataSetVendors = mysqli_query($conn, $vendorsQuery);

    //------------------ Fetch Process type for Subcontractor Dropdown -------------------
    $typeQuery = "SELECT * FROM process_type";
    $dataSetTypes = mysqli_query($conn, $typeQuery);

    echo $_POST['totalQty']." - ".$_POST['perDayQty'];
    //------------------ Calculate Total Days -------------------
    if(isset($_POST['totalQty']) && isset($_POST['perDayQty']) && $_POST['perDayQty'] > 0 && $_POST['totalQty'] > 0){
        $totalqty = $_POST['totalQty'];
        $dailyQty = $_POST['perDayQty'];
    
        $totaldays = ceil($totalqty / $dailyQty);
    }

    //------------------ Calculate Ending Date based on Starting Date and Total Days -------------------
    if(isset($_POST['startingDate']) && $_POST['startingDate'] != "" && $totaldays > 0){
        $startingDate = $_POST['startingDate'];
        $endingDate = date('Y-m-d', strtotime($startingDate. ' + '.($totaldays-1).' days'));
    }
    
    $activeUser=$_SESSION['_UserID'];   
    
    

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Agreement</title>
</head>
<body>
    <div class="container-fluid">
            <div class="mb-5">
                <h4>New Subcontract Agreement</h4>  
            </div>
            <div>
                <form method="post">
                    <!------------------------- Search Section ------------------------------------------- -->
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
                    <lable class="fw-bold">Order Quantity: <?php echo $orderQuantity; ?></lable> 
                    
                    <div class="form-group col-md-2 mb-1">
                        <label for="pieces1">Pieces per Set</label>
                        <input type="number" class="form-control" id="pieces1" required name="pieces" value="<?php echo ($piecesPerSet > 0) ? $piecesPerSet : ''; ?>" onchange="this.form.submit()">
                    </div>
                    <lable class="fw-bold">Subcontract Quantity: <?php echo $orderQuantity ?> / <?php echo $piecesPerSet?> = <?php echo $subconQty; ?></lable>
                    <hr>
                    <!-- ------------------------------------------- -->
                     <div class="form-group col-md-4 me-3 mt-1">
                            <label >Subcontractor</label>
                            <select class="form-select" name="vendorid" id="vendorSelect">
                                <option selected hidden></option>
                                <?php 
                                    while($vendor=mysqli_fetch_assoc($dataSetVendors)){
                                        ?>
                                        <option value="<?php echo $vendor['vendorID']; ?>"><?php echo $vendor['vendor']?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                    </div>
                    <div class="form-group col-md-3 me-3 mt-1">
                            <label >Process Type</label>
                            <select class="form-select" name="typeid" id="processSelect">
                                <option selected hidden></option>
                                <?php 
                                    while($type=mysqli_fetch_assoc($dataSetTypes)){
                                        ?>
                                        <option value="<?php echo $type['typeid']; ?>"><?php echo $type['processType']?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                    </div>

                    <div class="d-lg-flex mb-1 gap-3">
                        <div class="form-group mb-1 ">
                            <label for="totalQty">Contract Total Quantity</label>
                            <input type="number" class="form-control" id="totalQty" required name="totalQty" onchange="this.form.submit()" value="<?php echo ($totalqty > 0) ? $totalqty : ''; ?>">
                        </div>
                        <div class="form-group mb-1">
                            <label for="perDayQty">Per Day Quantity</label>
                            <input type="number" class="form-control" id="perDayQty" required name="perDayQty" onchange="this.form.submit()" value="<?php echo ($dailyQty > 0) ? $dailyQty : ''; ?>">
                        </div>
                    </div>
                    <lable class="fw-bold">Estimated Days: <?php echo $totaldays ?></lable>
                    <hr>
                    <!------------------------------------------- -->
                    <div class="d-lg-flex mb-1 gap-3">
                        <div class="form-group col-lg-2">
                            <label>Starting Date</label>
                            <input type="date" class="form-control" id="startingDate" required name="startingDate" onchange="this.form.submit()" value="<?php echo ($startingDate != "") ? $startingDate : ''; ?>">
                        </div>
                        <div class="form-group mb-3">
                        <br>    
                        <label>to</label>
                        </div>
                        <div class="form-group me-5 col-lg-2">
                            <label>Ending Date</label>
                            <input type="date" class="form-control" id="endingDate" required name="endingDate" value="<?php echo ($endingDate != "") ? $endingDate : ''; ?>">
                        </div>
                    </div>
                    <!-- <div class="d-lg-flex mb-1 gap-3">
                        <div class="form-group mb-1 ">
                            <label for="totalQty">Credit Period (Days)</label>
                            <input type="number" class="form-control" id="totalQty" required name="totalQty" onchange="this.form.submit()" value="0">
                        </div>
                        <div class="form-group mb-1">
                            <label for="perDayQty">Finished Goods Unit Price rate(Rs)</label>
                            <input type="number" class="form-control" id="finishedPrice" required name="finishedPrice" onchange="this.form.submit()" value="0">
                        </div>
                        <div class="form-group mb-1">
                            <label for="perDayQty">Sample Goods Unit Price rate(Rs)</label>
                            <input type="number" class="form-control" id="samplePrice" required name="samplePrice" onchange="this.form.submit()" value="0">
                        </div>
                    </div> -->
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

