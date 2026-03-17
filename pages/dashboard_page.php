 <?php
    include "../includes/db-con.php";
    //---------------------------------------------- counts -----------------------------------------

    $vendors = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM vendors WHERE status='Active'"));
    $orders = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM styleorder WHERE Status='Active'"));
    $gatepass = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as TOTALAGR FROM `agreements` WHERE Status='Active' AND endDate > NOW();"));
    $grn = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS 'PAYBLEGRN' FROM grn_details WHERE status='Approved' AND receiptID!=''"));
    $payments = mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(fgValue+sampleValue) AS 'PAYBLE' FROM grn_details WHERE status='Approved' AND receiptID!=''"));

    /*------------------------------------ Vendor Performance -------------------------------------*/

    $vlabels=[];
    $vdata=[];

    $q=mysqli_query($conn,"SELECT v.vendor,SUM(g.recFnishedQty) qty FROM grn_details g JOIN vendors v ON g.VendorID=v.vendorID GROUP BY v.vendorID");

    while($r=mysqli_fetch_assoc($q)){
        $vlabels[]=$r['vendor'];
        $vdata[]=$r['qty'];
    }

    /*------------------------------------ Production vs Received ----------------------------------*/

    $prod=[];
    $recv=[];

    $q2=mysqli_query($conn,"SELECT SUM(finishedQty) prod,SUM(recFnishedQty) recv FROM sub_pro_details");

    $row=mysqli_fetch_assoc($q2);

    $prod=$row['prod'];
    $recv=$row['recv'];

    /*----------------------------- Payment Summary --------------------------------------*/

    $payVendor=[];
    $payValue=[];

    $q3=mysqli_query($conn,"SELECT v.vendor,SUM(p.netValue) total FROM payments p JOIN vendors v ON p.VendorID=v.vendorID GROUP BY v.vendorID");

    while($r=mysqli_fetch_assoc($q3)){
        $payVendor[]=$r['vendor'];
        $payValue[]=$r['total'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
    .card-box{
        padding:20px;
        color:white;
        border-radius:10px;
    }
    .card-kpi{
        color:white;
        padding:20px;
        border-radius:10px;
        height: 120px;
    }
    </style>
</head>
<body>
    <div class="container">
        <div class="container mt-4" >
            <h3 class="mb-4">Subcontractor Management Dashboard</h3>
            <div class="row g-4 gap-3 justify-content-center">
                <div class="col-lg-2 col-md-3">
                    <div class="card-kpi bg-primary">
                        <h6>Total Active Vendors</h6>
                        <h3><?php echo $vendors['total']; ?></h3>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="card-kpi bg-success">
                        <h6>Total Style Orders</h6>
                        <h3><?php echo $orders['total']; ?></h3>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3">
                    <div class="card-kpi bg-warning">
                        <h6>Active Agreements</h6>
                        <h3><?php echo $gatepass['TOTALAGR']; ?></h3>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3">
                    <div class="card-kpi bg-danger">
                        <h6>Payble GRNs</h6>
                        <h3><?php echo $grn['PAYBLEGRN']; ?></h3>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3">
                    <div class="card-kpi bg-dark">
                        <h6>Total Payables</h6>
                        <h4><?php echo number_format($payments['PAYBLE'],2); ?></h4>
                    </div>
                </div>
            </div>

            <!-------------------------------------- Vendor Performance Chart ---------------------------------->
            <div class="container-fluid">
                <div class="card mt-4">
                    <div class="card-header">Vendor Performance</div>
                    <div class="card-body">
                        <canvas id="vendorChart"></canvas>
                    </div>
                </div>
            </div>

            <!------------------------Production Progress Chart -------------------------------------->
            <div class="d-flex gap-5">
                <div class="col-lg-3 card mt-4">
                    <div class="card-header">Production vs Received</div>
                    <div class="card-body">
                        <canvas id="prodChart"></canvas>
                    </div>
                </div>

            <!------------------------------- payment chart ----------------------------------->
                <div class="col-lg-3 card mt-4">
                    <div class="card-header">Vendor Payments</div>

                    <div class="card-body">
                        <canvas id="payChart"></canvas>
                    </div>
                </div>
            </div>
            

            <!-- ------------------------- Top Vendors List ---------------------------- -->
            <div>
                <h4 class="mt-5">Top Vendors</h4>

                <table class="table table-bordered">
                    <tr>
                        <th>Vendor</th>
                        <th>Total Finished Qty</th>
                    </tr>
                        <?php

                            $q=mysqli_query($conn,"SELECT v.vendor,SUM(g.recFnishedQty) qty FROM grn_details g JOIN vendors v ON g.VendorID=v.vendorID
                            GROUP BY v.vendorID ORDER BY qty DESC LIMIT 5");

                            while($r=mysqli_fetch_assoc($q)){

                            echo "<tr>
                                <td>".$r['vendor']."</td>
                                <td>".$r['qty']."</td>
                            </tr>";

                            }

                        ?>

                </table> 
            </div>
        </div>
    </div>
    

    <script>
        new Chart(document.getElementById('vendorChart'),{

            type:'bar',

            data:{
            labels:<?php echo json_encode($vlabels); ?>,
            datasets:[{
            label:'Finished Qty',
            data:<?php echo json_encode($vdata); ?>,
            backgroundColor:'rgba(54,162,235,0.7)'
            }]
            }

            });
        
        new Chart(document.getElementById('prodChart'),{

            type:'pie',

            data:{
            labels:['Produced','Received'],
            datasets:[{
            data:[<?php echo $prod ?>,<?php echo $recv ?>],
            backgroundColor:['green','blue']
            }]
            }

        });

        new Chart(document.getElementById('payChart'),{

            type:'bar',

            data:{
            labels:<?php echo json_encode($payVendor); ?>,
            datasets:[{
            label:'Payment Value',
            data:<?php echo json_encode($payValue); ?>,
            backgroundColor:'orange'
            }]
            }
        });
    </script>
</body>
</html>