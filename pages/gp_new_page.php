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
    
    echo "selected buyer: ".$selectedBuyer;
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

        $colorQry = "SELECT * FROM style_colors WHERE orderNoID='$selectedOrder'";
        $colorResult = mysqli_query($conn, $colorQry);

        $sizeQry = "SELECT * FROM style_sizes WHERE orderNoID='$selectedOrder'";
        $sizeResult = mysqli_query($conn, $sizeQry);
    }

    //------------------ Fetch Active Vendors for Subcontractor Dropdown -------------------
    $vendorsQuery = "SELECT * FROM vendors WHERE status='Active'";
    $dataSetVendors = mysqli_query($conn, $vendorsQuery);
    
    $activeUser=$_SESSION['_UserID'];   

    //------------------ Handle Form Submission -------------------
    /*if(isset($_POST['btnSubmit'])){
        // Validate required fields
        if(empty($_POST['buyerid']) || empty($_POST['styleNo']) || empty($_POST['orderNo']) || empty($_POST['pieces']) || empty($_POST['vendorid']) || empty($_POST['typeid']) || empty($_POST['totalQty']) || empty($_POST['perDayQty']) || empty($_POST['startingDate']) || empty($_POST['endingDate'])){
            $message = "Please fill in all required fields.";
        } else {
            // Prepare and execute insert query
            $vendorid = $_POST['vendorid'];
            $typeid = $_POST['typeid'];
            $orderNo = $_POST['orderNo'];
            $pieces = $_POST['pieces'];
            $totalQty = $_POST['totalQty'];
            $perDayQty = $_POST['perDayQty'];
            $startingDate = $_POST['startingDate'];
            $endingDate = $_POST['endingDate'];
            $creditPeriod = $_POST['creditPeriod'];
            $finishedPrice = $_POST['finishedPrice'];
            $samplePrice = $_POST['samplePrice'];
            $status = "Active";            

            $insertQuery = "INSERT INTO `agreements`(vendorID, process, styleOrderID, pcsPerSet, contractTotalQty, dailyQty, startedDate, endDate, creditPeriod, unitPriceFg, unitPriceSample, Status, createdDT, createdBy) 
                            VALUES ('$vendorid','$typeid','$orderNo','$pieces','$totalQty','$perDayQty','$startingDate','$endingDate','$creditPeriod','$finishedPrice','$samplePrice','$status',NOW(),'$activeUser')";
            */
            /* INSERT INTO `gatepass`(`gatepassID_1`, `gatepassID_2`, `locationID`, `orderNoID`, `gatepassDate`, `vendorID`, `orderAgreement`, `status`, `cratedDT`, `createdBy`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]')
INSERT INTO `gatepass_details`(`id`, `gpID`, `cutNo`, `color`, `size`, `matQty`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]')
How to add autoincremented ‘gatepassID_1’ value into ‘gpID’ column and save concurrently. */

