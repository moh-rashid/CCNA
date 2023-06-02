<?php
require 'config.php';

$pdo = pdo_connect_mysql();

$responses = [];

// check if post data is not empty
if (!empty($_POST)){

    //check if the data from the form elements is set
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $desc = isset($_POST['desc']) ? $_POST['desc'] : '';

    // insert the poll record into the polls table
    $stmt = $pdo->prepare('INSERT INTO `polls`(`title`, `desc`) VALUES (?,?)');
    $stmt->execute([$title, $desc]);

    //get the new poll id
    $poll_id = $pdo->lastInsertId();

    /* For each answer from the answers form convert the multiline string to an array using explode() */
    $answers = isset($_POST['answers']) ? explode(PHP_EOL, $_POST['answers']) : '';

    // for each answer in the answer array do an insert into the poll_answers table
    foreach ($answers as $answer) {
        $stmt = $pdo->prepare('INSERT INTO `poll_answers` (`poll_id`, `title`) VALUES (?,?)');
        $stmt->execute([$poll_id, $answer]);
    }
    //create the message your poll was created successfully
    $responses[] = "Your poll was created successfully! <a href='polls.php'>Return to polls page</a>";
}

?>

<?= template_header('Create Vote') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<h1 class="title">Create Vote</h1>
<?php if ($responses) : ?>
<p class="notification is-danger is-light">
    <?php echo implode('<br>', $responses); ?>
</p>
<?php endif; ?>
<form action="" method="post">
    <div class="field">
        <label class="Label">Title</Label>
        <div class="control">
            <input type="text" class="input" name="title" placeholder="Poll Title">
        </div>
    </div>
    <div class="field">
        <label class="label">Description</label>
        <div class="control">
            <input type="text" class="input" name="desc" placeholder="Poll Description">
        </div>
    </div>
    <div class="field">
        <label class="label">Answers (one answer per line)</label>
        <div class="control">
            <textarea class="textarea" name="answers" placeholder="Answers go here..."></textarea>
        </div>
    </div>
    <div class="field">
        <div class="control">
            <button class="button is-link">Create Poll</button>
        </div>
    </div>
</form>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>