<?php
	include "../includes/db-con.php";
    $message="";
    $returnDataSet2 = "";
    $selectedBuyer = "";

    if(isset($_POST['buyerid']))
    {
        $selectedBuyer=$_POST['buyerid'];
    }

    //------------------ Fetch Buyer Name and Style Nos -------------------
    $sqlQuery1="SELECT * FROM  buyer WHERE status='Active'";
	$returnDataSet1=mysqli_query($conn,$sqlQuery1);

	$activeUser=$_SESSION['_UserID'];
    
    //------------------ Insert New Vendor --------------------------------
    if(isset($_POST['btnSubmit']))
    {
        $styleno=$_POST['styleNo'];
        $stylename=$_POST['styleName'];
        $buyerid=$_POST['buyerid'];
        $status=$_POST['status'];

        $query_stylechk="SELECT COUNT(styleNo) FROM styles WHERE buyerID='$buyerid' AND styleNo='$styleno'";
		$result_stylechk=mysqli_query($conn,$query_stylechk);
		$chk=mysqli_fetch_assoc($result_stylechk);
		$chk_count= $chk['COUNT(styleNo)'];
        
        if($chk_count==0)
        {
            
            $insertQuery="INSERT INTO styles(styleNo, styleName, buyerID, createdDT, createdBy, status) 
                           VALUES ('$styleno','$stylename','$buyerid',NOW(),'$activeUser','$status')";
                
                    $result1=mysqli_query($conn, $insertQuery);
        
                    if($result1)
                    {
                        $message="Garment Style added successfully.";
                    }
                    else
                    {
                        $message="Error adding Style: " . mysqli_error($conn);
                    }
                    echo "<script>
                        setTimeout(function(){window.location.href = 'home_page.php?activity=styles';}, 1000);
                    </script>";
                    exit();
        }
        else
        {
            $message="This Style Number already exists. Please enter a different Style No: ".$styleno;  
        }
        
    }

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Styles</title>
</head>
<body>
    <div class="container-fluid">
            <div class="mb-5">
                <h4>Add New Garment Style</h4>  
            </div>
            <div>
                <form method="post">
                    <div class="form-group col-md-4 me-3">
                            <label >Buyer</label>
                            <select class="form-select" name="buyerid" id="buyerSelect" onchange="this.form.submit()"  >
                                <option selected hidden></option>
                                <?php 
                                    while($buyer=mysqli_fetch_assoc($returnDataSet1)){
                                        ?>
                                        <option value="<?php echo $buyer['buyerID']; ?>" <?php if(isset($_POST['buyerid']) && $_POST['buyerid']==$buyer['buyerID']) echo "selected"; ?>><?php echo $buyer['buyerName']?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                    </div>
                                       
                    <div class="form-group mb-1">
                        <label for="styleNo">Style No</label>
                        <input type="text" class="form-control" id="styleNo" name="styleNo" required >
                    </div>
                    <div class="form-group mb-1">
                        <label for="styleName">Style Name</label>
                        <input type="text" class="form-control" id="styleName" name="styleName" required >
                    </div>
                <!-- ------------------------------------------- -->
                    <div class="form-row mb-2">
                        <div class="form-group col-md-2 mt-3">
                            <label for="inputState">Status</label>
                            <select id="inputState" class="form-select" name="status">
                                <option selected>Active</option>
                                <option>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <input type="submit" value="Save" class="btn btn-primary mt-5 me-2 save_btn" name="btnSubmit"/>
                    <input type="reset" value="Clear" class="btn btn-secondary mt-5 save_btn" name="btnClear"/>
                </form>
            </div> 
    </div>

</body>
</html>