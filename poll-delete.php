<?php
require 'config.php';

$responses = [];

// use PDO to connect to our db
$pdo = pdo_connect_mysql();

if (isset($_GET['id'])) {
    //get the contact from the DB
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$poll) {
        exit('A poll did not exist with that ID.');
    }

    //Delete the record if the user click yes
    if (isset($_GET['confirm'])) {
        if($_GET['confirm'] == 'yes') {
            // user clicked ues button
            $stmt = $pdo->prepare('DELETE FROM `polls` WHERE `id` = ?');
            $stmt->execute([$_GET['id']]);

            $stmt = $pdo->prepare('DELETE FROM `poll_answers` WHERE `poll_id` = ?');
            $stmt->execute([$_GET['id']]);
            $responses[] = "You have deleted the poll! <a href='polls.php'>Return to poll page</a>";
        } else{
             header('Location: polls.php');
        }
    }
} else {
    $responses[] = 'No ID was found...';
}

?>

<?= template_header('Page Title') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<h1 class="title">Page Heading</h1>
<h2 class="subtitle">Are you sure you want to delete this poll.
    <?=$poll['id']?> - <?=$poll['title']?>?
</h2>

<?php if ($responses) : ?>
<p class="notification is-danger is-light">
    <?php echo implode('<br>', $responses); ?>
</p>
<?php endif; ?>

<div class="buttons">
    <a href="?id=<?=$poll['id']?>&confirm=yes" class="button is-success">Yes</a>
    <a href="?id=<?=$poll['id']?>&confirm=no" class="button is-danger">No</a>
</div>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>