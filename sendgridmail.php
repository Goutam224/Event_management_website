<?php
require './vendor/autoload.php'; // Make sure this path is correct
include 'connection.php';
include 'header.php';

$id = $_GET['id'];
$sql = "SELECT * FROM decorations WHERE id = '$id'";
$res = mysqli_query($con, $sql);
$price = mysqli_fetch_assoc($res);

$num = mysqli_num_rows($res);

$id = $_GET['id'];
$query = mysqli_query($con, "SELECT * FROM decoration_gallery_images WHERE id='$id'");
$row = mysqli_fetch_array($query);

$sql1 = "SELECT * FROM decorations WHERE id ='$id'";
$res1 = mysqli_query($con, $sql1);
$decoration_data = mysqli_fetch_assoc($res1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="cssfiles/bookevent.css">
  <title>Document</title>
</head>
<body>
<form method="post" enctype="multipart/form-data">
  <div class="container">
    <h1>Book Your Date</h1>
    <hr>
    <label for="name"><b>Image</b></label><br>
    <img src="<?php echo $row['image']; ?>" width="500px" alt="image" class="img-fluid rounded mx-auto d-block" name="image">
    <br>
    <label for="name"><b>Name</b></label>
    <input type="text" placeholder="Enter Your Name" name="name" id="email" required>

    <label for="phone"><b>Phone Number</b></label>
    <input type="text" placeholder="Phone Number" name="phone" id="" required>

    <label for="email"><b>Email</b></label>
    <input type="email" placeholder="Enter Your Email" name="email" id="" required>

    <label for="address"><b>Address</b></label>
    <input type="text" placeholder="Enter Your Address" name="address" id="" required>

    <label for="date"><b>Select your Date</b></label>
    <input type="datetime-local" name="date" id="date" required>
    <hr>
    <label for="price"><b>Total Price - </b><?php echo $price['price']; ?></label>
    <button type="submit" name="submit" class="registerbtn">BOOK YOUR DATE</button>
  </div>
</form>

<?php
if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $date = $_POST['date'];

  $sql = "INSERT INTO bookevent(name, phone, email, address, date, decoration_id) VALUES ('$name', '$phone', '$email', '$address', '$date', '$id')";
  $sql1 = "INSERT INTO pending_list(name, phone, email, address, date, status) VALUES ('$name', '$phone', '$email', '$address', '$date', 'pending')";
  $add = mysqli_query($con, $sql1);
  $done = mysqli_query($con, $sql);

  if ($done) {
    // Send email using SendGrid
    $sendgrid_api_key = 'YOUR_SENDGRID_API_KEY';
    $email_subject = 'Adorn Flora';
    $email_body = 'Thank you for booking your date. Regards, Adorn Flora.';
    $from_email = 'sender id';
    $from_name = 'Adorn Flora';

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom($from_email, $from_name);
    $email->setSubject($email_subject);
    $email->addTo($to_email, $name);
    $email->addContent("text/plain", $email_body);

    $sendgrid = new \SendGrid($sendgrid_api_key);

    try {
      $response = $sendgrid->send($email);
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Thank You!</strong> for booking Your Date With Adorn Flora, You will receive Your booking updates shortly on Your email.
              Your Booking is under Process.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
      echo "<script>
              setTimeout(function(){
                window.location.href = 'index.php';
              }, 3000);
            </script>";
    } catch (Exception $e) {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Oops!</strong> There was an error sending your email. Please try again later.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
  } else {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Oops!</strong> There was an error with your booking. Please try again later.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';
  }
} else {
  echo "";
}
?>

</body>
</html>
