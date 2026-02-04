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
				float:right;
				position:absolute;
			}
			#td11
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
		<header class="navbar navbar-expand-lg bg-success fixed-top">
			<div class="container-fluid">
				<h3 class="h3"><a class="text-white fw-bold logo" href="#">SUBMAN</a></h3>
				<button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse justify-content-end" id="navbarNav">
				<ul class="navbar-nav ">
					<!--li class="nav-item">
						<a class="nav-link active text-light" aria-current="page" href="#">HOME</a>
					</li>
					<li class="nav-item ">
						<a class="nav-link text-light" href="#">ABOUT</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-light" href="#">SERVICES</a>
					</li-->
					<li class="nav-item">
						<!-- User Dropdown -->
						<div class="dropdown">
							<a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
							data-bs-toggle="dropdown">
								<img src="../Resources/images/userIcon.png" alt="" width="32" height="32"
									class="rounded-circle me-2">
								<strong>mdo</strong>
							</a>
							<ul class="dropdown-menu dropdown-menu-dark text-small shadow">
								<li><a class="dropdown-item" href="home_page.php?activity=acc"><?php echo $userName?></a></li>
								<li><a class="dropdown-item" href="#">Settings</a></li>
								<li><hr class="dropdown-divider"></li>
								<li><a class="dropdown-item" href="home_page.php?activity=logout">Sign out</a></li>
							</ul>
						</div>
					</li>
					<li class="nav-item">
						<a class="nav-link dropdown-toggle text-light pe-2" href="home_page.php?activity=notify" id="messagesDropdown" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-envelope mb-1"></i>
									<span class="red-badge">7</span>
								</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-light" href="home_page.php?activity=logout"><i class="fa fa-sign-out-alt"></i></a>
					</li>
				</ul>
			</div>
		</header>

		<!------------------------------ Body Contents ------------------------------------------------>
		<div>
			<div class="row content_div" id="body_row">
				<div class="col-2 pt-5 mt-1">
					<!-------------------------------- Side bar ---------------------------->
					<?php include '../includes/sidebar.php'?>
				</div>
			<div class="col pt-5 mt-5 ms-5 me-5 ">
				<!-------------------------- Content for the system operations ------------------------->
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
								case 'acc':
									include ("ViewProfile.php");
								break;
								
								case 'dashboard':
									include ("dashboard_page.php");
								break;
								
								case 'users':
									include ('users_all_page.php');
									break;
								case 'adduser':
									include ('users_add_page.php');
									break;
								case 'loc':
									include ('mast_location_page.php');
									break;
								case 'addloc':
									include ('mast_addloc_page.php');
									break;
								case 'logout':
								break;
								
								default:
									include("dashboard_page.php");
								break;
						}
					}
					else
					{
						header("Location home_page.php?activity=adminDashboard");
					}
				}   
				?>
			</div>
		</div>

		<script>
			document.addEventListener("DOMContentLoaded", function () {

				const employeeRadio = document.getElementById("Radio1");
				const subcontractorRadio = document.getElementById("Radio2");

				const locationSelect = document.getElementById("locationSelect");
				const subcontractorSelect = document.getElementById("subcontractorSelect");

				// Initial state
				locationSelect.disabled = true;
				subcontractorSelect.disabled = true;

				employeeRadio.addEventListener("change", function () {
					if (this.checked) {
						locationSelect.disabled = false;
						subcontractorSelect.disabled = true;
						subcontractorSelect.selectedIndex = 0;
					}
				});

				subcontractorRadio.addEventListener("change", function () {
					if (this.checked) {
						subcontractorSelect.disabled = false;
						locationSelect.disabled = true;
						locationSelect.selectedIndex = 0;
					}
				});

			});
		</script>

	</body>
</html>