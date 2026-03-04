<div class="row justify text-center">
                                <div class="col-xl-2 col-md-4">
                                    <label ><?php echo $user;?></label><br>
                                    <label class="mt-4">........................................</label><br>
                                    <label>Printed by</label><br>
                                    <label ><?php echo $createddt;?></label>
                                </div>
                                <div class="col-xl-2 col-md-4">
                                    <label ><?php
                                    $user='';
                                    $userRes=mysqli_query($conn,"SELECT CONCAT(Fname,' ',Lname) AS 'APPUS' FROM users WHERE User_ID='$approvedby'");
                                    if($u1=mysqli_fetch_assoc($userRes)) $user=$u1['APPUS'];
                                    echo $user;?></label><br>
                                    <label class="mt-4">........................................</label><br>
                                    <label>Approved by</label><br>
                                    <label ><?php echo $approveddt;?></label>
                                </div>
                                <div class="col-xl-2 col-md-4">
                                    <label ></label><br>
                                    <label class="mt-4">........................................</label><br>
                                    <label>Checked by</label><br>
                                </div>
                                <div class="col-xl-2 col-md-4">
                                    <label></label><br>
                                    <label class="mt-4">........................................</label><br>
                                    <label>Received by</label><br>
                                </div>
                                <div class="col-xl-2 col-md-4">
                                    <label >Remarks:</label><br>
                                    <label class="mt-4">................................</label>
                                </div>
                            </div>
                            <div class="row justify-content-center gap-3 mt-5 no-print">
                                <hr>
                                <?php
                                    if($accConfirm==1){
                                    ?>
                                    <input type="submit" class="btn btn-primary save_btn" value="Approve" name="btnApprove" id="btnApprove"/>
                                    <?php
                                    }
                                ?>
                                <button type="button" class="btn btn-success save_btn" onclick="window.print()">Print</button>
                            </div>
