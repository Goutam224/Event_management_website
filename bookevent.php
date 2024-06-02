<?php
include 'connection.php';
include 'header.php';
require 'vendor/autoload.php';

use SendGrid\Mail\Mail as SendGridMail;

$id = intval($_GET['id']);
$gallery_image_id = isset($_GET['gallery_image_id']) ? intval($_GET['gallery_image_id']) : null;

// Fetch decoration data
$sql = "SELECT * FROM decorations WHERE id = '$id'";
$res = mysqli_query($con, $sql);
$decoration = mysqli_fetch_assoc($res);

// Fetch the specific gallery image if `gallery_image_id` is provided
if ($gallery_image_id) {
    $query = "SELECT * FROM decoration_gallery_images WHERE id='$gallery_image_id' AND decoration_id='$id'";
} else {
    // Fallback to the first image if `gallery_image_id` is not provided
    $query = "SELECT * FROM decoration_gallery_images WHERE decoration_id='$id' LIMIT 1";
}

$result = mysqli_query($con, $query);
$imageRow = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $date = $_POST['date'];
    $price = $imageRow['price']; // Get price from the selected image

    // Send email confirmation using SendGrid
    $emailMessage = new SendGridMail();
    $emailMessage->setFrom("sender id", "Adorn Flora");
    $emailMessage->setSubject("Adorn Flora - Booking Confirmation");
    $emailMessage->addTo($email, $name);
    $emailMessage->addContent("text/plain", "Thank you for booking with us. We will contact you shortly. Regards, Adorn Flora.");

    $sendgrid = new \SendGrid('sendgrid api key');

    try {
        $response = $sendgrid->send($emailMessage);

        $sql = "INSERT INTO bookevent (name, phone, email, address, date, gallery_image_id, price) VALUES ('$name', '$phone', '$email', '$address', '$date', '$gallery_image_id', '$price')";
        $sql1 = "INSERT INTO pending_list (name, phone, email, address, date, status) VALUES ('$name', '$phone', '$email', '$address', '$date', 'pending')";

        $add = mysqli_query($con, $sql1);
        $done = mysqli_query($con, $sql);

        if ($done) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Thank You!</strong> for booking Your Date With Adorn Flora. You will receive updates shortly on Your email. Your Booking is under Process.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            echo "<script>
                    setTimeout(function(){
                        window.location.href = 'index.php';
                    }, 3000);
                </script>";
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Oops!</strong> There was an error processing your request.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Book Your Date</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Book Your Date</h1>
        <hr>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image"><b>Gallery Image</b></label><br>
                <img src="<?php echo $imageRow['image']; ?>" width="500px" alt="Decoration Gallery Image" class="img-fluid rounded mx-auto d-block">
            </div>
            <div class="form-group">
                <label for="price"><b>Price</b></label><br>
                <p><?php echo $imageRow['price']; ?></p>
            </div>
            <div class="form-group">
                <label for="name"><b>Name</b></label>
                <input type="text" class="form-control" placeholder="Enter Your Name" name="name" required>
            </div>
            <div class="form-group">
                <label for="phone"><b>Phone Number</b></label>
                <input type="text" class="form-control" placeholder="Enter Your Phone Number" name="phone" required>
            </div>
            <div class="form-group">
                <label for="email"><b>Email</b></label>
                <input type="email" class="form-control" placeholder="Enter Your Email" name="email" required>
            </div>
            <div class="form-group">
                <label for="address"><b>Address</b></label>
                <textarea name="address" placeholder="Enter Your Address" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="date"><b>Date</b></label>
                <input type="date" name="date" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary mt-3">Book Now</button>
        </form>
    </div>
</body>
</html>
