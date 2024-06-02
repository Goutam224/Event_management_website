<?php include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="cssfiles/fetchcontact.css">
  <!-- Fontawesome CDN Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <title>Contact Us</title>
</head>
<body>
<?php include 'requireddashboard.php';?>
<div class="container">
 

  <?php 

// Handle delete request
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM contact WHERE id = $id";
    if (mysqli_query($con, $sql)) {
        echo '<div class="alert alert-success" role="alert">Query deleted successfully.</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to delete the query. Please try again.</div>';
    }
}

// Fetch contact details from the database
$sql = "SELECT * FROM contact";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Query</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>';
    while($row = mysqli_fetch_assoc($result)) {
        echo '<tr>
                <td>' . $row['name'] . '</td>
                <td>' . $row['email'] . '</td>
                <td>' . $row['phone'] . '</td>
                <td>' . $row['query'] . '</td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="id" value="' . $row['id'] . '">
                        <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
              </tr>';
    }
    echo '</tbody>
        </table>';
} else {
    echo '<div class="alert alert-info" role="alert">No contact details found.</div>';
}
?>

</div>
</body>
</html>