/*$conn->begin_transaction();

$sql1 = "INSERT INTO gatepass 
(locationID, orderNoID, gatepassDate, vendorID, orderAgreement, status, cratedDT, createdBy) 
VALUES ('$locationID','$orderNoID','$gatepassDate','$vendorID','$orderAgreement','$status','$createdDT','$createdBy')";

$conn->query($sql1);

$last_id = $conn->insert_id;

$sql2 = "INSERT INTO gatepass_details 
(gpID, cutNo, color, size, matQty) 
VALUES ('$last_id','$cutNo','$color','$size','$matQty')";

$conn->query($sql2);

$conn->commit();*/

            /*if(mysqli_query($conn, $insertQuery)){
                echo "<script>
                        setTimeout(function(){window.location.href = 'home_page.php?activity=agreements';}, 1000);
                    </script>";
                    exit();
            } else {
                $message = "Error creating agreement: " . mysqli_error($conn);
            }
        }
    }
*/
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
                            <input type="date" class="form-control" id="gatepassDate" required name="gatepassDate" onchange="calculateEndingDate();">
                    </div>
                    <!-- ---------------------------------------------------------------------------------------- -->

                    <!-- Have to load agreemtn no when select vendor -->
                    <div class="d-lg-flex mb-3  mt-2">
                        <div class="form-group col-md-4 me-3">
                            <label >Sub Contractor</label>
                            <select class="form-select" name="vendorid" id="vendorSelect" onchange="this.form.submit()"  >
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
                        <div class="form-group col-md-4 me-3 mt-1">
                            <label >Order Agreement No.</label>
                            <select class="form-select" name="vendorid" id="vendorSelect">
                                <option selected hidden></option>
                                <?php 
                                    if($selectedVendor != ""){
                                        while($vendor=mysqli_fetch_assoc($dataSetVendors)){
                                            ?>
                                            
                                            <option value="<?php echo $vendor['vendorID']; ?>" <?php if(isset($_POST['vendorid']) && $selectedVendor == $vendor['vendorID']) echo "selected";?>>
                                            <?php echo $vendor['vendor']?></option>
                                        <?php
                                        }
                                    }
                                    else{
                                        while($vendor=mysqli_fetch_assoc($dataSetVendors)){
                                            ?>
                                            <option value="<?php echo $vendor['vendorID']; ?>" 
                                            <?php if(isset($_POST['vendorid']) && $_POST['vendorid']==$vendor['vendorID']) echo "selected"; ?>>
                                            <?php echo $vendor['vendor']?></option>
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
                            <select class="form-select" name="colorid" id="color">
                                <option selected hidden></option>
                                <?php 
                                    while($color=mysqli_fetch_assoc($colorResult)){
                                        ?>
                                        <option value="<?php echo $color['colorID']; ?>" 
                                        <?php if(isset($_POST['colorid']) && $_POST['colorid']==$color['colorID']) echo "selected"; ?>>
                                        <?php echo $color['color']?></option>
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
                                            <option value="<?php echo $size['sizeID']; ?>" 
                                            <?php if(isset($_POST['sizeid']) && $_POST['sizeid']==$size['sizeID']) echo "selected"; ?>>
                                            <?php echo $size['size']?></option>
                                        <?php
                                        }
                                        ?>
                                </select>
                            </div>
                        </div>

                        <div class="d-lg-flex mb-1 gap-3">
                            <div class="form-group mb-1 col-3">
                                <label for="cutno">Cut No</label>
                                <input type="text" class="form-control" id="cutno" required name="cutno">
                            </div>
                            <div class="form-group mb-1 col-3 ">
                                <label for="matQty">Meterial Sets Quantity</label>
                                <input type="number" class="form-control" id="matQty" required name="matQty" value="0">
                            </div>
                        </div>
                                              

                        <div class="d-lg-flex justify-content-center mb-1 mt-3 gap-2">
                            <input type="submit" value="Save" class="btn btn-primary me-2 save_btn" name="btnSubmit"/>
                            <input type="button" value="Clear" class="btn btn-secondary save_btn" name="btnClear" onclick="window.location.href='home_page.php?activity=addagreement'"/>
                        </div>
                    </div>
                    <!-- --------------------------------------------------------------------------------------------------------------------- -->
                    
                </form>
            </div> 
    </div>
<!-- --------------------------------------------- JS Functions ----------------------------------------------------- -->
    <script>
    function resetStyleAndOrder() {
        document.getElementById('styleSelect').selectedIndex = 0;
        document.getElementById('orderSelect').innerHTML = '<option selected hidden></option>';
    }

    //------------------ Calculate Total Days -------------------
    function calcDays(){
        let totalQty = document.getElementById('totalQty').value;
        let perDayQty = document.getElementById('perDayQty').value;
        if(totalQty > 0 && perDayQty > 0){
            var days = Math.ceil(totalQty / perDayQty);
            document.getElementById('estimatedDays').innerText = "Estimated Days: " + days;
        } else {
            document.getElementById('estimatedDays').innerText = "Estimated Days: ";
        }
    }

    //------------------ Calculate Ending Date based on Starting Date and Total Days -------------------
    function calculateEndingDate(){
    let startDate = document.getElementById('startingDate').value;
    let totalQty = parseInt(document.getElementById('totalQty').value);
    let perDayQty = parseInt(document.getElementById('perDayQty').value);

    if(startDate && totalQty > 0 && perDayQty > 0){

        let days = Math.ceil(totalQty / perDayQty);

        let start = new Date(startDate);
        start.setDate(start.getDate() + (days - 1));

        let yyyy = start.getFullYear();
        let mm = String(start.getMonth() + 1).padStart(2, '0');
        let dd = String(start.getDate()).padStart(2, '0');

        let finalDate = yyyy + "-" + mm + "-" + dd;

        document.getElementById('endingDate').value = finalDate;
    }
}
</script>
</body>
</html>

