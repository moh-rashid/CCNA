<?php
require 'config.php';

//additional php code for this page goes here

?>

<?= template_header('Main') ?>
<?= template_nav('Home') ?>

    <!-- START PAGE CONTENT -->
    <h1 class="title">Main Navigation Menu</h1>
    <p>    <a href="contacts.php" class="button is-info">
		Contacts
	</a>
    <br>
    <a href="index.php" class = "button is-info">
        Blog
    </a>
    <br>
    <a href="polls.php" class="button is-info">
		Polls
	</a>
    <br>
    <a href="profile.php" class = "button is-info">
        Profile
    </a>
    </p>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>