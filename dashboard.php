
<?php
include 'connection.php';
session_start();
if(!isset( $_SESSION['IS_LOGIN'])){
  header("location:login.php");
  
}
?>

<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
  
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="cssfiles/dashboard.css">
  </head>
  <body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary navbar bg-dark" data-bs-theme="dark" >
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Adorn Flora</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
    
        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="fetchevent.php">Booking Status</a>
        </li>

        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="confirmbookingview.php">Confirmed Bookings</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="changepassword.php">Change Password</a>
        </li>


        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Upload Files
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="carouselimage.php">Carousel Image</a></li>
            <li><a class="dropdown-item" href="decorations.php">Decoration Images</a></li>
          </ul>

          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Decoration Images
          </a>
          <ul class="dropdown-menu">
     
            <li><a class="dropdown-item" href="fetchdecoration.php">Decoration Main Images</a></li>
            <li><a class="dropdown-item" href="fetch_gallery_images.php">Decoration Gallery Images</a></li>
          </ul>
    
          <li class="nav-item">
          <a class="nav-link" href="carouseldata.php">Carousel Images</a>
        </li>

        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="payments.php">Payment Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="fullypaid.php">Completed Orders</a>
        </li>


        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="fetchcontact.php">Queries</a>
        </li>


      </ul> 
      
</ul>

        </li>

        <a href="logout.php" class="btn btn-outline-danger">Log out</a>
    </div>
  </div>
</nav>
<div class="container-fluid">
<h1 class="siteheading"> <strong>Ado</strong>rn Flora</h1>
</div>

<h4 class="title">The Perfect flora Design</h4>
  </body>
</html>
