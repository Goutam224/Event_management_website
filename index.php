<?php
include 'connection.php';
?>
<?php
include 'header.php'
?>

<?php
$result = mysqli_query($con, "SELECT * FROM carouselimages");
$rowcount = mysqli_num_rows($result);

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&family=Raleway:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
<link rel="stylesheet" href="cssfiles/home.css">
<link rel="stylesheet" href="cssfiles/carousel.css">
<!-- <div class="container-fluid">
  <h1 class="heading">Adorn Flora</h1>
  <h3>The Perfect Flora Design</h3>
</div> -->

<div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel" >
    <div class="carousel-inner" >
<?php
for ($i = 1; $i <= $rowcount; $i++) {
  $row = mysqli_fetch_array($result);
?>
  
      <?php
      if ($i == 1) {
      ?>
        <div class="carousel-item active" data-bs-interval="2500">
          <img src="carouselimg/<?php echo $row["image"] ?>" class="border" height="750px" alt="...">
        </div> 
  <?php
      } 
      else {
  ?>
    <div class="carousel-item" data-bs-interval="2500">
      <img src="carouselimg/<?php echo $row["image"] ?>" class="border" height="750px" alt="...">
    </div>
<?php
      }
    
?>
 
<?php

}

?>
 </div> 
<div class="container">
  <p>
           <span>Adorn Flora</span> is known for planning and designing exceptional events. We have created a planning experience that 
               is as thorough as it is seamless, bringing a customized and tailored planning experience to those who value 
                 the <span>fine art </span> hosting, and desire to create an approachable, detail rich, <span>timeless </span> celebration. 

              We provide an unparalleled level of <span>personalized service </span> attention to detail, allowing us to fully understand 
               the intricacies of what makes your relationship unique to you as a couple, and limit our bookings to ensure we
                  are able  to uphold our incredibly <span>high standards </span> service. We are so excited you are here, and cannot wait to
                                   meet you and begin creating a celebration as special as your <span> love story.</span>
</p>
</div>
<hr>



<link rel="stylesheet" href="cssfiles/services.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<link rel="stylesheet" href="cssfiles/fetch.css">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

<h1 class="text-center">Decoration</h1>
<div class="container">
<div class="row">
                <?php
                $sql = "SELECT * FROM decorations";
                $res = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_assoc($res)) {
                ?>
                         <div class="col-md-4 mt-4">
                                <a class="serviceanchor" href="view-decoration.php?id=<?php echo $row['id'] ?>">
                                        <img src="<?php echo $row['image'] ?>" class="card-img-top rounded" width="350" height="350">
                                        <div class="card-body">
                                                <h3 class="card-title"><?php echo $row['decoration_type'] ?></h3>

                </a>
                        </div>
        </div>
<?php  } ?>
</div>
</div>








<div>
  <hr>
</div>
<div class="centerlist"><ul>
  <li> VIEW OUR  <span><a href="index.php">Home </a> </span> </li><br>
  <li> REVIEW OUR  <span><a href="services.php"> Decorations</a> </span></li>
  <li> REACH US  <span><a href="contact.php"> Contact Us </a> </span></li>
</ul>
</div>

<?php include 'footer.php'; ?>