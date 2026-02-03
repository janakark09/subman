<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Menu</title>
<!--Font-awsome-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            min-height: 100vh;
        }

        .sidebar {
            width: 100%;
            min-height: 100vh;
        }

        /* Main menu active */
        .nav-pills .nav-link.active {
            background-color: #198754;
            color: #fff;
            font-weight: 500;
        }

        /* Hover */
        .nav-pills .nav-link:hover {
            background-color: #495057;
            color: #fff;
        }

        /* Sub menu */
        .submenu .nav-link {
            padding-left: 2.5rem;
            font-size: 0.9rem;
        }

        .submenu .nav-link.active {
            background-color: #0d6efd;
        }

        /* Arrow rotation */
        .nav-link .fa-angle-down {
            transition: transform 0.3s;
        }

        .nav-link[aria-expanded="true"] .fa-angle-down {
            transform: rotate(180deg);
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!------------------------- Sidebar ------------------------>
    <div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-white bg-dark">
        <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-4">Main Menu</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto" id="sidebarMenu">
                   
            <li class="nav-item">
                <a href="home_page.php?activity=dashboard" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='dashboard' ? 'active' : '' ?>">
                    <i class="fa fa-chart-area me-2" aria-hidden="true"></i> Dashboard
                </a>
            </li>

<!---------------- Vendors with Sub Menu ------------------------------------>
            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center"
                   data-bs-toggle="collapse" href="#vendorMenu" role="button" aria-expanded="false">
                    <span><i class="fa fa-handshake me-2"></i> Subcontractors</span>
                    <i class="fa fa-angle-down"></i>
                </a>

                <div class="collapse submenu" id="vendorMenu">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">New Vendor</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">All Vendors</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">Edit Vendor</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">Order Agreements</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!---------------- Merchandising with Sub Menu ------------------------------------>
            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center"
                   data-bs-toggle="collapse" href="#merchMenu" role="button" aria-expanded="false">
                    <span><i class="fa fa-users me-2"></i> Merchandising</span>
                    <i class="fa fa-angle-down"></i>
                </a>

                <div class="collapse submenu" id="merchMenu">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">Buyers</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">Style Order Management</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">Colors and Sizes</a>
                        </li>
                    </ul>
                </div>
            </li>
         <!------------------------------- Planning Module with Sub Menu ---------------------------->
            <li class="nav-item">
                <a href="#" class="nav-link text-white">
                    <i class="fa fa-clock me-2"></i> Order Planning</a>
            </li>
        <!---------------------------------- Gate Passes with Sub Menu ------------------------------------>
            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center"
                   data-bs-toggle="collapse" href="#gatepasssMenu" role="button" aria-expanded="false">
                    <span><i class="fa fa-cubes me-2"></i> Gate Passes</span>
                    <i class="fa fa-angle-down"></i>
                </a>

                <div class="collapse submenu" id="gatepasssMenu">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">All Gate Passes</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">New gate Pass</a>
                        </li>
                    </ul>
                </div>
            </li>
        <!------------------------------- Production Module with Sub Menu ---------------------------->
            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center"
                   data-bs-toggle="collapse" href="#productsMenu" role="button" aria-expanded="false">
                    <span><i class="fa fa-tshirt me-2"></i> Production Module</span>
                    <i class="fa fa-angle-down"></i>
                </a>

                <div class="collapse submenu" id="productsMenu">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">All Records</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">Add Record</a>
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
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">GRN</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">Payments</a>
                        </li>
                    </ul>
                </div>
            </li>
         <!------------------------------- Reports with Sub Menu ---------------------------->
            <li class="nav-item">
                <a href="#" class="nav-link text-white">
                    <i class="fa fa-calculator me-2"></i> Reports</a>
            </li>
            <!-------------------------- Reports with Sub Menu ------------------------------------------>
            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center"
                   data-bs-toggle="collapse" href="#reportsMenu" role="button" aria-expanded="false">
                    <span><i class="fa fa-newspaper me-2"></i> Reports</span>
                    <i class="fa fa-angle-down"></i>
                </a>

                <div class="collapse submenu" id="reportsMenu">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">Report1</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">Report2</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">Report3</a>
                        </li>
                    </ul>
                </div>
            </li>
        <!-------------------------- Users Management with Sub Menu ------------------------------------------>
            <li class="nav-item">
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
                            <a href="#" class="nav-link text-white">User Types</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-------------------------- Masters with Sub Menu ------------------------------------------>
            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center"
                   data-bs-toggle="collapse" href="#mastersMenu" role="button" aria-expanded="true">
                    <span><i class="fa fa-cog me-2"></i> Masters</span>
                    <i class="fa fa-angle-down"></i>
                </a>

                <div class="collapse submenu" id="mastersMenu">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="home_page.php?activity=loc" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='loc' ? 'active' : '' ?>">Locations</a>
                        </li>
                        <li class="nav-item">
                            <a href="home_page.php?activity=addloc" class="nav-link text-white <?= ($_GET['activity'] ?? '')=='addloc' ? 'active' : '' ?>">Add Location</a>
                        </li>
                        <!--li class="nav-item">
                            <a href="#" class="nav-link text-white">User Types</a>
                        </li-->
                    </ul>
                </div>
            </li>

        </ul>

        <hr>

        <!-- User Dropdown -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
               data-bs-toggle="dropdown">
                <img src="../Resources/images/userIcon.png" width="32" height="32" class="rounded-circle me-2">
                <strong>mdo</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark shadow">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

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

</body>
</html>
