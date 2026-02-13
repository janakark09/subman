<?php
	include "../includes/db-con.php";
	
	$sqlQuery="SELECT agr.id as ID,ven.vendor AS VENDOR,pt.processType AS PROCESS,so.styleNo AS STYLENO,so.orderNo AS ORDERNO,agr.contractTotalQty AS TOTAL_QTY,
    agr.dailyQty AS DAILY_QTY,agr.startedDate AS SDATE,agr.endDate AS EDATE,agr.Status AS STAT,DATE_FORMAT(agr.createdDT,'%d/%m/%Y') AS CREATED 
    FROM agreements AS agr 
    JOIN vendors AS ven ON agr.vendorID = ven.vendorID 
    JOIN process_type AS pt ON agr.process = pt.typeid 
    JOIN styleorder AS so ON agr.styleOrderID = so.id 
    JOIN users AS u ON agr.createdBy = u.User_ID;";

	$returnDataSet=mysqli_query($conn,$sqlQuery);
	
	$activeUser=$_SESSION['_UserID'];

 ?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Agreements</title>
</head>
<body>
    <div class="d-flex justify-content-between mb-3">
        <h4>All Subcontract Agreements</h4>
        <button type="submit" class="btn btn-primary me-2" name="btnAddVen" onclick="window.location.href='home_page.php?activity=addagreement'">+ Add New Agreement</button> 
    </div>
    <div  class="table-wrapper">
        <table class="table1 text-center" cellspacing="0">
        	<tr>
                <th>Agreement ID</th>
            	<th>Vendor Name</th>
                <th>Process</th>
                <th>Style No</th>
                <th>Order No</th>
                <th>Contract Total Qty(Sets)</th>
                <th>Daily Qty</th>
                <th>Started Date</th>
                <th>Ending Date</th>
                <th>Status</th>
                <th>created Date</th>	
                <th></th>				
            </tr>
            <?php
			while($result1=mysqli_fetch_assoc($returnDataSet))
			{
			?>
            <tr>
            	<td>
                <a href="DashBoard.php?activity=editAgreement&selectedID=<?php echo $result1['ID']?>"><?php echo $result1['ID']?></a>
                </td>
                <td><?php echo $result1['VENDOR']?></td>
                <td><?php echo $result1['PROCESS']?></td>
                <td><?php echo $result1['STYLENO']?></td>
                <td><?php echo $result1['ORDERNO']?></td>
                <td><?php echo $result1['TOTAL_QTY']?></td>
                <td><?php echo $result1['DAILY_QTY']?></td>
                <td><?php echo $result1['SDATE']?></td>
                <td><?php echo $result1['EDATE']?></td>
                <td><?php echo $result1['STAT']?></td>
                <td><?php echo $result1['CREATED']?></td>
                <td><a href="DashBoard.php?activity=viewAgr&Criteria=Agreement&selectedID=<?php echo $result1['ID']?>">View</a></td>
            <tr>
            <?php
			}
			?>
        </table>
    </div>
</body>
</html>