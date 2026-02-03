<?php
	session_start();

	if(isset($_POST['login1']))
	{
		
		$accUname=$_REQUEST['Uname'];
		$accPass= $_REQUEST['Pswd'];
		
		//validate -check empty fields..
		if(empty($accUname) || empty($accPass))
		{
			header("Location:../login.php?error:emptyfields&Username=".$accUname);
		}
		else
		{
			//database connection
			include "db-con.php";
			
			//query the database
			$sql="SELECT * FROM users WHERE Name='$accUname'";
			$query=mysqli_query($conn,$sql);
			$result=mysqli_fetch_assoc($query);
			if($result)
			{
				if($accUname==$result['Name'] && $accPass==$result['Password'])
					{
											echo "done";
						$_SESSION['_UserName']=$accUname;
						$_SESSION['_UserID']=$result['User_ID'];
						header("Location:../pages/home_page.php?activity=Dashboard");
						exit();
					}
					else
					{
						header("Location:../index.php?error=*Wrong Password");
						exit();
					}
				
			}
			else
			{
				header("Location:../index.php?error=*invalidCredential");
				exit();
				echo "Username not available";
			}
		}
		
	}
?>

