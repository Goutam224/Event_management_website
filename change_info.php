<?php 
include 'connection.php';

?>

<?php
 if(isset($_POST['submit'])){
    $sitename=$_POST['sitename'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $address=$_POST['address'];
$sql="UPDATE siteinfo SET sitename='$sitename',email='$email',phone='$phone',address='$address' WHERE (id='1')";
$query=mysqli_query($con,$sql);
if($query){
    echo "Updated successfully";
}else{
    echo "failed to update";
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
  
    <title>Change Info Here</title>
 
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
        <h3>Change Info Here</h3>

        
        <label for="username">Site Name</label>
        <input type="text" placeholder="Site Name" id="sitename" name="sitename" >

        <a href="nameupdate" class="btn btn-outline success">UPDATE</a>
        <label for="username">Email</label>
        <input type="text" placeholder="Email" id="username" name="email" required>


        <label for="password">Mobile No.</label>
        <input type="text" placeholder="Mobile Number" id="mobile"  name="phone" required >


        <label for="password">Address</label>
        <input type="text" placeholder="Mobile Number" id="address"  name="address" required >

        <input type="submit" value="Change" name="submit" class="button">
      
        
    </form>
</body>
</html>

 </body>
</html>