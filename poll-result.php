<?php
require 'config.php';

$pdo = pdo_connect_mysql();

$responses = [];

if (isset ($_GET['id'])) {
    //get the poll answers for the poll that matches the id
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);

    //check to see if a poll with that id exists
   if ($poll){
        //get the poll answers
        $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ?'); 
        $stmt->execute([$_GET['id']]);
        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC); 

        //total number of votes
        $total_votes = 0;
         foreach ($poll_answers as $poll_answer) {
             $total_votes += $poll_answer['votes'];
         }
} else {
    $responses[] = 'A poll with that ID was not found.';
}
} else {
    $responses[] = 'A poll with that ID was not found.';
}

?>
<?= template_header('Poll results') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<h1 class="title">Poll results</h1>
<?php if ($responses) : ?>
<p class="notification is-danger is-light">
    <?php echo implode('<br>', $responses); ?>
</p>
<?php endif; ?>
<h2 class="subtitle"><?= $poll['title']?> (Totlal votes: <?=$total_votes?>)</h2>
<div class="container">
    <?php foreach ($poll_answers as $poll_answer) :?>
    <p><?=$poll_answer['title']?> (<?=$poll_answer['votes']?>)</p>
    <progress class="progress is-info is-large" value="<?=$poll_answer['votes']?>" max="<?=$total_votes?>">
    </progress>
    <?php endforeach; ?>
    <a href="polls.php">Return to the polls page</a>
</div>

<!-- END PAGE CONTENT -->

<?= template_footer() ?>