<?php
require 'config.php';

//additional php code for this page goes here
//connect to our database using pdo
$pdo = pdo_connect_mysql();

// get all the polls
$stmt = $pdo->query( 'SELECT p.*, GROUP_CONCAT(pa.title ORDER BY pa.id) AS answers 
                      FROM polls p LEFT JOIN poll_answers pa ON pa.poll_id = p.id
                      GROUP BY p.id');

$polls = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_header('Polls') ?>
<?= template_nav('Site Title') ?>
<!-- START PAGE CONTENT -->
<h1 class="title">Polls</h1>
<p class="subtitle">Welcome! Here is our list of polls.</p>
<a href="poll-create.php" class="button is-success">Create Poll</a>
<table class="table">
    <thead>
        <tr>
            <td>#</td>
            <td>Title</td>
            <td>Answers</td>
            <td>Action</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach($polls as $poll): ?>
        <tr>
            <td><?= $poll['id'] ?></td>
            <th><?= $poll['title'] ?></th>
            <td><?= $poll['answers'] ?></td>
            <td>
                <a href="poll-vote.php?id=<?= $poll['id'] ?>" class="button"><i class="fas fa-poll"></i></a>
                <a href="poll-delete.php?id=<?= $poll['id'] ?>" class="button"><i class="fas fa-trash"></i></a>
            </td>
        </tr>
        <?php endforeach;?>

    </tbody>

</table>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>