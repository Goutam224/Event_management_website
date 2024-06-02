<?php
require 'vendor/autoload.php';
include 'connection.php';

use SendGrid\Mail\Mail as SendGridMail;

$id = $_GET['id'];

$query1 = mysqli_query($con, "SELECT * FROM bookevent WHERE id='$id'");
$row = mysqli_fetch_array($query1);

$gallery_image_id = $row['gallery_image_id'];

// Fetching price from bookevent table based on gallery image ID
$query2 = mysqli_query($con, "SELECT price FROM bookevent WHERE gallery_image_id='$gallery_image_id'");
$price_row = mysqli_fetch_assoc($query2);
$price = $price_row['price'];

// Fetching image from decoration_gallery_images table based on gallery image ID
$query3 = mysqli_query($con, "SELECT * FROM decoration_gallery_images WHERE id='$gallery_image_id'");
$gallery_image = mysqli_fetch_assoc($query3);

if (isset($_POST['submit'])) {
    // Get form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $date = $_POST['date'];
    $advanceprice = $_POST['advance'];
    $remaining_payment = $price - $advanceprice;

    if ($advanceprice <= $price) {
        // Sending confirmation email using SendGrid
        $emailMessage = new SendGridMail();
        $emailMessage->setFrom("adornflora01@gmail.com", "Adorn Flora");
        $emailMessage->setSubject("Adorn Flora - Booking Confirmation");
        $emailMessage->addTo($email, $name);
        $emailMessage->addContent("text/plain", "Thank you for booking with us. We accept your Event order request , You will check your status on the Booking Status page using your Email Id. Regards, Adorn Flora.");

        $sendgrid = new \SendGrid('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');

        try {
            $response = $sendgrid->send($emailMessage);
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }

        // Insert booking details into the database
        $sql = "INSERT INTO confirmedbooking (gallery_image_id, name, phone, email, address, date, price, status, advance_payment, remaining_payment) 
                VALUES ('$gallery_image_id', '$name', '$phone', '$email', '$address', '$date', $price, 'Approved', '$advanceprice', '$remaining_payment')";
        $approve = "UPDATE pending_list SET status='Confirmed' WHERE email='$email'";
        $approvedone = mysqli_query($con, $approve);
        $done = mysqli_query($con, $sql);

        if ($done) {
            // Delete the booking entry from the pending list
            $delete_sql = "DELETE FROM bookevent WHERE id='$id'";
            mysqli_query($con, $delete_sql);

            // Redirect to the booking view page after successful confirmation
            echo '<script>window.location.href = "confirmedbookingviewcompleted.php";</script>';
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Booking confirmed successfully. Redirecting to the booking view page...
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            exit;
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> There was an issue processing your request. Please try again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    } else {
        // Error handling if advance payment exceeds total price
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Advance payment is greater than the total price. Please check the price and try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmed Booking</title>
    <link rel="stylesheet" href="cssfiles/bookevent.css">
    <link rel="stylesheet" href="cssfiles/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
include 'requireddashboard.php';
?>
    <div class="container">
        <h1>CONFIRMED CLIENT BOOKING</h1>
        <hr>
        <div id="alert-placeholder"></div>

        <label for="name"><b>Image</b></label><br>
        <?php if ($gallery_image && isset($gallery_image['image'])): ?>
            <img src="<?php echo $gallery_image['image']; ?>" width="500px" alt="image" class="img-fluid rounded mx-auto d-block" name="gallery_image_id">
        <?php else: ?>
            <p>No image available</p>
        <?php endif; ?>
        <br>

        <form method="post" enctype="multipart/form-data">
            <label for="name"><b>Name</b></label>
            <input type="text" placeholder="Enter Your Name" name="name" id="name" value="<?php echo $row['name'] ?>" required>

            <label for="phone"><b>Phone Number</b></label>
            <input type="text" placeholder="Phone Number" name="phone" id="phone" value="<?php echo $row['phone'] ?>" required>

            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Enter Your Email" name="email" id="email" value="<?php echo $row['email'] ?>" required>

            <label for="address"><b>Address</b></label>
            <input type="text" placeholder="Enter Your Address" name="address" id="address" value="<?php echo $row['address'] ?>" required>

            <label for="date"><b>Select your Date</b></label>
            <input type="datetime-local" name="date" id="date" value="<?php echo $row['date'] ?>" required>
            <hr>

            <label for="price"><b>Total Price</b></label>
            <input type="text" placeholder="Total Price" name="price" id="price" value="<?php echo $price ?>" required>

            <label for="advance"><b>Advance Payment</b></label>
            <input type="text" placeholder="Advance Payment" name="advance" id="advance" required>
            <div>Remaining Payment: <span id="remaining_payment"></span></div>

            <button type="submit" name="submit" class="registerbtn">CONFIRM CLIENT BOOKING</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#advance').on('input', function () {
                var total_price = parseFloat($('#price').val());
                var advance_price = parseFloat($(this).val());
                var remaining_payment = total_price - advance_price;
                $('#remaining_payment').text(remaining_payment);
            });

            $('form').on('submit', function (e) {
                var total_price = parseFloat($('#price').val());
                var advance_price = parseFloat($('#advance').val());

                if (advance_price > total_price) {
                    e.preventDefault();
                    var alertHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        '<strong>Error!</strong> Advance payment is greater than the total price. Please check the price and try again.' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '</div>';
                    $('#alert-placeholder').html(alertHtml);
                }
            });
        });
    </script>
</body>
</html>
