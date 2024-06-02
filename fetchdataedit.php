<?php
ob_start(); // Start output buffering
include 'connection.php';
include 'requireddashboard.php';

// Fetch decoration prices
$sql = "SELECT * FROM decorations";
$res = mysqli_query($con, $sql);
$price = mysqli_fetch_assoc($res);

// Fetch booking details based on ID
$id = $_GET['id'];
$query = mysqli_query($con, "SELECT * FROM bookevent WHERE id='$id'");
$row = mysqli_fetch_array($query);

// Fetch decoration prices based on the booked decoration ID
$decorationId = $row['gallery_image_id'];
$decorationQuery = mysqli_query($con, "SELECT * FROM decoration_gallery_images WHERE id='$decorationId'");
$decorationRow = mysqli_fetch_assoc($decorationQuery);
$decorationPrice = $decorationRow['price'];

?>

<link rel="stylesheet" href="cssfiles/bookevent.css">
<link rel="stylesheet" href="cssfiles/dashboard.css">

<form method="post" enctype="multipart/form-data">
    <div class="container">
        <h1>Update Booking Information</h1>
        <hr>

        <label for="name"><b>Name</b></label>
        <input type="text" placeholder="Enter Your Name" name="name" value="<?php echo $row['name'] ?>" required>

        <label for="phone"><b>Phone Number</b></label>
        <input type="text" placeholder="Phone Number" name="phone" value="<?php echo $row['phone'] ?>" required>

        <label for="email"><b>Email</b></label>
        <input type="email" placeholder="Enter Your Email" name="email" value="<?php echo $row['email'] ?>" required>

        <label for="address"><b>Address</b></label>
        <input type="text" placeholder="Enter Your Address" name="address" value="<?php echo $row['address'] ?>" required>

        <label for="date"><b>Select your Date</b></label>
        <input type="datetime-local" name="date" value="<?php echo date('Y-m-d\TH:i', strtotime($row['date'])) ?>" required>

        <hr>

        <label for="price"><b>Total Price</b></label>
        <input type="text" disabled value="<?php echo $decorationPrice ?>">

        <button type="submit" name="submit" class="registerbtn">Update Booking Information</button>
    </div>
</form>

<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $date = date('Y-m-d H:i:s', strtotime($_POST['date']));

    // Update booking details
    $sql = "UPDATE bookevent SET name='$name', phone='$phone', email='$email', address='$address', date='$date' WHERE id='$id'";
    $done = mysqli_query($con, $sql);

    if ($done) {
        // Send email using SendGrid
        require './vendor/autoload.php';
        $emailMessage = new \SendGrid\Mail\Mail();
        $emailMessage->setFrom("adornflora01@gmail.com", "Adorn Flora");
        $emailMessage->setSubject("Booking Information Updated");
        $emailMessage->addTo($email, $name);
        $emailMessage->addContent("text/plain", "Your booking information has been updated. Thank you for choosing Adorn Flora.");
        $sendgrid = new \SendGrid('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');

        try {
            $response = $sendgrid->send($emailMessage);
            header('Location: fetchevent.php'); // Redirect with capital L in Location
            exit; // Stop further execution
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> There was an error updating your booking information.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
}

ob_end_flush(); // Flush the output buffer
?>
