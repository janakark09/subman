    <?php
	include "../includes/db-con.php";

    $selectedBuyer = "";
    $selectedStyle = "";
    $selectedOrder = "";
    $selectedLoc="";
    $selectedVendor="";
    $fromDate="";
    $toDate="";
    $selection1="";
    $message="";

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

    if(isset($_POST['orderNo']))
    {
        $selectedOrder=$_POST['orderNo'];
    }

    //------------------ Fetch Location -------------------
    $locationQuery="SELECT * FROM  mast_location WHERE status='Active'";
	$locationDataSet=mysqli_query($conn,$locationQuery);

    //------------------ Fetch Vendor Name -------------------
    $vendorQuery="SELECT * FROM  vendors WHERE status='Active'";
    $vendorDataSet=mysqli_query($conn,$vendorQuery);

    if(isset($_POST['btnView'])){
        $selectedBuyer=$_POST['buyerid'];
        $selectedStyle=$_POST['styleNo'];
        $selectedOrder=$_POST['orderNo'];
        $selectedLoc=$_POST['locationid'];
        $selectedVendor=$_POST['vendorid'];
        $fromDate=$_POST['fromDate'];
        $toDate=$_POST['toDate'];
        $selection1=$_POST['selection1'];

        echo  $selectedBuyer."-".$selectedStyle."-".$selectedOrder."-".$selectedLoc."-".$selectedVendor."-".$fromDate."-".$toDate."-".$selection1;

        $url = 'ordertracker_report_view.php?activity=ordertrackerView&Criteria=Grn&buyer= '.$selectedBuyer.'&style= '.$selectedStyle.'&order= '.$selectedOrder.'&location= '.$selectedLoc.'&vendor= '.$selectedVendor.'&fromDate= '.$fromDate.'&toDate= '.$toDate.'&selection1= '.$selection1;
        // echo '<a href="' . htmlspecialchars($url) . '" target="_blank" rel="noopener noreferrer">View</a>';
        echo "<script>
            setTimeout(function(){window.open('" . htmlspecialchars($url)."', '_blank');}, 1000);
        </script>";
    }

    $activeUser=$_SESSION['_UserID'];

 ?>
 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report1</title>
