    <?php
	include "../includes/db-con.php";

    $selectedVendor = "";
    $selectedStyle = "";
    $selectedOrder = "";
    $message="";
    $allgrnQuery="";

    $allpayQuery="SELECT P.receiptID AS 'ID', DATE_FORMAT(P.Date,'%d/%m/%y') AS 'DATE', V.vendor AS 'VEN', P.netValue AS 'NETVAL', CONCAT(U.Fname,' ',U.Lname) AS 'USER',
                 DATE_FORMAT(P.createdDT,'%d/%m/%y') AS 'CREATEDDT',P.Status AS 'STATUS' FROM payments P 
                 JOIN payment_methods PM ON P.payMenthod=PM.methodID JOIN vendors V ON P.VendorID=V.vendorID
                 JOIN users U ON P.createdBy=U.User_ID";

    $returnAll=mysqli_query($conn,$allpayQuery);

    //------------------ Fetch Payment Records based on Date Range -------------------
    if(isset($_POST['fromDate']) && isset($_POST['fromDate'])!="" && $_POST['fromDate'] > $_POST['toDate']){
        $fromDate = $_POST['fromDate'];
        $allpayQuery .= " AND P.Date >= '$fromDate'";
        // echo $allpayQuery;
        $returnAll=mysqli_query($conn,$allpayQuery);
    }
    if(isset($_POST['toDate']) && isset($_POST['toDate'])!="" && $_POST['toDate'] > $_POST['fromDate']){
        $toDate = $_POST['toDate'];
        $allpayQuery .= " AND P.Date <= '$toDate'";
        $returnAll=mysqli_query($conn,$allpayQuery);
    }
    //------------------ Fetch Vendor Name -------------------
    $sqlQuery1="SELECT * FROM  vendors WHERE status='Active'";
    $returnDataSet1=mysqli_query($conn,$sqlQuery1);

    //------------------ Fetch Selected Vendor -------------------
    if(isset($_POST['vendorid']))
    {
        $selectedVendor=$_POST['vendorid'];
    }
    if($selectedVendor != "" && $selectedVendor != "All"){
         $srchQry=$allpayQuery." WHERE P.VendorID='$selectedVendor' ";
        $returnAll=mysqli_query($conn,$srchQry);
    }
    else{
        $returnAll=mysqli_query($conn,$allpayQuery);
    }

    $activeUser=$_SESSION['_UserID'];

    //------------------ Delete Payment -------------------
        if(isset($_POST['btnDelete'])){
            $deleteID = $_POST['deleteID'];

            $removePayID="UPDATE  grn_details SET receiptID=NULL WHERE receiptID='$deleteID'";
            $removeResult = mysqli_query($conn,$removePayID);

            if($removeResult){
                $deleteQry = "DELETE FROM payments WHERE receiptID='$deleteID'";
                $deleteResult = mysqli_query($conn,$deleteQry);

                if($deleteResult){
                    
                    $message = "Payment record ".$deleteID." deleted successfully.";
                    $returnAll=mysqli_query($conn,$allpayQuery);
                }else{
                    $message = "Error deleting record.";
            }   
            }
        }

 ?>
 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment List</title>
</head>
<body>
    <div class="d-flex justify-content-between mb-3">
        <h4>Payment Receipt List</h4>
        <button class="btn btn-primary me-2" name="btnAdd" onclick="window.location.href='home_page.php?activity=payAdd'">+ New Payment </button> 
    </div>
    <form method="POST">
        <div class="container-fluid">
            <!---------------------------------- Buyer Style Order Section -------------------------------------- -->
            <div class="d-lg-flex mb-3">
                    <div class="form-group col-lg-2">
                        <label>From Date</label>
                        <input type="date" class="form-control" id="fromDate" name="fromDate" value="<?php echo isset($_POST['fromDate']) ? $_POST['fromDate'] : ''; ?>" onchange="this.form.submit()"/>
                    </div>
                    <div class="form-group col-lg-2">
                        <label>To Date</label>
                        <input type="date" class="form-control" id="toDate" name="toDate" value="<?php echo isset($_POST['toDate']) ? $_POST['toDate'] : ''; ?>" onchange="this.form.submit()"/>
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
                            
            <div class="table-wrapper mt-5">
                <table class="table1 text-center" cellspacing="0" style="font-size: 9pt; min-width: 100%;">
                    <tr class="table-header">
                        <th>Receipt No.</th>
                        <th>Payment Date</th>
                        <th>Net Value</th>
                        <th>Vendor</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Created By</th>
                        <th>View</th>	
                        <th>Delete</th>			
                    </tr>
                    <?php
                    try{
                        while($result1=mysqli_fetch_assoc($returnAll))
                        {
                            ?>
                            <tr class="flex align-items-center">
                                <td><a><?php echo $result1['ID'];?></a></td> 
                                <td><?php echo $result1['DATE'];?></td>
                                <td class="decimal-data"><?php echo $result1['NETVAL'];?></td>
                                <td><?php echo $result1['VEN'];?></td>
                                <td ><?php echo $result1['STATUS'];?></td>
                                <td><?php echo $result1['CREATEDDT'];?></td>
                                <td><?php echo $result1['USER'];?></td>
                                <td class="text-center"><?php 
                                        $selected= $result1['ID'];
                                        $url = 'payment_view_page.php?activity=payView&selectedID= '.$selected;
                                        echo '<a href="' . htmlspecialchars($url) . '" target="_blank" rel="noopener noreferrer">View</a>';
                                ?></td>
                                <td class="text-center">
                                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this payment?');">
                                        <input type="hidden" name="deleteID" value="<?php echo $result1['ID']; ?>">
                                        <button type="submit" name="btnDelete" style="border:none;background:none;color:red;">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
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
        </div> 
    </form>
    <div class="container text-center mt-3" >
        <label class="text-danger"><?php echo "*".$message?></label>
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
