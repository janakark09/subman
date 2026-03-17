<?php
include "../includes/db-con.php";
    $activeUser=$_SESSION['_UserID'] ?? null;
    $acc1=$acc2=$acc3=$acc4=$acc5=$acc6=$acc7=$acc8=$acc9=$acc10=$acc11=$acc12=$acc13=$acc14=$acc15=$acc16=$acc17=$acc18=$acc19=$acc20=$acc21=$acc22=$acc23=$acc24=$acc25=0;

    $userdetailsQuery=mysqli_query($conn,"SELECT * FROM user_details WHERE User_ID='".$activeUser."'");

    if($uDetails=mysqli_fetch_assoc($userdetailsQuery))
        {
            $acc1=$uDetails['acc1'];
            $acc2=$uDetails['acc2'];
            $acc3=$uDetails['acc3'];
            $acc4=$uDetails['acc4'];
            $acc5=$uDetails['acc5'];
            $acc6=$uDetails['acc6'];
            $acc7=$uDetails['acc7'];
            $acc8=$uDetails['acc8'];
            $acc9=$uDetails['acc9'];
            $acc10=$uDetails['acc10'];
            $acc11=$uDetails['acc11'];
            $acc12=$uDetails['acc12'];
            $acc13=$uDetails['acc13'];
            $acc14=$uDetails['acc14'];
            $acc15=$uDetails['acc15'];
            $acc16=$uDetails['acc16'];
            $acc17=$uDetails['acc17'];
            $acc18=$uDetails['acc18'];
            $acc19=$uDetails['acc19'];
            $acc20=$uDetails['acc20'];
            $acc21=$uDetails['acc21'];
            $acc22=$uDetails['acc22'];
            $acc23=$uDetails['acc23'];
            $acc24=$uDetails['acc24'];
            $acc25=$uDetails['acc25'];
        }    
?>

