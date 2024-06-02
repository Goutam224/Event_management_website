<?php
session_start();
include 'connection.php';
if(isset($_GET['token'])){
    $token=$_GET['token'];
    $update="UPDATE admininfo SET status='active' WHERE token='$token'";
    $result=mysqli_query($con,$update);
    if($result){
        if(isset($_SESSION['msg'])){
            $_SESSION['msg']='<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Congratulations!</strong> Account Activated Successfully , Now You have To Logged In.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';
          header('location:login.php');
        }else{
$_SESSION['msg']='<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>Oops!</strong> You Are Logged Out.
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>';
header('location:login.php');
        }
    }
        else{
            $_SESSION['msg']='<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sorry!</strong> Please Register Your Account.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';
          header('location:signup.php');
        }
    
}

?>