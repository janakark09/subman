<?php 
	include "../includes/db-con.php";
	$message="";
		
	$selectedID=$_SESSION['_UserID'];

	$sqlQuery="SELECT * FROM users,user_details WHERE users.User_ID='$selectedID' AND user_details.User_ID='$selectedID'";
	$returnData=mysqli_query($conn,$sqlQuery);
	$result_load=mysqli_fetch_assoc($returnData);
	
	$oldPASS=$result_load['Password'];
	$Uid=$result_load['User_ID'];
	
	
	if(isset($_POST['btnSubmit']))
	{
		$Pswd_old=$_POST['pw_oldpass'];
		$Pswd_new=$_POST['pw_newpass'];
		$Pswd_new1=$_POST['pw_newpass'];
		
		if($oldPASS==$Pswd_old)
		{
			if($Pswd_new == $Pswd_new1)
		{
			$sqlQuery1="UPDATE users SET Password='$Pswd_new' WHERE User_ID='$Uid' ";
			$result1=mysqli_query($conn,$sqlQuery1);
		
			if($result1)
			{
				$message="*Successfuly saved. Please Login again";
			}
			else
			{
				$message="*Error in saving.";
			}
	/*################### Refresh the window after data saving ########################	*/
				header("Refresh: 1 ../login.php");
			}
		else
		{
			$message="*Password does not match.";
		}
		}
		else
		{
			$message="*Please enter correct old Password to proceed.";
		}
				
		
	}
 ?>
 
<html>
<head>
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="../assets/css/NavForms.css"/>
</head>
	
<body>
<div class="title">Profile</div>
<div class="objects">
<div>
    <p class="ALT"><?php echo $message; ?></p>
    <form class="Content_forms" method="post">
    	User ID :<label><?php echo $result_load['User_ID'];?></label> 
        <br/><br/>
    	Name :<label><?php echo $result_load['Name'];?></label>
        <br/><br/>
        Email :<label><?php echo $result_load['Email'];?></label>
        <br/><br/>        
        Address  : <Label><?php echo $result_load['Address'];?></Label>
        <br/><br/>
        Telephone Number  :<label><?php echo $result_load['TelNumber'];?></label>
        <br/><br/>
        Joined date  : <label><?php echo $result_load['Joined_Date'];?></label>
        <br/><br/>
        NIC Number  :<label><?php echo $result_load['NIC_number'];?></label>
        <br/><br/>
        
        Old Password  : <br/> <input id="textBox1" type="password" placeholder="old password" name="pw_oldpass"  required="required" value=""/>
        <br/><br/>
        
        New Password  : <br/> <input id="textBox1" type="password" placeholder="new password" name="pw_newpass"  required="required"/>
        <br/><br/>
        
        Confirm New Password  : <br/> <input id="textBox1" type="password" placeholder="Confirm new password" name="pw_newpass1"  required="required"/>
        <br/><br/>
        <input id="Btn" type="submit"  name="btnSubmit" value="Save"/>
        <input id="Btn" type="Reset" />
    </form>
    </div>
</div>
	
</body>
</html>

