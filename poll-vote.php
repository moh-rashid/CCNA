<?php
require 'config.php';
// connect to our database using pdo
$pdo = pdo_connect_mysql();

$responses = [];

if(isset($_GET['id'])) {
    //get the poll answers for the poll that matches the id
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);

    //check to see if a poll with that id exists
    if ($poll) {
        //get the poll answers
        $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ?');
        $stmt->execute([$_GET['id']]);
        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC); 
              
        if(!empty($_POST)) {
            $stmt = $pdo->prepare('UPDATE `poll_answers` SET `votes`= `votes` + 1 WHERE `id` = ?');
             $stmt->execute([$_POST['poll_answer']]);
             $responses[] = "Poll was updated! <a href='polls.php'>Return to polls page</a>";
        }

     } else{
        $responses[] = 'A poll with that ID was not found.';
    } 
} else {
    $responses[] = 'No poll with that ID was not found.';
    }

    
?>
<?= template_header('Poll Vote') ?>
<?= template_nav('Site Title') ?>

<?php if ($responses) : ?>
<p class="notification is-danger is-light">
    <?php echo implode('<br>', $responses); ?>
</p>
<?php endif; ?>

<h1 class="title">Vote for:</h1>
<h2 class="subtitle">What's your favorite programming language?</h2>
<form action="poll-vote.php?id=<?=$_GET['id']?>" method="post">
    <div class="field">
        <div class="control">
            <?php foreach($poll_answers as $poll_answer) : ?>
            <label class="radio">
                <input type="radio" name="poll_answer" value="<?= $poll_answer['id'] ?>" required>
                <?=$poll_answer['title']?>
            </label><br>
            <?php endforeach?>
        </div>
    </div>
    <div class="field">
        <div class="control">
            <button class="button" value="Vote" type="submit">Vote</button>
        </div>
    </div>
</form>
<!-- END PAGE CONTENT -->
<?= template_footer() ?>