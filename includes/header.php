<?php
if(!isset($pageTitle)){
  $pageTitle = "DataSphere Club";
}
if(!isset($activePage)){
  $activePage = "";
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-with, initial-scale=1.0">
    <title>
      <?php echo escape($pageTitle); ?> | DataSphere
    </title>
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <header>
      <div class="container header-content">
        <div class="logo">
          <a href="index.php">DataShere</a>
          <p>Data Science &amp; AI Club</p>
        </div>
        <nav>
          <ul>
            <li>
              <a class="<?php echo $activePage === "home" ? "active" : ""; ?>"
                href="index.php"> Home
              </a>
            </li>
            <li>
              <a class="<?php echo $activePage === "events" ? "active" : ""; ?>"
                href="events.php"> Events
              </a>
            </li>
            <li>
              <a class="<?php echo $activePage === "register" ? "active" : ""; ?>"
                href="register.php"> Register
              </a>
            </li>
            <li>
              <a class="<?php echo $activePage === "registrations" ? "active" : ""; ?>"
                href="registrations.php"> Registration List
              </a>
            </li>
            <li>
              <a class="<?php echo $activePage === "about" ? "active" : ""; ?>"
                href="about.php"> About &amp; Contact
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </header>