<div class="d-flex justify-content-end mb-3">
    <div class="d-flex justify-content-right align-items-center pt-3 ps-2 pb-1 bg-dark">
        <button class="navbar-toggler" type="button"  id="togglebtn1" data-bs-toggle="collapse" data-bs-target="#sidebarMenuWrapper" aria-controls="sidebarMenuWrapper" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-window-maximize text-secondary"></i>
	    </button>
    </div>
    <!-- <button class="navbar-toggler navbar-dark" type="button"  id="togglebtn1" data-bs-toggle="collapse" data-bs-target="#sidebarMenuWrapper" aria-controls="sidebarMenuWrapper" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span> -->
	</button>
    <div class="collapse d-md-block d-lg-block navbar-collapse" id="sidebarMenuWrapper">
        <!------------------------- Sidebar ------------------------>
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-white bg-dark">
            <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-4">Main Menu</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto" id="sidebarMenu">
                    
                <li class="nav-item " <?php if($acc1==0){ echo 'hidden'; } ?>>
                    <a href="home_page.php?activity=dashboard" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='dashboard' ? 'active' : '' ?>">
                        <i class="fa fa-chart-area me-2" aria-hidden="true"></i> Dashboard
                    </a>
                </li>

                <!---------------- Merchandising with Sub Menu ------------------------------------>
                <li class="nav-item" <?php if($acc2==0){ echo 'hidden'; } ?>>
                    <a class="nav-link text-white d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#merchMenu" role="button" aria-expanded="false">
                        <span><i class="fa fa-users me-2"></i> Merchandising</span>
                        <i class="fa fa-angle-down"></i>
                    </a>

                    <div class="collapse submenu" id="merchMenu">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item" <?php if($acc3==0){ echo 'hidden'; } ?>>
                                <a href="home_page.php?activity=allbuyers" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='allbuyers' ? 'active' : '' ?>">All Buyers</a>
                            </li>
                            <li class="nav-item" <?php if($acc4==0){ echo 'hidden'; } ?>>
                                <a href="home_page.php?activity=styles" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='styles' ? 'active' : '' ?>">Style Management</a>
                            </li>
                            <li class="nav-item" <?php if($acc4==0){ echo 'hidden'; } ?>>
                                <a href="home_page.php?activity=styleorder" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='styleorder' ? 'active' : '' ?>">Style Order Management</a>
                            </li>
                            <li class="nav-item" <?php if($acc4==0){ echo 'hidden'; } ?>>
                                <a href="home_page.php?activity=colorsize" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='colorsize' ? 'active' : '' ?>">Style Color & Size</a>
                            </li>
                        </ul>
                    </div>
                </li>

        <!---------------- Vendors with Sub Menu ------------------------------------>
                <li class="nav-item">
                    <a class="nav-link text-white d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#vendorMenu" role="button" aria-expanded="false">
                        <span><i class="fa fa-handshake me-2"></i> Subcontracting</span>
                        <i class="fa fa-angle-down"></i>
                    </a>

                    <div class="collapse submenu" id="vendorMenu">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item" <?php if($acc8==0){ echo 'hidden'; } ?>>
                                <a href="home_page.php?activity=allvendors" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='allvendors' ? 'active' : '' ?>">All Vendors</a>
                            </li>
                            <li class="nav-item" <?php if($acc8==0){ echo 'hidden'; } ?>>
                                <a href="home_page.php?activity=addvendor" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='addvendor' ? 'active' : '' ?>">New Vendor</a>
                            </li>
                            <li class="nav-item" <?php if($acc9==0){ echo 'hidden'; } ?>>
                                <a href="home_page.php?activity=agreements" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='agreements' ? 'active' : '' ?>">Order Agreements</a>
                            </li>
                        </ul>
                    </div>
                </li>
            <!------------------------------- Planning Module with Sub Menu ---------------------------->
                <li class="nav-item" <?php if($acc6==0){ echo 'hidden'; } ?>>
                    <a class="nav-link text-white d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#planningMenu" role="button" aria-expanded="false">
                        <span><i class="fa fa-clock me-2"></i>Order Planning</span>
                        <i class="fa fa-angle-down"></i>
                    </a>

                    <div class="collapse submenu" id="planningMenu">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a href="home_page.php?activity=planning" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='planning' ? 'active' : '' ?>">Order Planning</a>
                            </li>
                            <li class="nav-item" <?php if($acc7==0){ echo 'hidden'; } ?>>
                                <a href="home_page.php?activity=confirmplan" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='confirmplan' ? 'active' : '' ?>">Confirm Planning</a>
                            </li>
                        </ul>
                    </div>
                </li>
            <!---------------------------------- Gate Passes with Sub Menu ------------------------------------>
                <li class="nav-item" <?php if($acc12==0){ echo 'hidden'; } ?>>
                    <a class="nav-link text-white d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#gatepasssMenu" role="button" aria-expanded="false">
                        <span><i class="fa fa-cubes me-2"></i> Gate Passes</span>
                        <i class="fa fa-angle-down"></i>
                    </a>

                    <div class="collapse submenu" id="gatepasssMenu">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a href="home_page.php?activity=gatepass" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='gatepass' ? 'active' : '' ?>">All Gate Passes</a>
                            </li>
                            <li class="nav-item" <?php if($acc11==0){ echo 'hidden'; } ?>>
                                <a href="home_page.php?activity=newgatepass" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='newgatepass' ? 'active' : '' ?>">New gate Pass</a>
                            </li>
                        </ul>
                    </div>
                </li>
            <!------------------------------- Production Module with Sub Menu ---------------------------->
                <li class="nav-item" <?php if($acc15==0){ echo 'hidden'; } ?>>
                    <a class="nav-link text-white d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#productsMenu" role="button" aria-expanded="false">
                        <span><i class="fa fa-tshirt me-2"></i> Production Module</span>
                        <i class="fa fa-angle-down"></i>
                    </a>

                    <div class="collapse submenu" id="productsMenu">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a href="home_page.php?activity=proRec" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='proRec' ? 'active' : '' ?>">All Records</a>
                            </li>
                            <li class="nav-item" <?php if($acc14==0){ echo 'hidden'; } ?>>
                                <a href="home_page.php?activity=proAdd" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='proAdd' ? 'active' : '' ?>">Add Record</a>
                            </li>
                        </ul>
                    </div>
                </li>
            <!------------------------------- Finance Module with Sub Menu ---------------------------->
                <li class="nav-item">
                    <a class="nav-link text-white d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#financeMenu" role="button" aria-expanded="false">
                        <span><i class="fa fa-dollar-sign me-2"></i> Finance Module</span>
                        <i class="fa fa-angle-down"></i>
                    </a>

                    <div class="collapse submenu" id="financeMenu">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item" <?php if($acc17==0){ echo 'hidden'; } ?>>
                                <a href="home_page.php?activity=grnAll" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='grnAll' ? 'active' : '' ?>">GRN</a>
                            </li>
                            <li class="nav-item" <?php if($acc18==0){ echo 'hidden'; } ?>>
                                <a href="home_page.php?activity=grnList" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='grnList' ? 'active' : '' ?>">GRN List</a>
                            </li>
                            <li class="nav-item" <?php if($acc20==0){ echo 'hidden'; } ?>>
                                <a href="home_page.php?activity=payAdd" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='payAdd' ? 'active' : '' ?>">Payments</a>
                            </li>
                            <li class="nav-item" <?php if($acc21==0){ echo 'hidden'; } ?>>
                                <a href="home_page.php?activity=payList" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='payList' ? 'active' : '' ?>">Payments List</a>
                            </li>
                        </ul>
                    </div>
                </li>
            <!------------------------------- Reports with Sub Menu ---------------------------->
                <!-- <li class="nav-item">
                    <a href="#" class="nav-link text-white">
                        <i class="fa fa-calculator me-2"></i> Reports</a>
                </li> -->
                <!-------------------------- Reports with Sub Menu ------------------------------------------>
                <li class="nav-item" <?php if($acc23==0){ echo 'hidden'; } ?>>
                    <a class="nav-link text-white d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#reportsMenu" role="button" aria-expanded="false">
                        <span><i class="fa fa-newspaper me-2"></i> Reports</span>
                        <i class="fa fa-angle-down"></i>
                    </a>

                    <div class="collapse submenu" id="reportsMenu">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a href="home_page.php?activity=rptOrderTrack" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='rptOrderTrack' ? 'active' : '' ?>">Order tracker</a>
                            </li>
                            <li class="nav-item">
                                <a href="home_page.php?activity=rptStyles" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='rptStyles' ? 'active' : '' ?>">Style Report</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link text-white">Report3</a>
                            </li>
                        </ul>
                    </div>
                </li>
            <!-------------------------- Users Management with Sub Menu ------------------------------------------>
                <li class="nav-item" <?php if($acc24==0){ echo 'hidden'; } ?>>
                    <a class="nav-link text-white d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#usersMenu" role="button" aria-expanded="true">
                        <span><i class="fa fa-user-circle me-2"></i> Users</span>
                        <i class="fa fa-angle-down"></i>
                    </a>

                    <div class="collapse submenu" id="usersMenu">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a href="home_page.php?activity=adduser" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='adduser' ? 'active' : '' ?>">New User</a>
                            </li>
                            <li class="nav-item">
                                <a href="home_page.php?activity=users" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='users' ? 'active' : '' ?>">All Users</a>
                            </li>
                            <li class="nav-item">
                                <a href="home_page.php?activity=usertype" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='usertype' ? 'active' : '' ?>">User Types</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-------------------------- Masters with Sub Menu ------------------------------------------>
                <li class="nav-item" <?php if($acc25==0){ echo 'hidden'; } ?>>
                    <a class="nav-link text-white d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#mastersMenu" role="button" aria-expanded="true">
                        <span><i class="fa fa-cog me-2"></i> Masters</span>
                        <i class="fa fa-angle-down"></i>
                    </a>

                    <div class="collapse submenu" id="mastersMenu">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item" <?php if($acc25==0){ echo 'hidden'; } ?>>
                                <a href="home_page.php?activity=loc" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='loc' ? 'active' : '' ?>">Locations</a>
                            </li>
                            <li class="nav-item" <?php if($acc25==0){ echo 'hidden'; } ?>>
                                <a href="home_page.php?activity=addloc" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='addloc' ? 'active' : '' ?>">Add Location</a>
                            </li>
                            <!--li class="nav-item">
                                <a href="#" class="nav-link text-white">User Types</a>
                            </li-->
                        </ul>
                    </div>
                </li>
                <!-------------------------- About Developer ------------------------------------------>
                <li class="nav-item">
                    <a href="home_page.php?activity=aboutdev" class="nav-link text-white">
                        <i class="fa fa-baby me-2"></i> About Developer</a>
                </li>
                <li class="nav-item">
                    <a href="../includes/logout.php" class="nav-link text-white">
                        <i class="fa fa-power-off me-2"></i> Logout</a>
                </li>
                

            </ul>
            
        </div>
    </div>
</div>


<!-- Active Menu Script -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const collapseLinks = document.querySelectorAll(
        '#sidebarMenu [data-bs-toggle="collapse"]'
    );

    collapseLinks.forEach(link => {

        const targetId = link.getAttribute("href");
        const targetEl = document.querySelector(targetId);

        targetEl.addEventListener("show.bs.collapse", function () {

            // Close other open submenus
            document.querySelectorAll('#sidebarMenu .collapse.show')
                .forEach(openMenu => {
                    if (openMenu !== targetEl) {
                        bootstrap.Collapse.getOrCreateInstance(openMenu).hide();
                    }
                });

        });

    });

    // Active state for normal links
    document.querySelectorAll('#sidebarMenu .nav-link').forEach(link => {
        link.addEventListener('click', function () {

            if (this.dataset.bsToggle === 'collapse') return;

            document.querySelectorAll('#sidebarMenu .nav-link')
                .forEach(item => item.classList.remove('active'));

            this.classList.add('active');
        });
    });

});
</script>

<!-- </body>
</html> -->
