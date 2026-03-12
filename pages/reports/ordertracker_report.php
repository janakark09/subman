    <?php
	include "../includes/db-con.php";

    $selectedBuyer = "";
    $selectedStyle = "";
    $selectedOrder = "";
    $message="";
    $allgrnQuery="";

    $allgrnQuery="SELECT GD.grnCode1 AS 'CODE1',CONCAT(GD.grnCode2,'/',GD.grnCode1) AS 'CODE2',SP.recordID AS 'PROID',SO.styleNo AS 'STYLE',SO.orderNo AS 'ORDERNO', 
                DATE_FORMAT(GD.invoiceDate,'%d/%m/%y') AS 'INVDATE',GD.recFnishedQty AS 'RECFQTY', V.vendor AS 'VEN',GD.recDamQty AS 'RECDQTY',GD.recSampleQty AS 'RECSQTY', 
                (GD.fgValue+GD.sampleValue+GD.vat) AS 'GRNVAL', DATE_FORMAT(GD.createdDT,'%d/%m/%y') AS 'GRNDATE', CONCAT(U.Fname, ' ', U.Lname) AS 'GRNBY', GD.status AS 'STATUS'
                FROM grn_details GD JOIN sub_production SP ON GD.proRecNo=SP.recordID JOIN styleorder SO ON SP.orderNoID=SO.id 
                JOIN mast_location ML ON SP.locationID=ML.locationID JOIN vendors V ON SP.vendorID=V.vendorID JOIN users U ON SP.createdBy=U.User_ID";

    $returnAll=mysqli_query($conn,$allgrnQuery);
    
    if(isset($_POST['btnAll']))
        {
            $returnAll=mysqli_query($conn,$allgrnQuery);
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

    if(isset($_POST['orderNo']))
    {
        $selectedOrder=$_POST['orderNo'];
    }

    if(isset($_POST['btnSearch']) && $selectedOrder!=""){
        //echo $selectedOrder;
        $srchQry=$allQuery." WHERE SP.orderNoID='$selectedOrder' ";
        $returnAll=mysqli_query($conn,$srchQry);
    }
    elseif(isset($_POST['btnSearch']) && $selectedOrder=="")
        {
            $message = "All production records Loaded. *Please select a Order No to search.";
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
                    <div class="d-lg-flex mb-3">
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
                        <div class="form-group col-md-4 me-5">
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

                <div class="form-group col-lg-2">
                            <label>From Date</label>
                            <input type="date" class="form-control" id="fromDate" required name="fromDate" value="<?php echo isset($_POST['fromDate']) ? $_POST['fromDate'] : ''; ?>" onchange="this.form.submit()"/>
                        </div>
                        <div class="form-group col-lg-2">
                            <label>To Date</label>
                            <input type="date" class="form-control" id="toDate" required name="toDate" value="<?php echo isset($_POST['toDate']) ? $_POST['toDate'] : ''; ?>" onchange="this.form.submit()"/>
                        </div>
                            <div class="form-group col-md-4 me-3 ms-5">
                                <br>
                                <input type="button" value="Clear" class="btn btn-secondary save_btn" name="btnClear" onclick="window.location.href='home_page.php?activity=payList'"/>
                            </div> 
                        </div>
                        <div class="form-group col-md-4 me-3">
                                <label >Vendor</label>
                                <select class="form-select" name="vendorid" id="vendorSelect" onchange="this.form.submit()"  >
                                    <option selected >All</option>
                                    <?php 
                                        while($vendor=mysqli_fetch_assoc($returnDataSet1)){
                                            ?>
                                            <option value="<?php echo $vendor['vendorID']; ?>" 
                                            <?php if(isset($_POST['vendorid']) && $_POST['vendorid']==$vendor['vendorID']) echo "selected"; ?>>
                                            <?php echo $vendor['vendor']?></option>
                                        <?php
                                        }
                                        ?>
                                </select>
                        </div>
                        <div class="form-group col-md-4 me-3 ms-5">
                            <br>
                            <button type="Search" class="btn btn-primary me-2 save_btn" name="btnSearch" id="btnSearch">Search</button>
                            <button type="All" class="btn btn-primary me-2 save_btn" name="btnAll" id="btnAll" onclick="resetStyleAndOrder()">All</button>
                        </div>
        </div>
        
    <div class="table-wrapper">
        <table class="table1 text-center" cellspacing="0" style="font-size: 9pt;">
        	<tr class="table-header">
                <th hidden></th>
                <th>GRN No.</th>
            	<th>Product. ID</th>
                <th>Style</th>
                <th>Order</th>
                <th>Invoice Date</th>
                <th>Vendor</th>
                <th>Finished Qty.</th>
                <th>Damage Qty.</th>
                <th>Sample Qty.</th>
                <th>GRN Value</th>
                <th>Status</th>
                <th>Created Date</th>
                <th>Created By</th>
                <th>View</th>			
            </tr>
            <?php
            try{
                while($result1=mysqli_fetch_assoc($returnAll))
                {
                    ?>
                    <tr class="flex align-items-center">
                        <td hidden><input type="text" name="grnID" value="<?php echo $result1['CODE1']; ?>"></td> 
                        <td class="text-center"><?php echo $result1['CODE2']; ?></td>
                        <td><?php echo $result1['PROID']?></td>
                        <td><?php echo $result1['STYLE']?></td>
                        <td><?php echo $result1['ORDERNO']?></td>
                        <td ><?php echo $result1['INVDATE']?></td>
                        <td><?php echo $result1['VEN']?></td>
                        <td><?php echo $result1['RECFQTY']?></td>
                        <td><?php echo $result1['RECDQTY']?></td>
                        <td><?php echo $result1['RECSQTY']?></td>
                        <td class="decimal-data"><?php echo $result1['GRNVAL']?></td>
                        <td><?php echo $result1['STATUS']?></td>
                        <td><?php echo $result1['GRNDATE']?></td>
                        <td><?php echo $result1['GRNBY']?></td>
                        <td class="text-center"><?php 
                                $selected= $result1['CODE1'];
                                $url = 'grn_view_page.php?activity=grnView&Criteria=Grn&selectedID= '.$selected;
                                echo '<a href="' . htmlspecialchars($url) . '" target="_blank" rel="noopener noreferrer">View</a>';
                        ?></td> 
                    </tr>
                    <?php
                }
            }
            catch(Exception $e){
                echo "Error: " . $e->getMessage();
            }
			?>
        </table>
    </div> 
    <!-- <div class="d-lg-flex justify-content-center mb-5 mt-3 gap-2">
        <input type="submit" value="Save" class="btn btn-primary me-2 save_btn" name="btnSave"/>
        <input type="button" value="Clear" class="btn btn-secondary save_btn" name="btnClear" onclick="window.location.href='home_page.php?activity=grnAll'"/>
    </div> -->
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
