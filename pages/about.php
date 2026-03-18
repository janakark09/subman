<?php
    include "../includes/db-con.php";
    $message="";
    
    $activeUser=$_SESSION['_UserID'];   
 ?>

<div class="ps-lg-5 pe-lg-5 ms-3 me-5 container">
    <div class="container ps-lg-5 pe-lg-5 mb-5">
            <div class="mb-5 text-center">
                <h4>About Subcontracts Management System</h4>  
            </div>
            <div class="text-justify">
                <p class="textJustify">Subcontracts Management System is a web-based application designed to streamline and enhance the management of 
                    subcontracting processes within organizations. The system provides a centralized platform for tracking, managing, and analyzing subcontractor
                     relationships, contracts, and performance. It offers features such as contract creation, document management, performance monitoring, 
                     and reporting tools to help organizations efficiently manage their subcontracting activities and ensure compliance with contractual obligations.</p>
            </div>
            <div class="row justify-content-end">
                
                <div class="card rounded-5 bg-light ">
                    <div class="card-body col-lg-6 mb-sm-5">
                        <h5 class="card-title">Key Features:</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Contract Management: Create, store, and manage subcontractor contracts in a centralized repository.</li>
                            <li class="list-group-item">Order Planning: Plan and schedule subcontracting orders efficiently to meet project timelines.</li>
                            <li class="list-group-item">Material Movement Tracking: Track the movement of materials and resources related to subcontracting activities.</li>
                            <li class="list-group-item">Performance Monitoring: Track subcontractor performance metrics and generate reports to evaluate their effectiveness.</li>
                            <li class="list-group-item">Payment and Invoice Management: Manage subcontractor payments and invoices efficiently.</li>
                            <li class="list-group-item">Communication Tools: Facilitate communication between the organization and subcontractors through messaging and notifications.</li>
                        </ul>
                    </div>
                 </div> 
                 <div class="col-lg-6 justify-content-end" style="margin-top: -10em;">
                    <img src="../Resources/images/tailoring-processs.jpg" class="img-fluid card rounded-5" alt="Subcontract Management System">
                </div>
            </div>

            <div class="container ps-lg-5 pe-lg-5 mb-5 mt-5">
                <h4>About Developer</h4>
                <img src="../Resources/images/developer.jpg" class="img-fluid rounded-circle border border-1 mt-3" alt="Subcontract Management System">
                <p class="textJustify mt-4">The Subcontracts Management System was developed by A.D. Janaka Ruwan Kumara (K2557618 - janakark09@gmail.com) as a part of Individual Project of BSc Topup Program in Kington University. The system is designed to address the challenges organizations face in managing subcontracting processes, combining efficiency with a user-friendly interface to meet practical business needs.</p>
                    
                
            </div>
    </div>

</div>

</body>
</html>

