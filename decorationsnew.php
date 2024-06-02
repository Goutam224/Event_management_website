<?php
include 'connection.php';
include 'requireddashboard.php';

if(isset($_POST['decoration_type'])) {
    $decoration_type = ucwords($_POST['decoration_type']);
    $image = $_FILES['image']['name'];
    $price = $_POST['price'];
    // create folder if not exists according to the decoration type

    if (!file_exists("decorations/" . $decoration_type)) {
        mkdir("decorations/" . $decoration_type);
    }

    $image = "decorations/" . $decoration_type . "/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
        $sql = "INSERT INTO decorations (decoration_type, image, price) VALUES ('$decoration_type', '$image', '$price')";
        $res = mysqli_query($con, $sql);
        if ($res) {       
            // upload gallery images in decoration_gallery_images table
            $decoration_id = mysqli_insert_id($con);
            $gallery_images = $_FILES['gallery_images']['name'];
            foreach ($gallery_images as $key => $value) {
                $gallery_image = "decorations/" . $decoration_type . "/" . basename($value);
                $sql = "INSERT INTO decoration_gallery_images (decoration_id, image) VALUES ('$decoration_id', '$gallery_image')";
                mysqli_query($con, $sql);
                move_uploaded_file($_FILES['gallery_images']['tmp_name'][$key], $gallery_image);
            }
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Hey!</strong> Your Image is Successfully Uploaded.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';

        } else {
            echo "Something went wrong";
        }
    } else {
        echo "There was a problem uploading image";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cssfiles/decorations.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <title>Decorations</title>
</head>

<body>
    <br>
    <div class="container">
        <h3 class="text-center">Create New Decoration</h3>
        <div class="row">
            <div class="col-md-6 offset-md-3 form-container">
                <div class="mb-2 ">
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="decoration_type">Decoration Name</label>
                            <input type="text" name="decoration_type" class="form-control">
                        </div>
                      

                        <div class="form-group mt-3">
                            <label for="">Decoration Main Image</label>
                            <input class="form-control" type="file" accept="image/png, image/jpeg" name="image" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="">Decoration Gallery Images</label>
                            <input type="file" name="gallery_images[]"  accept="image/png, image/jpeg" class="form-control" multiple>
                        </div>
                        <div class="form-group mt-3">
                            <label for="price">Price</label>
                            <input type="text" name="price" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success mt-4 text-center">Save</button>
                    </form>
                </div>
            </div>
        </div>
        <hr>
        <div class="row mt-5">
            <div class="col-md-12">
                <h1 class="text-center">Decorations</h1>
                <div class="table-responsive">
                    <table class="table table-hover"> 
                        <thead>
                            <tr>
                                <th>Decoration name</th>
                                <th>Decoration image</th>
                                <th>Decoration gallery images</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM decorations";
                            $res = mysqli_query($con, $sql);
                            while ($row = mysqli_fetch_assoc($res)) {
                                $decoration_id = $row['id'];
                                $decoration_type = $row['decoration_type'];
                                $image = $row['image'];
                                $price = $row['price'];
                                $sql = "SELECT * FROM decoration_gallery_images WHERE decoration_id = '$decoration_id'";
                                $res2 = mysqli_query($con, $sql);
                                $gallery_images = "";
                                while ($row2 = mysqli_fetch_assoc($res2)) {
                                    $gallery_images .= "<img src='" . $row2['image'] . "' width='100' height='100'> &nbsp;";
                                }
                            ?>
                                <tr>
                                    <td><?php echo $decoration_type ?></td>
                                    <td><img src="<?php echo $image ?>" width="100" height="100"></td>
                                    <td><?php echo $gallery_images ?></td>
                                    <td><?php echo $price ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
