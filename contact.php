<?php 
require './vendor/autoload.php'; // Include Composer autoloader
include 'connection.php';


if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $query = $_POST['query'];
    
    $sql = "INSERT INTO contact(name, email, phone, query) VALUES ('$name', '$email', '$phone', '$query')";
    $done = mysqli_query($con, $sql);
    
    if ($done) {
        // Send email using SendGrid
        $sendgrid_api_key = 'sendgrid api key';
        $to_email = $email;
        $email_subject = 'Adorn Flora';
        $email_body = 'Thank you for filling the enquiry form. Our team will contact you within 24 hours to resolve your query. Regards, Adorn Flora.';
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
                  <strong>Thank You!</strong> for filling the enquiry form.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  </div>';
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
              <strong>Oops!</strong> There was an error with your submission. Please try again later.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </div>';
    }
} else {
    echo "";
}
?>
<?php
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="cssfiles/contact.css">
  <!-- Fontawesome CDN Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <title>Contact Us</title>
</head>
<body>
<div class="container1">
  <div class="content">
    <div class="left-side">
      <div class="address details">
        <i class="fas fa-map-marker-alt"></i>
        <div class="topic">Address</div>
        <div class="text-one">Khudel Bujurg</div>
        <div class="text-two">Indore, 452016</div>
      </div>
      <div class="phone details">
        <i class="fas fa-phone-alt"></i>
        <div class="topic">Phone</div>
        <div class="text-one">+91 7047347674</div>
      </div>
      <div class="email details">
        <a href="mailto:adornflora01@gmail.com"><i class="fas fa-envelope"></i></a>
        <div class="topic">Email</div>
        <div class="text-one">adornflora01@gmail.com</div>
      </div>
    </div>
    <div class="right-side">
      <div class="topic-text">Send us a message or provide me a Feedback</div>
      <p>If you have any work from me or any types of queries related to my work and also you can provide me a feedback as how much did you love my work, you can send me a message from here. It's my pleasure to help you.</p>
      <form action="" method="post">
        <div class="input-box">
          <input type="text" name="name" placeholder="Enter your name" required>
        </div>
        <div class="input-box">
          <input type="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="input-box">
          <input type="text" name="phone" placeholder="Enter your phone No." required>
        </div>
        <div class="input-box message-box">
          <input type="text" name="query" class="input-box" placeholder="Write Your Query" required>
        </div>
        <div class="button">
          <input type="submit" value="Send Now" name="submit">
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'footer.php';?>
</body>
</html>
