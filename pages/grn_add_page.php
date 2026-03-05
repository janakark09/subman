<?php
	include "../includes/db-con.php";

    $no = 1;
    $recID="";
    $gpRef="";
    $gpDate="";
    $style="";
    $order="";
    $location="";
    $address="";
    $vendor="";
    $venAddrs="";
    $venTel="";
    $agreement="";
    $proQty="";
    $damQty="";
    $sampleQty="";
    $status="";
    $createdby="";
    $createddt="";
    // $approvedby="";
    // $approveddt="";
    
    $user="";
    $accConfirm=0;
    $message="";
    $saved=0;
    
    
    $slectedrecID=$_REQUEST['selectedID'];

    $recQuery="SELECT SP.recordID AS 'recID',Sp.gatepassRefID AS 'REF', SP.gatepassDate AS 'GPDATE', SO.styleNo AS 'STYLE', SO.orderNo AS 'ORDERNO', ML.location AS 'LOC', ML.address AS 'ADDR',
                V.vendor AS 'VEN',V.address AS 'VADDR',V.tel AS 'VTEL',V.fax AS 'VFAX',V.email AS 'VEMAIL', SP.orderAgreement AS 'AGREEMENT',SUM(PD.finishedQty) AS 'FINQTY',(SUM(PD.fabDamQty)+SUM(PD.processDamQty)) AS 'DAMQTY',SUM(PD.sampleQty) AS 'SMQTY', 
                SP.status AS 'STATUS', CONCAT(U.Fname,' ',U.Lname) AS 'CREATEDBY', DATE_FORMAT(SP.cratedDT,'%d/%m/%y') AS 'CREATEDDT', approvedBy AS 'APPROVED', DATE_FORMAT(SP.approvedDT,'%d/%m/%y') AS 'APPDT' 
                    FROM  sub_production SP JOIN sub_pro_details PD ON SP.recordID=PD.recID 
                    JOIN mast_location AS ML ON SP.locationID=ML.locationID  
                    JOIN styleorder AS SO ON SP.orderNoID=SO.id 
                    JOIN vendors AS V ON SP.vendorID=V.vendorID 
                    JOIN agreements AS AG ON SP.orderAgreement=AG.id 
                    JOIN users AS U ON SP.createdBy=U.User_ID WHERE SP.recordID='$slectedrecID'";
                    
    $selectedData=mysqli_query($conn,$recQuery);
    if($selectedData && mysqli_num_rows($selectedData)==1)
        {
            $rowData=mysqli_fetch_assoc($selectedData);
            $recID=$rowData['recID'];
            $gpRef=$rowData['REF'];
            $gpDate=$rowData['GPDATE'];
            $style=$rowData['STYLE'];
            $order=$rowData['ORDERNO'];
            $location=$rowData['LOC'];
            $address=$rowData['ADDR'];
            $vendor=$rowData['VEN'];
            $venAddrs=$rowData['VADDR'];
            $venTel=$rowData['VTEL'];
            $venFax=$rowData['VFAX'];
            $venEmail=$rowData['VEMAIL'];
            $agreement=$rowData['AGREEMENT'];
            $proQty=$rowData['FINQTY'];
            $damQty=$rowData['DAMQTY'];
            $sampleQty=$rowData['SMQTY'];
            $status=$rowData['STATUS'];
            $createdby=$rowData['CREATEDBY'];
            $createddt=$rowData['CREATEDDT'];
            // $approvedby=$rowData['APPROVED'];
            // $approveddt=$rowData['APPDT'];
            // $tel=$rowData['TEL'];
            // $person=$rowData['CONP'];
        }
    
    $detailsQuery="SELECT PD.cutNo AS 'CUT',C.color AS 'COLOR',S.size AS 'SIZE', PD.finishedQty AS 'FQTY', PD.recFnishedQty AS 'RECFQTY', PD.processDamQty AS 'DQTY', PD.recDamQty AS 'RECDQTY', PD.sampleQty AS 'SQTY', PD.recSampleQty AS 'RECSQTY' FROM sub_pro_details PD 
                JOIN style_colors C ON PD.colorID=C.colorID JOIN style_sizes S ON PD.sizeID=S.sizeID  WHERE PD.recID='$slectedrecID'";

    $detailsData=mysqli_query($conn,$detailsQuery);

	$activeUser=$_SESSION['_UserID'];

    $userQuery="SELECT CONCAT(U.Fname,' ',U.Lname) AS 'CURRENTU', UD.acc10 AS 'APP1' FROM users U JOIN user_details UD ON U.User_ID=UD.User_ID WHERE U.User_ID='$activeUser'";
    $userData=mysqli_query($conn,$userQuery);
    if($userData && mysqli_num_rows($userData)==1)
        {
            $rowData=mysqli_fetch_assoc($userData);
            $user=$rowData['CURRENTU'];
            $accConfirm=$rowData['APP1'];

        }
    if(isset($_POST['btnSave']))
        {
            $recFQty=$_POST['recFQty'];
            $recDQty=$_POST['recDQty'];
            $recSQty=$_POST['recSQty'];
            $updateRecQuery="INSERT INTO grn_details(grnCode2, proRecNo, locationID, invoiceDate, invoiceNo, fgUnitPrice, fgValue, sampleUnitPrice, 
                        sampleValue, createdDT, createdBy, status) 
                        VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]',
                        '[value-11]','[value-12]','[value-13]','[value-14]','[value-15]','[value-16]','[value-17]')";
            $updateRec=mysqli_query($conn,$updateRecQuery);
            if($updateRec)
                {
                    for($i=0;$i<count($recFQty);$i++)
                        {
                            //echo $recFQty[$i]."-".$recDQty[$i]."-".$recSQty[$i]."<br>";
                            $updateDetailsQuery="UPDATE sub_pro_details SET recFnishedQty='$recFQty[$i]', recDamQty='$recDQty[$i]', recSampleQty='$recSQty[$i]' WHERE recID='$recID' LIMIT 1 OFFSET $i";
                            mysqli_query($conn,$updateDetailsQuery);
                        }
                    $message="Record Saved Successfully!";
                    $saved=1;
                }
            else
                {
                    $message="Error Saving Record!";
                }
        }
 ?>
 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production view</title>

    <!--bootstrap-->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>

		<!--Font-awsome-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<!--Google Font Family-->
		<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Merienda:wght@300..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../assets/css/style.css"/>
    

