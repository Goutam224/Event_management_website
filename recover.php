<?php
include 'connection.php';
require 'vendor/autoload.php'; // Include SendGrid library
use SendGrid\Mail\Mail;

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $sql = "SELECT * FROM `admininfo` WHERE username='$username'";
    $res = mysqli_query($con, $sql);

    if (mysqli_num_rows($res) > 0) {
        $userdata = mysqli_fetch_array($res);
        $useremail = $userdata['username'];
        $token = $userdata['token'];
        $subject = "Reset Password";
        $body = "Hi, $username. Click Here To Reset Your Password
http://localhost/adornflora/recover_password.php?token=$token";
        
        $email = new Mail();
        $email->setFrom("adornflora01@gmail.com", "AdornFlora");
        $email->setSubject($subject);
        $email->addTo($username);
        $email->addContent("text/plain", $body);

        $sendgrid = new \SendGrid('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');

        try {
            $response = $sendgrid->send($email);
            if ($response->statusCode() == 202) {
                $_SESSION['msg'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Congratulations!</strong> Check Your Email To Reset Your Password ' . $username . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                header('location:login.php');
            } else {
                echo "Email sending failed...";
            }
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    } else {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Sorry!</strong> Email Not Found.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="cssfiles/signup.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKpH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>Recover Password</title>
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="post" enctype="multipart/form-data">
        <h3>Recover Your Password Here</h3>

        <label for="username">Username</label>
        <input type="text" placeholder="Email" id="username" name="username" required>

        <input type="submit" value="Send Email" name="submit" class="button">
    </form>
</body>
</html>