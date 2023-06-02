<?php
require 'config.php';

$responses = [];

// use PDO to connect to our db
$pdo = pdo_connect_mysql();

if (isset($_GET['id'])) {
    //get the blog$blog from the DB
    $stmt = $pdo->prepare('SELECT * FROM blog_post WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$blog) {
        exit('A blog did not exist with that ID.');
    }

    //Delete the record if the user click yes
    if (isset($_GET['confirm'])) {
        if($_GET['confirm'] == 'yes') {
            // user clicked ues button
            $stmt = $pdo->prepare('DELETE FROM `blog_post` WHERE `id` = ?');
            $stmt->execute([$_GET['id']]);
            $responses[] = "You have deleted the blog! <a href='index.php'>Return to blog page</a>";
        } else{
            //$responses[] = 'The record was updated.';
             header('Location: index.php');
        }
    }
} else {
    $responses[] = 'No ID was found...';
}

?>

<?= template_header('Delete blog') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<h1 class="title">Delete blog</h1>
<h2 class="subtitle">Are you sure you want to delete blog#
    <?=$blog['id']?> - <?=$blog['title']?>?
</h2>

<?php if ($responses) : ?>
<p class="notification is-danger is-light">
    <?php echo implode('<br>', $responses); ?>
</p>
<?php endif; ?>

<div class="buttons">
    <a href="?id=<?=$blog['id']?>&confirm=yes" class="button is-success">Yes</a>
    <a href="?id=<?=$blog['id']?>&confirm=no" class="button is-danger">No</a>

</div>

<!-- END PAGE CONTENT -->

<?= template_footer() ?>