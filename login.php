<?php include 'connection.php';
if(isset($_POST['submit'])){
$username=$_POST['username'];
$password=$_POST['password'];
$query = "SELECT * FROM admininfo WHERE username='$username' and status='active'";
$result=mysqli_query($con,$query);
if(mysqli_num_rows($result)>0){

    $row=mysqli_fetch_assoc($result);
    $verify=password_verify($password,$row['password']);
if($verify==1){
  session_start();
    $_SESSION['IS_LOGIN']=true;
    $_SESSION['USERNAME']=$row['username'];
            header('location:dashboard.php');
            die();
        }
        else{
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>oopps!</strong> You Entered Wrong Password.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>' ;
        }
    }
else{
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>oopps!</strong> You Entered Inccorect Username.
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
    <title>Login Page</title>
</head>
<body>
  <!DOCTYPE html>
<html lang="en">
<head>

 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->
    
</head>
<body>

    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="post" enctype="multipart/form-data">
        <h3>Login Here</h3>
        <h3>(For Admin Only)</h3>

        <label for="username">Username</label>
        <input type="text" placeholder="Email" id="username" name="username" class="text-center" required>

        <label for="password">Password</label>
        <input type="password" placeholder="Password" id="password" name="password" class="text-center" required >

      
        <input type="submit" value="Log In" name="submit" class="button">
      
        </div><br>
       <p class="text-center">Forgot Your Password ?  <a href="recover.php">Click Here</a></p>
    </form>
</body>
</html>

 </body>
</html>