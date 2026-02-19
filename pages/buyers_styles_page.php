<?php
	include "../includes/db-con.php";
	
	$sqlQuery="SELECT S.styleNo AS STNO, S.styleName AS STNAME, S.buyerID AS BUYERID, B.buyerName AS BUYERNAME, S.createdBy AS CREATEDBY, DATE_FORMAT(S.createdDT,'%d-%m-%Y') AS DT, S.status AS STS FROM styles S JOIN buyer B ON S.buyerID=B.buyerID WHERE B.status='Active'";
	$returnDataSet=mysqli_query($conn,$sqlQuery);
	
	$activeUser=$_SESSION['_UserID'];

 ?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Styles</title>
</head>
<body>
    <div class="d-flex justify-content-between mb-3">
        <h4>Garment Styles Management</h4>
        <button type="submit" class="btn btn-primary me-2" name="btnAddStyle" onclick="window.location.href='home_page.php?activity=addstyle'">+ Add New Style</button> 
    </div>
    <div class="table-wrapper" style="overflow-x:auto;">
        <table class="table1 text-center" cellspacing="0" style="min-width: 100%;">
        	<tr>
                <th>Style No</th>
                <th>Style Name</th>
                <th>Buyer</th>
                <th>Created By</th>
                <th>Created Date</th>
                <th>Status</th>				
            </tr>
            <?php
			while($result1=mysqli_fetch_assoc($returnDataSet))
			{
			?>
            <tr>
            	<td><a href="home_page.php?activity=editStyle&selectedID=<?php echo $result1['STNO']?>"><?php echo $result1['STNO']?></a></td>
                <td><?php echo $result1['STNAME']?></td>
                <td><?php echo $result1['BUYERNAME']?></td>
                <td><?php echo $result1['CREATEDBY']?></td>
                <td><?php echo $result1['DT']?></td>
                <td><?php echo $result1['STS']?></td>			
            <tr>
            <?php
			}
			?>
        </table>
    </div>
</body>
</html>