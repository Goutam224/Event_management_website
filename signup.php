<?php include 'connection.php';
?>

<?php
 if(isset($_POST['submit'])){
    $username=$_POST['username'];
    $phone=$_POST['phone'];
    $password=$_POST['password'];
    $cpassword=$_POST['cpassword'];
$sql="SELECT * FROM `admininfo` WHERE (username='$username')";

      $res=mysqli_query($con,$sql);

      if (mysqli_num_rows($res) > 0) {
        
        $row = mysqli_fetch_assoc($res);
        if($username==isset($row['username']))
        {
            	echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>oopps!</strong> Username Already Exist.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>' ;
        
        }
		}
else{   
        if($password===$cpassword){
          $hash=password_hash($password,PASSWORD_DEFAULT);
          $chash=password_hash($cpassword,PASSWORD_DEFAULT);
          $token=bin2hex(random_bytes(16));
            $sql="INSERT INTO admininfo(username,phone,password,cpassword,token,status) VALUES ('$username','$phone','$hash','$chash','$token','inactive')";
            $result=mysqli_query($con,$sql);
            if($result){
      
$subject = "Account Activation Mail";
$body = "Hi, $username. Click Here To Activate Your Account
http://localhost/adornflora/activate.php?token=$token";
$headers = "From : tester91314@gmail.com";

if(mail($username, $subject, $body, $headers)) {
  $_SESSION['msg']='<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Congratulations!</strong> Check Your Email To Activate Your Account '.$username.'
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
    header('location:login.php');
}else{
    echo "Email sending failed...";
}
            }
           echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Congratulations!</strong> You Have Successfully Registered Your Account , Now You have To Logged In.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
       
        }
            else{
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Sorry !</strong> Passwords Does not matched.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
            }
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
    <title>Login form</title>
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
        <h3>Signup Here</h3>

        <label for="username">Username</label>
        <input type="text" placeholder="Email" id="username" name="username" required>


        <label for="password">Mobile No.</label>
        <input type="text" placeholder="Mobile Number" id="mobile"  name="phone" required >

        <label for="password">Password</label>
        <input type="password" placeholder="Password" id="password" name="password" minlength="6" required >

        <label for="password">Confirm Password</label>
        <input type="password" placeholder="Confirm Password" id="password"  name="cpassword" minlength="6" required >


        <input type="submit" value="Sign Up" name="submit" class="button">
      
        <p class="loginheading">Already Have An Account?</p>
  
       <a href="login.php">Log in</a>
        
        <div class="social">
          <div class="go"><i class="fab fa-google"></i>  Google</div>
          <div class="fb"><i class="fab fa-facebook"></i>  Facebook</div>
        </div>
    </form>
</body>
</html>

 </body>
</html>