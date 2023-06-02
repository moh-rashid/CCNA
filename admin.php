<?php
require 'config.php';

$pdo = pdo_connect_mysql();
session_start();


$responses = [];

 // If the user is not logged in redirect them to the login page
 if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
 }

 $stmt = $con->prepare('SELECT `password`, `email` FROM `accounts` WHERE id = ?');
 $stmt->bind_param('i', $_SESSION['id']);
 $stmt->execute();
 $stmt->bind_result($password, $email);
 $stmt->fetch();
 $stmt->close();

 
?>

<?= template_header('Page Title') ?>
<?= template_nav('Site Title') ?>


<div class="columns">
 <!-- START LEFT NAV COLUMN-->
 <div class="column is-one-quarter">
 <aside class="menu">
 <p class="menu-label"> Admin menu </p>
 <ul class="menu-list">
 <li><a href="admin.php" class="is-active"> Admin </a></li>
 <li><a href="profile.php"> Profile </a></li>
 <li><a href="polls.php"> Polls </a></li>
 <li><a href="contacts.php"> Contacts </a></li>
 </ul>
 </aside>
 </div>
 <!-- END LEFT NAV COLUMN-->
 <!-- START RIGHT CONTENT COLUMN-->
 <div class="column">
 <h1 class="title"> Page Title Goes Here </h1>
 <p> This is where page content goes. </p>
 </div>
 <!-- END RIGHT CONTENT COLUMN-->
</div>

<?= template_footer() ?>