<?php
	session_start();

	if(isset($_POST['login1']))
	{
		
		$accUname=strtolower($_REQUEST['Uname']);
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

			$dbuname=$result['Name'];
			$dbpass=$result['Password'];

			if($result)
			{
				if($accUname==$dbuname && md5($accPass)==$dbpass)
					{
						$userdetailsQuery=mysqli_query($conn,"SELECT * FROM user_details WHERE User_ID='".$result['User_ID']."'");
						$detailsCount=mysqli_num_rows($userdetailsQuery);
						$resultDetails=mysqli_fetch_assoc($userdetailsQuery);	
						$_SESSION['_UserName']=$accUname;
						$_SESSION['_UserID']=$result['User_ID'];
						$_SESSION['_UserType']=$result['User_Type'];
						$_SESSION['_Result']=$result['User_ID'].'-'.$resultDetails['acc1'];

						if($detailsCount>0)
						{
							$_SESSION['Acc1']=$resultDetails['acc1'];
							$_SESSION['Acc2']=$resultDetails['acc2'];
							$_SESSION['Acc3']=$resultDetails['acc3'];
							$_SESSION['Acc4']=$resultDetails['acc4'];
							$_SESSION['Acc5']=$resultDetails['acc5'];
							$_SESSION['Acc6']=$resultDetails['acc6'];
							$_SESSION['Acc7']=$resultDetails['acc7'];
							$_SESSION['Acc8']=$resultDetails['acc8'];
							$_SESSION['Acc9']=$resultDetails['acc9'];
							$_SESSION['Acc10']=$resultDetails['acc10'];
							$_SESSION['Acc11']=$resultDetails['acc11'];
							$_SESSION['Acc12']=$resultDetails['acc12'];
							$_SESSION['Acc13']=$resultDetails['acc13'];
							$_SESSION['Acc14']=$resultDetails['acc14'];
							$_SESSION['Acc15']=$resultDetails['acc15'];
							$_SESSION['Acc16']=$resultDetails['acc16'];
							$_SESSION['Acc17']=$resultDetails['acc17'];
							$_SESSION['Acc18']=$resultDetails['acc18'];
							$_SESSION['Acc19']=$resultDetails['acc19'];
							$_SESSION['Acc20']=$resultDetails['acc20'];
							$_SESSION['Acc21']=$resultDetails['acc21'];
							$_SESSION['Acc22']=$resultDetails['acc22'];
							$_SESSION['Acc23']=$resultDetails['acc23'];
							$_SESSION['Acc24']=$resultDetails['acc24'];
							$_SESSION['Acc25']=$resultDetails['acc25'];
						}

						header("Location:../pages/home_page.php?activity=Dashboard");
						exit();
					}
					else
					{
						header("Location:../index.php?error=*Wrong Password+$accUname");
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

