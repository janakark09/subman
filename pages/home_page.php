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

	$noifyQuery=mysqli_query($conn,"SELECT notifications.*, CONCAT(users.Fname,' ', users.Lname) AS UserName FROM notifications JOIN users ON notifications.user = users.User_ID WHERE attUser='$UsrID' AND NotifyStatus='0' ORDER BY createdDT DESC");
	$notifyDataset=mysqli_fetch_all($noifyQuery, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
	<head>
		
		<title>Subman</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		 <link rel="icon" type="image/x-icon" href="../Resources/images/syslogo.ico">

		<!--bootstrap-->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

		<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous"> -->

		<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script> -->
		<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script> -->

		<!--Font-awsome-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<!--Google Font Family-->
		<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Merienda:wght@300..900&display=swap" rel="stylesheet">
		
		<link rel="stylesheet" type="text/css" href="../assets/css/style.css"/>
		<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="../assets/css/NavForms.css"/>
		<link rel="stylesheet" type="text/css" href="../assets/font-awesome/css/all.css"/>
		<script src="../assets/font-awesome/js/all.js"></script>
		<style type="text/css">
			
			.orangecolor{
				color: #ef5c23;
			}
			.logo{
				text-decoration: none;
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
				<!-- Toggle button for mobile view -->
				<button class="navbar-toggler navbar-dark" type="button"  id="togglebtn1" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse justify-content-end" id="navbarNav">
				<ul class="navbar-nav">
					<li class="nav-item">
						<!-- User Dropdown -->
						<div class="dropdown">
							<a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
							data-bs-toggle="dropdown">
								<img src="../Resources/images/userIcon.png" alt="" width="32" height="32"
									class="rounded-circle me-2">
								<strong><?php echo $Usrname?></strong>
							</a>
							<ul class="dropdown-menu dropdown-menu-dark text-small shadow">
								<li><a class="dropdown-item" href="home_page.php?activity=acc">Reset Password</a></li>
								<li><a class="dropdown-item" href="#">Settings</a></li>
								<li><hr class="dropdown-divider"></li>
								<li><a class="dropdown-item" href="home_page.php?activity=logout">Sign out</a></li>
							</ul>
						</div>
					</li>
					<!-- ---------------------- Message Toolbox ---------------------------------------------->
					<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle text-light pe-2 position-relative" 
					href="#" 
					id="messagesDropdown" 
					role="button"
					data-bs-toggle="dropdown" 
					aria-expanded="false">

						<i class="fa fa-envelope"></i>

						<!-- Badge -->
						<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
						 palceholder="Unread Messages" style="margin-top: 10px; margin-left: -25px; font-size: 0.75rem;">
							<?php echo count($notifyDataset); ?>
						</span>
					</a>

					<!-- Notification Panel -->
					<ul class="dropdown-menu dropdown-menu-end shadow" 
						aria-labelledby="messagesDropdown" 
						style="width: 320px;">

						<li class="dropdown-header fw-bold">Messages</li>

						<!-- Message Item -->
						 <?php foreach($notifyDataset as $notify){
							?>
						<li class="cursor-pointer" onclick="markAsRead(<?php echo $notify['id']; ?>)">
							<a href="#" class="dropdown-item d-flex align-items-start">
								<img src="../Resources/images/userIcon.png" 
									class="rounded-circle me-2" width="40" height="40">
								<div>
									<strong><?php echo $notify['UserName']; ?></strong>
									<div class="small text-muted"><?php echo $notify['description']; ?></div>
									<small class="text-muted">
										<?php 
											date_default_timezone_set('Asia/Colombo');
											$createdTime = new DateTime($notify['createdDT']);
											$currentTime = new DateTime('now');
											$interval = $currentTime->diff($createdTime);

											//echo $currentTime->format('Y-m-d H:i:s') ." - " . $createdTime->format('Y-m-d H:i:s') . " = " . $interval->format('%y years, %m months, %d days, %h hours, %i minutes');

											if ($interval->y > 0) {
												echo $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
											} elseif ($interval->m > 0) {
												echo $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
											} elseif ($interval->d > 0) {
												echo $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
											} elseif ($interval->h > 0) {
												echo $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
											} elseif ($interval->i > 0) {
												echo $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
											} else {
												echo 'Just now';
											}
									 ?></small>
								</div>
							</a>
						</li>

						<li><hr class="dropdown-divider"></li>
						 <?php } ?>

						<!-- Footer -->
						<li class="text-center">
							<a href="#" class="dropdown-item text-primary" onclick="markAllAsRead()">Mark As Read All</a>
						</li>

					</ul>
				</li>
					<!-- ---------------------------------------------------------------------------------- -->
					<li class="nav-item">
						<a class="nav-link text-light" href="home_page.php?activity=logout"><i class="fa fa-sign-out-alt"></i></a>
					</li>
				</ul>
			</div>
		</header>

		<!------------------------------ Body Contents ------------------------------------------------>
		<div class="container-fluid">
			<div class="pt-5">
				<div class="row d-flex min-vh-100">
					<div class="col-sm col-md-4 col-lg-3 col-xl-3 mt-1 bg-dark">
						<!-------------------------------- Side bar ---------------------------->
						<?php include '../includes/sidebar.php'?>
						<!-- User Dropdown -->
					</div>
					<div class="col-sm col-md-6 col-lg pt-5 mt-2 ps-5">
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
										//------------------------------------------------
										case 'addvendor':
											include ("vendor_add_page.php");
										break;
										case 'allvendors':
											include ("vendor_all_page.php");
										break;
										case 'editvendor':
											include ("vendor_edit_page.php");
										break;
										//-----------------------------------------------
										case 'agreements':
											include ("agreements_page.php");
										break;
										case 'addagreement':
											include ("agreement_new_page.php");
										break;
										//------------------------------------------------
										case 'addbuyer':
											include ("buyers_add_page.php");
										break;
										case 'allbuyers':
											include ("buyers_all_page.php");
										break;
										case 'editbuyer':
											include ("buyers_edit_page.php");
										break;
										//----------------------------
										case 'styles':
											include ("buyers_styles_page.php");
										break;
										case 'addstyle':
											include ("buyers_stylesadd_page.php");
										break;
										case 'styleorder':
											include ("buyers_styleorder_page.php");
										break;
										case 'addstyleorder':
											include ("buyers_styleorderadd_page.php");
										break;
										case 'colorsize':
											include ("buyers_colorsize_page.php");
										break;
										//------------------------------------------------
										case 'planning':
											include ("order_planning_page.php");
											break;
										case 'confirmplan':
											include ("order_planconfirm_page.php");
											break;
										//------------------------------------------------
										case 'gatepass':
											include ("gp_all_page.php");
											break;
										case 'newgatepass':
											include ("gp_new_page.php");
											break;
										case 'viewgp':
											include ("gp_view_page.php");
											break;
										//------------------------------------------------
										case 'proRec':
											include ("pro_all_page.php");
											break;
										case 'proAdd':
											include ("pro_new_page.php");
											break;
										case 'proView':
											include ("pro_view_page.php");
											break;
										//------------------------------------------------
										case 'grnAll':
											include ("grn_all_page.php");
											break;
										case 'grnUpdate':
											include ("grn_add_page.php");
											break;
										case 'grnList':
											include ("grn_list_page.php");
											break;
										case 'grnView':
											include ("grn_view_page.php");
											break;
										case 'payAdd':
											include ("payment_add_page.php");
											break;
										case 'payList':
											include ("payment_list_page.php");
											break;
										case 'payView':
											include ("payment_view_page.php");
											break;
										//------------------------------------------------
										case 'rptOrderTrack':
											include ('./reports/ordertracker_report.php');
											break;
										case 'rptStyles':
											include ('./reports/styles_report.php');
											break;
										//------------------------------------------------
										case 'users':
											include ('users_all_page.php');
											break;
										case 'adduser':
											include ('users_add_page.php');
											break;
										case 'edituser':
											include ('users_edit_page.php');
											break;
										case 'usertype':
											include ('users_type_page.php');
											break;
										case 'addusertype':
											include ('users_addutype_page.php');
											break;
										//------------------------------------------------
										case 'loc':
											include ('mast_location_page.php');
											break;
										case 'addloc':
											include ('mast_addloc_page.php');
											break;
										case 'editLoc':
											include ('mast_editloc_page.php');
											break;
										//------------------------------------------------
										case 'aboutdev':
											include ('about.php');
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

		<script>
		function markAsRead(id) {
			fetch('../includes/update_notification.php', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
				},
				body: 'id=' + id
			})
			.then(response => response.text())
			.then(data => {
				console.log("Updated:", data);

				// Optional: remove badge or style change
			})
			.catch(error => console.error('Error:', error));

			// Fade or remove item visually
    		event.currentTarget.style.opacity = "0.3";
			event.currentTarget.style.visibility = "hidden";
		}
		function markAllRead() {
			fetch('../includes/update_notification.php', {
				method: 'POST'
			})
			.then(response => response.text())
			.then(data => {
				console.log(data);

				// Remove red badge count
				let badge = document.querySelector('.badge');
				if (badge) {
					badge.remove();
				}

				// Fade all notifications
				let items = document.querySelectorAll('.dropdown-item');
				items.forEach(item => {
					item.style.opacity = "0.5";
				});
			})
			.catch(error => console.error('Error:', error));
		}
		</script>

	</body>
</html>