</head>
<body>
    <div class="d-flex justify-content-between mb-3">
        <h4>Order Tracker Report</h4>
    </div>
    <form method="POST">
        <div class="container-fluid">
            <!---------------------------------- Buyer Style Order Section -------------------------------------- -->
                    <div class="d-lg-flex mb-3">
                        <div class="form-group col-md-4 me-3">
                            <label >Buyer</label>
                            <select class="form-select" name="buyerid" id="buyerSelect" onchange="resetStyleAndOrder(); this.form.submit()"  >
                                <option selected>All</option>
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
                        <div class="form-group col-md-4 me-3">
                            <label >Style No.</label>
                            <select class="form-select" name="styleNo" id="styleSelect" onchange="this.form.submit()">
                                <option selected>All</option>
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
                        <div class="form-group col-md-4 me-5">
                            <label >Order No.</label>
                            <select class="form-select" name="orderNo" id="orderSelect" onchange="this.form.submit()">
                                <option selected>All</option>
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
                    <div class="d-lg-flex mb-3">
                        <div class="form-group col-md-4 me-3">
                            <label >Location</label>
                            <select class="form-select" name="locationid" id="locationSelect1">
                                <option selected>All</option>
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
                        <div class="form-group col-md-4 me-3">
                                <label >Subcontractor</label>
                                <select class="form-select" name="vendorid" id="vendorSelect"  >
                                    <option selected >All</option>
                                    <?php 
                                        while($vendor=mysqli_fetch_assoc($vendorDataSet)){
                                            ?>
                                            <option value="<?php echo $vendor['vendorID']; ?>" 
                                            <?php if(isset($_POST['vendorid']) && $_POST['vendorid']==$vendor['vendorID']) echo "selected"; ?>>
                                            <?php echo $vendor['vendor']?></option>
                                        <?php
                                        }
                                        ?>
                                </select>
                        </div>
                    </div>
                    <div class="d-lg-flex mb-3 gap-3">
                        <div class="form-group col-lg-2">
                            <label>From Date</label>
                            <input type="date" class="form-control" id="fromDate" required name="fromDate" value="<?php echo isset($_POST['fromDate']) ? $_POST['fromDate'] : ''; ?>" onchange="this.form.submit()"/>
                        </div>
                        <div class="form-group col-lg-2">
                            <label>To Date</label>
                            <input type="date" class="form-control" id="toDate" required name="toDate" value="<?php echo isset($_POST['toDate']) ? $_POST['toDate'] : ''; ?>" onchange="this.form.submit()"/>
                        </div>
                    </div> 
                    <div class="mb-3 gap-3 mt-5 bg-light p-3 col-3 rounded border">
                        <div class="form-group">
                            <input type="radio" class="form-check-input" name="selection1" id="selection1" value="Gate pass" <?php if(isset($_POST['selection1']) && $_POST['selection1']=="Gate pass") echo "checked"; ?>>
                            <label for="selection1">Gate Passes</label>
                        </div>
                        <div class="form-group">
                            <input type="radio" class="form-check-input" name="selection1" id="selection2" value="Production Records" <?php if(isset($_POST['selection1']) && $_POST['selection1']=="Production Records") echo "checked"; ?>>
                            <label for="selection2">Production Records</label>
                        </div>
                        <div class="form-group">
                            <input type="radio" class="form-check-input" name="selection1" id="selection3" value="GRN" <?php if(isset($_POST['selection1']) && $_POST['selection1']=="GRN") echo "checked"; ?>>
                            <label for="selection3">GRN</label>
                        </div>
                        <div class="form-group">
                            <input type="radio" class="form-check-input" name="selection1" id="selection4" value="Payments" <?php if(isset($_POST['selection1']) && $_POST['selection1']=="Payments") echo "checked"; ?>>
                            <label for="selection4">Payments</label>
                        </div>
                    </div>
                    <div class="container-fluid mb-3 gap-3">
                        <div class="d-flex justify-content-center align-items-center">
                            <br>
                            <?php
                                $url = './reports/ordertracker_report_view.php?activity=ordertrackerView'
                                    .'&Criteria=Grn'
                                    .'&selectedID='."1"
                                    .'&buyer='.urlencode($selectedBuyer)
                                    .'&style='.urlencode($selectedStyle)
                                    .'&order='.urlencode($selectedOrder)
                                    .'&location='.urlencode($selectedLoc)
                                    .'&vendor='.urlencode($selectedVendor)
                                    .'&fromDate='.urlencode($fromDate)
                                    .'&toDate='.urlencode($toDate)
                                    .'&selection1='.urlencode($selection1);

                                echo '<a href="' . htmlspecialchars($url) . '" target="_blank" rel="noopener noreferrer">
                                        <button type="button" class="btn btn-primary me-2 save_btn">View</button>
                                </a>';
                                ?>
                            <input type="submit" class="btn btn-primary me-2 save_btn" name="btnView" id="btnView" value="View"/>
                            <input type="button" value="Clear" class="btn btn-secondary save_btn" name="btnClear" onclick="window.location.href='home_page.php?activity=rptOrderTrack'"/>
                        </div>
                    </div>                    
                        
        </div>
    </form>
    <div class="container text-center" >
        <label class="text-danger"><?php echo $message?></label>
    </div>
    <script>
    function resetStyleAndOrder() {
        document.getElementById('styleSelect').selectedIndex = 0;
        document.getElementById('orderSelect').innerHTML = '<option selected hidden></option>';
    }
    let cells = document.querySelectorAll(".decimal-data");
        cells.forEach(function(cell) {
        let number = Number(cell.textContent);
        cell.textContent = number.toLocaleString('en-US', {
            style: 'decimal',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    });
</script>
</body>
</html>