</head>
<body>
    <div class="w-100">
        <form method="POST">
            <div class="report-container">
                <div class="w-100 report-content">
                    <div class="mb-5">
                        <h4>Goods Received Note (GRN)</h4>  
                    </div>
                                <!-- <div><h3 class="text-center title mb-2">GOODS RECEIVED NOTE</h3></div> -->
                                <div class="row no-wrap1">
                                    <div class="col-md-6 ps-4 mb-3">
                                        <table class="w-100" style="border:1px;">
                                            <tbody>
                                                <tr><td>Record No.</td><td>:</td><td> <?php echo $recID;?></td></tr>
                                                <tr><td>Subcontractor</td><td>:</td><td> <?php echo $vendor;?></td></tr>
                                                <tr><td>Address</td><td>:</td><td> <?php echo $venAddrs;?></td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6 ps-4 mb-3">
                                        <table class="w-100" style="border:1px;">
                                            <tbody>
                                                <tr><td>Finished Date</td><td>:</td><td> <?php echo $gpDate;?></td></tr>
                                                <tr><td>Ref. No.</td><td>:</td><td> <?php echo $gpRef;?></td></tr>
                                                <tr><td>Entered By</td><td>:</td><td> <?php echo $createdby;?></td></tr>
                                                <tr><td>Entered Date/Time</td><td>:</td><td> <?php echo $createddt;?></td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <hr>
                                <!---------------------------------- Buyer Style Order Section -------------------------------------- -->

                                <div style="height:50px; font-family: times-new-roman;"><h4 class="text-center mt-3"><u>Order Details</u></h4></div>
                                <div class="row text-center">
                                    <div class="col ps-4">
                                        <table class="w-100 table">
                                            <tr>
                                                <th>Style No.</th>
                                                <th>Order No.</th>
                                                <th>Agr. No</th>
                                                <th>Total(Finished)</th>
                                                <th>Total(Damages)</th>
                                                <th>Total(Sample)</th>
                                            </tr>
                                            <tr>
                                                <td><?php echo $style;?></td>
                                                <td><?php echo $order;?></td>
                                                <td><?php echo $agreement;?></td>
                                                <td><?php echo $proQty;?></td>
                                                <td><?php echo $damQty;?></td>
                                                <td><?php echo $sampleQty;?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="d-lg-flex mt-3 mb-3 gap-3" >
                                    <div class="form-group col-lg-2">
                                        <label>Invoice Date</label>
                                        <input type="date" class="form-control" id="invDate" required name="invDate" 
                                        value="<?php echo isset($_POST['invDate']) ? $_POST['inveDate']: '';?>">
                                    </div>
                                    <div class="form-group mb-1 col-3">
                                            <label for="invno">Invoice No.</label>
                                            <input type="text" class="form-control" id="invno" name="invno">
                                        </div>
                                </div>

                                <div class="d-lg-flex mt-3 mb-3 gap-3" >
                                    <div class="form-group mb-1 col-2">
                                        <label for="finUprice">Finished good Unit Price</label>
                                        <input type="number" class="form-control" id="finUprice" name="finUprice">
                                    </div>
                                    <div class="form-group mb-1 col-2">
                                        <label for="samUprice">Sample Unit Price</label>
                                        <input type="number" class="form-control" id="samUprice" name="samUprice">
                                    </div>
                                </div>
                                <!---------------------------------- Item Details Section -------------------------------------- -->

                                <div style="height:50px; font-family: times-new-roman;"><h4 class="text-center mt-5"><u>Parts Details</u></h4></div>
                                <div class="row text-center">
                                    <div class="col ps-4 table-responsive">
                                        <table class="w-100 table1" style="min-width:100%;">
                                            <tr>
                                                <th>No.</th>
                                                <th>Cut No.</th>
                                                <th>Color.</th>
                                                <th>Size</th>
                                                <th>Finished</th>
                                                <th class="tbl-num-cell">Received Finished</th>
                                                <th>Damages</th>
                                                <th class="tbl-num-cell">Received Damages</th>
                                                <th>Samples</th>
                                                <th class="tbl-num-cell">Received Samples</th>
                                            </tr>
                                            <?php
                                            while($details=mysqli_fetch_assoc($detailsData))
                                                {
                                            ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $details['CUT'];?></td>
                                                <td><?php echo $details['COLOR'];?></td>
                                                <td><?php echo $details['SIZE'];?></td>
                                                <td><?php echo $details['FQTY'];?></td>
                                                <td class="tbl-num-cell"><input class="form-control text-end" type="text" name="recFQty[]" value="<?php echo $details['RECFQTY'];?>" /></td>
                                                <td><?php echo $details['DQTY'];?></td>
                                                <td class="tbl-num-cell"><input class="form-control text-end" type="text" name="recDQty[]" value="<?php echo $details['RECDQTY'];?>" /></td>
                                                <td><?php echo $details['SQTY'];?></td>
                                                <td class="tbl-num-cell"><input class="form-control text-end" type="text" name="recSQty[]" value="<?php echo $details['RECSQTY'];?>" /></td>
                                            </tr>
                                            <?php
                                                }
                                            ?>
                                            <tr>
                                                <td class="dark-cell" colspan="4">Total</td>
                                                <td class="dark-bg-cell"><?php echo $proQty;?></td>
                                                <td class="dark-bg-cell"></td>
                                                <td class="dark-bg-cell"><?php echo $damQty;?></td>
                                                <td class="dark-bg-cell"></td>
                                                <td class="dark-bg-cell"><?php echo $sampleQty;?></td>
                                                <td class="dark-bg-cell"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                
                                <div class="row justify-content-center gap-3 mt-5 no-print">
                                    <hr>
                                    <?php
                                        if($accConfirm==1 && $status!="Primary" && $saved==0)
                                         {
                                        ?>
                                            <input type="submit" class="btn btn-primary save_btn" value="Save" name="btnSave" id="btnSave"/>
                                        <?php
                                        }
                                        if($saved==1 && $status!="Approved")
                                         {
                                        ?>
                                            <button type="button" class="btn btn-success save_btn" onclick="window.print()">Print</button>
                                        <?php
                                         }
                                    ?><button type="button" class="btn btn-secondary save_btn" onclick="window.location.href='home_page.php?activity=grnAll'">Close</button>
                                </div>
                </div>
                
            </div>
        </form>
    
    <div class="container text-center" >
        <label class="text-danger"><?php echo $message?></label>
    </div>
    </div>
    

</body>
</html>
