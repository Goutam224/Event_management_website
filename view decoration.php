<?php
include 'connection.php';
include 'header.php';


$sql = "SELECT * FROM decorations WHERE id = {$_GET['id']}";
$res = mysqli_query($con, $sql);
$decoration_data = mysqli_fetch_assoc($res);

$sql = "SELECT * FROM decoration_gallery_images WHERE decoration_id = {$_GET['id']}";
$gallery_images = mysqli_query($con, $sql);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="view_decoration.css"> -->
    <!-- <link rel="stylesheet" href="fullscreen.css"> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h3 class="text-center"><?php echo ucwords($decoration_data['decoration_type']) ?> Images</h3>

        <div class="row text-center">
            <div class="col-md-12">
                <img height="400" width="400" src="<?php echo $decoration_data['image'] ?>" alt="" class="img-fluid rounded">
            </div>
        </div>
        <hr>
        <div class="row slide mt-4">
            <?php while ($row = mysqli_fetch_array($gallery_images)) { ?>
                <div class="col-md-4 mt-4 view-image " data-image="<?php echo $row['image'] ?>">
                    <img height="250" width="250" src="<?php echo $row['image'] ?>" alt="" class="img-fluid rounded" onclick="fullview(this.src)">
                    <div class="card-body">
                        <p class="card-text">INR - <?php echo $decoration_data['price'] ?></p>
                        <a href="bookevent.php?id=<?php echo $_GET['id']; ?>" class="btn btn-primary">Book Now</a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php echo ucwords($decoration_data['decoration_type']) ?></h5>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
        <script type="text/javascript">
        </script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
        <script>

            $(document).ready(function(){
                $(".view-image").click(function(){
                    var image = $(this).attr('data-image');
                    $(".modal-body").html('<img src="'+image+'" class="img-fluid">');
                    $("#exampleModal").modal('show');
                });
            });

            $('.slide').slick({
                centerMode: true,
                centerPadding: '60px',
                slidesToShow: 3,
                dots: true,

                responsive: [{
                        breakpoint: 768,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 1
                        }
                    }
                ]
            });
        </script>

</body>

</html>