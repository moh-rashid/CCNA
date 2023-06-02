<?php
require 'config.php';

$responses = [];

// use PDO to connect to our db
$pdo = pdo_connect_mysql();

if (isset($_GET['id'])) {
    //get the reviews$reviews from the DB
    $stmt = $pdo->prepare('SELECT * FROM reviews WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $reviews = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$reviews) {
        exit('A review did not exist with that ID.');
    }

    //Delete the record if the user click yes
    if (isset($_GET['confirm'])) {
        if($_GET['confirm'] == 'yes') {
            // user clicked ues button
            $stmt = $pdo->prepare('DELETE FROM `reviews` WHERE `id` = ?');
            $stmt->execute([$_GET['id']]);
            $responses[] = "You have deleted the review! <a href='reviews.php'>Return to review page</a>";
        } else{
            //$responses[] = 'The record was updated.';
             header('Location: reviews.php');
        }
    }
} else {
    $responses[] = 'No ID was found...';
}

?>

<?= template_header('Delete reviews') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<h1 class="title">Delete reviews</h1>
<h2 class="subtitle">Are you sure you want to delete reviews#
    <?=$reviews['id']?> - <?=$reviews['name']?>?
</h2>

<?php if ($responses) : ?>
<p class="notification is-danger is-light">
    <?php echo implode('<br>', $responses); ?>
</p>
<?php endif; ?>

<div class="buttons">
    <a href="?id=<?=$reviews['id']?>&confirm=yes" class="button is-success">Yes</a>
    <a href="?id=<?=$reviews['id']?>&confirm=no" class="button is-danger">No</a>

</div>

<!-- END PAGE CONTENT -->

<?= template_footer() ?>