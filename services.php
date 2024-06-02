<?php include 'connection.php'; ?>
<?php include 'header.php'; ?>

<link rel="stylesheet" href="cssfiles/services.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<link rel="stylesheet" href="cssfiles/fetch.css">
<link rel="stylesheet" href="cssfiles/footerstatus.css">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

<h3 class="text-center">Decorations</h3>
<div class="container">
<div class="row">
                <?php
                $sql = "SELECT * FROM decorations";
                $res = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_assoc($res)) {
                ?>
                         <div class="col-md-4 mt-4">
                                <a class="serviceanchor" href="view-decoration.php?id=<?php echo $row['id'] ?>">
                                        <img src="<?php echo $row['image'] ?>" class="card-img-top" width="350" height="350">
                                        <div class="card-body">
                                                <h3 class="card-title"><?php echo $row['decoration_type'] ?></h3>

                </a>
                        </div>
        </div>
<?php  } ?>
</div>
</div>
<?php
include 'footer.php';
?>