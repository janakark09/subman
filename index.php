<?php
	if(isset($_REQUEST['error']))
	{
		$error=$_REQUEST['error'];
	}
	else
	{
		$error="";
	}
 
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

    <link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
    		<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/login_back.css"/>
    <style type="text/css">
    #login_div
    {
        width:100%;
    }
	.form
	{
		font-family:"Arial Black", Gadget, sans-serif;
		background-color:rgba(255,255,255,0.65);
		color:red;
		margin-left:auto;
		margin-right:auto;
		padding:20px 20px;
		width:350px;
		height:190px;
		border-radius:10px;
		box-shadow:0px 0px 20px black;
	}
	#btn
	{
		height:30px;
		width:90px;
		color:white;
		background-color:#B70004;
		font-family:"Arial Black";
		font-size:16px;
		border:none;
	}
	</style>
</head>

<body>
	<section class="vh-100" style="background-color: #9A616D;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="./Resources/images/LoginBack.jpg" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem; height:100%" />
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <form method="post" action="./includes/user_login.php">  <!--Linking the "./includes/user_login.php" to login process-->

                  <div class="d-flex align-items-center mb-1 pb-1">
                    <a href="index.php"><img src="./Resources/images/logo.png" alt="Logo" class="img-fluid" style="border-radius: 1rem 0 0 1rem;"></a>
                    <h1 class="h1 fw-bold mb-0">Subman</h1>
                  </div>

					<h5 class="fw-bold mb-3 pb-3" style="letter-spacing: 1px;">Sub Contract Management System</h5>
                  <h6 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h6>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" name="Uname" class="form-control form-control-lg" autofocus/>
                    <label class="form-label">Username</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" name="Pswd" class="form-control form-control-lg" />
                    <label class="form-label">Password</label>
                  </div>

                  <div class="pt-1 mb-4">
					        <input type="submit" value="Login" name="login1" class="btn btn-dark btn-lg btn-block"/>
                  </div>

                  <a href="https://originalapparel.lk/" class="small text-muted" target="_blank">www.originalapparel.lk</a>
                  <p style="text-align:center;font-size:12px;"><?php echo $error; ?></p>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
    <!--***********************************************************************-->
    
    <!--div style="height:100px; padding:20px" >
                <img src="Resources/esoft logo.jpg" align="right" width="150px"/>
    </div-->
    
<!--***********************************************************************--> 
    
    <!--div style="height:auto">
        <div id=login_div>
            <form class="form" action="./includes/user_login.php" method="post">
                <h2 style="text-align:center; margin:0px"><i>Login</i></h2>
                <hr color="red"></hr>
                <label >Username:  </label>
                <input type="text" placeholder="Username" style="border:none;height:20px" name="Uname" autofocus/>
                <br/><br/>
                <label>Password   :</label>
                <input type="password" placeholder="Password" style="border:none;height:20px" name="Pswd"/>
                <br/>
                <p align="center">
                    <input type="submit" value="Login" id="btn" name="login1"/>
                    <input type="reset" id="btn"/>
                </p>
                <p style="text-align:center;font-size:12px;"><?php echo $error; ?></p>
            </form>
        </div>
    </div-->
    
</body>
</html>