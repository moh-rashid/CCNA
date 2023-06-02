<?php
require 'config.php';

//additional php code for this page goes here
session_start();

if(!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}


$stmt = $con->prepare('SELECT password, email FROM accounts WHERE id =?');

$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
$admincheck = $_SESSION['name'];

?>

<?= template_header('profile') ?>
<?= template_nav('Site Title') ?>

<div class="columns">


    <!-- START LEFT NAV COLUMN-->
    <?php if ($admincheck == 'admin') :?>
    <div class="column is-one-quarter">
        <aside class="menu">
            <p class="menu-label">General</p>
            <ul class="menu-list">
                <li><a href="admin.php"> Admin </a></li>
                <li><a href="index.php"> Index </a></li>
                <li><a href="profile.php" class="is-active"> Profile </a></li>
                <li><a href="polls.php"> Polls </a></li>
                <li><a href="contacts.php"> Contacts </a></li>
            </ul>
        </aside>
    </div>
    <?php endif?>
    <!-- END LEFT NAV COLUMN-->

    <!-- START RIGHT CONTENT COLUMN-->
    <div class="column">
        <h1 class="title"> </h1>
        <p>
        <h1 class="title">Profile</h1>
        <h2 class="subtitle">Your account information are below:</h2>
        <table class="table">
            <tr>
                <td>Username:</td>
                <td><?=$_SESSION['name']?></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><?=$password?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?=$email?></td>
            </tr>
        </table>
        </p>
    </div>
</div>

<?= template_footer() ?>