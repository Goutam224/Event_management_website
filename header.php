<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Adorn Flora</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="cssfiles/header.css">
  <style>
    .navcolor.active {
      color: red !important;
    }
  </style>
</head>
<body>
  <section class="header">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
          <a class="navbar-brand" id="sitename" href="index.php"><span>Ad</span>orn Flo<span>ra</span></a>
          <button id="navbutton" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-3 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link navcolor" id="home-link" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link navcolor" id="services-link" href="services.php">Decorations</a>
              </li>
              <li class="nav-item">
                <a class="nav-link navcolor" id="contact-link" href="contact.php">Contact Us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link navcolor" id="booking-link" href="userbookingstatus.php">Booking Status</a>
              </li>
            </ul>
            <a href="login.php" class="btn btn-outline-warning">Login</a>
          </div>
        </div>
      </nav>
    </div>
  </section>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Get the current page URL
      var currentPage = window.location.href;

      // Function to add active class to the current link
      function setActiveLink(linkId) {
        var link = document.getElementById(linkId);
        if (link) {
          link.classList.add("active");
          link.classList.add("navcolor");
        }
      }

      // Check which link should be active
      if (currentPage.includes("index.php")) {
        setActiveLink("home-link");
      } else if (currentPage.includes("services.php")) {
        setActiveLink("services-link");
      } else if (currentPage.includes("contact.php")) {
        setActiveLink("contact-link");
      } else if (currentPage.includes("userbookingstatus.php")) {
        setActiveLink("booking-link");
      }
    });
  </script>
</body>
</html>
