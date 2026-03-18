<?php
include "../includes/db-con.php";

// Mark a single notification as read
if(isset($_POST['id'])) {
    $id = $_POST['id'];

    $query = "UPDATE notifications SET NotifyStatus='1' WHERE id='$id'";
    
    if(mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "error";
    }
}
// Mark all notifications as read for the logged-in user
if(isset($_SESSION['_UserID'])) {
    $UsrID = $_SESSION['_UserID'];

    $query = "UPDATE notifications SET NotifyStatus='1' WHERE attUser='$UsrID' AND NotifyStatus='0'";

    if(mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "no session";
}
?>