<?php include 'connection.php';
include 'requireddashboard.php';
if(isset($_POST['submit'])){
    if(isset($_GET['token'])){
        $token=$_GET['token'];
$newpassword=$_POST['password'];
$cpassword=$_POST['cpassword'];
$npass=password_hash($newpassword,PASSWORD_DEFAULT);
$cpass=password_hash($cpassword,PASSWORD_DEFAULT);

if($newpassword===$cpassword){
    $updatequery="UPDATE admininfo SET password='$npass' WHERE token='$token'";
    $query=mysqli_query($con,$updatequery);
    if($query){
        $_SESSION['msg']='<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Congratulations!</strong> Your Password Has Been Successfully Updated.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>' ;
      header('location:login.php');
    }else{
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>oopps!</strong> Your Password Is Not Updated.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>' ;
      header('location:recover_password.php');
    }
}
    else{
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>oopps!</strong> Password Does Not Match.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>' ;
    }
}
else{
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>oopps!</strong> Token Not Found.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>' ;
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   <link rel="stylesheet" href="cssfiles/signup.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
  <!DOCTYPE html>
<html lang="en">
<head>
  
    <title>Signup form</title>
 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
   
    </style>
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form  method="post" enctype="multipart/form-data">
        <h3>Reset Password Here</h3>


        <label for="password">New Password</label>
        <input type="password" placeholder=" New Password" id="password" name="password" minlength="6" required >

        <label for="password">Confirm Password</label>
        <input type="password" placeholder="Confirm Password" id="password"  name="cpassword" minlength="6" required >


        <input type="submit" value="Update Password" name="submit" class="button">
      
        
    </form>
</body>
</html>

 </body>
</html>