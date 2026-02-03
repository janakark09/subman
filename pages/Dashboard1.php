<?php
	include "../includes/db-con.php";
	session_start();
	$Usrname=$_SESSION['_UserName'];
	$UsrID=$_SESSION['_UserID'];
	//$resultSes=mysqli_fetch_assoc($conn,mysqli_query())
	//$userID=$_REQUEST['AccountName'];
	
	if($_REQUEST['activity']=="logout")
	{
		$Usrname="";
		$Usrname=null;
		$UsrID="";
		$UsrID=null;
		
		$_SESSION['User_Name']=null;
		$_SESSION['User_Name']="";
		$_SESSION['_UserID']=null;
		$_SESSION['_UserID']="";
		session_destroy();
		
		header("Location: ../index.php?");
		exit();
	}
	if(empty($_SESSION['_UserName']))
	{
		session_destroy();
		header("Location: ../index.php?");
		exit();
	}
	$today=date("Y/m/d");
?>
<!DOCTYPE html>
<html>
<head>
	<title>User Login</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>

	<!--Font-awsome-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!--Google Font Family-->
	<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Merienda:wght@300..900&display=swap" rel="stylesheet">
	
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/css/NavForms.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/font-awesome/css/all.css"/>
    <script src="../assets/font-awesome/js/all.js"></script>
    <style type="text/css">


		.logo{
    		text-decoration: none;
  		}
      	
    <style type="text/css">
		.signup
		{
			color:white;
			font-family:'Arial Black';
			margin-top:0px;
			margin-bottom:5px;
			margin-right:20px;
		}
		.orangecolor{
    		color: #ef5c23;
		}
		.logo{
    		text-decoration: none;
  		}
        .content_div
        {
	        height:100%;
	        width:100%;
	        float:left;
	        position:absolute;
        }
        #td1
{
	min-height:100%;
	width:300px;
	background-color:#000;
	margin:0px 0px;
	vertical-align:top;
}
    </style>
</head>

<body>
    <header class="navbar navbar-expand-lg bg-dark fixed-top">
        <div class="container-fluid">
            <h3 class="h3"><a class="orangecolor fw-bold logo" href="#">SubMan</a></h3>
    	    <button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      		    <span class="navbar-toggler-icon"></span>
    	    </button>
        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav ">
        <li class="nav-item">
          <a class="nav-link active text-light" aria-current="page" href="#">HOME</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link text-light" href="#">ABOUT</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="#">SERVICES</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" aria-disabled="true">TESTIMONIALS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="#">PORTFOLIO</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="Dashboard.php?activity=logout">SIGNOUT</a>
        </li>
      </ul>
        </div>
    </header>
    <!------------------------------ TOP DESTINATIONS Section ------------------------------------------------>
    <div>
        <div class="row content_div">
            <div class="col-2 pt-5 mt-1">
            <!-- Content for the left half -->
			 <?php
			    include '../includes/sidebar.php';
			 ?>
			 </div>
        <div class="col bg-light pt-5 mt-3">
            <!-- Content for the right half -->
            <?php
			if(empty($_REQUEST['activity']))
			{
				header("Location: ../index.php");
			}
			else
			{
				if($_REQUEST['activity'])
				{
					$Activity=$_REQUEST['activity'];
               
					   switch($Activity)
					   {
							case 'Acc':
								include ("ViewProfile.php");
							break;
							
							case 'Dashboard':
								include ("Dashboard_data.php");
							break;
							
							case 'Category':
								include ("Category.php");
							break;
							
							case 'Auth':
								include ("Author.php");
							break;
							
							case 'Books':
								include ("Books_View.php");
							break;
							
							case 'usedBooks':
								include ("Books_used.php");
							break;
														
							case 'IssuedBook':
								include ("Books_inhand.php");
							break;
							
							case 'RequestedBooks':
								include ("Books_requested.php");
							break;
							
							case 'requestBook':
								$selectedBook=$_REQUEST['selectedID'];
								$date_req=date("Y/m/d");
								
								$sqlQuery_req="INSERT INTO book_requested VALUES ('$selectedBook','$UsrID','$date_req')";
								$result_req=mysqli_query($conn,$sqlQuery_req);
								if($result_req)
								{
									header("Refresh: 0.5 DashBoard.php?activity=Books");
								}
								else
								{
									header("Refresh: 0.5 DashBoard.php?activity=Books&error=database error");
								}
							break;
							
							case 'delRequested':
							$selectedID=$_REQUEST['selectedID'];
							
							$sqlQuery_del="DELETE FROM book_requested WHERE Book_ID='$selectedID'";
							$result_del=mysqli_query($conn,$sqlQuery_del);
							
							if($result_del)
							{
								header("Refresh: 0.5 DashBoard.php?activity=RequestedBooks");
							}
							else
							{
								header("Refresh: 0.5 DashBoard.php?activity=RequestedBooks&error=database error");
							}							
							
							break;
							
							case 'catBooks':
								include ("Books_View_Cat.php");
							break;
							
							case 'authBooks':
								include ("Books_View_Auth.php");
							break;

							case 'delete':
							include("delData.php");
							break;
							
							case 'viewCharges':
							include("Book_LateCharge.php");
							break;
							
							case 'logout':
							break;
							
							default:
								include("Dashboard_data.php");
							break;
					   }
				}
				else
				{
					header("Location Dashboard.php?activity=adminDashboard");
				}
			}
				
               
        ?>
        </div>
        </div>
    </div>
</body>

</html>