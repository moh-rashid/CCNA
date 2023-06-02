<?php
require 'config.php';
// connect to our database using pdo
$pdo - pdo_connect_mysql();

if(isset($_GET['id'])) {
    //get the poll answers for the poll that matches the id
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt ->execute([S_GET['id']]);
    $poll - $stmt->fetch(PDO::FETCH_ASSOC);
    //check to see if a poll with that id exists
    if ($poll) {
        //get the poll answers
        $stmt - $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id - ?');
        $stmt->execute([$_GET['id']]);
        $poll_answers - $stmt->fetchAl1(PDO::FETCH_ASSOC);
      
        if(lempty($_POST)) {
            $stmt = $pdo->prepare('UPDATE poll_answers SET votes = "votes +1 WHERE id = ?');
             $stmt ->execute([$_POST['poll_answers']]);
             //Sresponses[] - 'The record was updated.';
                                                                                            I
             //header('Location: contacts.php');

     } else{
        Sresponses[] - 'A poll with that ID was not found.';
} else {
    Sresponses[] - 'No poll with that ID was not found.';
}
?>
<?- template_header ('Page Title') ?>
<?- template_nav('Site Title') ?>

   
<hi class="title">Vote for:</h1>
<h2 class="subtitle">What's your favorite programming language?</h2>
<form action="poll-vote.php?id=<?=$_GET['id']?>" method="post">
<div class="field">
    <div class="control">
     <?php foreach(Spolls as Spol1) : ?>
                    <label class="radio">
                    <input type="radio" name="poll_answer" value="4" required>
                    <?-Spoll['answers']?></label><br>
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
<?- template_footer() ?>